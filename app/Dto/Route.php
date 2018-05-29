<?php

namespace App\Dto;

/**
 * Class Route
 *
 * @package App\Dto
 */
class Route
{
    /**
     * @var string
     */
    private $controllerClass;

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $params;

    /**
     * @return string
     */
    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    /**
     * @param string $controllerClass
     *
     * @return Route
     */
    public function setControllerClass(string $controllerClass)
    {
        $this->controllerClass = $controllerClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return Route
     */
    public function setAction(string $action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @param array $params
     *
     * @return Route
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
}