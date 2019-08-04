<?php

use alcea\romanian\TranslateNumberToTxt;
use PHPUnit\Framework\TestCase;

final class CnpTest extends TestCase
{

    /**
     * @return array
     */
    public function invalidNumberDataProvider()
    {
        return [
            ['zero', '', ''],
            ['numbers', '', ''],
            ['9abc', '', ''],
            ['0X9abc', '', ''],
            ['9.23', '', ''],
            ['9,23', '', ''],
            ['9e23', '', ''],
            ['-12', '', ''],
            [9999999999999999, '', ''],
        ];
    }

    /**
     * @return array
     */
    public function allBaseNumberDataProvider()
    {
        return [
            #number, separator, expected
            [83, '', 'optzecişitrei'],                          // decimal number
            [0123, '', 'optzecişitrei'],                        // octal number (equivalent to 83 decimal)
            [0x1A, '_', 'douăzeci_şi_şase'],                    // hexadecimal number (equivalent to 26 decimal)
            [0b11111111, '#', 'două#sute#cincizeci#şi#cinci'],  // binary number (equivalent to 255 decimal)
        ];
    }

    /**
     * @return array
     */
    public function validNumberDataProvider()
    {
        return [
            #number, separator, expected
            [0, ' ', 'zero'],
            [1, ' ', 'un'],
            [2, ' ', 'doi'],
            [3, ' ', 'trei'],
            [4, ' ', 'patru'],
            [5, ' ', 'cinci'],
            [6, ' ', 'şase'],
            [7, ' ', 'şapte'],
            [8, ' ', 'opt'],
            [9, ' ', 'nouă'],
            [10, ' ', 'zece'],
            [11, ' ', 'unusprezece'],
            [12, ' ', 'doisprezece'],
            [13, ' ', 'treisprezece'],
            [14, ' ', 'patrusprezece'],
            [15, ' ', 'cincisprezece'],
            [16, ' ', 'şaisprezece'],
            [17, ' ', 'şaptesprezece'],
            [18, ' ', 'optsprezece'],
            [19, ' ', 'nouăsprezece'],
            [20, ' ', 'douăzeci'],

            [21, ' ', 'douăzeci şi unu'],
            [22, ' ', 'douăzeci şi doi'],
            [26, ' ', 'douăzeci şi şase'],
            [28, ' ', 'douăzeci şi opt'],

            [60, ' ', 'şaizeci'],
            [61, ' ', 'şaizeci şi unu'],
            [62, ' ', 'şaizeci şi doi'],
            [66, ' ', 'şaizeci şi şase'],
            [69, ' ', 'şaizeci şi nouă'],

            [90, ' ', 'nouăzeci'],
            [91, ' ', 'nouăzeci şi unu'],
            [92, ' ', 'nouăzeci şi doi'],
            [96, ' ', 'nouăzeci şi şase'],
            [99, ' ', 'nouăzeci şi nouă'],
            [93, ' ', 'nouăzeci şi trei'],

            [100, ' ', 'o sută'],
            [101, ' ', 'o sută unu'],
            [102, ' ', 'o sută doi'],
            [106, ' ', 'o sută şase'],
            [108, ' ', 'o sută opt'],

            [111, ' ', 'o sută unusprezece'],
            [112, ' ', 'o sută doisprezece'],
            [116, ' ', 'o sută şaisprezece'],
            [117, ' ', 'o sută şaptesprezece'],

            [121, ' ', 'o sută douăzeci şi unu'],
            [122, ' ', 'o sută douăzeci şi doi'],
            [126, ' ', 'o sută douăzeci şi şase'],
            [129, ' ', 'o sută douăzeci şi nouă'],

            [161, ' ', 'o sută şaizeci şi unu'],
            [162, ' ', 'o sută şaizeci şi doi'],
            [166, ' ', 'o sută şaizeci şi şase'],
            [168, ' ', 'o sută şaizeci şi opt'],

            [200, ' ', 'două sute'],
            [201, ' ', 'două sute unu'],
            [202, ' ', 'două sute doi'],
            [206, ' ', 'două sute şase'],
            [203, ' ', 'două sute trei'],

            [211, ' ', 'două sute unusprezece'],
            [212, ' ', 'două sute doisprezece'],
            [216, ' ', 'două sute şaisprezece'],
            [217, ' ', 'două sute şaptesprezece'],

            [222, ' ', 'două sute douăzeci şi doi'],
            [233, ' ', 'două sute treizeci şi trei'],
            [266, ' ', 'două sute şaizeci şi şase'],

            [300, ' ', 'trei sute'],
            [301, ' ', 'trei sute unu'],
            [302, ' ', 'trei sute doi'],
            [306, ' ', 'trei sute şase'],
            [309, ' ', 'trei sute nouă'],
            [399, ' ', 'trei sute nouăzeci şi nouă'],

            [600, ' ', 'şase sute'],
            [601, ' ', 'şase sute unu'],
            [602, ' ', 'şase sute doi'],
            [606, ' ', 'şase sute şase'],
            [604, ' ', 'şase sute patru'],

            [621, ' ', 'şase sute douăzeci şi unu'],

            [901, ' ', 'nouă sute unu'],
            [961, ' ', 'nouă sute şaizeci şi unu'],
            [999, ' ', 'nouă sute nouăzeci şi nouă'],

            [1000, ' ', 'o mie'],
            [1001, ' ', 'o mie unu'],
            [1002, ' ', 'o mie doi'],
            [1006, ' ', 'o mie şase'],
            [1010, ' ', 'o mie zece'],
            [1018, ' ', 'o mie optsprezece'],
            [1026, ' ', 'o mie douăzeci şi şase'],
            [1126, ' ', 'o mie o sută douăzeci şi şase'],
            [1602, ' ', 'o mie şase sute doi'],
            [1612, ' ', 'o mie şase sute doisprezece'],
            [1622, ' ', 'o mie şase sute douăzeci şi doi'],

            [2000, ' ', 'două mii'],
            [2001, ' ', 'două mii unu'],
            [2002, ' ', 'două mii doi'],
            [2006, ' ', 'două mii şase'],
            [2261, ' ', 'două mii două sute şaizeci şi unu'],
            [2662, ' ', 'două mii şase sute şaizeci şi doi'],
            [2791, ' ', 'două mii şapte sute nouăzeci şi unu'],

            [3000, ' ', 'trei mii'],
            [3001, ' ', 'trei mii unu'],
            [3002, ' ', 'trei mii doi'],
            [3006, ' ', 'trei mii şase'],
            [3621, ' ', 'trei mii şase sute douăzeci şi unu'],

            [6000, ' ', 'şase mii'],
            [6001, ' ', 'şase mii unu'],
            [6002, ' ', 'şase mii doi'],
            [6006, ' ', 'şase mii şase'],
            [6666, ' ', 'şase mii şase sute şaizeci şi şase'],

            [9001, ' ', 'nouă mii unu'],
            [9021, ' ', 'nouă mii douăzeci şi unu'],
            [9261, ' ', 'nouă mii două sute şaizeci şi unu'],
            [9602, ' ', 'nouă mii şase sute doi'],

            [10000, ' ', 'zece mii'],
            [10002, ' ', 'zece mii doi'],
            [10106, ' ', 'zece mii o sută şase'],
            [16001, ' ', 'şaisprezece mii unu'],
            [22051, ' ', 'douăzeci şi două de mii cincizeci şi unu'],
            [72001, ' ', 'şaptezeci şi două de mii unu'],

            [200000, ' ', 'două sute mii'],
            [206101, ' ', 'două sute şase mii o sută unu'],
            [536252, ' ', 'cinci sute treizeci şi şase de mii două sute cincizeci şi doi'],

            [1000000, ' ', 'un milion'],
            [1001000, ' ', 'un milion o mie'],
            [1001012, ' ', 'un milion o mie doisprezece'],
            [1002066, ' ', 'un milion două mii şaizeci şi şase'],
            [1261302, ' ', 'un milion două sute şaizeci şi unu de mii trei sute doi'],
            [1662622, ' ', 'un milion şase sute şaizeci şi două de mii şase sute douăzeci şi doi'],

            [2000000, ' ', 'două milioane'],
            [2000006, ' ', 'două milioane şase'],

            [6000000, ' ', 'şase milioane'],
            [6661116, ' ', 'şase milioane şase sute şaizeci şi unu de mii o sută şaisprezece'],

            [7010601, ' ', 'şapte milioane zece mii şase sute unu'],

            [62032042, ' ', 'şaizeci şi două de milioane treizeci şi două de mii patruzeci şi doi'],
            [72010601, ' ', 'şaptezeci şi două de milioane zece mii şase sute unu'],

            [100000000, ' ', 'o sută milioane'],
            [100006000, ' ', 'o sută milioane şase mii'],
            [200000000, ' ', 'două sute milioane'],
            [200000101, ' ', 'două sute milioane o sută unu'],
            [207010621, ' ', 'două sute şapte milioane zece mii şase sute douăzeci şi unu'],

            [1000000000, ' ', 'un miliard'],
            [2000006000, ' ', 'două miliarde şase mii'],
            [6213006002, ' ', 'şase miliarde două sute treisprezece milioane şase mii doi'],
            [8602020002, ' ', 'opt miliarde şase sute două milioane douăzeci de mii doi'],
            [16102021903, ' ', 'şaisprezece miliarde o sută două milioane douăzeci şi unu de mii nouă sute trei'],
            [602232136102, ' ', 'şase sute două miliarde două sute treizeci şi două de milioane o sută treizeci şi şase de mii o sută doi'],

            [999999999999, ' ', 'nouă sute nouăzeci şi nouă de miliarde nouă sute nouăzeci şi nouă de milioane nouă sute nouăzeci şi nouă de mii nouă sute nouăzeci şi nouă'],
            [999999999999, ' ', 'nouă sute nouăzeci şi nouă de miliarde nouă sute nouăzeci şi nouă de milioane nouă sute nouăzeci şi nouă de mii nouă sute nouăzeci şi nouă'],
        ];
    }

    /**
     * @dataProvider validNumberDataProvider
     * @param string|int $number
     * @param string $separator
     * @param string $expected
     */
    public function testCanGetTextRepresentationFromValidNumbers($number, $separator, $expected)
    {
        $this->assertEquals(new TranslateNumberToTxt($number, $separator), $expected);
    }

    /**
     * @dataProvider validNumberDataProvider
     * @param string|int $number
     * @param string $separator
     * @param string $expected
     */
    public function testCanGetTextRepresentationFromValidNumbersByCallingStaticConvertFunction($number, $separator, $expected)
    {
        $this->assertEquals(TranslateNumberToTxt::convert($number, $separator), $expected);
    }

    /**
     * @dataProvider allBaseNumberDataProvider
     * @param string|int $number
     * @param string $separator
     * @param string $expected
     */
    public function testCanGetTextRepresentationFromOtherBaseValidNumbers($number, $separator, $expected)
    {
        $this->assertEquals(new TranslateNumberToTxt($number, $separator), $expected);
    }

    /**
     * @dataProvider allBaseNumberDataProvider
     * @param string|int $number
     * @param string $separator
     * @param string $expected
     */
    public function testCanGetTextRepresentationFromOtherBaseValidNumbersByCallingStaticConvertFunction($number, $separator, $expected)
    {
        $this->assertEquals(TranslateNumberToTxt::convert($number, $separator), $expected);
    }

    /**
     * @dataProvider invalidNumberDataProvider
     * @param string|int $number
     * @param string $separator
     * @param string $expected
     */
    public function testCanNotGetTextRepresentationFromInvalidNumbers($number, $separator, $expected)
    {
        $this->assertEquals(new TranslateNumberToTxt($number, $separator), $expected);
    }

    /**
     * @dataProvider invalidNumberDataProvider
     * @param string|int $number
     * @param string $separator
     * @param string $expected
     */
    public function testCanNotGetTextRepresentationFromInvalidNumbersByCallingStaticConvertFunction($number, $separator, $expected)
    {
        $this->assertEquals(new TranslateNumberToTxt($number, $separator), $expected);
    }

}
