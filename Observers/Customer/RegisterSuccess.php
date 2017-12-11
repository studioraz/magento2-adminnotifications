<?php

namespace SR\AdminNotifications\Observers\Customer;

use Magento\Framework\Event\ObserverInterface;
use SR\AdminNotifications\Model\Email\Sender\CustomerRegistrationSender;
use Magento\Customer\Api\CustomerRepositoryInterface;

class RegisterSuccess implements ObserverInterface
{

    /**
     * @var CustomerRegistrationSender
     */
    private $_sender;

    /** @var  \Magento\Customer\Api\CustomerRepositoryInterface */
    private $_customerRepository;

    public function __construct(

        CustomerRegistrationSender $sender
    )
    {
        $this->_sender = $sender;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        /* @var $customer \Magento\Customer\Model\Data\Customer */
        $customerData = $observer->getData('customer');

        $this->_sender->send($customerData);

    }

}