#!/usr/bin/env php
<?php
# Runs given payload assuming given vector
# TODO Add offsetGet, etc. when the time comes

error_reporting(E_ALL);

if($argc < 2)
{
	print($argv[0] . ' <vector> <base64_payload>' . "\n");
	exit(0);
}

$vector = $argv[1];
$payload = base64_decode($argv[2]);

if(file_exists('test.php'))
{
    require('test.php');
    exit(0);
}
if(!file_exists('vendor/autoload.php'))
{
    print('Unable to load either test.php or vendor/autoload.php' . "\n");
    exit(-1);
}

require('vendor/autoload.php');

# The payload must be processed in function of its form:
# Phar: Try to get the content of the only file in the PHAR file
switch($vector)
{
	case 'phar':
	    $phar = sys_get_temp_dir() . '/phpggc.phar';
	    file_put_contents($phar, $payload);
	    var_dump(file_get_contents('phar://' . $phar . '/test.txt'));
	    unlink($phar);
	    break;
	case '__toString':
	    $payload = unserialize($payload);
	    print($payload);
	    break;
	case '__destruct':
	case '__wakeup':
		$payload = unserialize($payload);
   		break;
   	default:
		print('Unable to test payload via vector "' . $vector . '"' . "\n");
}