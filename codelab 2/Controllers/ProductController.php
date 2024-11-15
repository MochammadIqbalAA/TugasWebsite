<?php

namespace Controller;

include "Traits/ResponseFormatter.php";
include "Controllers/Controller.php";

use Controllers\Controller;
use Traits\ResponseFormatter;

class ProductController extends Controller{
    use ResponseFormatter;

    public function __construct(){
        $this->controllerName = "Get All Product";
        $this->controllerMenthod = "GET";
    }

    public function getAllProduct(){
        $dummyData = [
            "Air Mineral",
            "Kebab",
            "Spaghetti",
            "Jus Jambu",
        ];

        $response = [
            "controller_attribute" => $this->getControllerAttribute(),
            "Product" => $dummyData
        ];
        return $this->responseFormatter(200, "Succes", $response);
    }
}