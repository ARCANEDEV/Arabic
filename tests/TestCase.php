<?php namespace Arcanedev\Arabic\Tests;

use ReflectionClass;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $instance = '';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    abstract protected function getObject();

    /**
     * @param string $class
     * @param string $name
     *
     * @return \ReflectionMethod
     */
    protected static function getMethodFromClass($class, $name)
    {
        $class  = new ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Common Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function testCanBeInstantiate()
    {
        $this->assertInstanceOf($this->instance, $this->getObject());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return array
     */
    protected function getArabicPeriods()
    {
        return [
            'am' => 'صباحا',
            'pm' => 'مساءا'
        ];
    }

    /**
     * @return string
     */
    protected function getCurrentArabicPeriod()
    {
        $key = date('a');

        return $this->getArabicPeriods()[$key];
    }

    /**
     * @return array
     */
    protected function getArabicDaysNames()
    {
        return [
            'Mon'   => 'الأثنين',
            'Tue'   => 'الثلاثاء',
            'Wed'   => 'الأربعاء',
            'Thu'   => 'الخميس',
            'Fri'   => 'الجمعه',
            'Sat'   => 'السبت',
            'Sun'   => 'الأحد',
        ];
    }

    /**
     * @return string
     */
    protected function getCurrentArabicDayName()
    {
        $key = date('D');

        return $this->getArabicDaysNames()[$key];
    }

    /**
     * @return array
     */
    protected function getArabicMonthsNames()
    {
        return [
            'Jan'   => 'يناير',
            'Feb'   => 'فبراير',
            'Mar'   => 'مارس',
            'Apr'   => 'أبريل',
            'May'   => 'مايو',
            'Jun'   => 'يونيو',
            'Jul'   => 'يوليو',
            'Aug'   => 'أغسطس',
            'Sep'   => 'سبتمبر',
            'Oct'   => 'أكتوبر',
            'Nov'   => 'نوفمبر',
            'Dec'   => 'ديسمبر'
        ];
    }

    /**
     * @return string
     */
    protected function getArabicCurrentMonthName()
    {
        $key = date('M');

        return $this->getArabicMonthsNames()[$key];
    }

    protected function getHijriMonthsNames()
    {
        return [
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
    }

    public function getHijriMonthsNamesIndexes()
    {
        return array_combine(range(1, 12), array_values($this->getHijriMonthsNames()));
    }

    protected function getArabicNumbers() {
        return [
            '0'   => '٠',
            '1'   => '١',
            '2'   => '٢',
            '3'   => '٣',
            '4'   => '٤',
            '5'   => '٥',
            '6'   => '٦',
            '7'   => '٧',
            '8'   => '٨',
            '9'   => '٩'
        ];
    }
}
