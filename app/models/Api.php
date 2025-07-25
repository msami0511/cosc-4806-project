<?php

class Api
{
    public function search_movie($title)
    {
        $apiKey = $_ENV['omdb_key'] ?? 'your_api_key';
        $url = "http://www.omdbapi.com/?apikey=" . $apiKey . "&t=" . urlencode($title);
        $json = file_get_contents($url);
        return json_decode($json, true);
    }
}
