<?php namespace Arcanedev\Arabic\Tests\DateTime;

use Arcanedev\Arabic\Tests\TestCase;

use Arcanedev\Arabic\DateTime\Months;

class MonthsTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $instance = 'Arcanedev\\Arabic\\DateTime\\Months';

    /** @var Months */
    private $months;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->months = new Months;
    }

    public function tearDown()
    {
        unset($this->months);
    }

    protected function getObject()
    {
        return $this->months;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * @test
     */
    public function testCanGetAllArabicMonths()
    {
        $months = Months::getAllArabic();

        $this->assertEquals(12, count($months));
        $this->assertEquals($this->getArabicMonthsNames(), $months);
    }

    /**
     * @test
     */
    public function testCanGetArabicMonthByName()
    {
        $this->assertEquals('يناير',    Months::getOneArabicByName('January'));
        $this->assertEquals('فبراير',   Months::getOneArabicByName('february'));
        $this->assertEquals('نوفمبر',   Months::getOneArabicByName('NoVeMbEr'));
        $this->assertEquals('ديسمبر',   Months::getOneArabicByName('December'));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnGetArabicMonthByName()
    {
        Months::getOneArabicByName(1);
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\UndefinedOffsetException
     */
    public function testMustThrowUndefinedOffsetExceptionOnGetArabicMonthByName()
    {
        Months::getOneArabicByName('Jan');
    }

    /**
     * @test
     */
    public function testCanGetArabicMonthByShortName()
    {
        $this->assertEquals('يناير',    Months::getOneArabicByShortName('Jan'));
        $this->assertEquals('فبراير',   Months::getOneArabicByShortName('feb'));
        $this->assertEquals('نوفمبر',   Months::getOneArabicByShortName('NoV'));
        $this->assertEquals('ديسمبر',   Months::getOneArabicByShortName('Dec'));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnGetArabicMonthByShortName()
    {
        Months::getOneArabicByShortName(1);
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\UndefinedOffsetException
     */
    public function testMustThrowUndefinedOffsetExceptionOnGetArabicMonthByShortName()
    {
        Months::getOneArabicByShortName('January');
    }

    /**
     * @test
     */
    public function testCanGetArabicMonthByIndex()
    {
        $this->assertEquals('يناير',    Months::getOneArabicByIndex(1));
        $this->assertEquals('فبراير',   Months::getOneArabicByIndex(2));
        $this->assertEquals('نوفمبر',   Months::getOneArabicByIndex(11));
        $this->assertEquals('ديسمبر',   Months::getOneArabicByIndex(12));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnGetArabicMonthByIndex()
    {
        Months::getOneArabicByIndex('Jan');
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\UndefinedOffsetException
     */
    public function testMustThrowUndefinedOffsetExceptionOnGetArabicMonthByIndex()
    {
        Months::getOneArabicByIndex(0);
    }

    /**
     * @test
     */
    public function testCanGetHijriMonths()
    {
        $months = Months::getAllHijri();

        $this->assertEquals(12, count($months));
        $this->assertEquals($this->getHijriMonthsNames(), $months);
    }

    /**
     * @test
     */
    public function testCanGetHijriMonthByIndex()
    {
        $this->assertEquals('محرم', Months::getOneHijriByIndex(1));
        $this->assertEquals('صفر', Months::getOneHijriByIndex(2));
        $this->assertEquals('ذو القعدة', Months::getOneHijriByIndex(11));
        $this->assertEquals('ذو الحجة', Months::getOneHijriByIndex(12));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnGetHijriMonthByIndex()
    {
        Months::getOneHijriByIndex('Jan');
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\UndefinedOffsetException
     */
    public function testMustThrowUndefinedOffsetExceptionOnGetHijriMonthByIndex()
    {
        Months::getOneHijriByIndex(0);
    }
}
