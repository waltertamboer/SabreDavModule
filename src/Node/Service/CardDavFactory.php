<?php

namespace SabreDavModule\Node\Service;

use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class CardDavFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!isset($this->creationOptions['pdo_service'])) {
            throw new RuntimeException(sprintf('Missing "pdo_service" in options array for "%s".', __CLASS__));
        }

        $pdo = $serviceLocator->getServiceLocator()->get($this->creationOptions['pdo_service']);

        $principalBackend = new \Sabre\DAVACL\PrincipalBackend\PDO($pdo);
        $carddavBackend = new \Sabre\CardDAV\Backend\PDO($pdo);
        $addressBook = new \Sabre\CardDAV\AddressBookRoot($principalBackend, $carddavBackend);

        $this->creationOptions = array();

        return $addressBook;
    }
}
