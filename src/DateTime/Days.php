<?php namespace Arcanedev\Arabic\DateTime;

use Arcanedev\Arabic\Contracts\DateTime\DayInterface;
use Arcanedev\Arabic\Exceptions\InvalidTypeException;
use Arcanedev\Arabic\Exceptions\UndefinedOffsetException;

class Days implements DayInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const MONDAY    = 'الأثنين';
    const TUESDAY   = 'الثلاثاء';
    const WEDNESDAY = 'الأربعاء';
    const THURSDAY  = 'الخميس';
    const FRIDAY    = 'الجمعه';
    const SATURDAY  = 'السبت';
    const SUNDAY    = 'الأحد';

    /** @var array */
    private static $arabicDaysNames = [
        self::MONDAY,
        self::TUESDAY,
        self::WEDNESDAY,
        self::THURSDAY,
        self::FRIDAY,
        self::SATURDAY,
        self::SUNDAY,
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return array
     */
    public static function getAllByNames()
    {
        return self::combineDays([
            'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
        ]);
    }

    /**
     * @return array
     */
    public static function getAllByShortNames()
    {
        return self::combineDays([
            'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun',
        ]);
    }

    /**
     * @return array
     */
    public static function getAllByIndexes()
    {
        return self::combineDays(range(1, 7));
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    private static function combineDays($keys)
    {
        return array_combine($keys, self::$arabicDaysNames);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get all arabic days names
     *
     * @return array
     */
    public static function all()
    {
        return self::getAllByShortNames();
    }

    /**
     * @param string $name
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getByName($name)
    {
        self::checkNameExists($name);

        return self::getAllByNames()[$name];
    }

    /**
     * @param string $shortName
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getByShortName($shortName)
    {
        self::checkShortNameExists($shortName);

        return self::getAllByShortNames()[$shortName];
    }

    /**
     * @param int $index - 1 Monday / 7 Sunday
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getByIndex($index)
    {
        self::checkIndexExist($index);

        return self::getAllByIndexes()[$index];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param string $name
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     */
    private static function checkNameExists(&$name)
    {
        if ( ! is_string($name) ) {
            throw new InvalidTypeException('The name must be an string, ' . gettype($name) . ' is given.');
        }

        $name = self::prepareName($name);

        if ( ! array_key_exists($name, self::getAllByNames()) ) {
            throw new UndefinedOffsetException("The short name [$name] does not exists !");
        }
    }

    /**
     * @param string $shortName
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     */
    private static function checkShortNameExists(&$shortName)
    {
        if ( ! is_string($shortName) ) {
            throw new InvalidTypeException('The short name must be an string, ' . gettype($shortName) . ' is given.');
        }

        $shortName = self::prepareName($shortName);

        if ( ! array_key_exists($shortName, self::getAllByShortNames()) ) {
            throw new UndefinedOffsetException("The short name [$shortName] does not exists !");
        }
    }

    /**
     * @param int $index
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     */
    private static function checkIndexExist($index)
    {
        if ( ! is_int($index) ) {
            throw new InvalidTypeException('The index must be an integer, ' . gettype($index) . ' is given.');
        }

        if ( ! array_key_exists($index, self::getAllByIndexes()) ) {
            throw new UndefinedOffsetException("The index must be between 1 and 7 (Monday to Sunday) !");
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param string $name
     *
     * @return string
     */
    private static function prepareName($name)
    {
        return ucfirst(strtolower(trim($name)));
    }
}
