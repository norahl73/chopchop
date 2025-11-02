<!DOCTYPE html>
<html>
  <head>
    <meta name="utf-8" />
    <meta name="description" content="Welcome to ChopChop!" />
    <link rel="stylesheet" href="/chop/styles/index.css" />
    <title>ChopChop - Recipe Library</title>
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <nav class="main-nav">
        <a class="logo" href="/chop/index.php?url=home">
          <img
            src="/chop/assets/logo.svg"
            alt="ChopChop logo"
            width="36"
            height="36"
          />
          <span>ChopChop</span>
        </a>

        <!-- Main Navigation -->
        <ul class="nav-links">
          <li>
            <a class="active" href="/chop/recipe-library">Recipe Library</a>
          </li>
          <li><a href="/chop/index.php?url=favorites">Favorites</a></li>
          <li><a href="/chop/index.php?url=shopping-list">Shopping List</a></li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="/chop/templates/profile.php">
          <img src="/chop/assets/pfp.jpg" alt="Profile" width="36" height="36" />
        </a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="recipe-main">
      <div class="page-header">
        <h1>Recipe Library</h1>
        <p>Discover amazing recipes for every occasion</p>

        <!-- Search Bar where they can look up different recipes -->
        <div class="search-container">
          <input
            type="text"
            id="searchInput"
            placeholder="Search recipes..."
            class="search-input"
          />
          <button class="search-btn">Search</button>
        </div>
      </div>

      <!-- Recipe Cards to show what it would look like for meals-->
      <div class="recipes-grid">
        <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card">
          <img
            src="<?= $recipe['image_path'] ? htmlspecialchars($recipe['image_path']) : '/chop/assets/food.jpg' ?>"
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

        <!-- Modal for ^ recipe -->
        <div id="modal-<?= $recipe['id'] ?>" class="modal hidden">
          <div class="modal-content recipe-modal-content">
            <button class="close-btn" data-target="modal-<?= $recipe['id'] ?>">×</button>

            <img src="<?= $recipe['image_path'] ? htmlspecialchars($recipe['image_path']) : '/chop/assets/food.jpg' ?>"
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

            <h3>Instructions</h3>
            <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>

            <!-- Favorite button -->
            <form method="POST" action="/chop/index.php?url=favorites">
              <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
              <button type="submit" class="button favorite-btn">Add to Favorites</button>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </main>

    <!-- Footer -->
    <footer>
      <p>(c) ChopChop - Your Personal Recipe Library</p>
    </footer>
  </body>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Open modal
      document.querySelectorAll(".view-recipe-btn").forEach(btn => {
        btn.addEventListener("click", () => {
          const targetId = btn.dataset.target;
          document.getElementById(targetId).classList.remove("hidden");
        });
      });

      // Close modal
      document.querySelectorAll(".close-btn").forEach(btn => {
        btn.addEventListener("click", () => {
          const targetId = btn.dataset.target;
          document.getElementById(targetId).classList.add("hidden");
        });
      });

      // Close when clicking outside modal content
      document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("click", e => {
          if (e.target === modal) modal.classList.add("hidden");
        });
      });
    });
  </script>
</html>
