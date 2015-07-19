<?php

namespace SabreDavModule\Controller;

use Sabre\DAV\Server;
use Zend\Mvc\Controller\AbstractActionController;

class SabreDav extends AbstractActionController
{
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function indexAction()
    {
        $response = $this->server->exec();

        return $response;
    }
}
