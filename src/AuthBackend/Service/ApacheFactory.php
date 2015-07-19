<?php

namespace SabreDavModule\AuthBackend\Service;

use Sabre\DAV\Auth\Backend\Apache;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApacheFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authBackend = new Apache();

        $this->creationOptions = array();

        return $authBackend;
    }
}
