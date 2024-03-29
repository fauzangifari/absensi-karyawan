<?php

namespace App\App;

class View
{

    public static function render(string $view, $model)
    {
        require __DIR__ . "/../View/Template/header.php";
        require __DIR__ . "/../View/$view.php";
        require __DIR__ . "/../View/Template/footer.php";
    }

    public static function redirect(string $url)
    {
        header("Location: $url");
        if(getenv('ENVIRONMENT') != 'test') {
            exit();
        }
    }

}