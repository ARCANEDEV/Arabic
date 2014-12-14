<?php namespace Arcanedev\Arabic\DateTime;

use Arcanedev\Arabic\Contracts\DateTime\MonthsInterface;
use Arcanedev\Arabic\Exceptions\InvalidTypeException;
use Arcanedev\Arabic\Exceptions\UndefinedOffsetException;

class Months implements MonthsInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const JANUARY   = 'يناير';
    const FEBRUARY  = 'فبراير';
    const MARCH     = 'مارس';
    const APRIL     = 'أبريل';
    const MAY       = 'مايو';
    const JUNE      = 'يونيو';
    const JULY      = 'يوليو';
    const AUGUST    = 'أغسطس';
    const SEPTEMBER = 'سبتمبر';
    const OCTOBER   = 'أكتوبر';
    const NOVEMBER  = 'نوفمبر';
    const DECEMBER  = 'ديسمبر';

    /** @var array */
    private static $arabicMonthsNames    = [
        self::JANUARY,  self::FEBRUARY, self::MARCH,
        self::APRIL,    self::MAY,      self::JUNE,
        self::JULY,     self::AUGUST,   self::SEPTEMBER,
        self::OCTOBER,  self::NOVEMBER, self::DECEMBER
    ];

    /** @var array */
    private static $hijriMonthsNames     = [
        'Muharram'          => 'محرم',
        'Safar'             => 'صفر',
        'Rabi al-Awwal'     => 'ربيع أول',
        'Rabi al-Akhir'     => 'ربيع ثانى',
        'Jamadi al-Awwal'   => 'جمادى أول',
        'Jamadi al-Akhir'   => 'جمادى ثانى',
        'Rajab'             => 'رجب',
        'Shabaan'           => 'شعبان',
        'Ramadhan'          => 'رمضان',
        'Shawwal'           => 'شوال',
        'Zilqad'            => 'ذو القعدة',
        'Zilhajj'           => 'ذو الحجة',
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return array
     */
    public static function getAllArabicByNames()
    {
        return self::combineArabicMonths([
            'January',  'February', 'March',
            'April',    'May',      'June',
            'July',     'August',   'September',
            'October',  'November', 'December',
        ]);
    }

    /**
     * @return array
     */
    public static function getAllArabicByShortNames()
    {
        return self::combineArabicMonths([
            'Jan', 'Feb', 'Mar',
            'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep',
            'Oct', 'Nov', 'Dec',
        ]);
    }

    /**
     * @return array
     */
    public static function getAllArabicByIndexes()
    {
        return self::combineArabicMonths(range(1, 12));
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    private static function combineArabicMonths($keys)
    {
        return array_combine(
            $keys,
            self::$arabicMonthsNames
        );
    }

    /**
     * @return array
     */
    private static function getAllHijriByNames()
    {
        return self::$hijriMonthsNames;
    }

    /**
     * @return array
     */
    public static function getAllHijriByIndexes()
    {
        return self::combineHijriMonths(range(1, 12));
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    private static function combineHijriMonths($keys)
    {
        return array_combine(
            $keys,
            array_values(self::getAllHijriByNames())
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return array
     */
    public static function getAllArabic()
    {
        return self::getAllArabicByShortNames();
    }

    /**
     * @param string $name
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneArabicByName($name)
    {
        self::checkArabicNameExists($name);

        return self::getAllArabicByNames()[$name];
    }

    /**
     * @param string $shortName
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneArabicByShortName($shortName)
    {
        self::checkArabicShortNameExists($shortName);

        return self::getAllArabicByShortNames()[$shortName];
    }

    /**
     * @param int $index
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneArabicByIndex($index)
    {
        self::checkArabicIndexExists($index);

        return self::getAllArabicByIndexes()[$index];
    }

    /**
     * @return array
     */
    public static function getAllHijri()
    {
        return self::getAllHijriByNames();
    }

    /**
     * @param int $index
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     *
     * @return string
     */
    public static function getOneHijriByIndex($index)
    {
        self::checkHijriIndexExists($index);

        return self::getAllHijriByIndexes()[$index];
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
    private static function checkArabicNameExists(&$name)
    {
        if ( ! is_string($name) ) {
            throw new InvalidTypeException('The name must be an string, ' . gettype($name) . ' is given.');
        }

        $name = self::prepareName($name);

        if ( ! array_key_exists($name, self::getAllArabicByNames()) ) {
            throw new UndefinedOffsetException("The short name [$name] does not exists !");
        }
    }

    /**
     * @param string $shortName
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     */
    private static function checkArabicShortNameExists(&$shortName)
    {
        if ( ! is_string($shortName) ) {
            throw new InvalidTypeException('The short name must be an string, ' . gettype($shortName) . ' is given.');
        }

        $shortName = self::prepareName($shortName);

        if ( ! array_key_exists($shortName, self::getAllArabicByShortNames()) ) {
            throw new UndefinedOffsetException("The short name [$shortName] does not exists !");
        }
    }

    /**
     * @param int $index
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     */
    private static function checkArabicIndexExists($index)
    {
        self::isInIndexes($index, self::getAllArabicByIndexes());
    }

    /**
     * @param int $index
     *
     * @throws InvalidTypeException
     * @throws UndefinedOffsetException
     */
    private static function checkHijriIndexExists($index)
    {
        self::isInIndexes($index, self::getAllHijriByIndexes());
    }

    /**
     * @param int   $index
     * @param array $indexes
     *
     * @throws UndefinedOffsetException
     */
    private static function isInIndexes($index, $indexes)
    {
        self::checkIndex($index);

        if ( ! array_key_exists($index, $indexes) ) {
            throw new UndefinedOffsetException('The index must be between 1 and 12 !');
        }
    }

    /**
     * @param int $index
     *
     * @throws InvalidTypeException
     */
    private static function checkIndex($index)
    {
        if ( ! is_int($index) ) {
            throw new InvalidTypeException('The index must be an integer, ' . gettype($index) . ' is given');
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
