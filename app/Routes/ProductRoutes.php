<?php

namespace app\Routes;

include "Controller/ProductController.php";

use app\Controller\ProductController;

class ProductRoutes
{
    public function handle($method, $path)
    {

        error_log("Method: $method, Path: $path");
        // JIKA REQUEST METHOD GET DAN PATH SAMA DENGAN '/api/product'
        if ($method == "GET" && $path == "/api/product") {
            $controller = new ProductController();
            echo $controller->index();
        }        
        
        // JIKA REQUEST METHOD GET DAN PATH SAMA DENGAN '/api/product/{id}'
        if ($method == "GET" && strpos($path, "/api/product/") === 0) {
            $pathParts = explode("/", $path);
            $id = $pathParts[count($pathParts) - 1];
            
            $controller = new ProductController();
            echo $controller->getById($id);
        }

        // JIKA REQUEST METHOD POST DAN PATH SAMA DENGAN '/api/product'
        if ($method == "POST" && $path == "/api/product") {
            $controller = new ProductController();
            echo $controller->insert();
        }

        // JIKA REQUEST METHOD PUT DAN PATH SAMA DENGAN '/api/product/{id}'
        if ($method == "PUT" && strpos($path, "/api/product/") === 0) {
            $pathParts = explode("/", $path);
            $id = $pathParts[count($pathParts) - 1];
            
            $controller = new ProductController();
            echo $controller->update($id);
        }

        // JIKA REQUEST METHOD DELETE DAN PATH SAMA DENGAN '/api/product/{id}'
        if ($method == "DELETE" && strpos($path, "/api/product/") === 0) {
            $pathParts = explode("/", $path);
            $id = $pathParts[count($pathParts) - 1];
            
            $controller = new ProductController();
            echo $controller->delete($id);
        }

        echo json_encode([
            "code" => 404,
            "message" => "Not Found"
        ]);
        
    }
}
