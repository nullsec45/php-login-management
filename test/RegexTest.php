<?php
namespace Test\PHPMVC;

use PHPUnit\Framework\TestCase;

class RegexTest extends TestCase{
    public function testRegex(){
        $path="/products/sepatu/categories/termahal";

        $pattern="#^/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)$#";

        $result=preg_match($pattern, $path, $variables);

        self::assertEquals(1,$result);

        var_dump($variables);
    }
}