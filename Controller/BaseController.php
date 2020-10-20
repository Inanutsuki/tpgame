<?php

namespace App\Controller;

use App\Model\Traits\EntityHelperTrait;

class BaseController {

    use EntityHelperTrait;

    protected function render($templateName, array $templateData = [], $baseLayout = "base.html.php"){
        extract($templateData);
        ob_start();
        require "templates/" . $templateName;
        $content = ob_get_clean();

        require "templates/" . $baseLayout;
    }

}