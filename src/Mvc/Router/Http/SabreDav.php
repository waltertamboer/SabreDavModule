<?php

namespace SabreDavModule\Mvc\Router\Http;

use Traversable;
use Zend\Mvc\Router\Exception;
use Zend\Mvc\Router\Http\RouteInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;

class SabreDav implements RouteInterface
{
    private $regex;
    private $spec;
    private $defaults;
    private $options;
    private $assembledParams;

    public static function factory($options = array())
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(
                __METHOD__ . ' expects an array or Traversable set of options'
            );
        }

        if (!isset($options['regex'])) {
            $options['regex'] = '(?<slug>.+)';
        }

        if (!isset($options['spec'])) {
            $options['spec'] = '%slug%';
        }

        if (!isset($options['defaults'])) {
            $options['defaults'] = array();
        }

        $regex = $options['regex'];
        unset($options['regex']);

        $spec = $options['spec'];
        unset($options['spec']);

        $defaults = $options['defaults'];
        unset($options['defaults']);

        return new static($regex, $spec, $defaults, $options);
    }

    public function __construct($regex, $spec, $defaults, array $options)
    {
        $this->regex = $regex;
        $this->spec = $spec;
        $this->defaults = $defaults;
        $this->defaults['slug'] = '';
        $this->options = $options;
        $this->assembledParams = array();
    }

    public function match(Request $request, $pathOffset = null)
    {
        if (!method_exists($request, 'getUri')) {
            return null;
        }

        $uri = $request->getUri();
        $path = $uri->getPath();

        $matches = array();
        $result = preg_match('(\G' . $this->regex . ')', $path, $matches, null, $pathOffset);
        if (!$result) {
            return null;
        }

        $matchedLength = strlen($matches[0]);

        foreach ($matches as $key => $value) {
            if (is_numeric($key) || is_int($key) || $value === '') {
                unset($matches[$key]);
            } else {
                $matches[$key] = rawurldecode($value);
            }
        }

        return new RouteMatch(array_merge($this->defaults, $matches), $matchedLength);
    }

    public function assemble(array $params = array(), array $options = array())
    {
        $url = $this->spec;
        $mergedParams = array_merge($this->defaults, $params);

        foreach ($mergedParams as $key => $value) {
            $spec = '%' . $key . '%';

            if (strpos($url, $spec) !== false) {
                $url = str_replace($spec, $value, $url);

                $this->assembledParams[] = $key;
            }
        }

        return $url;
    }

    public function getAssembledParams()
    {
        return $this->assembledParams;
    }
}
