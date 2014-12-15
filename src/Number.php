<?php namespace Arcanedev\Arabic;

use Arcanedev\Arabic\Exceptions\InvalidTypeException;
use Arcanedev\Arabic\Exceptions\NumbersNotFoundException;

use Arcanedev\Arabic\Contracts\NumberInterface;

class Number implements NumberInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    private static $arabicNumbers = [
        '0'   => '٠',
        '1'   => '١',
        '2'   => '٢',
        '3'   => '٣',
        '4'   => '٤',
        '5'   => '٥',
        '6'   => '٦',
        '7'   => '٧',
        '8'   => '٨',
        '9'   => '٩'
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get all arabic convert
     *
     * @return array
     */
    public static function all()
    {
        return self::$arabicNumbers;
    }

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
    public static function convert($string, $mustContainNumbers = true)
    {
        if ( ! is_string($string) ) {
            $string = (string) $string;
        }

        if ( $mustContainNumbers === true) {
            self::checkStringContainNumbers($string);
        }

        $arabicNumbers = self::all();

        return str_replace(
            array_keys($arabicNumbers),
            array_values($arabicNumbers),
            $string
        );
    }

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
    public static function convertFloat($number, $decimals = 2, $decimalMark = '.', $thousandsMark = ',')
    {
        self::checkNumeric($number);

        $number = number_format($number, $decimals, $decimalMark, $thousandsMark);

        return self::convert($number);
    }

    /**
     * Convert convert to arabic convert
     *
     * @param int|float|string $number
     *
     * @throws InvalidTypeException
     *
     * @return string
     */
    public static function convertNumber($number)
    {
        self::checkNumber($number);

        return self::convert($number);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param string $string
     *
     * @throws NumbersNotFoundException
     */
    private static function checkStringContainNumbers($string)
    {
        if ( preg_match('~[0-9]~', $string) === 0 ) {
            throw new NumbersNotFoundException("The string value must contain at least one convert, [$string] is given.");
        }
    }

    /**
     * @param int|float|string $number
     *
     * @throws InvalidTypeException
     */
    private static function checkNumber(&$number)
    {
        self::checkNumeric($number);

        if ( is_int($number) or is_float($number) ) {
            $number = (string) $number;
        }
    }

    /**
     * @param int|float|string $number
     *
     * @throws InvalidTypeException
     */
    private static function checkNumeric(&$number)
    {
        if ( ! is_numeric($number) ) {
            throw new InvalidTypeException("The convert must be a numeric value, " . gettype($number) . " is given.");
        }

        if ( is_string($number) ) {
            $number = (float) $number;
        }
    }
}
