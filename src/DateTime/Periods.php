<?php namespace Arcanedev\Arabic\DateTime;

use Arcanedev\Arabic\Exceptions\InvalidTypeException;
use Arcanedev\Arabic\Exceptions\UndefinedOffsetException;

class Periods
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const AM_PERIOD = 'صباحا';
    const PM_PERIOD = 'مساءا';

    private static $arabicPeriods    = [
        self::AM_PERIOD,
        self::PM_PERIOD
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Getter & Setters
     | ------------------------------------------------------------------------------------------------
     */
    private static function getByKeys()
    {
        return self::combinePeriods(['am', 'pm']);
    }

    private static function combinePeriods($keys)
    {
        return array_combine($keys, self::$arabicPeriods);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public static function all()
    {
        return self::getByKeys();
    }

    public static function getOneByKey($key)
    {
        self::checkKey($key);

        return self::getByKeys()[$key];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    private static function checkKey(&$key)
    {
        if ( ! is_string($key) ) {
            throw new InvalidTypeException('The key must be a string, ' . gettype($key) . ' is given');
        }

        $key = self::prepareKey($key);

        if ( ! array_key_exists($key, self::getByKeys()) ) {
            throw new UndefinedOffsetException("The period key must be am or pm, [$key] is given");
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private static function prepareKey($key)
    {
        return strtolower(trim($key));
    }
}