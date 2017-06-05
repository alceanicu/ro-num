[![Build Status](https://travis-ci.org/alceanicu/ro-num.svg?branch=master)](https://travis-ci.org/alceanicu/ro-num) [![Latest Stable Version](https://poser.pugx.org/alcea/ro-num/v/stable.svg)](https://packagist.org/packages/alcea/ro-num) [![Total Downloads](https://poser.pugx.org/alcea/ro-num/downloads.svg)](https://packagist.org/packages/alcea/ro-num) [![Latest Unstable Version](https://poser.pugx.org/alcea/ro-num/v/unstable.svg)](https://packagist.org/packages/alcea/ro-num) [![License](https://poser.pugx.org/alcea/ro-num/license.svg)](https://packagist.org/packages/alcea/ro-num)

# RoNum 
Clasa PHP ce face conversie din numar in litere (romana)

#Cum se poate instala?

### 1. composer
```php
composer require  alcea/ro-num "~1"
```

### 2. sau editeaza - require section from composer.json
```
"alcea/ro-num": "~1"
```

### 3. sau clone from GitHub
```
git clone https://github.com/alceanicu/ro-num.git
```

#Mod de utilizare?

```php
 <?php
 use alcea\roNum\RoNum;
 
 $number = 501;
 $roNum = new RoNum();
 echo $roNum->format($number); // cinci sute unu
 echo $roNum->format($number, '#'); // cinci#sute#unu
 ```
