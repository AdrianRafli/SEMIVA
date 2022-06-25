<?php

namespace Adrian\Website\Semiva\App {

    function header(string $value){
        echo $value;
    }

}

namespace Adrian\Website\Semiva\Service {

    function setcookie(string $name, string $value){
        echo "$name: $value";
    }

}