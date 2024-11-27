<?php

include_once "MoviesDB.php";

class RouteAction {
    var $movies;

    function __construct() {
        $this->movies = new MoviesDB();
    }

    function index($request, $response, $args) {
        echo "<h1>This is the REST Server Home Page</h1>";
    }

    function getMovies($request, $response, $args) {
        $records = $this->movies->getMovies();
        return $response->withHeader('Content-Type', 'application/json')->write(json_encode($records, JSON_PRETTY_PRINT));
    }

    function addMovie($request, $response, $args) {
        $post = $request->getParsedBody();

        // validate and sanitise

        $result = $this->movies->addMovie($post);

        if ($result['success']) {
            $message = ['message' => 'Movie saved to database', 'record' => $result['record']];
        } else {
            $message = ['message' => 'Failed to save movie to database', 'record' => null];
        }

        return $response->withHeader('Content-Type', 'application/json')->write(json_encode($message));
    }
    
    function searchMovies($request, $response, $args) {
        $keyword = $args['keyword'];

        // sanitise and validate

        $records = $this->movies->searchMovies($keyword);
        return $response->withHeader('Content-Type', 'application/json')->write(json_encode($records, JSON_PRETTY_PRINT));
    }

    function getMovieById($request, $response, $args) {
        $id = (int)$args['id'];

        // validate

        $movie = $this->movies->getMovie($id);
        return $response->withHeader('Content-Type', 'application/json')->write(json_encode($movie, JSON_PRETTY_PRINT));
    }

    function deleteMovie($request, $response, $args) {
        $id = $args['id'];
        $result = $this->movies->deleteMovie($id);

        if ($result['success'] && $result['deleted']) {
            $message = ['message' => 'Movie deleted from database', 'success' => true, 'temp_record' => $result['temp_record']];
        } else {
            $message = ['message' => 'Failed to delete movie from database', 'success' => false, 'temp_record' => $result['temp_record']];
        }
        return $response->withHeader('Content-Type', 'application/json')->write(json_encode($message));
    }

    function updateMovie($request, $response, $args) {
        $id = $args['id'];
        $values = $request->getParsedBody();

        // validate

        $result = $this->movies->updateMovie($id, $values);

        if ($result['success'] && $result['record'] !== false) {
            $message = ['message' => 'Movie updated in database', 'success' => $result['success'], 'movie' => $result['record']];
        } else {
            $message = ['message' => 'Failed to update movie in database', 'success' => false, 'movie' => null];
        }

        return $response->withHeader('Content-Type', 'application/json')->write(json_encode($message));
    }
}
