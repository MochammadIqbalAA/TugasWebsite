<?php

namespace Controllers;

class Controller{
    //Variabel atribut
    var $controllerName;
    var $controllerMenthod;

    //method untuk mengambil semua input
    public function getControllerAttribute()
    {
        return [
            "ControllerName" => $this->controllerName,
            "Method" => $this->controllerMenthod,
        ];
    }
}