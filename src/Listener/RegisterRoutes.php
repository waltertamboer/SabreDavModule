<?php

namespace SabreDavModule\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\ModuleManager\ModuleEvent;

class RegisterRoutes extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events)
    {
        $events->attach(ModuleEvent::EVENT_MERGE_CONFIG, array($this, 'onMergeConfig'));
    }

    public function onMergeConfig(ModuleEvent $e)
    {
        $configListener = $e->getConfigListener();
        $config = $configListener->getMergedConfig(false);

        if (!isset($config['sabredav'])) {
            return;
        }

        foreach ($config['sabredav'] as $endPoint => $endPointConfig) {
            if (!$endPointConfig['enabled']) {
                $route = $endPointConfig['route'];

                unset($config['router']['routes'][$route]);
            }
        }

        $configListener->setMergedConfig($config);
    }
}
