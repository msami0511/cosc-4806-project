<?php
require_once __DIR__ . '/../database.php';

class MovieRating
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect(); // use the db_connect() function you defined
    }

    public function addRating($movie_id, $rating)
    {
        $sql = "INSERT INTO rating (movie_id, rating) VALUES (:movie_id, :rating)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':movie_id', $movie_id);
        $stmt->bindParam(':rating', $rating);
        return $stmt->execute();
    }

    public function getAverageRating($movie_id)
    {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_ratings FROM rating WHERE movie_id = :movie_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':movie_id', $movie_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'average' => $row['avg_rating'] ? round($row['avg_rating'], 1) : 0,
            'count' => $row['total_ratings'] ?? 0
        ];
    }
}
