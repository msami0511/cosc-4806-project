<?php

class Movie extends Controller
{
    public function index()
    {
        $this->view('movie/index');
    }

    public function search()
    {
        if (!isset($_GET['movie']) || empty($_GET['movie'])) {
            header("Location: /movie");
            exit;
        }

        $movie_title = $_GET['movie'];
        $api = $this->model('Api');
        $movie = $api->search_movie($movie_title);

        if (!isset($movie['Title'])) {
            $movie = [
                'Title' => 'Unknown Movie',
                'Year' => '',
                'Genre' => 'N/A',
                'Plot' => 'N/A',
                'Poster' => 'N/A',
                'imdbID' => 'unknown'
            ];
        }

        
        $ratingModel = $this->model('MovieRating');
        $rating = $ratingModel->getAverageRating($movie['imdbID']);

        
        $prompt = "Write a short, friendly movie review for '{$movie['Title']}' ({$movie['Year']}). The plot is: {$movie['Plot']}";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $_ENV['GEMINI'];


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
