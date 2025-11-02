<?php
    class Recipe {
        private $pdo;

        // constructor
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        // adding recipe to recipe table
        public function create($user_id, $title, $genre, $time_takes, $instructions, $ingredients = [], $image_path = null) {
            $ingredients_json = json_encode($ingredients);
            
            $stmt = $this->pdo->prepare("
                INSERT INTO chop_recipes (user_id, title, image_path, genre, time_takes, instructions, ingredients)
                VALUES (:user_id, :title, :image_path, :genre, :time_takes, :instructions, :ingredients)
            ");
            return $stmt->execute([
                'user_id' => $user_id,
                'title' => $title,
                'image_path' => $image_path,
                'genre' => $genre,
                'time_takes' => $time_takes,
                'instructions' => $instructions,
                'ingredients' => $ingredients_json
            ]);
        }

        // fetches recipe by its id
        public function findById($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM chop_recipes WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // fetches all recipes in table
        public function findAll() {
            $stmt = $this->pdo->prepare("SELECT * FROM chop_recipes ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Fetches recipe based off of query entered in search bar
        public function search($query) {
            $searchTerm = '%' . $query . '%';
            $stmt = $this->pdo->prepare("
                SELECT * FROM chop_recipes 
                WHERE title LIKE :search 
                   OR genre LIKE :search 
                   OR instructions LIKE :search
                ORDER BY created_at DESC
            ");
            $stmt->execute(['search' => $searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>