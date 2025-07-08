<?php

/**
 * Extract the desired controller and action from the URL.
 * 
 * The expected format is example.com/controller/action
 */
class URLParser {

    private const DEFAULT_CONTROLLER = 'DefaultController';
    private const DEFAULT_ACTION = 'index';

    public string $controllerName;
    public string $actionName;

    public array $urlSegments = [];

    function __construct(string $url) {
        $uri = explode('?', $url)[0];
        $this->urlSegments = explode('/', $uri);

        $this->setControllerName();
        $this->setActionName();
    }

    private function setControllerName() {
        if (!empty($this->urlSegments[0])) {
            $this->controllerName = ucfirst($this->urlSegments[0]);
        } else {
            $this->controllerName = self::DEFAULT_CONTROLLER;
        }
    }

    private function setActionName() { 
        $this->actionName = $this->urlSegments[1] ?: self::DEFAULT_ACTION;
    }
}