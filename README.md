[![Build Status](https://travis-ci.org/alceanicu/ro-num.svg?branch=master)](https://travis-ci.org/alceanicu/ro-num) [![Latest Stable Version](https://poser.pugx.org/alcea/ro-num/v/stable.svg)](https://packagist.org/packages/alcea/ro-num) [![Total Downloads](https://poser.pugx.org/alcea/ro-num/downloads.svg)](https://packagist.org/packages/alcea/ro-num) [![Latest Unstable Version](https://poser.pugx.org/alcea/ro-num/v/unstable.svg)](https://packagist.org/packages/alcea/ro-num) [![License](https://poser.pugx.org/alcea/ro-num/license.svg)](https://packagist.org/packages/alcea/ro-num)

# Transformare numar in litere
Clasa PHP ce face conversie din numar(cifre) in litere (romana).

# Cum se poate instala?

### 1. composer
```php
composer require alcea/ro-num
```

### 2. sau editeaza - require section from composer.json
```
"alcea/ro-num": "*"
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

# How to run tests
```
## Open an terminal and run commands:
cd ro-num
./vendor/bin/phpunit --bootstrap ./vendor/autoload.php --testdox
```
