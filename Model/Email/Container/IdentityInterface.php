<?php


namespace  SR\AdminNotifications\Model\Email\Container;

use Magento\Store\Model\Store;

interface IdentityInterface
{
    /**
     * @return bool
     */
    public function isEnabled();

    /**
     * @return array|bool
     */
    public function getEmailCopyTo();

    /**
     * @return mixed
     */
    public function getTemplateId();

    /**
     * @return mixed
     */
    public function getEmailIdentity();

    /**
     * @return Store
     */
    public function getStore();

    /**
     * @param Store $store
     * @return mixed
     */
    public function setStore(Store $store);

}
