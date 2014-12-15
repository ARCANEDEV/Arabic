<?php namespace Arcanedev\Arabic\Tests;

use Arcanedev\Arabic\DateTime;

class DateTimeTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $instance = 'Arcanedev\\Arabic\\DateTime';

    /** @var DateTime */
    protected $datetime;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->datetime = new DateTime;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->datetime);
    }

    /**
     * @return DateTime
     */
    protected function getObject()
    {
        return $this->datetime;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function testCanBeInstantiate()
    {
        parent::testCanBeInstantiate();

        $this->assertInstanceOf('DateTime', $this->datetime->getDate());
    }

    /**
     * @test
     */
    public function testCanGetAndSetDate()
    {
        $format     = 'Y-m-d H:i:s';
        $datetime   = '2014-12-01 12:00:00';

        $this->datetime->setDatetime($datetime, $format);
        $this->assertEquals($datetime, $this->datetime->getDate()->format($format));
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidDateFormatException
     */
    public function testMustThrowInvalidDateFormatException()
    {
        $this->datetime->setDatetime('2014-12-01 12:00:00', 'm-d H:i:s');
    }

    /**
     * @test
     */
    public function testCanGetSetTimestamp()
    {
        $timestamp = 1417435200;

        $this->datetime->setTimestamp($timestamp);
        $this->assertEquals($timestamp, $this->datetime->getTimestamp());

        $this->datetime->setTimestamp((string) $timestamp);
        $this->assertEquals($timestamp, $this->datetime->getTimestamp());
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTimestampException
     */
    public function testMustThrowInvalidTimestampException()
    {
        $this->datetime->setTimestamp('Current Date');
    }

    /**
     * @test
     */
    public function testGetters()
    {
        $date = new \DateTime;
        $this->assertEquals($date->format('Y'), $this->datetime->getYear());
        $this->assertEquals($date->format('m'), $this->datetime->getMonth());
        $this->assertEquals($date->format('d'), $this->datetime->getDay());
        $this->assertEquals($date->format('H:i'), $this->datetime->getTime());
        $this->assertEquals($date->format('H:i:s'), $this->datetime->getTime(true));
    }

    /**
     * @test
     */
    public function testCanGetArabicDays()
    {
        $arabicDays = $this->datetime->getArabicDaysNames();

        $this->assertEquals(7, count($arabicDays));
        $this->assertEquals($this->getArabicDaysNames(), $arabicDays);

        $this->assertEquals($this->getCurrentArabicDayName(), $this->datetime->getArabicDayName());
    }

    /**
     * @test
     */
    public function testCanGetArabicMonths()
    {
        $arabicMonths = $this->datetime->getArabicMonthsNames();

        $this->assertEquals(12, count($arabicMonths));
        $this->assertEquals($this->getArabicMonthsNames(), $arabicMonths);

        $this->assertEquals($this->getArabicCurrentMonthName(), $this->datetime->getArabicMonthName());
    }

    /**
     * @test
     */
    public function testCanGetHijriMonths()
    {
        $hijriMonths = $this->datetime->getHijriMonthsNames();

        $this->assertEquals(12, count($hijriMonths));
        $this->assertEquals($this->getHijriMonthsNames(), $hijriMonths);
        $this->assertEquals($this->getHijriMonthsNamesIndexes(), $this->datetime->getHijriMonthsIndexes());

        $this->assertEquals('محرم', $this->datetime->getHijriMonthByKey(1));
    }

    /**
     * @test
     */
    public function testCanGetArabicNumbers()
    {
        $arabicNumbers = $this->datetime->getArabicNumbers();

        $this->assertEquals(10, count($arabicNumbers));
        $this->assertEquals($this->getArabicNumbers(), $arabicNumbers);
    }

    /**
     * @test
     */
    public function testCanGetArabicPeriods()
    {
        $arabicPeriods = $this->datetime->getArabicPeriods();
        $this->assertEquals(2, count($arabicPeriods));
        $this->assertEquals($this->getArabicPeriods(), $arabicPeriods);
    }

    /**
     * @test
     */
    public function testCanGetArabicPeriodFromDate()
    {
        $this->assertEquals($this->getCurrentArabicPeriod(), $this->datetime->getArabicPeriod());
    }

    /**
     * @test
     */
    public function testSwitchDate()
    {
        $time = \DateTime::createFromFormat('Y-m-d H:i:s', '2014-12-12 12:00:00')->getTimestamp();

        $this->assertEquals('December 12, 2014, 12:00 pm', $this->datetime->date($time));
        $this->assertEquals('December 12, 2014, 12:00 pm', $this->datetime->date($time, 3));

        $this->assertEquals('الساعة (12:00) مساءا - الجمعه 12 ديسمبر , 2014', $this->datetime->date($time, 1));
        $this->assertEquals('الساعة (١٢:٠٠) مساءا - الجمعه ١٢ ديسمبر , ٢٠١٤', $this->datetime->date($time, 1, true));

        $this->assertEquals('الساعة (12:00) مساءا - الجمعه 19 صفر , 1436', $this->datetime->date($time, 2));
        $this->assertEquals('الساعة (١٢:٠٠) مساءا - الجمعه ١٩ صفر , ١٤٣٦', $this->datetime->date($time, 2, true));
    }

    /**
     * @test
     */
    public function testConvertGregorianToJD()
    {
        $date = self::getMethod('gregorianToJD');

        $this->assertEquals(2457004, $date->invokeArgs($this->datetime, [2014, 12, 12]));
        $this->assertEquals(2298561, $date->invokeArgs($this->datetime, [1581, 02, 12]));
    }

    /**
     * @test
     */
    public function testAgoFunction()
    {
        $this->datetime->setDatetime('2013-10-11 10:09:08', 'Y-m-d H:i:s');

        $arabic_ago = $this->datetime->ago(null, 'ar');

        $pattern = "/\d+ [{Arabic}\w]*/u";
        $this->assertRegExp($pattern, $arabic_ago);

        $pattern = "/(\d+ \w+)/";
        $this->assertRegExp($pattern, $this->datetime->ago(null, 'en'));
    }

    /**
     * @test
     */
    public function testAgoFunctionFromFuture()
    {
        // The Judgement Day
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2037-12-31 23:59:59');

        $this->assertEquals('future', $this->datetime->ago($date->getTimestamp(), 'ar'));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param string $methodName
     *
     * @return \ReflectionMethod
     */
    protected static function getMethod($methodName)
    {
        return parent::getMethodFromClass('Arcanedev\\Arabic\\DateTime', $methodName);
    }
}
