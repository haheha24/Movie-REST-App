<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../../vendor/autoload.php";

use GuzzleHttp\Client;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

//need to go into the MOVIE-REST-APP root for this Dotenv instance to find the dotenv vendor
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', 'client.env');
$dotenv->load();
$dotenv->required([
    'SERVER_URI',
    'CLIENT_URI',
    'POSTER_PATH'
])->notEmpty();

/**
 * MUST IMPLEMENT CLIENTSIDE ERROR HANDLING FOR FORMS
 */


class RequestAction {
    var $client;
    var $view;

    function __construct() {
        $this->client = new Client(['base_uri' => $_ENV['SERVER_URI']]);
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->view = new Environment($loader);
    }

    function index() {
        echo $this->view->render('index.twig');
    }

    function getMovies() {
        $uri = 'movies';
        $response = $this->client->get($uri);
        $contents = $response->getBody()->getContents();
        $records = json_decode($contents, true);

        echo $this->view->render('movie_table.twig', ['records' => $records]);
    }

    function addMovie() {
        if (isset($_POST['submit'])) {

            $filename = $_FILES["filename"]["name"];
            $temp_file = $_FILES["filename"]["tmp_name"];
            $destination = './' . $_ENV['POSTER_PATH'];
            $target_file = $destination . $filename;
            move_uploaded_file($temp_file, $target_file);

            $_POST['filename'] = $filename;

            $uri = 'movies';
            $response = $this->client->request('POST', $uri, ['form_params' => $_POST]);
            $contents = $response->getBody()->getContents();
            $result = json_decode($contents, true);

            echo $this->view->render('message.twig', ['message' => $result['message']]);
        } else {
            echo $this->view->render('movie_form.twig');
        }
    }
    function searchMovies() {
        if (isset($_POST['submit'])) {
            $keyword = $_POST['keyword'];
            $uri = "movies/keyword/$keyword";
            $response = $this->client->get($uri);
            $contents = $response->getBody()->getContents();
            $records = json_decode($contents, true);

            echo $this->view->render('movie_table.twig', ['records' => $records]);
        } else {
            echo $this->view->render("movie_search_form.twig");
        }
    }
    function getMovie() {
        if (isset($_GET['id'])) {
            $uri = "movies/id/{$_GET['id']}";
            $response = $this->client->get($uri);
            $contents = $response->getBody()->getContents();
            $record = json_decode($contents, true);
            echo $this->view->render("movie_table_item.twig", ['record' => $record]);
        } else {
            echo $this->view->render('message.twig', ['message' => "That movie doesn't exist"]);
        }
    }
    function deleteMovie() {
        if (isset($_POST['submit'])) {
            if (isset($_POST['id'])) {
                // hidden input 'id' in post request exists
                $uri = "movies/id/{$_POST['id']}/delete";
                $response = $this->client->request('delete', $uri, ['form_params' => $_POST]);
                $contents = $response->getBody()->getContents();
                $result = json_decode($contents, true);

                if ($result['success']) {
                    // successfully deleted
                    $image_path = './' . $_ENV['POSTER_PATH'] . $result['temp_record']['filename'];
                    if (file_exists($image_path)) {
                        // would need to make sure permissions are granted.
                        unlink($image_path);
                    }
                    echo $this->view->render("message.twig", ['message' => $result['message']]);
                } else {
                    // failed deletion
                    echo $this->view->render("message.twig", ['message' => $result['message']]);
                }
            } else {
                echo $this->view->render("message.twig", ["message" => "An error with the delete form occured."]);
            }
        } else {
            echo $this->view->render("movie_delete_form.twig", ['id' => $_GET['id']]);
        }
    }
    function updateMovie() {
        if (isset($_POST['submit']) && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
            if (isset($_FILES["new_filename"]["name"]) && mb_strlen($_FILES["new_filename"]["name"]) > 0) {
                $filename = $_FILES["new_filename"]["name"];
                $temp_file = $_FILES["new_filename"]["tmp_name"];
                $destination = $_ENV['POSTER_PATH'];
                $target_file = $destination . $filename;
                move_uploaded_file($temp_file, $target_file);

                $_PUT['filename'] = $filename;
            } else {
                $_PUT['filename'] = $_POST['existing_filename'];
            }

            foreach ($_POST as $key => $value) {
                if ($key !== 'submit' && $key !== '_method') {
                    $_PUT["$key"] = $value;
                }
            }

            $uri = "movies/id/{$_GET['id']}/update";
            $response = $this->client->request('PUT', $uri, ['form_params' => $_PUT]);
            $contents = $response->getBody()->getContents();
            $result = json_decode($contents, true);

            if ($result['success']) {
                // parse url to remove update query
                $url = $_SERVER['REQUEST_URI'];
                $url_parts = parse_url($url);
                parse_str($url_parts['query'] ?? '', $query_params);
                unset($query_params['update']);
                $new_query = http_build_query($query_params);
                $clean_url = $url_parts['path'] . ($new_query ? '?' . $new_query : '');

                header("Location: $clean_url", true, 302);
            } else {
                echo $this->view->render("movie_table_item.twig", ['record' => $result['movie'], 'message' => $result['message']]);
            }
        } else {
            $uri = "movies/id/{$_GET['id']}";
            $response = $this->client->get($uri);
            $contents = $response->getBody()->getContents();
            $record = json_decode($contents, true);
            echo $this->view->render('movie_update_form.twig', ['record' => $record]);
        }
    }
}
