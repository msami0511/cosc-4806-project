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
