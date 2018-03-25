<?php
class RecipesMade {
    private $id;
    private $recipe_id;
    private $user_id;
    private $pub_date;

    // SETTER
    public function setId($id) {
        $this->id = $id;
    }
    public function setRecipeId($r_id) {
        $this->recipe_id = $r_id;
    }
    public function setUserId($u_id) {
        $this->user_id = $u_id;
    }
    public function setPubDate($p_date) {
        $this->pub_date = $p_date;
    }

    // GETTER
    public function getId() {
        return $this->$id;
    }
    public function getRecipeId() {
        return $this->recipe_id;
    }
    public function getUserId() {
        return $this->user_id;
    }
    public function getPubDate() {
        return $this->pub_date;
    }

    public function __construct() {

    }

    // READ
    public function displayAllRecipesMade($db) {
        $sql = "SELECT * FROM recipes_made";
        $pdostm = $db->prepare($sql);
        $pdostm->execute();
        $recipesMade = $pdostm->fetchAll(PDO::FETCH_OBJ);
        return $recipesMade;
    }

    // ADD
    public function addRecipeMade($db, $in_id, $in_rid, $in_uid, $in_pdate) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO recipes_made VALUES (:in_id, :in_rid, :in_uid, :in_pdate)";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(":in_id", $in_id, PDO::PARAM_INT);
        $pdostm->bindValue(":in_rid", $in_rid, PDO::PARAM_INT);
        $pdostm->bindValue(":in_uid", $in_uid, PDO::PARAM_INT);
        $pdostm->bindValue(":in_pdate", $in_pdate);
        $count = $pdostm->execute();
        return $count;
    }

    // UPDATE
    public function updateRecipeMade($db, $in_id, $in_rid, $in_uid, $in_pdate) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE recipes_made SET recipe_id = :in_rid, user_id = :in_uid, pub_date = :in_pdate WHERE id = :in_id";

        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(":in_id", $in_id, PDO::PARAM_INT);
        $pdostm->bindValue(":in_rid", $in_rid, PDO::PARAM_INT);
        $pdostm->bindValue(":in_uid", $in_uid, PDO::PARAM_INT);
        $pdostm->bindValue(":in_pdate", $in_pdate);
        try {
            $count = $pdostm->execute();
            return $count;
        } catch (PDOException $e) {
            $count = $e->getMessage();
            return $count;
        }
    }

    //GET RECIPE MADE BY ID
    public function getRecipeMadeById($db, $id) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes_made WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $count = $statement->fetch(PDO::FETCH_OBJ);
        return $count;
    }

    //DELETE
    public function deleteRecipeMade($db, $id) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE FROM recipes_made WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $count = $statement->execute();
        return $count;
    }
}



 ?>