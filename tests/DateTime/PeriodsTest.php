<?php namespace Arcanedev\Arabic\Tests\DateTime;

use Arcanedev\Arabic\DateTime\Periods;
use Arcanedev\Arabic\Tests\TestCase;

class PeriodsTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $instance = 'Arcanedev\\Arabic\\DateTime\\Periods';

    /** @var Periods */
    private $periods;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->periods = new Periods;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->periods);
    }

    /**
     * @return Periods
     */
    protected function getObject()
    {
        return $this->periods;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * @test
     */
    public function testCanGetAllPeriods()
    {
        $periods = Periods::all();

        $this->assertEquals(2, count(Periods::all()));
        $this->assertEquals($this->getArabicPeriods(), $periods);
    }

    /**
     * @test
     */
    public function testCanGetOnePeriod()
    {
        $am = 'صباحا';
        $this->assertEquals($am, Periods::getOneByKey('am'));
        $this->assertEquals($am, Periods::getOneByKey('Am'));
        $this->assertEquals($am, Periods::getOneByKey('AM'));
        $this->assertEquals($am, Periods::getOneByKey('aM'));

        $pm = 'مساءا';
        $this->assertEquals($pm, Periods::getOneByKey('pm'));
        $this->assertEquals($pm, Periods::getOneByKey('Pm'));
        $this->assertEquals($pm, Periods::getOneByKey('PM'));
        $this->assertEquals($pm, Periods::getOneByKey('pM'));
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnGetOnePeriod()
    {
        Periods::getOneByKey(true);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Arabic\Exceptions\UndefinedOffsetException
     * @expectedExceptionMessage The period key must be am or pm, [ok] is given
     */
    public function testMustThrowUndefinedOffsetExceptionOnGetOnePeriod()
    {
        Periods::getOneByKey('ok');
    }
}
