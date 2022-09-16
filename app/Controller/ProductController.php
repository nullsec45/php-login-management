<?php
namespace Program\PHPMVC\Controller;

class ProductController{
    public function categories(string $productId, string $categoryId):void{
        echo "Product $productId, Category $categoryId";
    }
    public function user(){
        echo "User :".$_SESSION["username"];
    }
}