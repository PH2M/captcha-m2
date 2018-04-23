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

#### Customer account creation
Because the Invisible reCAPTCHA needs to add some `data` to the submit button, the module adds a `button.phtml` template into the default `customer_form_register` block.
You have to follow these steps:
1. Override the `Magento_Customer::form/register.phtml` template in your theme
2. Find the submit button and replace it with `<?php echo $block->getChildHtml('ph2m.captcha.button') ?>`
3. (Optional) Override the `PH2M_Captcha::captcha/customer/create/button.phtml` in your theme to customize it

#### Contact us form
For the same reasons as the customer account creation, you have to follow these steps:
1. Override the `Magento_Contact::form.phtml` template in your theme
2. Find the submit button and replace it with `<?php echo $block->getChildHtml('ph2m.captcha.button') ?>`
3. (Optional) Override the `PH2M_Captcha::captcha/customer/create/button.phtml` in your theme to customize it