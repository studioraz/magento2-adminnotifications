<?php

namespace SR\AdminNotifications\Model\Email\Sender;

use SR\AdminNotifications\Model\Email\Container\CustomerRegistrationIdentity;
use SR\AdminNotifications\Model\Email\Container\Template;
use SR\AdminNotifications\Model\Email\Sender;

/**
 * Class OrderSender
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CustomerRegistrationSender extends Sender
{

    /**
     * Global configuration storage.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $globalConfig;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $_customer;

    public function __construct(
        Template $templateContainer,
        CustomerRegistrationIdentity $identityContainer,
        \SR\AdminNotifications\Model\Email\SenderBuilderFactory $senderBuilderFactory,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct($templateContainer, $identityContainer, $senderBuilderFactory, $logger);
    }

    public function send(\Magento\Customer\Model\Customer $customer)
    {
        $this->_customer = $customer;
        if ($this->checkAndSend()) {
            return true;
        }

        return false;
    }


    protected function prepareTemplate()
    {
        $transport = [
            'customer' => $this->_customer,
            'store' => $this->_customer->getStore()
        ];
        $transport = new \Magento\Framework\DataObject($transport);

        $this->templateContainer->setTemplateVars($transport->getData());

        parent::prepareTemplate();
    }


    protected function getStore()
    {
        return $this->_customer->getStore();
    }

}
