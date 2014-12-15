<?php namespace Arcanedev\Arabic\Str;

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

    /** @var array */
    private $arabicIndic   = [];

    /** @var array */
    private $ordering       = [];

    private $feminine       = 1;

    private $format        = 1;

    private $order         = 1;

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

        $this->loadIndividualsData($data);

        $this->loadComplicationData($data);

        $this->loadOrderingData($data);

        $this->loadArabicIndic($data);
    }


    private function loadIndividualsData($data)
    {
        foreach ($data['individual'] as $num => $individual) {
            if ( is_string($individual) ) {
                $this->individuals[$num] = $individual;
            }
            elseif ( isset($individual['grammar']) ) {
                $this->individuals[$num] = $individual['grammar'];
            }
            else {
                foreach($individual as $gender => $value) {
                    if ( is_array($value) && isset($value['grammar'])) {
                        $this->individuals[$num][$gender] = $value['grammar'];
                    }
                    else {
                        $this->individuals[$num][$gender] = $value;
                    }
                }
            }
        }
    }

    private function loadComplicationData($data)
    {
        if ( ! isset($data['complications']) ) {
            throw new \Exception('Ordering data not found, check the data array.');
        }

        $this->complications = $data['complications'];
    }

    private function loadOrderingData($data)
    {
        if ( ! isset($data['ordering']) ) {
            throw new \Exception('Ordering data not found, check the data array.');
        }

        $this->ordering = $data['ordering'];
    }

    private function loadArabicIndic($data)
    {
        if ( ! isset($data['arabic-indic']) ) {
            throw new \Exception('Ordering data not found, check the data array.');
        }

        $this->arabicIndic = $data['arabic-indic'];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getter & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the feminine flag of counted object
     *
     * @return int return current setting of counted object feminine flag
     */
    public function getFeminine()
    {
        return $this->feminine;
    }

    /**
     * Set feminine flag of the counted object
     *
     * @param int $value Counted object feminine (1 for masculine & 2 for feminine)
     *
     * @return self
     */
    public function setFeminine($value)
    {
        if ( $value == 1 or $value == 2) {
            $this->feminine = $value;
        }

        return $this;
    }

    /**
     * Get the gender key
     *
     * @return string
     */
    private function getGenderKey()
    {
        return $this->isFeminine() ? self::KEY_FEMALE : self::KEY_MALE;
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
     * @return self
     */
    public function setFormat($value)
    {
        if ($value == 1 or $value == 2) {
            $this->format = $value;
        }

        return $this;
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
     * @param bool $isFormated
     *
     * @return string
     */
    private function getIndividualItem($number, $prefixed = false, $isFormated = true)
    {
        $prefix = ($prefixed ? self::STR_PRE : '');

        $item   = $isFormated
            ? $this->individuals[$number][$this->getFormat()]
            : $this->individuals[$number];

        return $prefix . $item;
    }

    /**
     * @param int  $number
     * @param bool $isFormated
     *
     * @return string
     */
    private function getOnesIndividualItem($number, $isFormated = false)
    {
        $item = $this->individuals[$number][$this->getGenderKey()];

        return $isFormated
            ? $item[$this->getFormat()]
            : $item;
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
        $prefix = ($prefixed ? self::STR_PRE : '');

        $item = $withGender
            ? $this->individuals[$number][$this->getGenderKey()]
            : $this->individuals[$number];

        return $prefix . $item[$this->getFormat()];
    }

    /**
     * @param int $number
     *
     * @return string
     */
    private function getHundredIndividualItem($number)
    {
        return $this->getIndividualItem($number, false, ($number === 200));
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
            return $this->getFeminine() == 1 ? 'الأول' : 'الأولى';
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
     * Represent integer convert in Arabic-Indic digits using HTML entities
     *
     * @param int $number The convert you want to present in Arabic-Indic digits using HTML entities
     *
     * @return string The Arabic-Indic digits represent inserted integer convert using HTML entities
     */
    public function intToIndic($number)
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
     * @param int|float $number The convert you want to spell in Arabic idiom
     *
     * @return string The Arabic idiom that spells inserted convert
     */
    protected function subIntToStr($number)
    {
        $number = trim($number);

        if ( $number === 0 ) {
            return self::STR_ZERO;
        }

        $zeros  = $this->getZeroes($number);

        $blocks = $this->getBlocks($number);

        $items  = [];

        for ($i = (count($blocks) - 1); $i >= 0; $i--) {
            $number = (int) floor($blocks[$i]);

            $text   = $this->writtenBlock($number);

            if ( $text ) {
                if ($number === 1 and $i !== 0) {
                    $text = $this->complications[$i][4];

                    $text = ($this->isOrdered() ? self::STR_PRE : '') . $text;
                }
                elseif ($number == 2 and $i != 0) {
                    $text = $this->complications[$i][$this->getFormat()];

                    $text = ($this->isOrdered() ? self::STR_PRE : '') . $text;
                }
                elseif ($number > 2 and $number < 11 and $i != 0) {
                    $text .= ' ' . $this->complications[$i][3];

                    $text = ($this->isOrdered() ? self::STR_PRE : '') . $text;
                }
                elseif ($i != 0) {
                    $text .= ' ' . $this->complications[$i][4];

                    $text = ($this->isOrdered() ? self::STR_PRE : '') . $text;
                }

                if ( $text != '' and $zeros != '') {
                    $text  = $zeros . ' ' . $text;
                    $zeros = '';
                }

                array_push($items, $text);
            }
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
                    array_push($items, $this->getOrderingItem($number));
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
    private function isMasculine()
    {
        return ! $this->isFeminine();
    }

    /**
     * Check if feminine mode is activated
     *
     * @return bool
     */
    private function isFeminine()
    {
        return $this->getFeminine() === 1;
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
}
