<?php

namespace SabreDavModule\Node\Service;

use RuntimeException;
use Sabre\DAVACL\PrincipalBackend\PDO;
use Sabre\DAVACL\PrincipalCollection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class PrincipalCollectionFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!isset($this->creationOptions['pdo_service'])) {
            throw new RuntimeException(sprintf('Missing "pdo_service" in options array for "%s".', __CLASS__));
        }

        $pdo = $serviceLocator->getServiceLocator()->get($this->creationOptions['pdo_service']);

        $collection = new PrincipalCollection(new PDO($pdo));

        $this->creationOptions = array();

        return $collection;
    }
}
