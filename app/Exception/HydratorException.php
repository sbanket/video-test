<?php

namespace App\Exception;

use Exception;
use Throwable;

/**
 * Class HydratorException
 *
 * @package App\Exception
 */
class HydratorException extends Exception
{
    /**
     * @param string         $message
     * @param Throwable|null $previous
     *
     * @return HydratorException
     */
    public static function notObject(string $message, \Throwable $previous = null): HydratorException
    {
        return new static($message, 0, $previous);
    }
}