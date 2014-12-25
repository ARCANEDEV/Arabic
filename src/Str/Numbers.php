<?php namespace Arcanedev\Arabic\Str;

use Arcanedev\Arabic\Exceptions\MaximumLengthException;

class Numbers
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var array */
    private $individuals    = [];

    /** @var array */
    private $complications  = [];

    /**
     * Hindu–Arabic numeric
     *
     * @var array
     */
    private $arabicIndic   = [];

    /** @var array */
    private $ordering       = [];

    private $feminine       = true;

    private $format         = 1;

    private $order          = 1;

    private $ordered        = true;

    const KEY_MALE          = 'male';
    const KEY_FEMALE        = 'female';

    const STR_NEGATIVE      = 'سالب ';
    const STR_ZERO          = 'صفر';
    const STR_COMMA         = ' فاصلة';
    const STR_AND           = 'و';
    const STR_PRE           = 'ال';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Loads initialize values
     *
     * @ignore
     */
    public function __construct()
    {
        $data = include __DIR__ . '/../data/numbers.php';

        $this->loadIndividualsData($data['individual']);

        $this->complications = $data['complications'];

        $this->ordering      = $data['ordering'];

        $this->arabicIndic   = $data['arabic-indic'];
    }

    /**
     * Load the individuals data
     *
     * @param array $individuals
     */
    private function loadIndividualsData($individuals)
    {
        foreach ($individuals as $num => $individual) {
            if ( is_string($individual) ) {
                $this->individuals[$num] = $individual;
            }
            elseif ( isset($individual['grammar']) ) {
                $this->individuals[$num] = $individual['grammar'];
            }
            else {
                foreach($individual as $gender => $value) {
                    $this->individuals[$num][$gender] = (is_array($value) and isset($value['grammar']))
                        ? $value['grammar'] : $value;
                }
            }
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getter & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set Numbers to masculine output
     *
     * @return Numbers
     */
    public function masculine()
    {
        return $this->setFeminine(false);
    }

    /**
     * Set Numbers to feminine output
     *
     * @return Numbers
     */
    public function feminine()
    {
        return $this->setFeminine(true);
    }

    /**
     * Set feminine flag of the counted object
     *
     * @param bool $feminine
     *
     * @return Numbers
     */
    private function setFeminine($feminine = true)
    {
        $this->feminine = $feminine;

        return $this;
    }

    /**
     * Get the gender key
     *
     * @return string
     */
    private function getGenderKey()
    {
        return $this->isFeminine()
            ? self::KEY_FEMALE
            : self::KEY_MALE;
    }

    /**
     * Get the grammar position flag of counted object
     *
     * @return int return current setting of counted object grammar position flag
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set the grammar position flag of the counted object
     *
     * @param int $value Grammar position of counted object (1 if Marfoua & 2 if Mansoub or Majrour)
     *
     * @return Numbers
     */
    public function setFormat($value)
    {
        if ($value == 1 or $value == 2) {
            $this->format = $value;
        }

        return $this;
    }

    public function ordered()
    {

    }

    public function unordered()
    {

    }

    /**
     * Get the ordering flag value
     *
     * @return int return current setting of ordering flag value
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the ordering flag, is it normal convert or ordering convert
     *
     * @param int $value Is it an ordering convert? default is 1 (use 1 if no and 2 if yes)
     *
     * @return self
     */
    public function setOrder($value)
    {
        if ( $value == 1 or $value == 2 ) {
            $this->order = $value;
        }

        return $this;
    }

    /**
     * @param int  $number
     * @param bool $prefixed
     * @param bool $format
     *
     * @return string
     */
    private function getIndividualItem($number, $prefixed = false, $format = true)
    {
        $item   = $this->individuals[$number];

        if ($format) {
            $item = $item[$this->getFormat()];
        }

        return ($prefixed ? self::STR_PRE : '') . $item;
    }

    /**
     * @param int  $number
     * @param bool $format
     *
     * @return string
     */
    private function getOnesIndividualItem($number, $format = false)
    {
        $item = $this->individuals[$number][$this->getGenderKey()];

        return $format ? $item[$this->getFormat()]  : $item;
    }

    /**
     * @param int  $number
     * @param bool $prefixed
     * @param bool $withGender
     *
     * @return string
     */
    private function getTensIndividualItem($number, $prefixed = false, $withGender = false)
    {
        $item = $withGender
            ? $this->individuals[$number][$this->getGenderKey()]
            : $this->individuals[$number];

        return ($prefixed ? self::STR_PRE : '') . $item[$this->getFormat()];
    }

    /**
     * Get Hundred Individual Item
     *
     * @param int  $number
     * @param bool $prefixed
     *
     * @return string
     */
    private function getHundredIndividualItem($number, $prefixed = false)
    {
        return $this->getIndividualItem($number, $prefixed, ($number === 200));
    }

    /**
     * @param int  $number
     * @param bool $prefixed
     *
     * @return string
     */
    private function getOrderingItem($number, $prefixed = false)
    {
        return ($prefixed ? self::STR_PRE : '') . $this->ordering[$number][$this->getGenderKey()];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Spell integer convert in Arabic idiom
     *
     * @param int $number The convert you want to spell in Arabic idiom
     * @param int $order
     *
     * @return string The Arabic idiom that spells inserted convert
     */
    public function convert($number, $order = null)
    {
        if ( ! is_null($order) ) {
            $this->setOrder($order);
        }

        if ( $number == 1 && $this->getOrder() == 2 ) {
            return $this->isFeminine() ? 'الأولى' : 'الأول';
        }

        $string = $this->getNegativeSignFromNumber($number);

        $number     = explode('.', $number);

        $string    .= $this->subIntToStr($number[0]);

        if ( ! empty($number[1]) ) {
            $decimal    = $this->subIntToStr($number[1]);
            $string    .= self::STR_COMMA . ' ' . $decimal;
        }

        return $string;
    }

    /**
     * Represent integer convert in Arabic-Indic digits using HTML entities (ASCII)
     *
     * @param int $number The convert you want to present in Arabic-Indic digits using HTML entities
     *
     * @return string The Arabic-Indic digits represent inserted integer convert using HTML entities
     */
    public function toArabicIndic($number)
    {
        return strtr("$number", $this->arabicIndic);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the negative sign if the number is negative
     *
     * @param int|float $number
     *
     * @return string
     */
    private function getNegativeSignFromNumber(&$number)
    {
        if ( $number >= 0 ) {
            return '';
        }

        $number = (string) -1 * $number;

        return self::STR_NEGATIVE;
    }

    /**
     * Spell integer convert in Arabic idiom
     *
     * @param int|float $number
     *
     * @throws MaximumLengthException
     *
     * @return string The Arabic idiom that spells inserted convert
     */
    protected function subIntToStr($number)
    {
        $number = trim($number);

        $this->checkNumberLength($number);

        if ($number === '0') {
            return self::STR_ZERO;
        }

        $zeros  = $this->getZeroes($number);

        $blocks = $this->getBlocks($number);

        $items  = [];

        foreach(array_reverse($blocks, true) as $i => $block) {
            $number = (int) floor($block);

            $text   = $this->writtenBlock($number);

            if ( empty($text) ) {
                continue;
            }

            if ($i !== 0) {
                if ($number === 1) {
                    $text = $this->complications[$i][4];

                    $text = ($this->isOrdered() ? self::STR_PRE : '') . $text;
                }
                elseif ($number == 2) {
                    $text = $this->complications[$i][$this->getFormat()];

                    $text = ($this->isOrdered() ? self::STR_PRE : '') . $text;
                }
                elseif ($number > 2 and $number < 11) {
                    $text .= ' ' . $this->complications[$i][3];

                    $text = ($this->isOrdered() ? self::STR_PRE : '') . $text;
                }
                else {
                    $text .= ' ' . $this->complications[$i][4];

                    $text = ($this->isOrdered() ? self::STR_PRE : '') . $text;
                }
            }

            if ( $text != '' and $zeros != '') {
                $text  = $zeros . ' ' . $text;
                $zeros = '';
            }

            array_push($items, $text);
        }

        return implode(' ' . self::STR_AND . ' ', $items);
    }

    /**
     * @param int|float $number
     *
     * @return string
     */
    private function getZeroes($number)
    {
        $zeros      = '';
        $numbers    = $number;

        while ( $numbers[0] == '0' ) {
            $zeros  = self::STR_ZERO . ' ' . $zeros;
            $numbers = substr($numbers, 1, strlen($numbers));
        };

        return $zeros;
    }

    /**
     * Divide number by 3 digits
     *
     * @param $number
     *
     * @return array
     */
    private function getBlocks($number)
    {
        $blocks = [];

        while ( strlen($number) > 3 ) {
            array_push($blocks, substr($number, -3));
            $number = substr($number, 0, strlen($number) - 3);
        }

        array_push($blocks, $number);

        return $blocks;
    }

    /**
     * Spell sub block convert of three digits max in Arabic idiom
     *
     * @param int $number Sub block convert of three digits max you want to spell in Arabic idiom
     *
     * @return string The Arabic idiom that spells inserted sub block
     */
    private function writtenBlock($number)
    {
        $items  = [];

        if ( $number > 99 ) {
            $hundred = $this->calculateHundredKey($number);

            array_push($items, $this->getHundredIndividualItem($hundred));

            $number  = $number % 100;
        }

        if ( $number != 0 ) {
            if ( $this->isOrdered() ) {
                if ( $number <= 10 ) {
                    array_push($items, $this->getOrderingItem($number, true));
                }
                elseif ( $number < 20 ) {
                    $number    -= 10;

                    array_push($items,
                        $this->getOrderingItem($number, true) . ($this->isMasculine() ? ' عشر' : ' عشرة')
                    );
                }
                else {
                    $ones = $number % 10;

                    if ( $this->isInOrdering($ones) ) {
                        array_push($items, $this->getOrderingItem($ones, true));
                    }

                    $tens = $this->calculateTensKey($number);
                    array_push($items, $this->getTensIndividualItem($tens, true));
                }
            }
            else {
                if ($number === 2 or $number === 12) {
                    array_push($items, $this->getOnesIndividualItem($number, true));
                }
                elseif ($number < 20) {
                    array_push($items, $this->getOnesIndividualItem($number));
                }
                else {
                    $ones = $number % 10;

                    if ($ones === 2) {
                        array_push($items, $this->getOnesIndividualItem($ones, true));
                    }
                    elseif ($ones > 0) {
                        array_push($items, $this->getOnesIndividualItem($ones));
                    }

                    $tens = $this->calculateTensKey($number);
                    array_push($items, $this->getTensIndividualItem($tens));
                }
            }
        }

        return implode(' ' . self::STR_AND . ' ', array_filter($items));
    }

    /**
     * Calculate array key (number * Hundred)
     *
     * @param int|float $number
     *
     * @return int
     */
    private function calculateHundredKey($number)
    {
        return $this->calculateKey($number, 100);
    }

    /**
     * Calculate array key (number * Ten)
     *
     * @param int|float $number
     *
     * @return int
     */
    private function calculateTensKey($number)
    {
        return $this->calculateKey($number, 10);
    }

    /**
     * Calculate array key
     *
     * @param int|float $number
     * @param int       $coefficient
     *
     * @return int
     */
    public function calculateKey($number, $coefficient)
    {
        return (int) (floor($number / $coefficient) * $coefficient);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if masculine mode is activated
     *
     * @return bool
     */
    public function isMasculine()
    {
        return ! $this->isFeminine();
    }

    /**
     * Check if feminine mode is activated
     *
     * @return bool
     */
    public function isFeminine()
    {
        return $this->feminine;
    }

    /**
     * @return bool
     */
    private function isOrdered()
    {
        return $this->getOrder() === 2;
    }

    /**
     * @param int $number
     *
     * @return bool
     */
    private function isInOrdering($number)
    {
        return isset($this->ordering[$number]);
    }

    /**
     * @param string $number
     *
     * @throws MaximumLengthException
     */
    private function checkNumberLength($number)
    {
        if (strlen($number) > 14) {
            $msg = 'The number of digits exceeds the maximum length (14 digits).';

            throw new MaximumLengthException($msg);
        }
    }
}
