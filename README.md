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
Because the Invisible reCAPTCHA needs to add some `data` to the submit button, the module adds some `jQuery` and tries to select the default Magento 2 submit button using the selector `button.action.submit`. 
If your theme has removed these classes, you need to change this selector in configuration.