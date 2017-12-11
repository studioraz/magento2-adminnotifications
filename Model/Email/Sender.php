<?php

namespace SR\AdminNotifications\Model\Email;

use SR\AdminNotifications\Model\Email\Container\IdentityInterface;
use SR\AdminNotifications\Model\Email\Container\Template;

abstract class Sender
{
    /**
     * @var \SR\AdminNotifications\Model\Email\SenderBuilderFactory
     */
    protected $senderBuilderFactory;

    /**
     * @var Template
     */
    protected $templateContainer;

    /**
     * @var IdentityInterface
     */
    protected $identityContainer;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;


    public function __construct(
        Template $templateContainer,
        IdentityInterface $identityContainer,
        \SR\AdminNotifications\Model\Email\SenderBuilderFactory $senderBuilderFactory,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->templateContainer = $templateContainer;
        $this->identityContainer = $identityContainer;
        $this->senderBuilderFactory = $senderBuilderFactory;
        $this->logger = $logger;
    }


    protected function checkAndSend()
    {
        $this->identityContainer->setStore($this->getStore());
        if (!$this->identityContainer->isEnabled()) {
            return false;
        }

        $this->prepareTemplate();

        /** @var SenderBuilder $sender */
        $sender = $this->getSender();

        try {
            $sender->send();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return true;
    }

    /**
     * @param Order $order
     * @return void
     */
    protected function prepareTemplate()
    {
        $this->templateContainer->setTemplateOptions($this->getTemplateOptions());

        $templateId = $this->identityContainer->getTemplateId();

        $this->templateContainer->setTemplateId($templateId);
    }

    /**
     * @return Sender
     */
    protected function getSender()
    {
        return $this->senderBuilderFactory->create(
            [
                'templateContainer' => $this->templateContainer,
                'identityContainer' => $this->identityContainer,
            ]
        );
    }

    /**
     * @return array
     */
    protected function getTemplateOptions()
    {
        return [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $this->identityContainer->getStore()->getStoreId()
        ];
    }

    protected function getStore()
    {
        return $this->identityContainer->getStore();
    }
}
