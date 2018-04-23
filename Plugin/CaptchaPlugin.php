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

namespace PH2M\Captcha\Plugin;

use PH2M\Captcha\Block\Captcha;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Response\RedirectInterface;

/**
 * Class CaptchaPlugin
 * @package PH2M\Captcha\Plugin\Captcha
 */
class CaptchaPlugin
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var RedirectFactory
     */
    private $resultRedirectFactory;

    /**
     * @var RedirectInterface
     */
    private $redirect;

    /**
     * CreatePostPlugin constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager,
        RedirectFactory $redirectFactory,
        RedirectInterface $redirect
    ) {
        $this->messageManager           = $messageManager;
        $this->scopeConfig              = $scopeConfig;
        $this->resultRedirectFactory    = $redirectFactory;
        $this->redirect                 = $redirect;
    }

    /**
     * @param \Magento\Framework\App\Action\Action $subject
     * @return \Magento\Framework\Controller\Result\Redirect|void
     */
    protected function validateCaptcha($subject)
    {
        if(!$this->scopeConfig->getValue(Captcha::XML_PATH_ENABLE, ScopeInterface::SCOPE_STORE)){ return; }
        if(!$secretKey = $this->scopeConfig->getValue(Captcha::XML_PATH_SECRET_KEY)){ return; }

        $captcha = $subject->getRequest()->getPost('g-recaptcha-response');

        if(!$captcha){
            return $this->redirectError(__('Invalid CAPTCHA'));
        }

        $data = ['secret' => $secretKey, 'response' => $captcha];
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

        try{
            $response = json_decode(curl_exec($verify));

            if (!$response || !$response->success) {
                return $this->redirectError(__('An error occurred, please retry.'));
            }
        } catch (Exception $e) {
            return $this->redirectError(__('An error occurred, please retry.'));
        }
    }

    /**
     * @param $errorMessage
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    private function redirectError($errorMessage)
    {
        $this->messageManager->addErrorMessage($errorMessage);

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->redirect->getRefererUrl());
        return $resultRedirect;
    }
}