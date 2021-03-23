<?php

use Magento\Framework\App\Bootstrap;

require 'app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');


$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
$storeId = $storeManager->getStore()->getId();

$websiteId = $storeManager->getStore($storeId)->getWebsiteId();

try {
    $customer = $objectManager->get('\Magento\Customer\Api\Data\CustomerInterfaceFactory')->create();
    $customer->setWebsiteId($websiteId);
    $email = 'test11@example.com';
    $customer->setEmail($email);
    $customer->setFirstname("test first");
    $customer->setLastname("test last");
    $hashedPassword = $objectManager
        ->get('\Magento\Framework\Encryption\EncryptorInterface')
        ->getHash('MyNewPass', true);

    $objectManager->get('\Magento\Customer\Api\CustomerRepositoryInterface')->save($customer, $hashedPassword);

    $customer = $objectManager->get('\Magento\Customer\Model\CustomerFactory')->create();
    $customer->setWebsiteId($websiteId)->loadByEmail($email);
} catch (Exception $e) {
    echo $e->getMessage();
}
