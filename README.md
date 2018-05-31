Captcha for M2
--------------
Google reCAPTCHA for Magento 2

Requirements
------------
Magento 2.2+ because we need `ViewModel` classes.

Installation
------------
```
composer require ph2m/captcha-m2
php bin/magento module:enable PH2M_Captcha
php bin/magento setup:upgrade
```

Instructions
------------
Just enter your site key and secret key in Stores > Configuration > Customers > Customer Configuration > PH2M Catpcha.