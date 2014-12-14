<?php namespace Arcanedev\Arabic\Contracts\DateTime;

use Arcanedev\Arabic\Exceptions\InvalidTypeException;
use Arcanedev\Arabic\Exceptions\UndefinedOffsetException;

interface DayInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return array
     */
    public static function getAllByNames();

    /**
     * @return array
     */
    public static function getAllByShortNames();

    /**
     * @return array
     */
    public static function getAllByIndexes();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get all arabic days names
     *
     * @return array
     */
    public static function all();

    /**
     * @param string $name
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getByName($name);

    /**
     * @param string $shortName
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getByShortName($shortName);

    /**
     * @param int $index - 1 Monday / 7 Sunday
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getByIndex($index);
}
