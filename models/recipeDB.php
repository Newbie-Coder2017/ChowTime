<?php
class RecipeDb {
    // DISPLAY ALL RECIPES
    public static function displayAllRecipes() {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes";
        $statement = $db->prepare($query);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();

        return $statement->fetchAll();
    }

    //DISPLAY ONLY RECIPE NAME
    public static function displayByTitle($title) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT title FROM recipes WHERE title LIKE '%$title%';";
        $statement = $db->prepare($query);
        $statement->bindValue(":title", $title, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    //DISPLAY RECIPE BY ID
    public static function displayById($in_id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM recipes WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $in_id, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return $statement->fetch();
    }

    //ADD A RECIPE
    public static function addRecipe($recipe) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "INSERT INTO recipes VALUES (:id, :user_id, :img_id, :title, :descr, :p_time, :c_time, :dish, :ingred, :diff, :spicy, :p_date, :steps)";

        $statement = $db->prepare($query);

        $id = $recipe->getId();
        $user_id = $recipe->getUserId();
        $img_id = $recipe->getImgId();
        $title = $recipe->getTitle();
        $descr = $recipe->getDescr();
        $p_time = $recipe->getPrepTime();
        $c_time = $recipe->getCookTime();
        $dish = $recipe->getDishLvl();
        $ingred = $recipe->getIngredLvl();
        $diff = $recipe->getDiffLvl();
        $spicy = $recipe->getSpicyLvl();
        $p_date = $recipe->getPubDate();
        $steps = $recipe->getSteps();

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindValue(':img_id', $img_id, PDO::PARAM_INT);
        $statement->bindValue(':title', $title, PDO::PARAM_STR);
        $statement->bindValue(':descr', $descr, PDO::PARAM_STR);
        $statement->bindValue(':p_time', $p_time);
        $statement->bindValue(':c_time', $c_time);
        $statement->bindValue(':dish', $dish, PDO::PARAM_INT);
        $statement->bindValue(':ingred', $ingred, PDO::PARAM_INT);
        $statement->bindValue(':diff', $diff, PDO::PARAM_INT);
        $statement->bindValue(':spicy', $spicy, PDO::PARAM_INT);
        $statement->bindValue(':p_date', $p_date);
        $statement->bindValue(':steps', $steps, PDO::PARAM_STR);

        $statement->setFetchMode(PDO::FETCH_OBJ);
        $count = $statement->execute();

        return $count;


    }

    //UPDATE A RECIPE (also should be done based on user session)
    //Default params are exhisting params from the recipe
    public static function updateRecipe($in_id) {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "UPDATE Recipes SET
                    user_id = :u_id,
                    descr =  :descr,
                    img = :img,
                    prep = :prep,
                    ingred = :ingred,
                    diff = :diff,
                  WHERE id = :id";

        $this->setId($in_id);
        $id = $this->getId();
        $title = $this->getTitle();
        $descr = $this->getDescr();
        $img = $this->getImgSrc();
        $prep = $this->getPrepTime();
        $dish = $this->getDishLvl();
        $ingred = $this->getIngredLvl();
        $diff = $this->getDiffLvl();

        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->bindValue(":title", $title, PDO::PARAM_STR);
        $statement->bindValue(":descr", $descr, PDO::PARAM_STR);
        $statement->bindValue(":img", $img, PDO::PARAM_STR);
        $statement->bindValue(":prep", $prep, PDO::PARAM_STR);
        $statement->bindValue(":ingred", $ingred, PDO::PARAM_STR);
        $statement->bindValue(":diff", $diff, PDO::PARAM_STR);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $count = $statement->execute();

        return $count;
    }
    //DELETE A RECIPE
    public static function deleteRecipe($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE FROM recipes WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $count = $statement->execute();

        return $count;
    }

    //TOTAL RECIPE TIME
    public static function totalRecipeTime($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT ADDTIME(prep_time, cook_time) AS 'total_time' FROM recipes WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return $statement->fetch();
    }

    //RECOMMENDED DIFFICULTY
    public static function recommDiff($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT ROUND(((dishes_lvl + ingred_lvl + spicy_lvl)/3), 2) AS 'recomm_diff' FROM recipes WHERE id= :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return $statement->fetch();
    }

    //MAIN RECIPE IMAGE
    public static function mainRecipeImg($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT img_src FROM recipe_imgs ri
        JOIN recipes r
        ON r.main_img_id = ri.id
        WHERE r.id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();

        return $statement->fetch();
    }

    //ALL RECIPE IMAGES
    public static function allRecipeImgs($id) {
        $db = Database::getDb();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT img_src FROM recipe_imgs ri
        JOIN recipes r
        ON r.id = ri.recipe_id
        WHERE r.id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();

        return $statement->fetchAll();
    }

    //SELECT LAST RECIPE ID FROM THE LIST - https://stackoverflow.com/questions/3133711/select-last-id-without-insert?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    public static function getLastRecipe() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT @var := MAX(id) FROM recipes";
        $db->prepare($sql);
        // $db->setFetchMode(PDO::FETCH_OBJ);
        $id = $db->execute();

        return $id;
    }

    public static function getImageCount() {
        $db = Database::getDb();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT COUNT(img_src) FROM recipe_imgs";
        $statement = $db->prepare($sql);
        $statement->execute();
        return $statement->fetch();
    }
}
?>
