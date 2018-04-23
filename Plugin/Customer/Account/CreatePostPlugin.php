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

namespace PH2M\Captcha\Plugin\Customer\Account;

/**
 * Class CreatePostPlugin
 * @package PH2M\Captcha\Plugin\Customer\Account
 */
class CreatePostPlugin extends \PH2M\Captcha\Plugin\CaptchaPlugin
{
    /**
     * @param \Magento\Customer\Controller\Account\CreatePost $subject
     * @return \Magento\Framework\Controller\Result\Redirect|void
     */
    public function beforeExecute(\Magento\Customer\Controller\Account\CreatePost $subject)
    {
        return $this->validateCaptcha($subject);
    }
}