<?php

namespace Database\Query;

require './Database.php';

use PDO;

class DvdQuery extends \Database
{

    public $title;
    public $order;

    public function titleContains($title)
    {

        $this->title = $title;

    }

    public function orderByTitle()
    {
        $this->order = " ORDER BY title";

    }


    public function __construct()
    {
        parent::__construct();
    }

    public function find()
    {
        $sql = "
            SELECT title, dvds.id, rating_name
            FROM dvds, ratings
            WHERE dvds.rating_id = ratings.id
        ";

        if ($this->title) {
            $sql = $sql . " AND title LIKE ?";
        }

        if ($this->order) {
            $sql = $sql . $this->order;
        }

        $statement = self::$pdo->prepare($sql);
        $like = "%" . $this->title . "%";
        $statement->bindParam(1, $like);
        $statement->execute();
        var_dump($sql);
        return $statement->fetchAll(PDO::FETCH_OBJ);





    }

}