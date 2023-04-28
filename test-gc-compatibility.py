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
    
Versions:
    You can specify package version by adding a semicolon to the package name:
    
    # Tests version 1.6.0 and 1.6.3
    $ ./test-gc-compatibility.py doctrine/doctrine-bundle:1.6.0,1.6.3 doctrine/rce1
    
    or with a range:
    
    # Tests from version 5.0.0 to 6.1.3
    $ ./test-gc-compatibility.py doctrine/doctrine-bundle:1.6.0..1.12.3 doctrine/rce1
    
    If no upper or lower version is present, every version before (resp. after)
    the specified one will be tested:
    
    # from doctrine 1.12.0 to the newest
    $ ./test-gc-compatibility.py doctrine/doctrine-bundle:1.12.0.. doctrine/rce1
    # from the first version of doctrine to 1.6.0
    $ ./test-gc-compatibility.py doctrine/doctrine-bundle:..1.6.0 doctrine/rce1
    

Credit goes to @M4yFly for the original idea and implementation.
"""

import subprocess
import argparse
import pathlib
import os
import re
import tempfile
import shutil
from concurrent.futures import ProcessPoolExecutor

try:
    from rich import print
except ImportError:
    print("Please install the `rich` python3 package to use this program.")
    print("$ pip install rich")
    exit()


from rich.progress import Progress
from rich.table import Table


class UnableToInstallPackageException(Exception):
    """A package cannot be installed."""


class Tester:
    """Tests gadget chains against a composer package."""

    _package = None
    _cwd = None

    def run(self):
        args = setup_arguments()
        self._gcs: list[str] = args.gadget_chain
        self._executor = Executor(args.create_project)
        self._package = Package(args.package, executor=self._executor)
        self._workers = args.workers

        for gc in self._gcs:
            self.ensure_gc_exists(gc)

        php_version = self._executor.php("--version")[0].split("\n")[0]
        print(f"Running on PHP version " f"[blue]{php_version}[/blue]" f".")

        versions = self._package.get_target_versions()
        print(
            f"Testing {len(versions)} versions for "
            f"[blue]{self._package.name}[/blue] against "
            f"{len(self._gcs)} gadget chains."
        )

        self.test_chains_on_versions(versions)

    def ensure_gc_exists(self, name):
        """Makes sure that a GC exists."""
        if not self._executor.phpggc("-i", name):
            raise TesterException(f"Gadget chain does not exist: {name}")

    def test_chains_on_versions(self, versions):
        """Contains the main logic. Each version of the package will be
        installed, and each gadget chain will be tested against it. Results
        are kept in a table.
        """
        table = Table(self._package.name)
        table.add_column("Package", justify="center")

        for gc in self._gcs:
            table.add_column(gc, justify="center")

        errored_payload_rows = (self.__status_str(False),) + ("[yellow]-",) * len(
            self._gcs
        )

        with Progress() as progress, ProcessPoolExecutor(self._workers) as ppe:
            ptask = progress.add_task("Testing chains", total=len(versions))

            futures = {
                version: ppe.submit(self.test_chains_on_version, version)
                for version in versions
            }
            for version, future in futures.items():
                future.add_done_callback(
                    lambda f: progress.update(
                        ptask, advance=1, description=f"Testing ({version})"
                    )
                )

            for version, future in futures.items():
                try:
                    tests = future.result()
                except KeyboardInterrupt:
                    ppe.shutdown(cancel_futures=True)
                    raise
                except UnableToInstallPackageException:
                    table.add_row(version, *errored_payload_rows)
                else:
                    outputs = [self.__status_str(test) for test in tests]
                    table.add_row(version, self.__status_str(True), *outputs)

            progress.update(ptask, visible=False)

        print(table)

    def __status_str(self, test):
        return test and "[green]OK" or "[red]KO"

    def test_chains_on_version(self, version):
        pv = PackageVersion(self._package.name, version, self._executor)

        try:
            pv.install()
            return [self._executor.phpggc("--test-payload", gc) for gc in self._gcs]
        finally:
            pv.cleanup()


class TesterException(Exception):
    pass


def setup_arguments():
    parser = argparse.ArgumentParser(
        description="Test PHPGGC gadget chains against every version of a composer package.",
        epilog="""\
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
    
Versions:
    You can specify package version by adding a semicolon to the package name:
    
    # Tests version 1.6.0 and 1.6.3
    $ ./test-gc-compatibility.py doctrine/doctrine-bundle:1.6.0,1.6.3 doctrine/rce1
    
    or with a range:
    
    # Tests from version 5.0.0 to 6.1.3
    $ ./test-gc-compatibility.py doctrine/doctrine-bundle:1.6.0..1.12.3 doctrine/rce1
    
    If no upper or lower version is present, every version before (resp. after)
    the specified one will be tested:
    
    # from doctrine 1.12.0 to the newest
    $ ./test-gc-compatibility.py doctrine/doctrine-bundle:1.12.0.. doctrine/rce1
    # from the first version of doctrine to 1.6.0
    $ ./test-gc-compatibility.py doctrine/doctrine-bundle:..1.6.0 doctrine/rce1
    
Using "create-project":
    Some GC require a full project to be installed, instead of just a package.
    Use the `-c` flag to use the `create-project` command instead of `require`.
""",
        formatter_class=argparse.RawTextHelpFormatter,
    )
    parser.add_argument("package")
    parser.add_argument("gadget_chain", nargs="+")
    parser.add_argument(
        "--create-project",
        "-c",
        action='store_true',
        help="Use the `create-project` command instead of `require` when installing packages.",
    )
    parser.add_argument(
        "--workers",
        "-w",
        type=int,
        required=False,
        help="Number of workers to use. Defaults to the number of CPU cores.",
    )

    return parser.parse_args()


class Executor:
    """Small wrapper to execute composer and phpggc."""

    def __init__(self, create_project: bool):
        self.get_commands()
        self.create_project = create_project

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
        # We will change our current directory during the execution.
        # If we can find php_file in the current path, refer to it using an
        # absolute path.
        # Otherwise, just assume it's an alias or from $PATH.
        path = pathlib.Path(php_file)
        if path.exists():
            php_file = str(path.absolute())

        if self._try_run_command(php_file):
            return (php_file,)
        elif path.exists() and self._try_run_command(self._php_path, php_file):
            return (self._php_path, php_file)
        raise TesterException(f"Unable to run PHP file: {php_file}")

    def get_commands(self):
        """Gets the paths of the two required programs, phpggc and composer, and
        verifies if they need to be started with "php" as a prefix.
        """
        work_dir = pathlib.Path(__file__).parent.resolve()
        phpggc = os.environ.get("PHPGGC_PATH", str(work_dir / "phpggc"))
        composer = os.environ.get("COMPOSER_PATH", "composer")

        if not pathlib.Path(phpggc).is_file():
            raise TesterException("phpggc executable not found")

        self._php_path = os.environ.get("PHP_BINARY", "php")
        self._phpggc = self._get_valid_run_command(phpggc)
        self._composer = self._get_valid_run_command(composer)

    def _run(self, *args):
        """Runs a program with given arguments."""
        return subprocess.run(args, stdout=subprocess.PIPE, stderr=subprocess.PIPE)

    def composer(self, *args):
        """Runs composer and returns stdout and stderr as a tuple."""
        process = self._run(*self._composer, *args)
        return process.stdout.decode("utf-8"), process.stderr.decode("utf-8")
    
    def install(self, *args):
        if self.create_project:
            prefix = "create-project"
            suffix = (".", )
        else:
            prefix = "require"
            suffix = ()
        return self.composer(prefix, *args, *suffix)
        

    def phpggc(self, *args):
        """Runs PHPGGC with given arguments and returns whether the execution
        was successful or not.
        """
        process = self._run(*self._phpggc, *args)
        return process.returncode == 0

    def php(self, *args):
        """Runs PHP with given arguments and returns whether the execution
        was successful or not.
        """
        process = self._run(self._php_path, *args)
        return process.stdout.decode("utf-8"), process.stderr.decode("utf-8")


class Package:
    """Represents a composer package."""

    def __init__(self, name: str, executor: Executor):
        self.extract_name_versions(name)
        self._executor = executor

    def extract_name_versions(self, name):
        if ":" not in name:
            self.name = name
            self.versions = None
        else:
            self.name, self.versions = name.split(":")

    def get_package_versions(self):
        versions, _ = self._executor.composer("show", "-a", self.name)
        try:
            versions = re.search(r"versions :(.*)\ntype", versions).group(1)
        except AttributeError:
            print(f"[red]Package [b]{self.name}[/b] has not version candidates (misspelled ?)")
            exit(1)    
            
        return [v.strip() for v in versions.split(",")]

    def get_target_versions(self):
        """Uses composer to obtain each version (or tag) for the package."""
        if self.versions is None:
            return self.get_package_versions()

        package_versions = None
        target_versions = []

        def get_version_idx_or_raise(version):
            try:
                return package_versions.index(version)
            except ValueError:
                raise ValueError(f"Version {version} could not be found")

        for version in self.versions.split(","):
            # range
            if ".." in version:
                vmin, vmax = version.split("..")
                if package_versions is None:
                    package_versions = self.get_package_versions()

                vmin_idx = (
                    get_version_idx_or_raise(vmin) if vmin else len(package_versions)
                )
                vmax_idx = get_version_idx_or_raise(vmax) if vmax else 0
                # Versions are stored from biggest to smallest
                target_versions += package_versions[vmax_idx : vmin_idx + 1]
            else:
                target_versions.append(version)

        return target_versions


class PackageVersion:
    def __init__(self, package: str, version: str, executor: Executor):
        self.package = package
        self.version = version
        self._executor = executor
        self.work_dir = pathlib.Path(tempfile.mkdtemp(prefix="phpggc"))

    def cleanup(self):
        """Removes any composer related file in the working directory, such as
        composer.json and vendor/.
        """
        shutil.rmtree(self.work_dir, ignore_errors=True)

    def install(self):
        """Uses composer to install a specific version of the package."""
        # We'll jump to a temporary directory for phpggc and composer to work
        # without breaking anything. We can safely change directories as we are
        # not in the original process
        os.chdir(self.work_dir)
        _, stderr = self._executor.install(
            "--no-scripts",
            "--no-interaction",
            # "--no-plugins",
            "--quiet",
            "--ignore-platform-req=ext-*",
            f"{self.package}:{self.version}",
        )
        if stderr:
            raise UnableToInstallPackageException(
                f"Unable to install version: {self.version}"
            )


if __name__ == "__main__":
    tester = Tester()

    try:
        tester.run()
    except TesterException as e:
        print(f"[red]Error: {e}[/red]")
    except KeyboardInterrupt:
        print(f"[red]Execution interrupted.")
