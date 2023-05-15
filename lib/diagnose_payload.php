#!/usr/bin/env php
<?php
# Looks for undefined classes in the payload
# Usage: phpggc symfony/rce8 | php /tools/web/php/phpggc/lib/diagnose_payload.php

error_reporting(E_ALL);

$payload = file_get_contents("php://stdin");

if(!file_exists('vendor/autoload.php'))
{
    print('Unable to load either test.php or vendor/autoload.php' . "\n");
    exit(1);
}

require('vendor/autoload.php');

$payload = unserialize($payload);

if($payload === false)
{
    print("Unable to unserialize payload\n");
    exit(1);
}

check_object_state($payload);

function check_object_state($payload, $depth=0, $key="root") {
    if(is_object($payload))
    {
        $pad = str_repeat("  ", $depth) . $key . " -> ";
        $vars = get_mangled_object_vars($payload);
        if($payload instanceof __PHP_Incomplete_Class) {
            $name = $vars["__PHP_Incomplete_Class_Name"];
            unset($vars["__PHP_Incomplete_Class_Name"]);
            print $pad . $name . " [X]\n";
        }
        else
        {
            $name = get_class($payload);
            print $pad . $name . "\n";
        }
        foreach($vars as $name => $value)
        {
            if(strpos($name, "\0") !== false) {
                $parts = explode("\0", $name);
                $name = end($parts);
            }
            check_object_state($value, $depth+1, $name);
        }
    }
    elseif(is_array($payload))
    {
        foreach($payload as $k => $value)
        {
            check_object_state($value, $depth + 1, "[$k]");
        }
    }
}