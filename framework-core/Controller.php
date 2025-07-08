<?php

class Controller {

    /**
     * Render the view file called $name and pass it the data in $data.
     * View files are assumed to be in app/views/
     */
    public function render(string $name, array $data = []) {
        extract($data);

        $viewFile = "../app/views/$name.php";
        $layoutFile = __DIR__ . "/views/layout.php";
        $contentView = $viewFile;

        include $layoutFile;
    }
}