<!DOCTYPE html>
<html>
  <head>
    <meta name="utf-8" />
    <meta name="description" content="Welcome to ChopChop!" />
    <link rel="stylesheet" href="styles/index.css" />
    <title>ChopChop - Recipe Library</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </head>

  <body>
    <!-- Header -->
    <header class="header">
      <nav class="main-nav">
        <a class="logo" href="index.php?url=home">
          <img
            src="assets/logo.svg"
            alt="ChopChop logo"
            width="36"
            height="36"
          />
          <span>ChopChop</span>
        </a>

        <!-- Main Navigation -->
        <ul class="nav-links">
          <li><a class="active" href="index.php?url=recipe-library">Recipe Library</a></li>
          <li><a href="index.php?url=favorites">Favorites</a></li>
          <li><a href="index.php?url=shopping-list">Shopping List</a></li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="index.php?url=profile">
          <img src="assets/pfp.jpg" alt="Profile" width="36" height="36" />
        </a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="recipe-main">
      <div class="page-header">
        <h1 style="color:white">Recipe Library</h1>
        <p>Discover amazing recipes for every occasion</p>

        <!-- Search Bar where they can look up different recipes -->
        <div class="search-container">
          <input
            type="text"
            id="searchInput"
            placeholder="Search for recipes."
            class="search-input"
          />
          <button class="search-btn">Search</button>
        </div>
      </div>

      <!-- Page Control Buttons -->
      <div class="controls">
        <button id="filterBtn">Filter / Sort</button>

        <div id="filterMenu" class="hidden filter-menu">
          <button class="sortAZ">Sort A–Z</button>
          <button class="filterGenre">Filter by Genre</button>
          <button class="resetFilter">Reset Filters</button>
        </div>

        <button id="addBtn">+ Add Recipe</button>
      </div>

      <!-- Recipe Cards -->
      <div class="recipes-grid">
        <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card">
          <img
            src="<?= $recipe['image_path'] ? htmlspecialchars($recipe['image_path']) : 'assets/food.jpg' ?>"
            alt="<?= htmlspecialchars($recipe['title']) ?> recipe"
            class="recipe-image"
          />
          <div class="recipe-content">
            <h3><?= htmlspecialchars($recipe['title']) ?></h3>
            <div class="recipe-meta">
              <span class="cooking-time"><?= htmlspecialchars($recipe['time_takes']) ?> min</span>
              <span class="genre"><?= htmlspecialchars($recipe['genre']) ?></span>
            </div>
            <button class="view-recipe-btn" data-target="modal-<?= $recipe['id'] ?>">View Recipe</button>
          </div>
        </div>

        <!-- Modal for recipe -->
        <div id="modal-<?= $recipe['id'] ?>" class="modal hidden">
          <div class="modal-content recipe-modal-content">
            <button class="close-btn" data-target="modal-<?= $recipe['id'] ?>">×</button>

            <img
              src="<?= $recipe['image_path'] ? htmlspecialchars($recipe['image_path']) : 'assets/food.jpg' ?>"
              alt="<?= htmlspecialchars($recipe['title']) ?>"
              class="recipe-modal-img"
            />

            <h2><?= htmlspecialchars($recipe['title']) ?></h2>
            <p><strong>Genre:</strong> <?= htmlspecialchars($recipe['genre']) ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($recipe['time_takes']) ?> minutes</p>

            <h3>Ingredients</h3>
            <ul>
              <?php 
                $ingredients = json_decode($recipe['ingredients'], true) ?: [];
                foreach ($ingredients as $ingredient): ?>
                <li><?= htmlspecialchars($ingredient) ?></li>
              <?php endforeach; ?>
            </ul>

            <h3>Instructions</h3>
            <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>

            <!-- Favorite button -->
            <form method="POST" action="index.php?url=favorites">
              <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
              <button type="submit" class="button favorite-btn">Add to Favorites</button>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Add Recipe Modal -->
      <div id="addRecipeModal" class="modal hidden">
        <div class="modal-content addRecipe">
          <button id="closeAddModal" class="close-btn">×</button>
          <h2>Add a New Recipe</h2>
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="add_recipe" value="1">

            <label for="title">Recipe Title</label>
            <input type="text" id="title" name="title" required>

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" required>

            <label for="time_takes">Time (minutes)</label>
            <input type="number" id="time_takes" name="time_takes" required>

            <label>Ingredients</label>
            <div id="ingredient-list">
              <input type="text" name="ingredients[]" placeholder="Ingredient 1" required>
            </div>
            <button type="button" id="addIngredientBtn" class="button secondary">+ Add Ingredient</button>

            <label for="instructions">Instructions</label>
            <textarea id="instructions" name="instructions" rows="6" required></textarea>

            <label for="image">Upload Image</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit" class="button">Add Recipe</button>
          </form>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer>
      <p>(c) ChopChop - Your Personal Recipe Library</p>
    </footer>

    <!-- Modal Script -->
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        // View recipe buttons
        document.querySelectorAll(".view-recipe-btn").forEach(btn => {
          btn.addEventListener("click", () => {
            const targetId = btn.dataset.target;
            document.getElementById(targetId).classList.remove("hidden");
          });
        });

        // Close buttons
        document.querySelectorAll(".close-btn").forEach(btn => {
          btn.addEventListener("click", () => {
            const targetId = btn.dataset.target;
            if (targetId) {
              document.getElementById(targetId).classList.add("hidden");
            } else {
              btn.closest('.modal').classList.add("hidden");
            }
          });
        });

        // Click outside modal to close
        document.querySelectorAll(".modal").forEach(modal => {
          modal.addEventListener("click", e => {
            if (e.target === modal) modal.classList.add("hidden");
          });
        });

        // Filter menu toggle
        const filterBtn = document.getElementById("filterBtn");
        const filterMenu = document.getElementById("filterMenu");
        
        filterBtn.addEventListener("click", () => {
          filterMenu.classList.toggle("hidden");
        });

        // Add Recipe Modal
        const addModal = document.getElementById("addRecipeModal");
        document.getElementById("addBtn").addEventListener("click", () => {
          addModal.classList.remove("hidden");
        });
        
        document.getElementById("closeAddModal").addEventListener("click", () => {
          addModal.classList.add("hidden");
        });

        // Dynamic ingredient fields
        const ingredientList = document.getElementById("ingredient-list");
        document.getElementById("addIngredientBtn").addEventListener("click", () => {
          const input = document.createElement("input");
          input.type = "text";
          input.name = "ingredients[]";
          input.placeholder = "Ingredient";
          ingredientList.appendChild(input);
        });

        // Sort A-Z functionality
        document.querySelector(".sortAZ").addEventListener("click", () => {
          const grid = document.querySelector(".recipes-grid");
          const cards = Array.from(grid.querySelectorAll(".recipe-card"));
          
          cards.sort((a, b) => {
            const titleA = a.querySelector("h3").textContent.toLowerCase();
            const titleB = b.querySelector("h3").textContent.toLowerCase();
            return titleA.localeCompare(titleB);
          });
          
          cards.forEach(card => grid.appendChild(card));
          filterMenu.classList.add("hidden");
        });

        // Reset filters
        document.querySelector(".resetFilter").addEventListener("click", () => {
          location.reload();
        });
      });
    </script>

    <!-- jQuery Filtering Script -->
    <script>
      $("#searchInput").on("input", function () {
        const term = $(this).val().toLowerCase();

        $(".recipe-card").each(function () {
          const title = $(this).find("h3").text().toLowerCase();
          $(this).toggle(title.includes(term));
        });
      });
    </script>

  </body>
</html>