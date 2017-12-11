<?php

namespace SR\AdminNotifications\Observers\Customer;

use Magento\Framework\Event\ObserverInterface;
use SR\AdminNotifications\Model\Email\Sender\CustomerRegistrationSender;

class RegisterSuccess implements ObserverInterface
{

    protected $_sender;

    public function __construct(

        CustomerRegistrationSender $sender
    )
    {
        $this->_sender = $sender;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getData('customer');
        $this->_sender->send($customer);

    }

}