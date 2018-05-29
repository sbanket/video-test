<?php

namespace App\Error;

use App\View\View;
use Exception;

class Error
{
    /**
     * @param $level
     * @param $message
     * @param $file
     * @param $line
     *
     * @throws \ErrorException
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * @param Exception $exception
     */
    public static function exceptionHandler(Exception $exception)
    {
        $code = $exception->getCode();
        http_response_code($code);
        if ($code != 404) {
            $code = 500;
            $log  = dirname(__DIR__) . '/../logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);
            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();
            error_log($message);
        }

        $view = new View(sprintf('app/View/error/%s.phtml', $code));
        $view->setTitle('Error')->render();
    }
}