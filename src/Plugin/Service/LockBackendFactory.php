<?php

namespace SabreDavModule\Plugin\Service;

use Sabre\DAV\Locks\Plugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class LockBackendFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $lockBackendPluginManager =
            $serviceLocator->getServiceLocator()->get('SabreDavModule\\\LockBackend\\Service\\PluginManager');

        $lockBackend = $lockBackendPluginManager->get(
            $this->creationOptions['backend']['name'],
            $this->creationOptions['backend']['options']
        );

        $plugin = new Plugin($lockBackend);

        $this->creationOptions = array();

        return $plugin;
    }
}
