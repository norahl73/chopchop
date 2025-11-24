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
        <!-- NEW: AJAX Load More Button -->
        <button id="loadMoreBtn" class="button secondary">Load More Recipes</button>
      </div>

      <!-- Grid View -->
      <section id="gridView" class="view">
        <div class="grid" id="recipeGrid">
          <?php foreach ($favorites as $recipe): ?>
          <article class="card" data-target="modal-<?= $recipe['id'] ?>" data-recipe-id="<?= $recipe['id'] ?>">
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
        <ul class="list" id="recipeList">
          <?php foreach ($favorites as $recipe): ?>
          <li class="list-item" data-target="modal-<?= $recipe['id'] ?>" data-recipe-id="<?= $recipe['id'] ?>">
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
      <div id="modalContainer">
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
      </div>

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
      // AJAX functionality; load more recipes
      
      // Track loaded recipe IDs to avoid duplicates
      const loadedRecipeIds = new Set();
      
      // Initialize with PHP-loaded recipes
      <?php foreach ($favorites as $recipe): ?>
        loadedRecipeIds.add(<?= $recipe['id'] ?>);
      <?php endforeach; ?>

      // Function to load additional recipes via AJAX
      function loadMoreRecipes() {
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'Loading...';

        // Make AJAX request to JSON endpoint
        fetch('recipes.json')
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            console.log('AJAX recipes loaded successfully:', data);
            
            // Filter out recipes that are already loaded
            const newRecipes = data.recipes.filter(recipe => !loadedRecipeIds.has(recipe.id));
            
            if (newRecipes.length === 0) {
              alert('No more recipes to load!');
              loadMoreBtn.disabled = false;
              loadMoreBtn.textContent = 'Load More Recipes';
              return;
            }

            // Add new recipes to both views
            newRecipes.forEach(recipe => {
              loadedRecipeIds.add(recipe.id);
              addRecipeToGridView(recipe);
              addRecipeToListView(recipe);
              createRecipeModal(recipe);
            });

            // Reattach event listeners
            attachEventListeners();

            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'Load More Recipes';
            
            alert(`${newRecipes.length} new recipes loaded!`);
          })
          .catch(error => {
            console.error('Error loading recipes:', error);
            alert('Error loading recipes. Please try again.');
            loadMoreBtn.disabled = false;
            loadMoreBtn.textContent = 'Load More Recipes';
          });
      }

      // Function to add recipe to grid view
      function addRecipeToGridView(recipe) {
        const gridContainer = document.getElementById('recipeGrid');
        const card = document.createElement('article');
        card.className = 'card';
        card.setAttribute('data-target', `modal-${recipe.id}`);
        card.setAttribute('data-recipe-id', recipe.id);
        
        card.innerHTML = `
          <div class="card-top">
            <span class="dish">${escapeHtml(recipe.name)}</span>
            <button class="moreBtn">⋯</button>
          </div>
          <img src="${recipe.image || 'assets/food.jpg'}" alt="Thumbnail for ${escapeHtml(recipe.name)}" class="thumbnail" />
          <div class="card-body">
            <p class="quickDesc">${escapeHtml(recipe.cuisine)} · ${recipe.time} min</p>
          </div>
        `;
        
        gridContainer.appendChild(card);
      }

      // Function to add recipe to list view
      function addRecipeToListView(recipe) {
        const listContainer = document.getElementById('recipeList');
        const listItem = document.createElement('li');
        listItem.className = 'list-item';
        listItem.setAttribute('data-target', `modal-${recipe.id}`);
        listItem.setAttribute('data-recipe-id', recipe.id);
        
        listItem.innerHTML = `
          <img src="${recipe.image || 'assets/food.jpg'}" alt="Thumbnail for ${escapeHtml(recipe.name)}" class="list-thumb" />
          <div class="list-content">
            <h3>${escapeHtml(recipe.name)}</h3>
            <p>${escapeHtml(recipe.cuisine)} · ${recipe.time} min</p>
          </div>
          <button class="openDetail button">Open</button>
          <button class="moreBtn">⋯</button>
        `;
        
        listContainer.appendChild(listItem);
      }

      // Function to create modal for AJAX-loaded recipes
      function createRecipeModal(recipe) {
        const modalContainer = document.getElementById('modalContainer');
        const modal = document.createElement('div');
        modal.id = `modal-${recipe.id}`;
        modal.className = 'modal hidden';
        
        modal.innerHTML = `
          <div class="modal-content recipe-modal-content">
            <button class="close-btn" data-target="modal-${recipe.id}">×</button>

            <img src="${recipe.image || 'assets/food.jpg'}"
                alt="${escapeHtml(recipe.name)}" class="recipe-modal-img" />

            <h2>${escapeHtml(recipe.name)}</h2>
            <p><strong>Genre:</strong> ${escapeHtml(recipe.cuisine)}</p>
            <p><strong>Time:</strong> ${recipe.time} minutes</p>

            <h3>Description</h3>
            <p>${escapeHtml(recipe.description)}</p>

            <p><em>Note: This recipe was loaded via AJAX from recipes.json</em></p>
          </div>
        `;
        
        modalContainer.appendChild(modal);
      }

      // Utility function to escape HTML
      function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // Attach Load More button listener
      document.getElementById('loadMoreBtn').addEventListener('click', loadMoreRecipes);

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

      // Function to attach all event listeners (called after AJAX loads new recipes)
      function attachEventListeners() {
        // Click on grid cards to open their modals
        document.querySelectorAll(".card").forEach(card => {
          card.replaceWith(card.cloneNode(true));
        });
        
        document.querySelectorAll(".card").forEach(card => {
          card.addEventListener("click", (e) => {
            if (e.target.classList.contains('moreBtn')) {
              return;
            }
            const targetId = card.dataset.target;
            if (targetId) {
              document.getElementById(targetId).classList.remove("hidden");
            }
          });
        });

        // Click on "Open" buttons in list view
        document.querySelectorAll(".openDetail").forEach(button => {
          button.replaceWith(button.cloneNode(true));
        });

        document.querySelectorAll(".openDetail").forEach(button => {
          button.addEventListener("click", (e) => {
            e.stopPropagation();
            const listItem = button.closest('.list-item');
            const targetId = listItem.dataset.target;
            if (targetId) {
              document.getElementById(targetId).classList.remove("hidden");
            }
          });
        });

        // More buttons
        document.querySelectorAll(".moreBtn").forEach((btn) => {
          btn.replaceWith(btn.cloneNode(true));
        });

        const recipeModal = document.getElementById("recipeActions");
        let currentRecipeId = null;

        document.querySelectorAll(".moreBtn").forEach((btn) => {
          btn.onclick = (e) => {
            e.stopPropagation();
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

        // Close buttons for all modals
        document.querySelectorAll(".close-btn").forEach(btn => {
          btn.replaceWith(btn.cloneNode(true));
        });

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

        // Initial attachment of event listeners
        attachEventListeners();

        document.getElementById("closeModal").onclick = () => {
          document.getElementById("recipeActions").classList.add("hidden");
        };

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