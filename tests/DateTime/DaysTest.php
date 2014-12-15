<?php namespace Arcanedev\Arabic\Tests\DateTime;

use Arcanedev\Arabic\Tests\TestCase;

use Arcanedev\Arabic\DateTime\Days;

class DaysTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $instance = 'Arcanedev\\Arabic\\DateTime\\Days';

    /** @var Days */
    private $days;

    /* ------------------------------------------------------------------------------------------------
     |  Main Function
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->days = new Days;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->days);
    }

    /**
     * @return Days
     */
    protected function getObject()
    {
        return $this->days;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * @test
     */
    public function testCanGetAllDays()
    {
        $days = Days::all();
        $this->assertEquals(7, count($days));
        $this->assertEquals($this->getArabicDaysNames(), $days);
    }

    /**
     * @test
     */
    public function testCanGetDayByName()
    {
        $this->assertEquals('الأثنين', Days::getByName('Monday'));
        $this->assertEquals('الثلاثاء', Days::getByName('tuesday'));
        $this->assertEquals('الأحد', Days::getByName('SuNdAy'));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testGetDayByNameMustThrowInvalidTypeException()
    {
        Days::getByName(1);
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\UndefinedOffsetException
     */
    public function testGetDayByNameMustThrowUndefinedOffsetException()
    {
        Days::getByName('Mon');
    }

    /**
     * @test
     */
    public function testCanGetOneDayByShortName()
    {
        $this->assertEquals('الأثنين', Days::getByShortName('Mon'));
        $this->assertEquals('الثلاثاء', Days::getByShortName('tue'));
        $this->assertEquals('الأحد', Days::getByShortName('SuN'));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testGetDayByShortNameMustThrowInvalidTypeException()
    {
        Days::getByShortName(1);
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\UndefinedOffsetException
     */
    public function testGetDayByShortNameMustThrowUndefinedOffsetException()
    {
        Days::getByShortName('Monday');
    }

    /**
     * @test
     */
    public function testCanGetOneDayByIndex()
    {
        $this->assertEquals('الأثنين', Days::getByIndex(1));
        $this->assertEquals('الأحد', Days::getByIndex(7));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testGetDayByIndexMustThrowInvalidTypeException()
    {
        Days::getByIndex('Monday');
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\UndefinedOffsetException
     */
    public function testGetDayByIndexMustThrowUndefinedOffsetException()
    {
        Days::getByIndex(9000);
    }
}
