<?php

namespace alcea\romanian;

/**
 * Class TranslateNumberToTxt
 *
 * @property string $_number
 * @property string $_separator
 * @property string $_numberInTxt
 */
class TranslateNumberToTxt
{

    const GR_MLD = 0;
    const GR_MIL = 1;
    const GR_MII = 2;
    const GR_SUT = 3;
    const ZERO = 'zero';

    private $_number;
    private $_separator;
    private $_numberInTxt;
    private static $_sufixGroup = [
        ['miliard', 'milion', 'mie', ''],
        ['miliarde', 'milioane', 'mii', '']
    ];
    private static $_dex = [
        0 => '',
        1 => [
            0 => 'unu',     // 21; 201; 1001
            1 => 'o',       // 100; 1.000
            2 => 'un'       // 1, 1.000.000
        ],
        2 => [
            0 => 'doi',     // 2; 22; 122
            1 => 'două'    // 200; 2.000; 2.200
        ],
        3 => ['trei'],
        4 => ['patru'],
        5 => ['cinci'],
        6 => [
            0 => 'şase',   // 6; 56; 600
            1 => 'şai'     // 60; 60.000
        ],
        7 => ['şapte'],
        8 => ['opt'],
        9 => ['nouă'],
        10 => ['zece'],
        11 => ['unusprezece'],
        12 => ['doisprezece'],
        13 => ['treisprezece'],
        14 => ['patrusprezece'],
        15 => ['cincisprezece'],
        16 => ['şaisprezece'],
        17 => ['şaptesprezece'],
        18 => ['optsprezece'],
        19 => ['nouăsprezece']
    ];

    /**
     * @param string $number
     * @param string $separator
     */
    public function __construct($number, $separator = ' ')
    {
        $this->_number = str_pad($number, 12, '0', STR_PAD_LEFT);
        $this->_separator = $separator;
        $this->_numberInTxt = $this->formatNumberToTxt();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->_numberInTxt;
    }

    /**
     * 
     * @return string
     */
    private function formatNumberToTxt()
    {
        if ($this->_number == '000000000000') {
            return self::ZERO;
        }

        $numLength = strlen($this->_number);
        if ($numLength > 12) {
            return '';
        }

        for ($i = 0; $i < $numLength; $i++) {
            if (!is_numeric($this->_number[$i])) {
                return '';
            }
        }

        $groups = str_split($this->_number, 3);

        $string = [];
        $firstGroup = false;
        foreach ($groups as $groupKey => $groupValue) {
            if ($groupValue === '000') {
                continue;
            }

            $string[$groupKey] = $this->parseGroup($groupKey, $groupValue, $firstGroup);
            $firstGroup = true;
        }

        return implode($this->_separator, $string);
    }

    /**
     * @param string $groupKey - [0 => 'miliarde', 1 => 'milioane', 2 => 'mii', 3 => 'sute']
     * @param string $groupValue - XXX as [0-9][0-9][1-9]
     * @param bool $firstGroup
     * @return string
     */
    private function parseGroup($groupKey, $groupValue, $firstGroup)
    {
        $s = $groupValue[0];
        $z = $groupValue[1];
        $u = $groupValue[2];
        $zu = ($z * 10) + $u;

        if (($s == 0) && ($z == 0) && ($u == 1)) {
            $sufix = self::$_sufixGroup[0][$groupKey];
        } else {
            $sufix = self::$_sufixGroup[1][$groupKey];
        }

        $sufix = empty($sufix) ? '' : $this->_separator . $sufix;

        // for the position of hundreds
        if ($s == 0) {
            $sute = '';
        } elseif ($s == 1) {
            $sute = self::$_dex[$s][1] . $this->_separator . 'sută';
        } elseif ($s == 2) {
            $sute = self::$_dex[$s][1] . $this->_separator . 'sute';
        } elseif ($s == 6) {
            $sute = self::$_dex[$s][0] . $this->_separator . 'sute';
        } else {
            $sute = self::$_dex[$s][0] . $this->_separator . 'sute';
        }

        // X[01-19]
        if ($zu < 20) {
            if ($zu == 0) {
                return $sute . $sufix;
            } elseif ($zu == 1) {
                if ($groupKey == self::GR_MII) {
                    $val = self::$_dex[$zu][1];
                } else {
                    $val = ($s == 0) ? (!$firstGroup ? self::$_dex[$zu][2] : self::$_dex[$zu][0]) : self::$_dex[$zu][0];
                }
            } else {
                if ($groupKey == self::GR_SUT) {
                    $val = self::$_dex[$zu][0];
                } else {
                    $val = ($u == 2) ? self::$_dex[$zu][1] : self::$_dex[$zu][0];
                }
            }

            $sute = empty($sute) ? '' : $sute . $this->_separator;

            return $sute . $val . $sufix;
        }

        // X[20-99]
        if ($zu >= 20) {
            $sufix = ($groupKey != self::GR_SUT) ? ('de' . $sufix) : $sufix;
            $sufix = empty($sufix) ? '' : $this->_separator . $sufix;

            $sep = $this->_separator . 'şi' . $this->_separator;

            if (in_array($z, [2, 6])) {
                $val = self::$_dex[$z][1] . 'zeci';
            } else {
                $val = self::$_dex[$z][0] . 'zeci';
            }

            if ($u == 0) {
                //
            } elseif ($u == 2) {
                if ($groupKey == self::GR_SUT) {
                    $val .= $sep . self::$_dex[$u][0];
                } else {
                    $val .= $sep . self::$_dex[$u][1];
                }
            } else {
                $val .= $sep . self::$_dex[$u][0];
            }

            $sute = empty($sute) ? '' : $sute . $this->_separator;

            return $sute . $val . $sufix;
        }
    }

}
