[![Build Status](https://travis-ci.org/alceanicu/ro-num.svg?branch=master)](https://travis-ci.org/alceanicu/ro-num) [![Latest Stable Version](https://poser.pugx.org/alcea/ro-num/v/stable.svg)](https://packagist.org/packages/alcea/ro-num) [![Total Downloads](https://poser.pugx.org/alcea/ro-num/downloads.svg)](https://packagist.org/packages/alcea/ro-num) [![License](https://poser.pugx.org/alcea/ro-num/license.svg)](https://packagist.org/packages/alcea/ro-num)

# Transformare numar in litere
Clasa PHP ce face conversie din numar(cifre) in litere (romana).
Transforma orice numar din intervalul [0-999 999 999 999] in transcriere lui in litere (in limba romana).
Orice numar invalid sau in afara intervalului va fi convertit in '' (empty space);
Optional se poate seta si un separator (implicint este ' ' [empty space]);
EX:
```txt
0 va fi transcris in 'zero'
83 va fi transcris in 'optzeci şi trei'
10002 va fi transcris in 'zece mii doi',
```

# Cum se poate instala?

### 1. composer
```php
composer require alcea/ro-num
```

### 2. sau editeaza - require section from composer.json
```
"alcea/ro-num": "^1.1"
```

### 3. sau clone from GitHub
```
git clone https://github.com/alceanicu/ro-num.git
```

# Mod de utilizare?

```php
 use alcea\romanian\TranslateNumberToTxt;

 $number = '22620';
 echo new TranslateNumberToTxt($number);      // douăzeci şi două de mii şase sute douăzeci 
 echo new TranslateNumberToTxt($number, '#'); // douăzeci#şi#două#de#mii#şase#sute#douăzeci 
 echo new TranslateNumberToTxt($number, '');  // douăzecişidouădemiişasesutedouăzeci
 
 // or

 echo TranslateNumberToTxt::convert(255);     // 'două sute cincizeci şi cinci'
 echo TranslateNumberToTxt::convert(83, '#'); // 'optzeci#şi#trei'
 ```

# How to run tests?
```
## Open an terminal and run commands:
cd ro-num
./vendor/bin/phpunit --bootstrap ./vendor/autoload.php --testdox
```


## License

This package is licensed under the [MIT](http://opensource.org/licenses/MIT) license.
