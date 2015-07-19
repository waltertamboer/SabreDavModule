<?php

namespace SabreDavModule\AuthBackend\Service;

use RuntimeException;
use Sabre\DAV\Auth\Backend\PDO;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class PdoFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!isset($this->creationOptions['pdo_service'])) {
            throw new RuntimeException(sprintf('Missing "pdo_service" in options array for "%s".', __CLASS__));
        }

        $pdo = $serviceLocator->getServiceLocator()->get($this->creationOptions['pdo_service']);

        $authBackend = new PDO($pdo);

        $this->creationOptions = array();

        return $authBackend;
    }
}
