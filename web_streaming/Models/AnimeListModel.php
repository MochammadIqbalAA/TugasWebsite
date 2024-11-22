<?php

class AnimeListModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllAnime()
    {
        $stmt = $this->pdo->query("SELECT * FROM anime_list");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimeById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM anime_list WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAnime($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE anime_list 
                                     SET title = ?, genre = ?, description = ?, release_year = ? 
                                     WHERE id = ?");
        return $stmt->execute([
            $data['title'],
            $data['genre'],
            $data['description'],
            $data['release_year'],
            $id
        ]);
    }

    public function addAnime($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO anime_list (title, genre, description, release_year) 
                                     VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['title'],
            $data['genre'],
            $data['description'],
            $data['release_year']
        ]);
    }

    public function deleteAnime($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM anime_list WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
