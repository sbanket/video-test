<?php

namespace App\Controller;

/**
 * Class Controller
 *
 * @package App\Controller
 */
class Controller
{
    /**
     * @var array
     */
    private $params;

    /**
     * @param string     $name
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getQuery(string $name, $default = null)
    {
        if (empty($this->params['query'][$name])) {
            return $default;
        }

        return $this->params['query'][$name];
    }

    /**
     * @param string     $name
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getRoute(string $name, $default = null)
    {
        if (empty($this->params['route'][$name])) {
            return $default;
        }

        return $this->params['route'][$name];
    }

    /**
     * @param array $params
     *
     * @return Controller
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
}