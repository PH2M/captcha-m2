<?php
/**
 * 2011-2018 PH2M
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is available
 * through the world-wide-web at this URL: http://www.opensource.org/licenses/OSL-3.0
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to contact@ph2m.com so we can send you a copy immediately.
 *
 * @author PH2M - contact@ph2m.com
 * @copyright 2011-2018 PH2M
 * @license http://www.opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PH2M\Captcha\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Captcha
 * @package PH2M\Captcha\Block
 * @method \PH2M\Captcha\ViewModel\Captcha getViewModel()
 */
class Captcha extends Template
{
    const XML_PATH_ENABLE = 'customer/phcaptcha/enable';
    const XML_PATH_SITE_KEY = 'customer/phcaptcha/site_key';
    const XML_PATH_SECRET_KEY = 'customer/phcaptcha/secret_key';

    /**
     * @return string
     */
    public function getSiteKey()
    {
        return $this->getViewModel()->getScopeConfig()->getValue(self::XML_PATH_SITE_KEY, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->getViewModel()->getScopeConfig()->getValue(self::XML_PATH_SECRET_KEY, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function isEnabled()
    {
        return $this->getViewModel()->getScopeConfig()->getValue(self::XML_PATH_ENABLE, ScopeInterface::SCOPE_STORE);
    }
}