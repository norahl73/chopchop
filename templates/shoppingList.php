<!DOCTYPE html>
<html>
  <head>
    <meta name="utf-8" />
    <meta name="description" content="Welcome to ChopChop!" />
    <link rel="stylesheet" href="/chop/styles/index.css" />
    <title>ChopChop - Shopping List</title>
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

        <!-- Main Nav -->
        <ul class="nav-links">
          <li><a href="/chop/index.php?url=recipe-library">Recipe Library</a></li>
          <li><a href="/chop/index.php?url=favorites">Favorites</a></li>
          <li>
            <a class="active" href="/chop/index.php?url=shopping-list">Shopping List</a>
          </li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="/chop/templates/profile.html">
          <img src="/chop/assets/pfp.jpg" alt="Profile" width="36" height="36" />
        </a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="shopping-main">
      <div class="page-header">
        <h1>Shopping List</h1>
        <p>Keep track of ingredients you need to buy</p>

        <!-- Ahow we can add an item to the list-->
        <div class="add-item-container">
          <input
            type="text"
            id="newItemInput"
            placeholder="Add new item..."
            class="add-item-input"
          />
          <button id="addItemBtn" class="add-item-btn">Add Item</button>
        </div>
      </div>

      <!-- the actual Shopping List  -->
      <div class="shopping-list-container">
        <div class="list-header">
          <h2>Your Items</h2>
          <button id="clearAllBtn" class="clear-all-btn">Clear All</button>
        </div>

        <ul id="shoppingList" class="shopping-list">
          <!-- Sample items, in list form, to check off (Common ingreidents) -->
          <li class="shopping-item">
            <input type="checkbox" id="item1" class="item-checkbox" />
            <label for="item1" class="item-label">Milk</label>
            <button class="remove-item-btn">X</button>
          </li>

          <li class="shopping-item">
            <input type="checkbox" id="item2" class="item-checkbox" />
            <label for="item2" class="item-label">Bread</label>
            <button class="remove-item-btn">X</button>
          </li>

          <li class="shopping-item">
            <input type="checkbox" id="item3" class="item-checkbox" />
            <label for="item3" class="item-label">Eggs</label>
            <button class="remove-item-btn">X</button>
          </li>

          <li class="shopping-item">
            <input type="checkbox" id="item4" class="item-checkbox" />
            <label for="item4" class="item-label">Chicken Breast</label>
            <button class="remove-item-btn">X</button>
          </li>

          <li class="shopping-item">
            <input type="checkbox" id="item5" class="item-checkbox" />
            <label for="item5" class="item-label">Tomatoes</label>
            <button class="remove-item-btn">X</button>
          </li>
        </ul>

        <!-- Empty state whenever theres none in the list-->
        <div id="emptyState" class="empty-state" style="display: none">
          <p>Your shopping list is empty!</p>
          <p>Add some items above to get started.</p>
        </div>
      </div>

      <!-- Quick Add Section, adding common things -->
      <div class="quick-add-section">
        <h3>Quick Add Common Items</h3>
        <div class="quick-add-buttons">
          <button class="quick-add-btn" data-item="Beef">Beef</button>
          <button class="quick-add-btn" data-item="Tuna">Tuna</button>
          <button class="quick-add-btn" data-item="Rice">Rice</button>
          <button class="quick-add-btn" data-item="Pasta">Pasta</button>
          <button class="quick-add-btn" data-item="Cheese">Cheese</button>
          <button class="quick-add-btn" data-item="Onions">Onions</button>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer>
      <p>(c) ChopChop - Your Personal Recipe Library</p>
    </footer>
  </body>
</html>
