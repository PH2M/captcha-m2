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

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Customer\Model\Session;

/**
 * Class CreatePostPlugin
 * @package PH2M\Captcha\Plugin\Customer\Account
 */
class CreatePostPlugin extends \PH2M\Captcha\Plugin\CaptchaPlugin
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * CreatePostPlugin constructor.
     * @param Session $customerSession
     * @param ScopeConfigInterface $scopeConfig
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $redirectFactory
     * @param RedirectInterface $redirect
     */
    public function __construct(
        Session $customerSession,
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager,
        RedirectFactory $redirectFactory,
        RedirectInterface $redirect
    ) {
        $this->customerSession = $customerSession;

        parent::__construct($scopeConfig, $messageManager, $redirectFactory, $redirect);
    }

    /**
     * @param \Magento\Customer\Controller\Account\CreatePost $subject
     * @param callable $proceed
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function aroundExecute(\Magento\Customer\Controller\Account\CreatePost $subject, callable $proceed)
    {
        if ($this->isCaptchaValid($subject)) {
            return $proceed();
        } else {
            $this->customerSession->setCustomerFormData($subject->getRequest()->getPostValue());
            return $this->redirectError();
        }
    }
}