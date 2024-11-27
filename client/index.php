<?php

include_once 'app/RequestAction.php';
$requestAction = new RequestAction();

// GET MOVIE -> UPDATE
if ((isset($_GET['action']) && isset($_GET['id'])) && isset($_GET['update'])) {
    if ($_GET['action'] == "viewMovies" && ctype_digit($_GET['id']) && strcasecmp($_GET['update'], "true") === 0) {
        $requestAction->updateMovie();
    } else {
        $requestAction->index();
        header("Location: /client", true, 302);
    }
    // GET MOVIE -> DELETE
} else if ((isset($_GET['action']) && isset($_GET['id'])) && isset($_GET['delete'])) {
    if ($_GET['action'] == "viewMovies" && ctype_digit($_GET['id']) && strcasecmp($_GET['delete'], "true") === 0) {
        $requestAction->deleteMovie();
    } else {
        $requestAction->index();
        header("Location: /client", true, 302);
    }
    // VIEW -> GET MOVIE
} else if (isset($_GET['action']) && isset($_GET['id'])) {
    if ($_GET['action'] == "viewMovies" && ctype_digit($_GET['id'])) {
        $requestAction->getMovie();
    } else {
        $requestAction->index();
        header("Location: /client", true, 302);
    }
    // ACTION
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
    // ADD 
    if ($action == 'addMovie') {
        $requestAction->addMovie();
        // SEARCH
    } else if ($action == "searchMovies") {
        $requestAction->searchMovies();
        // VIEW
    } elseif ($action == 'viewMovies') {
        $requestAction->getMovies();
    } else {
        $requestAction->index();
        header("Location: /client", true, 302);
    }
    // INDEX
} else {
    $requestAction->index();
}
