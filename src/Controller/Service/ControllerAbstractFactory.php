<?php

namespace SabreDavModule\Controller\Service;

use SabreDavModule\Controller\SabreDav;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return strpos($requestedName, 'sabredavmodule.') === 0;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $configName = substr($requestedName, 15);

        $server = $serviceLocator->getServiceLocator()->get('sabredav.server.' . $configName);

        return new SabreDav($server);
    }
}
