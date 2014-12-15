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
}
