<?php
namespace Program\PHPMVC\App;

class View{
    public static function render(string $view, $model=""){
        require __DIR__."/../View/components/header.php";
        require __DIR__."/../View/".$view.".php";
        require __DIR__."/../View/components/footer.php";
    }
}
?>