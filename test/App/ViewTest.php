<?php
namespace Adrian\Website\Semiva\App;

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testRender() {
        View::render('Home/index', [
            "Login"
        ]);

        $this->expectOutputRegex('[Login]');
        $this->expectOutputRegex('[html]');
        $this->expectOutputRegex('[body]');
        $this->expectOutputRegex('[Login Management]');
        $this->expectOutputRegex('[Login]');
        $this->expectOutputRegex('[Register]');
    }

}