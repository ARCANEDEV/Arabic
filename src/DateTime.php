<?php namespace Arcanedev\Arabic;

use DateTime as BaseDateTime;

use Arcanedev\Arabic\DateTime\Days      as Days;
use Arcanedev\Arabic\DateTime\Months    as Months;
use Arcanedev\Arabic\DateTime\Periods   as Periods;

use Arcanedev\Arabic\Exceptions\InvalidDateFormatException;
use Arcanedev\Arabic\Exceptions\InvalidTimestampException;

use Arcanedev\Arabic\Contracts\DateTimeInterface;

class DateTime implements DateTimeInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var BaseDateTime */
    protected $date;

    const ARABIC_HOUR_TITLE     = 'الساعة';

    /** @var string */
    protected $numericMode;

    const DEFAULT_NUMERIC_MODE  = 'default';
    const ARABIC_NUMERIC_MODE   = 'arabic';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        $this->date         = new BaseDateTime;
        $this->numericMode  = self::DEFAULT_NUMERIC_MODE;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get date
     *
     * @return BaseDateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set Date with a base DateTime Class
     *
     * @param BaseDateTime $date
     *
     * @return DateTime
     */
    public function setDate(BaseDateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param string $datetime
     * @param string $format
     *
     * @throws InvalidDateFormatException
     *
     * @return DateTime
     */
    public function setDatetime($datetime, $format = 'Y-m-d H:i:s')
    {
        $date = BaseDateTime::createFromFormat($format, $datetime);

        if ( $date === false ) {
            throw new InvalidDateFormatException('The date format must match the datetime.');
        }

        $this->date = $date;

        return $this;
    }

    /**
     * Get Timestamp from date
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->getDate()->getTimestamp();
    }

    /**
     * Set date based on timestamp
     *
     * @param string|int $timestamp
     *
     * @return DateTime
     */
    public function setTimestamp($timestamp)
    {
        $this->checkTimestamp($timestamp);

        $this->date->setTimestamp($timestamp);

        return $this;
    }

    /**
     * Get Year from Date
     *
     * @return string
     */
    public function getYear()
    {
        return $this->formatDate('Y');
    }

    /**
     * Get Month from Date
     *
     * @return string
     */
    public function getMonth()
    {
        return $this->formatDate('m');
    }

    /**
     * Get Day from Date
     *
     * @return string
     */
    public function getDay()
    {
        return $this->formatDate('d');
    }

    /**
     * Get Time (Hours:Minutes) from Date
     *
     * @param bool $seconds
     *
     * @return string
     */
    public function getTime($seconds = false)
    {
        $format = $seconds ? 'H:i:s' : 'H:i';

        return $this->formatDate($format);
    }

    /**
     * Format the date
     *
     * @param string $format
     *
     * @return string
     */
    protected function formatDate($format)
    {
        return $this->getDate()->format($format);
    }

    /**
     * Get Arabic Days Names
     *
     * @return array
     */
    public function getArabicDaysNames()
    {
        return Days::getAllByShortNames();
    }

    /**
     * Get Arabic Day Name
     *
     * @return string
     */
    public function getArabicDayName()
    {
        $shortName  = $this->formatDate('D');

        return Days::getByShortName($shortName);
    }

    /**
     * Get Arabic Months Names
     *
     * @return array
     */
    public function getArabicMonthsNames()
    {
        return Months::getAllArabic();
    }

    /**
     * Get Arabic Month Name
     *
     * @return string
     */
    public function getArabicMonthName()
    {
        $key    = $this->formatDate('M');

        return Months::getOneArabicByShortName($key);
    }

    /**
     * Get Hijri Months Names
     *
     * @return array
     */
    public function getHijriMonthsNames()
    {
        return Months::getAllHijri();
    }

    /**
     * Get Arabic Months Names
     *
     * @return array
     */
    public function getHijriMonthsIndexes()
    {
        return Months::getAllHijriByIndexes();
    }

    /**
     * Get Arabic Month Name by index
     *
     * @param int $monthIndex
     *
     * @return string
     */
    public function getHijriMonthByKey($monthIndex)
    {
        return Months::getOneHijriByIndex($monthIndex);
    }

    /**
     * Get Arabic Numbers
     *
     * @return array
     */
    public function getArabicNumbers()
    {
        return Number::all();
    }

    /**
     * Get Arabic Periods
     *
     * @return array
     */
    public function getArabicPeriods()
    {
        return Periods::all();
    }

    /**
     * Get Arabic Period
     *
     * @return string
     */
    public function getArabicPeriod()
    {
        $key        = $this->formatDate('a');

        return Periods::getOneByKey($key);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get date in Arabic
     *
     * @param int|string|null $timestamp
     * @param int             $mode       - (0) english | (1) arabic | (2) hijri
     * @param bool            $arabicMode
     *
     * @return string contain date
     */
    public function date($timestamp = null, $mode = 0, $arabicMode = false)
    {
        switch ($mode) {
            case 2: // Hijri
                return $this->hijriDate($timestamp, $arabicMode);

            case 1: // Arabic
                return $this->arabicDate($timestamp, $arabicMode);

            case 0: // English
            default:
                return $this->englishDate($timestamp);
        }
    }

    /**
     * Get date in English
     *
     * @param int|string|null $unixTime time
     *
     * @return string contain date
     */
    public function englishDate($unixTime = null)
    {
        if ( ! is_null($unixTime) ) {
            $this->setTimestamp($unixTime);
        }

        return $this->formatDate("F j, Y, g:i a");
    }

    /**
     * Get arabic date from Unix Time
     *
     * @param int|string|null $unixTime
     * @param bool|null       $arabicMode
     *
     * @return string contain date
     */
    public function arabicDate($unixTime = null, $arabicMode = null)
    {
        if ( ! is_null($unixTime) ) {
            $this->setTimestamp($unixTime);
        }

        $this->switchNumericMode($arabicMode);

        // Get full date
        return $this->parseFullDate([
            ':title'        => self::ARABIC_HOUR_TITLE,
            ':time'         => $this->getTime(),
            ':period'       => $this->getArabicPeriod(),
            ':dayName'      => $this->getArabicDayName(),
            ':day'          => $this->getDay(),
            ':monthName'    => $this->getArabicMonthName(),
            ':year'         => $this->getYear(),
        ]);
    }

    /**
     * Get hijri date from Unix Time
     *
     * @param int|string|null $timestamp
     * @param bool|null       $arabicMode
     *
     * @return string contain date
     */
    public function hijriDate($timestamp = null, $arabicMode = null)
    {
        if ( ! is_null($timestamp) ) {
            $this->setTimestamp($timestamp);
        }

        $this->switchNumericMode($arabicMode);

        /**
         * @var int $day
         * @var int $month
         * @var int $year
         */
        extract($this->hjConvert());

        // Get full date
        return $this->parseFullDate([
            ':title'        => self::ARABIC_HOUR_TITLE,
            ':time'         => $this->getTime(),
            ':period'       => $this->getArabicPeriod(),
            ':dayName'      => $this->getArabicDayName(),
            ':day'          => $day,
            ':monthName'    => $this->getHijriMonthByKey($month),
            ':year'         => $year,
        ]);
    }

    /**
     * @param int    $timestamp
     * @param string $locale
     *
     * @return string
     */
    public function ago($timestamp = null, $locale = 'ar')
    {
        if ( ! is_null($timestamp) ) {
            $this->setTimestamp($timestamp);
        }

        $interval = $this->getDate()->diff(new BaseDateTime('now'));

        if ( $interval->invert === 1) {
            return 'future';
        }

        if ( $locale === 'ar' ) {
            $format = [
                $interval->y > 0 ? '%y سنوات'   : '',
                $interval->m > 0 ? '%m أشهر'    : '',
                $interval->d > 0 ? '%d أيام'    : '',
                $interval->h > 0 ? '%h ساعات'  : '',
                $interval->i > 0 ? '%i دقيقة'   : '',
                $interval->s > 0 ? '%s ثانية'   : '',
            ];
        }
        else {
            $format = [
                "%y years",
                "%m months",
                "%d days",
                "%h hours",
                "%i minutes",
                "%s seconds"
            ];
        }

        return $interval->format(implode(' , ', array_filter($format)));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Numeric Mode Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param bool|null $arabicMode
     *
     * @return DateTime
     */
    protected function switchNumericMode($arabicMode = null)
    {
        return ! is_null($arabicMode) and $arabicMode === true
            ? $this->arabicMode()
            : $this->latinMode();
    }

    /**
     * Set Numeric mode to latin
     *
     * @return DateTime
     */
    public function latinMode()
    {
        return $this->toggleNumericMode(self::DEFAULT_NUMERIC_MODE);
    }

    /**
     * Set Numeric mode to arabic
     *
     * @return DateTime
     */
    public function arabicMode()
    {
        return $this->toggleNumericMode(self::ARABIC_NUMERIC_MODE);
    }

    /**
     * @param string $mode
     *
     * @return DateTime
     */
    protected function toggleNumericMode($mode)
    {
        $this->numericMode = $mode;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Parse Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param array $replace
     *
     * @return string
     */
    private function parseFullDate($replace)
    {
        $format = ':title (:time) :period - :dayName :day :monthName , :year';

        $output = str_replace(
            array_keys($replace),
            array_values($replace),
            $format
        );

        return $this->isArabicMode()
            ? $this->parseArabicNumeric($output)
            : $output;
    }

    /**
     * @param string $date
     *
     * @return string
     */
    protected function parseArabicNumeric($date)
    {
        return Number::convert($date);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Converter Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Convert given Gregorian date into Hijri date
     *
     * @return array Hijri date [int Year, int Month, int Day] (Islamic calendar)
     */
    protected function hjConvert()
    {
        $year   = $this->getYear();
        $month  = $this->getMonth();
        $day    = $this->formatDate('j');

        $jd = function_exists('gregoriantojd')
            ? gregoriantojd($month, $day, $year)
            : $this->gregorianToJD($year, $month, $day);

        return $this->jdToHijri($jd);
    }

    /**
     * Converts a Gregorian date to Julian Day Count
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return integer The julian day for the given gregorian date as an integer
     */
    protected function gregorianToJD($year, $month, $day)
    {
        $year   = (int) $year;
        $month  = (int) $month;
        $day    = (int) $day;

        if ( $month < 3 ) {
            $year--;
            $month += 12;
        }

        if (
            ($year < 1582)
            or ($year == 1582 and $month < 10)
            or ($year == 1582 and $month == 10 and $day <= 15)
        ) {
            // This is ignored in the GregorianToJD PHP function!
            $b = 0;
        }
        else {
            $a = (int) ($year / 100);
            $b = 2 - $a + (int) ($a / 4);
        }

        $jd = (int) (365.25 * ($year + 4716)) + (int) (30.6001 * ($month + 1)) + $day + $b - 1524.5;

        return round($jd);
    }

    /**
     * Convert given Julian day into Hijri date
     *
     * @param integer $jd Julian day
     *
     * @return array Hijri date [int Year, int Month, int Day](Islamic calendar)
     */
    protected function jdToHijri($jd)
    {
        $jd = $jd - 1948440 + 10632;
        $n  = (int)(($jd - 1) / 10631);
        $jd = $jd - 10631 * $n + 354;

        $j  = ((int)((10985 - $jd) / 5316)) *
            ((int)(50 * $jd / 17719)) +
            ((int)($jd / 5670)) *
            ((int)(43 * $jd / 15238));

        $jd = $jd - ((int)((30 - $j) / 15)) *
            ((int)((17719 * $j) / 50)) -
            ((int)($j / 16)) *
            ((int)((15238 * $j) / 43)) + 29;

        $month  = (int) (24 * $jd / 709);
        $day    = $jd - (int) (709 * $month / 24);
        $year   = 30 * $n + $j - 30;

        return compact('year', 'month', 'day');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if numeric mode is arabic
     *
     * @return bool
     */
    public function isArabicMode()
    {
        return $this->numericMode === self::ARABIC_NUMERIC_MODE;
    }

    /**
     * @param string|int $timestamp
     *
     * @throws InvalidTimestampException
     */
    private function checkTimestamp(&$timestamp)
    {
        if ( ! is_numeric($timestamp) and (int)$timestamp !== $timestamp ) {
            throw new InvalidTimestampException('The Timestamp must be a numeric value (string or int).');
        }

        if ( is_string($timestamp) ) {
            $timestamp = (int) $timestamp;
        }
    }
}
