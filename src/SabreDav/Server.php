<?php

namespace SabreDavModule\SabreDav;

use Sabre\DAV\Server as BaseServer;

class Server extends BaseServer
{
    public function __construct($treeOrNode = null)
    {
        parent::__construct($treeOrNode);

        $this->sapi = new Sapi();
    }

    public function exec()
    {
        parent::exec();

        return Sapi::$zendResponse;
    }
}
