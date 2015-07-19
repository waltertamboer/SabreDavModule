<?php

namespace SabreDavModule\SabreDav;

use Sabre\HTTP\ResponseInterface;
use Sabre\HTTP\Sapi as BaseSapi;
use Zend\Http\AbstractMessage;
use Zend\Http\Response;
use Zend\Http\Response\Stream;

/**
 * This class is the most disgusting class I've ever written. It truly shows how broken SabreDav actually is.
 * SabreDav uses a Sapi class to send a response to the client. We have no way to retrieve this response which is a
 * problem if we want to resepect Zend Framework's application flow. That's why this class is created, it will override
 * the methods which we can abuse to store a Zend Framework response instance. This instance is later on used to return
 * to the application.
 */
class Sapi extends BaseSapi
{
    /**
     * We need this static variable so we can access the created response later on in order to respect
     * Zend Framework's application flow. It's public because we can't make this any worse anyway...
     *
     * @var AbstractMessage
     */
    public static $zendResponse;

    // This method is fucking ridiculous. Yes I'm swearing, that's how insane this is. Apparently SabreDav creates
    // an instance of a Sapi class and than it uses the form "$this->sapi->..." to call static methods on it. Truly
    // disgusting. And PHP, screw you too for not throwing errors!
    static function sendResponse(ResponseInterface $response)
    {
        $body = $response->getBody();

        if (is_resource($body)) {
            self::$zendResponse = new Stream();
            self::$zendResponse->setStream($body);
        } else {
            self::$zendResponse = new Response();
            self::$zendResponse->setContent($body);
        }

        self::$zendResponse->setStatusCode($response->getStatus());
        self::$zendResponse->setVersion($response->getHttpVersion());

        $headers = self::$zendResponse->getHeaders();
        foreach ($response->getHeaders() as $key => $value) {
            foreach ($value as $k => $v) {
                $headers->addHeaderLine($key, $v);
            }
        }
    }
}
