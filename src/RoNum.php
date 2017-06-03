<?php

namespace alcea\roNum;

/**
 * Class RoNum
 *
 * @property string $number
 */
class RoNum
{
    const GR_MLD = 0;
    const GR_MIL = 1;
    const GR_MII = 2;
    const GR_SUT = 3;

    public static $sufixGrup = [
        ['miliard', 'milion', 'mie', ''],
        ['miliarde', 'milioane', 'mii', '']
    ];
    public static $dex = [
        0 => '',
        1 => [
            0 => 'unu',     // 21; 201; 1001
            1 => 'o',       // 100; 1.000
            2 => 'un'       // 1, 1.000.000
        ],
        2 => [
            0 => 'doi',     // 2; 22; 122
            1 => 'două'     // 200; 2.000; 2.200
        ],
        3 => ['trei'],
        4 => ['patru'],
        5 => ['cinci'],
        6 => [
            0 => 'şase',    // 6; 56; 600
            1 => 'şai'      // 60; 60.000
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
     * @return string
     */
    public function format($number, $separator = ' ')
    {
        $number = str_pad($number, 12, '0', STR_PAD_LEFT);

        if ($number == '000000000000') {
            return 'zero';
        }

        $numLength = strlen($number);

        if ($numLength > 12) {
            return '';
        }

        for ($i = 0; $i < $numLength; $i++) {
            if (!is_numeric($number[$i])) {
                return '';
            }
        }

        $grup = str_split($number, 3);

        $str = [];
        $firstGr = false;
        foreach ($grup as $key => $value) {
            if ($value == '000') {
                continue;
            }

            $str[$key] = $this->parseGroup($key, $value, $firstGr, $separator);
            $firstGr = true;
        }

        return implode($separator, $str);
    }

    /**
     * @param string $grup - [0-3] astfel [0 => miliarde; 1 => milioane; 2 => mii; 3 => sute]
     * @param string $suteZeciUnitati - [0-9][0-9][1-9]
     * @param string $separator
     * @return string
     */
    private function parseGroup($grup, $suteZeciUnitati, $firstGrp, $separator = '')
    {
        //
        $s = $suteZeciUnitati[0];
        $z = $suteZeciUnitati[1];
        $u = $suteZeciUnitati[2];
        $zu = ($z * 10) + $u;

        if (($s == 0) && ($z == 0) && ($u == 1)) {
            $sufix = self::$sufixGrup[0][$grup];
        } else {
            $sufix = self::$sufixGrup[1][$grup];
        }

        $sufix = empty($sufix) ? '' : $separator . $sufix;

        // pt. pozitia sutelor
        if ($s == 0) {
            $sute = '';
        } elseif ($s == 1) {
            $sute = self::$dex[$s][1] . $separator . 'sută';
        } elseif ($s == 2) {
            $sute = self::$dex[$s][1] . $separator . 'sute';
        } elseif ($s == 6) {
            $sute = self::$dex[$s][0] . $separator . 'sute';
        } else {
            $sute = self::$dex[$s][0] . $separator . 'sute';
        }

//        if ($zu == 0) {
//            return $sute . $sufix;
//        }

        // X[01-19]
        if ($zu < 20) {
            if ($zu == 0) {
                return $sute . $sufix;
            } elseif ($zu == 1) {
                if ($grup == self::GR_MII) {
                    $val = self::$dex[$zu][1];
                } else {
                    $val = ($s == 0) ? (!$firstGrp ? self::$dex[$zu][2] : self::$dex[$zu][0]) : self::$dex[$zu][0];
                }
            } else {
                if ($grup == self::GR_SUT) {
                    $val = self::$dex[$zu][0];
                } else {
                    $val = ($u == 2) ? self::$dex[$zu][1] : self::$dex[$zu][0];
                }
            }

            $sute = empty($sute) ? '' : $sute . $separator;

            return $sute . $val . $sufix;
        }

        // X[20-99]
        if ($zu >= 20) {
            $sufix = ($grup != self::GR_SUT) ? ('de' . $sufix) : $sufix;
            $sufix = empty($sufix) ? '' : $separator . $sufix;

            $sep = $separator . 'şi' . $separator;

            if (in_array($z, [2, 6])) {
                $val = self::$dex[$z][1] . 'zeci';
            } else {
                $val = self::$dex[$z][0] . 'zeci';
            }

            if ($u == 0) {
                //
            } elseif ($u == 2) {
                if ($grup == self::GR_SUT) {
                    $val .= $sep . self::$dex[$u][0];
                } else {
                    $val .= $sep . self::$dex[$u][1];
                }
            } else {
                $val .= $sep . self::$dex[$u][0];
            }

            $sute = empty($sute) ? '' : $sute . $separator;

            return $sute . $val . $sufix;
        }
    }

}