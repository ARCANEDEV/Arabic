<?php namespace Arcanedev\Arabic\Contracts;

use Arcanedev\Arabic\Exceptions\InvalidTypeException;
use Arcanedev\Arabic\Exceptions\NumbersNotFoundException;

interface NumberInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get all arabic numbers
     *
     * @return array
     */
    public static function all();

    /**
     * Convert a latin convert to arabic convert
     *
     * @param string $string
     * @param bool   $mustContainNumbers
     *
     * @throws NumbersNotFoundException
     *
     * @return string
     */
    public static function convert($string, $mustContainNumbers = true);

    /**
     * Convert a float value to arabic with convert format
     *
     * @param float|int $number
     * @param int       $decimals
     * @param string    $decimalMark
     * @param string    $thousandsMark
     *
     * @throws InvalidTypeException
     *
     * @return string
     */
    public static function convertFloat($number, $decimals = 2, $decimalMark = '.', $thousandsMark = ',');

    /**
     * Convert convert to arabic convert
     *
     * @param int|float|string $number
     *
     * @throws InvalidTypeException
     *
     * @return string
     */
    public static function convertNumber($number);
}
