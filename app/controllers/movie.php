<?php

class Movie extends Controller
{
    public function index()
    {
        $this->view('movie/index');
    }

    public function search()
    {
        if (!isset($_GET['movie']) || empty(trim($_GET['movie']))) {
            header("Location: /movie");
            exit;
        }

        $movie_title = trim($_GET['movie']);
        $api = $this->model('Api');
        $movie = $api->search_movie($movie_title);

        
        if (!$movie || (isset($movie['Response']) && $movie['Response'] === 'False')) {
            $_SESSION['error'] = "Movie not found. Please check the spelling and try again.";
            header("Location: /movie");
            exit;
        }

        
        $ratingModel = $this->model('MovieRating');
        $rating = $ratingModel->getAverageRating($movie['imdbID'] ?? $movie['Title']);

        
        $prompt = "Write a short, friendly movie review for '{$movie['Title']}' ({$movie['Year']}). The plot is: {$movie['Plot']}";

        $key = $_ENV['GEMINI'] ?? getenv('GEMINI');
        if (!$key) {
            $ai_review = ' GEMINI key not found.';
        } else {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $key;

            $payload = [
                "contents" => [
                    [
                        "role" => "user",
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ]
                ]
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                $ai_review = 'AI review failed: ' . curl_error($ch);
            } else {
                $result = json_decode($response, true);
                $ai_review = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No AI review available.';
            }

            curl_close($ch);
        }

        
        $this->view('movie/results', [
            'movie' => $movie,
            'rating' => $rating,
            'review' => $ai_review
        ]);
    }

    public function review($title = '', $rating = '')
    {
        $rating = intval($rating);
        $movie_title = urldecode($title);

        $api = $this->model('Api');
        $movie = $api->search_movie($movie_title);

        if (isset($movie['imdbID']) && $rating >= 1 && $rating <= 5) {
            $ratingModel = $this->model('MovieRating');
            $ratingModel->addRating($movie['imdbID'], $rating);
        }

        header("Location: /movie/search?movie=" . urlencode($movie_title));
        exit;
    }
}
