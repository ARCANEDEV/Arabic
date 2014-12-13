<?php namespace Arcanedev\Arabic\Contracts;

use Arcanedev\Arabic\Exceptions\InvalidDateFormatException;

interface DateTimeInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate();

    /**
     * @param string $datetime
     * @param string $format
     *
     * @throws InvalidDateFormatException
     *
     * @return DateTimeInterface
     */
    public function setDatetime($datetime, $format);

    /**
     * Get Timestamp from date
     *
     * @return int
     */
    public function getTimestamp();

    /**
     * Set date based on unix time
     *
     * @param int $timestamp time
     *
     * @return DateTimeInterface
     */
    public function setTimestamp($timestamp);

    /**
     * @return array
     */
    public function getArabicDaysNames();

    /**
     * Get Arabic Months Names
     *
     * @return array
     */
    public function getArabicMonthsNames();

    /**
     * Get Hijri Months Names
     *
     * @return array
     */
    public function getHijriMonthsNames();

    /**
     * Get Arabic Periods
     *
     * @return array
     */
    public function getArabicPeriods();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * Get date in Arabic
     *
     * @param int             $mode          - (0) english | (1) arabic | (2) hijri
     * @param bool            $arabicMode
     * @param int|string|null $timestamp time
     *
     * @return string contain date
     */
    public function date($mode = 0, $arabicMode = false, $timestamp = null);

    /**
     * Get date in English
     *
     * @param string $unixTime time
     *
     * @return string contain date
     */
    public function englishDate($unixTime);

    /**
     * Get arabic date from Unix Time
     *
     * @param int    $unixTime
     * @param string $numericMode (arabic || indian)
     *
     * @return string contain date
     *
     */
    public function arabicDate($unixTime, $numericMode = null);

    /**
     * Get hijri date from Unix Time
     *
     * @param int  $timestamp
     * @param null $arabicMode
     *
     * @return string contain date
     */
    public function hijriDate($timestamp = null, $arabicMode = null);

    /**
     * Set Numeric mode to latin
     *
     * @return DateTimeInterface
     */
    public function latinMode();

    /**
     * Set Numeric mode to arabic
     *
     * @return DateTimeInterface
     */
    public function arabicMode();

    /* ------------------------------------------------------------------------------------------------
     |  Check Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if numeric mode is arabic
     *
     * @return bool
     */
    public function isArabicMode();
}
