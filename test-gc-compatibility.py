#!/usr/bin/env python3
"""
Test PHPGGC gadget chains against every version of a composer package.

Usage:
    $ ./test-gc-compatibility.py <composer-package> <gadget-chain-1> [gadget-chain-2...]

Example:
    $ ./test-gc-compatibility.py monolog/monolog monolog/rce1 monolog/rce3

Required executables:
    The program requires phpggc and composer.
    By default, it will use the `phpggc` from the current directory, and the
    composer from PATH. If you wish to use other paths, use the `PHPGGC_PATH`
    and `COMPOSER_PATH` environment variables.
    If a file cannot be ran straight up, we'll try using `php <file>` instead.

Dependencies:
    $ pip install rich

Credit goes to @M4yFly for the original idea and implementation.
"""

import subprocess
import argparse
import pathlib
import os
import re
import tempfile
import shutil


try:
    from rich import print
except ImportError:
    print('Please install the `rich` python3 package to use this program.')
    print('$ pip install rich')
    exit()

from rich.progress import Progress
from rich.table import Table



class TesterException(Exception):
    pass


def setup_arguments():
    parser = argparse.ArgumentParser(description=
        'Test PHPGGC gadget chains against every version of a composer package.'
    )
    parser.add_argument('package')
    parser.add_argument('gadget_chain', nargs='+')

    return parser.parse_args()


class Executor:
    """Small wrapper to execute composer and phpggc.
    """
    
    def __init__(self):
        self.get_commands()
    
    def _try_run_command(self, *cmd):
        """Tries to run a command to completion: if no exception happens and the
        return code is zero, returns True. Otherwise, False.
        """
        try:
            process = self._run(*cmd)
        except (PermissionError, FileNotFoundError) as e:
            return False
        return process.returncode == 0

    def _get_valid_run_command(self, php_file):
        """Tries to run a PHP file directly (e.g. `./file.php`). If it does not
        work, tries with `php file.php`.
        Returns the arguments required to launch the file, as tuple.
        If nothing works, an exception is raised.
        """
        if self._try_run_command(php_file):
            return (php_file, )
        elif self._try_run_command('php', php_file):
            return ('php', php_file)
        raise TesterException(f'Unable to run PHP file: {php_file}')

    def get_commands(self):
        """Gets the paths of the two required programs, phpggc and composer, and
        verifies if they need to be started with "php" as a prefix.
        """
        work_dir = pathlib.Path(__file__).parent.resolve()
        phpggc = os.environ.get('PHPGGC_PATH', str(work_dir / 'phpggc'))
        composer = os.environ.get('COMPOSER_PATH', 'composer')

        if not pathlib.Path(phpggc).is_file():
            raise TesterException('phpggc executable not found')
    
        self._phpggc = self._get_valid_run_command(phpggc)
        self._composer = self._get_valid_run_command(composer)

    def _run(self, *args):
        """Runs a program with given arguments.
        """
        return subprocess.run(
            args, stdout=subprocess.PIPE, stderr=subprocess.PIPE
        )

    def composer(self, *args):
        """Runs composer and returns stdout and stderr as a tuple.
        """
        process = self._run(*self._composer, *args)
        return process.stdout.decode('utf-8'), process.stderr.decode('utf-8')

    def phpggc(self, *args):
        """Runs PHPGGC with given arguments and returns whether the execution
        was successful or not.
        """
        return self._run(*self._phpggc, *args).returncode == 0

class Package:
    def __init__(self, name, executor):
        self.name = name
        self._executor = executor
        self._work_dir = pathlib.Path(tempfile.mkdtemp(prefix='phpggc'))

    def get_versions(self):
        """Uses composer to obtain each version (or tag) for the package.
        """
        versions, _ = self._executor.composer('show', '-a', self.name)
        versions = re.search(r'versions :(.*)\ntype', versions).group(1)
        return [v.strip() for v in versions.split(',')]

    def clean_workdir(self, final=False):
        """Removes any composer related file in the working directory, such as
        composer.json and vendor/.
        """
        (self._work_dir / 'composer.json').unlink(missing_ok=True)
        (self._work_dir / 'composer.lock').unlink(missing_ok=True)
        shutil.rmtree(self._work_dir / 'vendor', ignore_errors=True)
        if final:
            self._work_dir.rmdir()

    def install_version(self, version):
        """Uses composer to install a specific version of the package.
        """
        self.clean_workdir()
        _, stderr = self._executor.composer(
            'require', '-q', '--ignore-platform-reqs', f'{self.name}:{version}'
        )
        if stderr:
            raise ValueError(f'Unable to install version: {version}')


class Tester:
    def run(self):
        args = setup_arguments()
        self._gcs = args.gadget_chain
        self._executor = Executor()
        self._package = Package(args.package, executor=self._executor)

        for gc in self._gcs:
            self.ensure_gc_exists(gc)

        versions = self._package.get_versions()
        print(
            f'Testing {len(versions)} versions for '
            f'[blue]{self._package.name}[/blue] against '
            f'{len(self._gcs)} gadget chains.'
        )

        self.test_chains_on_versions(versions)

    def ensure_gc_exists(self, name):
        """Makes sure that a GC exists.
        """
        if not self._executor.phpggc('-i', name):
            raise TesterException(f'Gadget chain does not exist: {name}')

    def test_chains_on_versions(self, versions):
        """Contains the main logic. Each version of the package will be
        installed, and each gadget chain will be tested against it. Results
        are kept in a table.
        """
        table = Table(self._package.name)
        table.add_column('Package', justify='center')

        for gc in self._gcs:
            table.add_column(gc, justify='center')

        errored_payload_rows = (
            (self.__status_str(False), ) + 
            ('[yellow]-[/yellow]', ) * len(self._gcs)
        )

        with Progress() as progress:
            ptask = progress.add_task('Testing chains', total=len(versions))

            for version in versions:
                progress.update(ptask, advance=1,
                                description=f'Testing ({version})')
                try:
                    tests = self.test_chains_on_version(version)
                except ValueError:
                    table.add_row(version, *errored_payload_rows)
                else:
                    outputs = [self.__status_str(test) for test in tests]
                    table.add_row(version, self.__status_str(True), *outputs)

        self._package.clean_workdir(final=True)
        print(table)

    def __status_str(self, test):
        return test and '[green]OK[/green]' or '[red]KO[/red]'

    def test_chains_on_version(self, version):
        self._package.install_version(version)
        return [
            self._executor.phpggc('--test-payload', gc)
            for gc in self._gcs
        ]


try:
    Tester().run()
except TesterException as e:
    print(f'[red]Error: {e}[/red]')
