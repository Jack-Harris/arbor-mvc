<?php

class Router {

    public function dispatch() {
        $parser = new URLParser($_SERVER['REQUEST_URI']);
        $this->renderAction($parser);
    }

    private function renderAction(URLParser $parser) {
        if (file_exists("../app/controllers/$parser->controllerName.php")) {
            require_once "../app/controllers/$parser->controllerName.php";
            $controller = new $parser->controllerName;

            if (method_exists($controller, $parser->actionName)) {
                return call_user_func_array([$controller, $parser->actionName], array_slice($parser->urlSegments, 2));
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}