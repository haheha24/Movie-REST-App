<?php

//need to go into the MOVIE-REST-APP root for this Dotenv instance to find the dotenv vendor
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', 'server.env');
$dotenv->load();
$dotenv->required([
    'DB_HOST',
    'DB_NAME',
    'DB_USER',
    'DB_PASS'
]);

class MoviesDB {
    //need to go into the MOVIE-REST-APP root for this Dotenv instance to find the dotenv vendor
    var $pdo;
    var $dsn;
    var $user;
    var $pass;

    function __construct() {
        $this->dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}";
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->pdo = new PDO($this->dsn, $this->user, $this->pass);
    }

    function __destruct() {
        $this->pdo = null;
    }

    function getMovies() {
        $statement = $this->pdo->query("select * from movies");
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $records = $statement->fetchAll();
        return $records;
    }

    function getMovie($id) {
        $statement = $this->pdo->prepare("select * from movies where id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);
        return $record;
    }

    function addMovie($values) {
        $title = $values['title'];
        $release_date = $values['release_date'];
        $genre = $values['genre'];
        $length = $values['length'];
        $director = $values['director'];
        $lead_actor = $values['lead_actor'];
        $filename = $values['filename'];

        $sql = "insert into movies (title, release_date, genre, length, director, lead_actor, filename)"
            . " values(:title, :release_date, :genre, :length, :director, :lead_actor, :filename)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":release_date", $release_date);
        $statement->bindParam(":genre", $genre);
        $statement->bindParam(":length", $length);
        $statement->bindParam(":director", $director);
        $statement->bindParam(":lead_actor", $lead_actor);
        $statement->bindParam(":filename", $filename);
        $success = $statement->execute();

        $sql = "select * from movies WHERE title = :title"
            . " and release_date = :release_date"
            . " and genre = :genre"
            . " and length = :length"
            . " and director = :director"
            . " and lead_actor = :lead_actor"
            . " and filename = :filename";
        $statement2 = $this->pdo->prepare($sql);
        $statement2->bindParam(":title", $title);
        $statement2->bindParam(":release_date", $release_date);
        $statement2->bindParam(":genre", $genre);
        $statement2->bindParam(":length", $length);
        $statement2->bindParam(":director", $director);
        $statement2->bindParam(":lead_actor", $lead_actor);
        $statement2->bindParam(":filename", $filename);
        $movie = $statement2->execute();

        return ['success' => $success, 'record' => $movie];
    }

    function deleteMovie($id) {
        $temp = $this->getMovie($id);

        $sql = "delete from movies where id = :id";
        $statement = $this->pdo->prepare($sql);
        $success = $statement->execute([':id' => $id]);

        $rowsAffected = $statement->rowCount();
        $verification = $this->getMovie($id);

        $deleted = $success && $rowsAffected === 1 && $verification === false;

        return ['success' => $success, 'temp_record' => $temp, 'deleted' => $deleted];
    }

    function searchMovies($keyword) {
        $records = [];
        $statement = $this->pdo->query(
            "select * from movies where "
                . "title like '%$keyword%' "
                . "OR release_date like '%$keyword%' "
                . "OR genre like '%$keyword%' "
                . "OR length like '%$keyword%' "
                . "OR director like '%$keyword%' "
                . "OR lead_actor like '%$keyword%' "
                . "OR filename like '%$keyword%' "
        );
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $records = $statement->fetchAll();
        return $records;
    }

    function updateMovie($id, $values) {
        $title = $values['title'];
        $release_date = $values['release_date'];
        $genre = $values['genre'];
        $length = $values['length'];
        $director = $values['director'];
        $lead_actor = $values['lead_actor'];
        $filename = $values['filename'];

        $sql = "update movies set"
            . " title = :title,"
            . " release_date = :release_date,"
            . " genre = :genre,"
            . " length = :length,"
            . " director = :director,"
            . " lead_actor = :lead_actor,"
            . " filename = :filename"
            . " WHERE id = :id";
        $statement = $this->pdo->prepare($sql);

        $statement->bindParam(":title", $title);
        $statement->bindParam(":release_date", $release_date);
        $statement->bindParam(":genre", $genre);
        $statement->bindParam(":length", $length);
        $statement->bindParam(":director", $director);
        $statement->bindParam(":lead_actor", $lead_actor);
        $statement->bindParam(":filename", $filename);
        $statement->bindParam(":id", $id);
        $success = $statement->execute();

        $data = $this->getMovie($id);

        return ['success' => $success, 'record' => $data];
    }
}
