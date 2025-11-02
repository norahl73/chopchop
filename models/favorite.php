<?php
    class Favorite {
        private $pdo;

        // constructor
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        // adding recipe to favorites table
        public function addFavorite($user_id, $recipe_id) {
            $stmt = $this->pdo->prepare("
                INSERT INTO chop_favorites (user_id, recipe_id)
                VALUES (:user_id, :recipe_id)
            ");
            return $stmt->execute([
                'user_id' => $user_id,
                'recipe_id' => $recipe_id
            ]);
        }

        // removing recipe from favorites table
        public function removeFavorite($user_id, $recipe_id) {
            $stmt = $this->pdo->prepare("
                DELETE FROM chop_favorites 
                WHERE user_id = :user_id AND recipe_id = :recipe_id
            ");
            return $stmt->execute([
                'user_id' => $user_id,
                'recipe_id' => $recipe_id
            ]);
        }

        // so each user has their unique favorites page (sorted by userid)
        public function getFavoritesByUser($user_id) {
            $stmt = $this->pdo->prepare("
                SELECT r.* 
                FROM chop_recipes r 
                JOIN chop_favorites f ON r.id = f.recipe_id 
                WHERE f.user_id = :user_id
            ");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Checking if a recipe is favorited (to be displayed on the favorites page)
        public function isFavorited($user_id, $recipe_id) {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM chop_favorites 
                WHERE user_id = :user_id AND recipe_id = :recipe_id
            ");
            $stmt->execute(['user_id' => $user_id, 'recipe_id' => $recipe_id]);
            return $stmt->fetchColumn() > 0;
        }
    }
?>