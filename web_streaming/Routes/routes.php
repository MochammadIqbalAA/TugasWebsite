<?php

include 'Controllers/AnimeListController.php';

class Routes
{
    public static function handleRequest($pdo)
    {
        // Mendapatkan metode HTTP dan URL
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Menangani request untuk endpoint dengan ID
        if (preg_match('#^/web_streaming/api/anime/(\d+)$#', $url, $matches)) {
            $id = $matches[1]; // Ambil ID dari URL
            $controller = new AnimeListController($pdo);

            switch ($method) {
                case 'GET':
                    $controller->getAnimeById($id); // Mendapatkan anime berdasarkan ID
                    break;
                case 'PUT':
                    $input = $_POST; // Mendapatkan data dari form-data untuk PUT
                    $controller->updateAnime($id, $input); // Memperbarui anime berdasarkan ID
                    break;
                case 'DELETE':
                    $controller->deleteAnime($id); // Menghapus anime berdasarkan ID
                    break;
                default:
                    echo json_encode(["status" => "error", "message" => "Method not allowed for this endpoint"]);
                    break;
            }
            return;
        }

        // Menangani POST request untuk membuat anime baru
        if ($url === '/web_streaming/api/anime' && $method === 'POST') {
            $controller = new AnimeListController($pdo);
            $input = $_POST; // Mendapatkan data dari form-data untuk POST
            $controller->createAnime($input); // Membuat anime baru
            return;
        }

        // Menangani GET request untuk mengambil semua anime
        if ($url === '/web_streaming/api/anime' && $method === 'GET') {
            $controller = new AnimeListController($pdo);
            $controller->getAllAnime(); // Mengambil semua anime dari database
            return;
        }

        // Jika endpoint tidak ditemukan
        echo json_encode(["status" => "error", "message" => "Endpoint not found"]);
    }
}

?>
