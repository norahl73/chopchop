<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ChopChop - Favorites</title>
    <link rel="stylesheet" href="styles/favorites.css" />
  </head>
  <body>
    <!-- Eyebrow Navigation -->
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

        <!-- Main Nav -->
        <ul class="nav-links">
          <li><a href="index.php?url=recipe-library">Recipe Library</a></li>
          <li><a class="active" href="#">Favorites</a></li>
          <li><a href="index.php?url=shopping-list">Shopping List</a></li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="index.php?url=profile">
          <img src="assets/pfp.jpg" alt="Profile" width="36" height="36" />
        </a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
      <!-- title header thing -->
      <section class="hero">
        <h1>Your Favorite Recipes</h1>
      </section>

      <!-- Page Control Buttons (will likely change to a popup or smth)-->
      <!-- Addresses filter and sort functionality -->
      <div class="controls">
        <button id="gridBtn">Grid</button>
        <button id="listBtn">List</button>
        <button id="filterBtn">Filter / Sort</button>
        <button id="addBtn">+ Add</button>
      </div>

      <!-- Grid View -->
      <section id="gridView" class="view">
        <div class="grid">
          <?php foreach ($favorites as $recipe): ?>
          <article class="card" data-target="modal-<?= $recipe['id'] ?>">
            <div class="card-top">
              <span class="dish"><?= htmlspecialchars($recipe['title']) ?></span>
              <button class="moreBtn">⋯</button>
            </div>
            <img src="<?= ($recipe['image_path'] ?: 'assets/food.jpg') ?>" alt="Thumbnail for <?= htmlspecialchars($recipe['title']) ?>" class="thumbnail" />
            <div class="card-body">
              <p class="quickDesc"><?= htmlspecialchars($recipe['genre']) ?> · <?= htmlspecialchars($recipe['time_takes']) ?> min</p>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- List View -->
      <section id="listView" class="view hidden">
        <ul class="list">
          <?php foreach ($favorites as $recipe): ?>
          <li class="list-item" data-target="modal-<?= $recipe['id'] ?>">
            <img src="<?= htmlspecialchars($recipe['image_path'] ?: 'assets/food.jpg') ?>" alt="Thumbnail for <?= htmlspecialchars($recipe['title']) ?>" class="list-thumb" />
            <div class="list-content">
              <h3><?= htmlspecialchars($recipe['title']) ?></h3>
              <p><?= htmlspecialchars($recipe['genre']) ?> · <?= htmlspecialchars($recipe['time_takes']) ?> min</p>
            </div>
            <button class="openDetail button">Open</button>
            <button class="moreBtn">⋯</button>
          </li>
          <?php endforeach; ?>
        </ul>
      </section>

      <!-- Recipe Detail modal -->
      <?php foreach ($favorites as $recipe): ?>
        <div id="modal-<?= $recipe['id'] ?>" class="modal hidden">
          <div class="modal-content recipe-modal-content">
            <button class="close-btn" data-target="modal-<?= $recipe['id'] ?>">×</button>

            <img src="<?= $recipe['image_path'] ? htmlspecialchars($recipe['image_path']) : 'assets/food.jpg' ?>"
                alt="<?= htmlspecialchars($recipe['title']) ?>" class="recipe-modal-img" />

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

            <h3>Instructions</h3><br />
            <p><?= (htmlspecialchars($recipe['instructions'])) ?></p>

            <form method="POST" action="index.php?url=favorites">
              <input type="hidden" name="remove_recipe" value="1">
              <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
              <button type="submit" class="button favorite-btn">Remove from Favorites</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>

      <!-- Recipe Actions Modal -->
      <!-- Addresses Recipe editing and detail viewing functionality -->
      <div id="recipeActions" class="modal hidden">
        <div class="modal-content">
          <h3>Recipe Actions</h3>
          <p>What would you like to do with this recipe?</p>
          <div class="modal-actions">
            <button id="openDetailBtn" class="button">Open</button>
            <button id="editRecipe" class="button secondary">Edit</button>
            <button id="closeModal" class="button tertiary">Close</button>
          </div>
        </div>
      </div>

      <!-- Add Recipe Modal -->
      <!-- Addresses adding recipe to library functionality -->
      <!-- also handles user data entry -->
      <div id="addRecipeModal" class="modal hidden">
            <div class="modal-content">
              <button id="closeAddModal" class="close-btn">×</button>
              <h2>Add a New Recipe</h2>
              <form method="POST" enctype="multipart/form-data">
              <input type="hidden" name="add_recipe" value="1">
              
              <label for="title">Recipe Title</label>
              <input type="text" id="title" name="title" required> <br />

              <label for="genre">Genre</label>
              <input type="text" id="genre" name="genre" required><br />

              <label for="time_takes">Time (minutes)</label>
              <input type="number" id="time_takes" name="time_takes" required><br />

              <label>Ingredients</label>
              <div id="ingredient-list">
              <input type="text" name="ingredients[]" placeholder="Ingredient 1" required>
              </div>
              <button type="button" id="addIngredientBtn" class="button secondary">+ Add Ingredient</button><br />

              <label for="instructions">Instructions</label><br />
              <textarea id="instructions" name="instructions" required></textarea><br />

              <label for="image">Upload Image</label>
              <input type="file" id="image" name="image" accept="image/*"><br />

              <button type="submit" class="button">Add Recipe</button>
            </form>
          </div>
      </div>
    </main>

    <!-- Footer -->
    <footer>
      <p>© ChopChop - Your Personal Recipe Library</p>
    </footer>

    <script>
      // View switching
      const gridView = document.getElementById("gridView");
      const listView = document.getElementById("listView");

      document.getElementById("gridBtn").onclick = () => showView(gridView);
      document.getElementById("listBtn").onclick = () => showView(listView);

      function showView(view) {
        gridView.classList.add("hidden");
        listView.classList.add("hidden");
        view.classList.remove("hidden");
      }

      document.addEventListener("DOMContentLoaded", () => {
        // Add Recipe Modal
        const addModal = document.getElementById("addRecipeModal");
        document.getElementById("addBtn").addEventListener("click", () => addModal.classList.remove("hidden"));
        document.getElementById("closeAddModal").addEventListener("click", () => addModal.classList.add("hidden"));

        // Ingredient Fields
        const list = document.getElementById("ingredient-list");
        document.getElementById("addIngredientBtn").addEventListener("click", () => {
          const input = document.createElement("input");
          input.type = "text";
          input.name = "ingredients[]";
          input.placeholder = "Ingredient";
          list.appendChild(input);
        });

        // Click on grid cards to open their modals
        document.querySelectorAll(".card").forEach(card => {
          card.addEventListener("click", (e) => {
            if (e.target.classList.contains('moreBtn')) {
              return; // Don't open modal if more button was clicked
            }
            const targetId = card.dataset.target;
            if (targetId) {
              document.getElementById(targetId).classList.remove("hidden");
            }
          });
        });

        // Click on "Open" buttons in list view to open recipe details
        document.querySelectorAll(".openDetail").forEach(button => {
          button.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent triggering list item click
            const listItem = button.closest('.list-item');
            const targetId = listItem.dataset.target;
            if (targetId) {
              document.getElementById(targetId).classList.remove("hidden");
            }
          });
        });

        // Click on list items to open their modals
        document.querySelectorAll(".openDetail").forEach(button => {
          button.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent triggering list item click
            const listItem = button.closest('.list-item');
            if (listItem && listItem.dataset.target) {
              const targetId = listItem.dataset.target;
              const modal = document.getElementById(targetId);
            }
          });
        });

        // Recipe actions modal for more buttons
        const recipeModal = document.getElementById("recipeActions");
        let currentRecipeId = null;

        document.querySelectorAll(".moreBtn").forEach((btn) => {
          btn.onclick = (e) => {
            e.stopPropagation(); // Prevent card/list item click event
            
            // Find the recipe ID from the parent element
            const parent = btn.closest('.card') || btn.closest('.list-item');
            if (parent && parent.dataset.target) {
              currentRecipeId = parent.dataset.target.replace('modal-', '');
            }
            
            recipeModal.classList.remove("hidden");
          };
        });

        // Open detail from recipe actions modal
        document.getElementById("openDetailBtn").onclick = () => {
          if (currentRecipeId) {
            document.getElementById(`modal-${currentRecipeId}`).classList.remove("hidden");
          }
          recipeModal.classList.add("hidden");
        };

        document.getElementById("closeModal").onclick = () => {
          recipeModal.classList.add("hidden");
        };

        // Close buttons for all modals
        document.querySelectorAll(".close-btn").forEach(btn => {
          btn.addEventListener("click", (e) => {
            e.preventDefault();
            const targetId = btn.dataset.target;
            if (targetId) {
              document.getElementById(targetId).classList.add("hidden");
            } else {
              btn.closest('.modal').classList.add("hidden");
            }
          });
        });

        // Click outside modal to close
        document.querySelectorAll(".modal").forEach(m => {
          m.addEventListener("click", e => {
            if (e.target === m) m.classList.add("hidden");
          });
        });
      });
    </script>
  </body>
</html>