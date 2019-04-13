<?php

namespace plugins\pluginsAdmin;


class Lib
{
    public function getAction(){
        return [
            "firstAction" => (new SomeClass())->firstAction(),
            "secondAction" => (new SomeClass())->secondAction(),
        ];
    }
}