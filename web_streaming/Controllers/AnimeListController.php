<?php

include 'Models/AnimeListModel.php';
include 'Traits/ApiResponsesFormatter.php';

use Traits\ApiResponsesFormatter;
header("Access-Control-Allow-Origin: *");  // Mengizinkan semua domain (untuk pengujian)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;  // Jika pre-flight request (OPTIONS), cukup keluar tanpa melakukan apapun
}
class AnimeListController
{
    use ApiResponsesFormatter;

    private $model;

    public function __construct($pdo)
    {
        $this->model = new AnimeListModel($pdo);
    }

    public function handleRequest()
    {
        // Mendapatkan metode HTTP dan URL
        $method = $_SERVER['REQUEST_METHOD'];
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $input = $_POST; // Mengambil data dari form-data (untuk x-www-form-urlencoded atau form-data)

        if (preg_match('#^/web_streaming/api/anime/(\d+)$#', $url, $matches)) {
            $id = $matches[1]; // Ambil ID dari URL
            switch ($method) {
                case 'GET':
                    $this->getAnimeById($id);
                    break;
                case 'PUT':
                    $this->updateAnime($id, $input);
                    break;
                case 'DELETE':
                    $this->deleteAnime($id);
                    break;
                default:
                    echo $this->errorResponse("Method not allowed for this endpoint", 405);
                    break;
            }
            return;
        }

        // Menangani POST request untuk membuat anime baru
        if ($url === '/web_streaming/api/anime' && $method === 'POST') {
            $this->createAnime($input);
        } else {
            echo $this->errorResponse("Method not allowed", 405);
        }
    }

    public function updateAnime($id, $data)
{
    try {
        
        // Mengambil data mentah dari body request
        $rawInput = file_get_contents("php://input");

        // Debugging: Tampilkan data mentah
        var_dump($rawInput); // Menampilkan data mentah yang diterima

        // Menggunakan regex untuk memecah form-data menjadi key-value pairs
        $pattern = '/Content-Disposition: form-data; name="([^"]+)".*?\r\n\r\n([^--]*)/s';
        preg_match_all($pattern, $rawInput, $matches, PREG_SET_ORDER);

        // Debugging: Tampilkan hasil pemrosesan
        var_dump($matches); // Menampilkan hasil parsing form-data

        // Menyusun data menjadi array yang bisa digunakan
        $data = [];
        foreach ($matches as $match) {
            $data[$match[1]] = trim($match[2]);
        }

        // Pastikan ttle
        if (empty($data['title'])) {
            throw new Exception('Title is required');
        }

        // Menggunakan data lain yang dikirimkan untuk update
        $data['genre'] = isset($data['genre']) && $data['genre'] !== '' ? $data['genre'] : null;
        $data['description'] = isset($data['description']) && $data['description'] !== '' ? $data['description'] : null;
        $data['release_year'] = isset($data['release_year']) && $data['release_year'] !== '' ? $data['release_year'] : null;

        // Update anime di database menggunakan Model
        $result = $this->model->updateAnime($id, $data);
        if ($result) {
            echo $this->successResponse(null, "Anime updated successfully");
        } else {
            echo $this->errorResponse("Failed to update anime", 500);
        }
    } catch (Exception $e) {
        echo $this->errorResponse($e->getMessage(), 400);
    }
    
}
// public function updateAnime($id, $data)
// {
//     // Mengambil data JSON yang diterima
//     $input = json_decode(file_get_contents("php://input"), true);

//     // Debugging: Lihat data yang diterima
//     var_dump($input); // Debugging untuk melihat data yang diterima

//     // Memastikan data yang diperlukan ada
//     if (empty($input['title']) || empty($input['genre']) || empty($input['description']) || empty($input['release_year'])) {
//         echo json_encode(["status" => "error", "message" => "All fields are required"]);
//         return;
//     }

//     // Jika data valid, lanjutkan untuk memperbarui anime
//     $this->model->updateAnime($id, $input);

//     echo json_encode(["status" => "success", "message" => "Anime updated successfully"]);
// }


    
    


    



    public function getAnimeById($id)
    {
        $anime = $this->model->getAnimeById($id);
        if ($anime) {
            echo $this->successResponse($anime, "Anime fetched successfully");
        } else {
            echo $this->errorResponse("Anime not found", 404);
        }
    }

    public function createAnime($data)
{
    // Mengambil data JSON yang diterima
    $jsonInput = json_decode(file_get_contents("php://input"), true);

    // Jika JSON tidak ada, gunakan $_POST
    $input = $jsonInput ?: $_POST;

    // Memeriksa apakah data yang diperlukan ada
    if (empty($input['title']) || empty($input['genre']) || empty($input['description']) || empty($input['release_year'])) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        return;
    }

    // Proses menambah anime ke database
    try {
        $this->model->addAnime($input);
        echo json_encode(["status" => "success", "message" => "Anime created successfully"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Failed to create anime: " . $e->getMessage()]);
    }
}

    public function deleteAnime($id)
    {
        try {
            if (empty($id)) {
                throw new Exception('ID is required for deletion');
            }

            $result = $this->model->deleteAnime($id);
            if ($result) {
                echo $this->successResponse(null, "Anime deleted successfully");
            } else {
                echo $this->errorResponse("Failed to delete anime", 500);
            }
        } catch (Exception $e) {
            echo $this->errorResponse($e->getMessage(), 400);
        }
    }
    public function getAllAnime()
{
    $anime = $this->model->getAllAnime();
    if ($anime) {
        echo $this->successResponse($anime, "All anime fetched successfully");
    } else {
        echo $this->errorResponse("No anime found", 404);
    }
}

}
?>
