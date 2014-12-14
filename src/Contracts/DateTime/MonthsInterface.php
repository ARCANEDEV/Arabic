<?php namespace Arcanedev\Arabic\Contracts\DateTime;

use Arcanedev\Arabic\Exceptions\InvalidTypeException;
use Arcanedev\Arabic\Exceptions\UndefinedOffsetException;

interface MonthsInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return array
     */
    public static function getAllArabicByNames();

    /**
     * @return array
     */
    public static function getAllArabicByShortNames();

    /**
     * @return array
     */
    public static function getAllArabicByIndexes();

    /**
     * @return array
     */
    public static function getAllHijriByIndexes();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return array
     */
    public static function getAllArabic();

    /**
     * @param string $name
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneArabicByName($name);

    /**
     * @param string $shortName
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneArabicByShortName($shortName);

    /**
     * @param int $index
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneArabicByIndex($index);

    /**
     * @return array
     */
    public static function getAllHijri();

    /**
     * @param int $index
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneHijriByIndex($index);
}
