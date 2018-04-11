<?php
class Comment {

    // CREATE COMMENT
    public function addComment($db, $recipe_id, $user_id, $comment){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$name, $email, $program
        $sql = "INSERT INTO comments (recipe_id, user_id, comment)
                              VALUES (:recipe_id, :user_id, :comment)";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $pdostm->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $pdostm->bindValue(':comment', $comment, PDO::PARAM_STR);
        $count = $pdostm->execute();
        return $count;
    }

    // READ ALL
    public function getAllComments($db){
        $sql = 'SELECT * FROM comments';
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

    // UPDATE COMMENT
    public function updateComment($db, $id, $comment){
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE comments SET comment = :comment WHERE id = :id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $pdostm->bindValue(':comment', $comment, PDO::PARAM_STR);
        $count = $pdostm->execute();
        return $count;
    }

    // DELETE COMMENT
    public function deleteComment($db, $id){
        $sql = 'DELETE FROM comments WHERE id = :id';
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }

    //READ comments
    public function getCommentById($db, $id){
        $sql = 'SELECT * FROM comments WHERE id = :id';

        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':id', $id, PDO::PARAM_INT);
        $pdostm->execute();
        $comment = $pdostm->fetch(PDO::FETCH_OBJ);
        return $comment;
    }

    public function getUniqueRecipe($db){
        $sql = 'SELECT DISTINCT recipe_id FROM comments';
        $pdostm = $db->prepare($sql);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }


    public function getRecipeComments($db, $recipe_event_id){
        $sql = "SELECT * FROM comments WHERE recipe_id = :recipe_event_id";
        $pdostm = $db->prepare($sql);
        $pdostm->bindValue(':recipe_event_id', $recipe_event_id, PDO::PARAM_INT);
        $pdostm->setFetchMode(PDO::FETCH_OBJ);
        $pdostm->execute();
        return $pdostm->fetchAll();
    }

}
