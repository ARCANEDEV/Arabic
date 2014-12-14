<?php namespace Arcanedev\Arabic\Contracts\DateTime;

use Arcanedev\Arabic\Exceptions\InvalidTypeException;
use Arcanedev\Arabic\Exceptions\UndefinedOffsetException;

interface PeriodsInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return array
     */
    public static function all();

    /**
     * @param string $key
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneByKey($key);
}
