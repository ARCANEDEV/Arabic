<?php namespace Arcanedev\Arabic\Tests;

use Arcanedev\Arabic\Str;

class StrTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $instance = 'Arcanedev\\Arabic\\Str';

    /** @var Str */
    private $str;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->str = new Str;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->str);
    }

    protected function getObject()
    {
        return $this->str;
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
        $this->assertInstanceOf($this->instance, $this->getObject());
    }
}
