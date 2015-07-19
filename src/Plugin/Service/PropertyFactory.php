<?php

namespace SabreDavModule\Plugin\Service;

use Sabre\DAV\PropertyStorage\Plugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class PropertyFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $propertyBackendPluginManager =
            $serviceLocator->getServiceLocator()->get('SabreDavModule\\\Property\\Service\\PluginManager');

        $lockBackend = $propertyBackendPluginManager->get(
            $this->creationOptions['backend']['name'],
            $this->creationOptions['backend']['options']
        );

        $plugin = new Plugin($lockBackend);

        $this->creationOptions = array();

        return $plugin;
    }
}
