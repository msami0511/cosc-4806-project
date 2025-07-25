        <?php
        class Movie extends Controller {
            public function index() {
                // Show the search form
                $this->view('movie/index');
            }

            public function search() {
                // Check if movie parameter exists and is not empty
                if (!isset($_REQUEST['movie']) || empty(trim($_REQUEST['movie']))) {
                    header('Location: /movie');
                    exit;
                }

                $movie_title = trim($_REQUEST['movie']);
                $api = $this->model('Api');
                $movie = $api->search_movie($movie_title);

                // Handle API error or movie not found
                if (!$movie || isset($movie['Error'])) {
                    $this->view('movie/result', ['error' => 'Movie not found or API error.']);
                    return;
                }

                // Pass movie data to result view
                $this->view('movie/results', ['movie' => $movie]);
            }
        }
