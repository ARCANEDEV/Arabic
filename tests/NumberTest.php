<?php namespace Arcanedev\Arabic\Tests;

use Arcanedev\Arabic\Number;

class NumberTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $instance = 'Arcanedev\\Arabic\\Number';

    /** @var Number */
    private $number;

    private $jamesBond = 'Double O Seven';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->number = new Number;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->number);
    }

    protected function getObject()
    {
        return $this->number;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */

    /**
     * @test
     */
    public function testCanGetAllArabicNumbers()
    {
        $arabicNumbers = Number::all();

        $this->assertEquals(10, count($arabicNumbers));
        $this->assertEquals($this->getArabicNumbers(), $arabicNumbers);
    }

    /**
     * @test
     */
    public function testCanConvert()
    {
        $this->assertEquals('٧', Number::convert(007));
        $this->assertEquals('١٢٣.٤٥', Number::convert(123.45));
        $this->assertEquals('٠٠٧', Number::convert('007'));
        $this->assertEquals('٢٠١٤-١٢-١٢ ١٢:٠٠:٠٠', Number::convert('2014-12-12 12:00:00'));
    }

    /**
     * @test
     */
    public function testCanConvertStringWithoutNumbers()
    {
        $this->assertEquals($this->jamesBond, Number::convert($this->jamesBond, false));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\NumbersNotFoundException
     */
    public function testMustThrowNumbersNotFoundException()
    {
        Number::convert($this->jamesBond);
    }

    /**
     * @test
     */
    public function testCanConvertNumber()
    {
        $this->assertEquals('١٢٠', Number::convertNumber(120));
        $this->assertEquals('٩٩٩.٩٩', Number::convertNumber(999.99));
        $this->assertEquals('١٢٥.٥', Number::convertNumber(125.50));
        $this->assertEquals('١٢٥.٥', Number::convertNumber('125.50'));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeWhileConvertingNumber()
    {
        Number::convertNumber($this->jamesBond);
    }

    /**
     * @test
     */
    public function testCanConvertAndFormatFloatNumber()
    {
        $this->assertEquals('١٢٣.٠٠', Number::convertFloat(123));
        $this->assertEquals('١٢٣,٠٠٠', Number::convertFloat(123, 3, ','));

        $this->assertEquals('١,٢٣٤.٥٠', Number::convertFloat(1234.5));
        $this->assertEquals('١.٢٣٤,٥٠', Number::convertFloat(1234.5, 2, ',', '.'));

        $this->assertEquals('١,٢٣٤.٥٦', Number::convertFloat('1234.56'));
        $this->assertEquals('١.٢٣٤,٥٦', Number::convertFloat('1234.56', 2, ',', '.'));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Arabic\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeWhileConvertingFloat()
    {
        Number::convertFloat($this->jamesBond);
    }
}
