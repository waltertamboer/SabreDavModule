<?php

namespace SabreDavModule;

use SabreDavModule\Listener\RegisterRoutes;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function init(ModuleManager $moduleManager)
    {
        $events = $moduleManager->getEventManager();
        $events->attachAggregate(new RegisterRoutes());

        $sm = $moduleManager->getEvent()->getParam('ServiceManager');
        $serviceListener = $sm->get('ServiceListener');

        $serviceListener->addServiceManager(
            'SabreDavModule\\AuthBackend\\Service\\PluginManager',
            'sabredav_auth_backends',
            'SabreDavModule\Feature\SabreDavAuthBackendProviderInterface',
            'getSabreDavAuthBackendConfig'
        );

        $serviceListener->addServiceManager(
            'SabreDavModule\\LockBackend\\Service\\PluginManager',
            'sabredav_lock_backends',
            'SabreDavModule\Feature\SabreDavLockBackendProviderInterface',
            'getSabreDavLockBackendConfig'
        );

        $serviceListener->addServiceManager(
            'SabreDavModule\\Node\\Service\\PluginManager',
            'sabredav_nodes',
            'SabreDavModule\Feature\SabreDavNodeProviderInterface',
            'getSabreDavNodeConfig'
        );

        $serviceListener->addServiceManager(
            'SabreDavModule\\Plugin\\Service\\PluginManager',
            'sabredav_plugins',
            'SabreDavModule\Feature\SabreDavPluginProviderInterface',
            'getSabreDavPluginConfig'
        );

        $serviceListener->addServiceManager(
            'SabreDavModule\\Property\\Service\\PluginManager',
            'sabredav_property_backends',
            'SabreDavModule\Feature\SabreDavPropertyBackendProviderInterface',
            'getSabreDavPropertyBackendConfig'
        );
    }
}
