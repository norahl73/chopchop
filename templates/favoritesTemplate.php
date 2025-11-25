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
          <img src="assets/logo.svg" alt="ChopChop logo" width="36" height="36" />
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

    <!-- MAIN CONTENT -->
    <main class="container">

      <section class="hero">
        <h1>Your Favorite Recipes</h1>
      </section>

      <div class="controls">
        <button id="gridBtn">Grid</button>
        <button id="listBtn">List</button>
        <button id="filterBtn">Filter / Sort</button>
        <button id="addBtn">+ Add</button>
        <button id="loadMoreBtn" class="button secondary">Load More Recipes</button>
      </div>

      <!-- GRID VIEW -->
      <section id="gridView" class="view">
        <div class="grid" id="recipeGrid">
          <?php foreach ($favorites as $recipe): ?>
          <article class="card" data-target="modal-<?= $recipe['id'] ?>" data-recipe-id="<?= $recipe['id'] ?>">
            <div class="card-top">
              <span class="dish"><?= htmlspecialchars($recipe['title']) ?></span>
              <button class="moreBtn">⋯</button>
            </div>
            <img 
              src="<?= $recipe['image_path'] ? htmlspecialchars($recipe['image_path']) : 'assets/food.jpg' ?>" 
              alt="Thumbnail for <?= htmlspecialchars($recipe['title']) ?>" 
              class="thumbnail" 
            />
            <div class="card-body">
              <p class="quickDesc"><?= htmlspecialchars($recipe['genre']) ?> · <?= htmlspecialchars($recipe['time_takes']) ?> min</p>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- LIST VIEW -->
      <section id="listView" class="view hidden">
        <ul class="list" id="recipeList">
          <?php foreach ($favorites as $recipe): ?>
          <li class="list-item" data-target="modal-<?= $recipe['id'] ?>" data-recipe-id="<?= $recipe['id'] ?>">
            <img 
              src="<?= $recipe['image_path'] ? htmlspecialchars($recipe['image_path']) : 'assets/food.jpg' ?>" 
              alt="Thumbnail for <?= htmlspecialchars($recipe['title']) ?>" 
              class="list-thumb" 
            />
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

            <h3>Instructions</h3><br />
            <p><?= htmlspecialchars($recipe['instructions']) ?></p>

            <form method="POST" action="index.php?url=favorites">
              <input type="hidden" name="remove_recipe" value="1">
              <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
              <button type="submit" class="button favorite-btn">Remove from Favorites</button>
            </form>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    </main>


    <footer>
      <p>© ChopChop - Your Personal Recipe Library</p>
    </footer>
    <script>
    </script>

  </body>
</html>
