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

namespace PH2M\Captcha\Plugin\Contact;

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class PostPlugin
 * @package PH2M\Captcha\Plugin\Contact
 */
class PostPlugin extends \PH2M\Captcha\Plugin\CaptchaPlugin
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * PostPlugin constructor.
     * @param DataPersistorInterface $dataPersistor
     * @param ScopeConfigInterface $scopeConfig
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $redirectFactory
     * @param RedirectInterface $redirect
     */
    public function __construct(
        DataPersistorInterface $dataPersistor,
        ScopeConfigInterface $scopeConfig,
        ManagerInterface $messageManager,
        RedirectFactory $redirectFactory,
        RedirectInterface $redirect
    ) {
        $this->dataPersistor = $dataPersistor;

        parent::__construct($scopeConfig, $messageManager, $redirectFactory, $redirect);
    }

    /**
     * @param \Magento\Contact\Controller\Index\Post $subject
     * @param callable $proceed
     * @return \Magento\Framework\Controller\Result\Redirect|void
     */
    public function aroundExecute(\Magento\Contact\Controller\Index\Post $subject, callable $proceed)
    {
        if ($this->isCaptchaValid($subject)) {
            return $proceed();
        } else {
            $this->dataPersistor->set('contact_us', $subject->getRequest()->getParams());
            return $this->redirectError();
        }
    }
}