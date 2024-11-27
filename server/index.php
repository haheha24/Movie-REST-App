<?php

require __DIR__."/vendor/autoload.php";
require __DIR__."/../vendor/autoload.php";

include_once 'app/RouteActions.php';
include_once "loginfo.php";

$app = new \Slim\App;
$container = $app->getContainer();
$container['RouteAction'] = function($c) {
    return new RouteAction();
};

// REST based route for default URI - /
$app->get('/', \RouteAction::class.':index');

// /movies
$app->get('/movies', \RouteAction::class.':getMovies');
// /movies/keyword/{keyword}
$app->get('/movies/keyword/{keyword}', \RouteAction::class.':searchMovies');
// POST /movies
$app->post('/movies', \RouteAction::class.':addMovie');

// /movies/id/{id}
$app->get('/movies/id/{id}', \RouteAction::class.':getMovieById');
// PUT /movies/id{id} 
$app->put('/movies/id/{id}/update', \RouteAction::class.':updateMovie');
// DELETE /movies/id/{id}
$app->delete('/movies/id/{id}/delete', \RouteAction::class.':deleteMovie');

// start the app
$app->run();
