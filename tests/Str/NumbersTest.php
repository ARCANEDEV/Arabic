<?php namespace Arcanedev\Arabic\Tests\Str;

use Arcanedev\Arabic\Tests\TestCase;

use Arcanedev\Arabic\Str\Numbers;

class NumbersTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $instance = 'Arcanedev\\Arabic\\Str\\Numbers';

    /** @var Numbers */
    private $numbers;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->numbers = new Numbers;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->numbers);
    }

    protected function getObject()
    {
        return $this->numbers;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function testCanGetAnArabicEgg()
    {
        $this->assertEquals('صفر', $this->numbers->convert(0));
    }

    /**
     * @test
     */
    public function testCanConvertNegativeNumber()
    {
        $this->assertEquals('سالب واحدة فاصلة خمسة و أربعون', $this->numbers->convert(-1.45));
    }

    /**
     * @test
     */
    public function testCanSwitchGender()
    {
        $this->assertTrue($this->numbers->isFeminine());
        $this->assertFalse($this->numbers->isMasculine());

        $this->numbers->masculine();
        $this->assertFalse($this->numbers->isFeminine());
        $this->assertTrue($this->numbers->isMasculine());

        $this->numbers->feminine();
        $this->assertTrue($this->numbers->isFeminine());
        $this->assertFalse($this->numbers->isMasculine());
    }

    /**
     * @test
     */
    public function testCanConvertInteger()
    {
        $this->numbers->feminine();
        $this->assertEquals('واحدة', $this->numbers->convert(1));
        $this->assertEquals('عشرة', $this->numbers->convert(10));

        $this->numbers->masculine();
        $this->assertEquals('واحد', $this->numbers->convert(1));
        $this->assertEquals('عشر', $this->numbers->convert(10));
    }

    /**
     * @test
     */
    public function testCanConvertFloat()
    {
        $this->assertEquals('واحدة فاصلة خمسة', $this->numbers->convert(1.5));
        $this->assertEquals('عشرة فاصلة خمسة و سبعون', $this->numbers->convert(10.75));
    }

    /**
     * @test
     */
    public function testCanConvertToIndianChar()
    {
        $htmlAscii = $this->numbers->toArabicIndic(1234567890);

        $this->assertEquals(
            '&#1633;&#1634;&#1635;&#1636;&#1637;&#1638;&#1639;&#1640;&#1641;&#1632;',
            $htmlAscii
        );

        $this->assertEquals(
            '١٢٣٤٥٦٧٨٩٠',
            html_entity_decode($htmlAscii, ENT_QUOTES, 'UTF-8')
        );
    }

    /**
     * @test
     */
    public function testCanSetOrder()
    {
        $this->assertEquals('الأولى', $this->numbers->convert(1, 2));
        $this->assertEquals('العاشرة', $this->numbers->convert(10, 2));
        $this->assertEquals('مئة', $this->numbers->convert(100, 2));
        $this->assertEquals('الألف', $this->numbers->convert(1000, 2));
    }

    /**
     * @test
     */
    public function testCanConvertBigDigits()
    {
        $this->assertEquals(
            'عشرة آلاف و مئة و واحدة',
            $this->numbers->convert(10101)
        );

        $this->assertEquals(
            'ألف و مئتان و أربعة و ثلاثون',
            $this->numbers->convert(1234)
        );

        $this->assertEquals(
            'ألفان و ثلاثمئة و خمسة و أربعون',
            $this->numbers->convert(2345)
        );

        $this->assertEquals(
            'ثلاثة آلاف و أربعمئة و ستة و خمسون',
            $this->numbers->convert(3456)
        );

        $this->assertEquals(
            'مئتان و أربعة و ثلاثون ألف و خمسمئة و سبعة و ستون',
            $this->numbers->convert(234567)
        );

        $this->assertEquals(
            'مليون و مئتان و أربعة و ثلاثون ألف و خمسمئة و سبعة و ستون',
            $this->numbers->convert(1234567)
        );

        $this->assertEquals(
            'مليار و مئتان و أربعة و ثلاثون مليون و خمسمئة و سبعة و ستون ألف و ثمانمئة و تسعون',
            $this->numbers->convert(1234567890)
        );

        $this->assertEquals(
            'تريليون و مئتان و أربعة و ثلاثون مليار و خمسمئة و سبعة و ستون مليون و ثمانمئة و تسعون ألف و مئة و ثلاثة و عشرون',
            $this->numbers->convert(1234567890123)
        );
    }

    /**
     * @test
     */
    public function testCanConvertWithDecimals()
    {
        $this->assertEquals(
            'صفر فاصلة صفر صفر صفر  واحدة',
            $this->numbers->convert(0.0001)
        );

        $this->assertEquals(
            'صفر فاصلة مئة و ثلاثة و عشرون ألف و أربعمئة و ستة و خمسون',
            $this->numbers->convert(0.123456)
        );
    }
}
