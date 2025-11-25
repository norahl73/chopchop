<!DOCTYPE html>
<html>
  <head>
    <meta name="utf-8" />
    <meta name="description" content="Welcome to ChopChop!" />
    <link rel="stylesheet" href="styles/index.css" />
    <title>ChopChop - Shopping List</title>
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

        <!-- Main Nav -->
        <ul class="nav-links">
          <li><a href="index.php?url=recipe-library">Recipe Library</a></li>
          <li><a href="index.php?url=favorites">Favorites</a></li>
          <li><a class="active" href="index.php?url=shopping-list">Shopping List</a></li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="index.php?url=profile">
          <img src="assets/pfp.jpg" alt="Profile" width="36" height="36" />
        </a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="shopping-main">
      <h1>Your Shopping List</h1>

      <div class="shopping-list-container">
        <!-- Add New Ingredient -->
        <div class="add-ingredient">
          <input type="text" id="newItem" placeholder="Add new ingredient..." />
          <button id="addBtn" class="add-btn">Add</button>
        </div>

        
        <ul id="shoppingList" class="ingredient-list"></ul>

        
        <button id="clearBtn" class="clear-btn">Clear List</button>
        <button id="sortBtn" class="sort-btn">Sort A–Z</button>
        <button id="filterBtn" class="filter-btn">Hide Completed</button>

        <!-- Quick Add Section -->
        <div class="quick-add">
          <h3>Quick Add Common Items</h3>
          <button class="quick-add-btn" data-item="Eggs">Eggs</button>
          <button class="quick-add-btn" data-item="Milk">Milk</button>
          <button class="quick-add-btn" data-item="Bread">Bread</button>
          <button class="quick-add-btn" data-item="Rice">Rice</button>
          <button class="quick-add-btn" data-item="Pasta">Pasta</button>
          <button class="quick-add-btn" data-item="Cheese">Cheese</button>
          <button class="quick-add-btn" data-item="Onions">Onions</button>
        </div>
      </div>
    </main>

  
    <footer>
      <p>(c) ChopChop - Your Personal Recipe Library</p>
    </footer>

    <!-- Shopping list -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {
      const list = document.getElementById("shoppingList");
      const input = document.getElementById("newItem");
      const addBtn = document.getElementById("addBtn");
      const clearBtn = document.getElementById("clearBtn");
      const sortBtn = document.getElementById("sortBtn");
      const filterBtn = document.getElementById("filterBtn");
      const quickBtns = document.querySelectorAll(".quick-add-btn");

      // Create a new list item
      function createListItem(text) {
        const li = document.createElement("li");
        li.classList.add("ingredient-item");

        li.innerHTML = `
          <input type="checkbox" class="check">
          <span>${text}</span>
          <button class="remove-btn">✕</button>
        `;

        // Remove button
        li.querySelector(".remove-btn").addEventListener("click", () => {
          li.remove();
        });

        // Strike-through toggle
        li.querySelector(".check").addEventListener("change", (e) => {
          const span = li.querySelector("span");
          if (e.target.checked) {
            span.style.textDecoration = "line-through";
            span.style.color = "#777";
          } else {
            span.style.textDecoration = "none";
            span.style.color = "black";
          }
        });

        list.appendChild(li);
      }

      // Add new typed ingredient
      addBtn.addEventListener("click", () => {
        const text = input.value.trim();
        if (text !== "") {
          createListItem(text);
          input.value = "";
        }
      });

      // Add using Enter key
      input.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
          e.preventDefault();
          addBtn.click();
        }
      });

      // Quick-add buttons
      quickBtns.forEach(btn => {
        btn.addEventListener("click", () => {
          createListItem(btn.dataset.item);
        });
      });

      // Clear entire list
      clearBtn.addEventListener("click", () => {
        list.innerHTML = "";
      });

      // Sort alphabetically
      sortBtn.addEventListener("click", () => {
        const items = Array.from(list.querySelectorAll("li"));
        items.sort((a, b) => {
          const textA = a.querySelector("span").textContent.toLowerCase();
          const textB = b.querySelector("span").textContent.toLowerCase();
          return textA.localeCompare(textB);
        });
        items.forEach(item => list.appendChild(item));
      });

      // Filter out completed items
      let hideCompleted = false;
      filterBtn.addEventListener("click", () => {
        hideCompleted = !hideCompleted;

        list.querySelectorAll("li").forEach(item => {
          const checked = item.querySelector(".check").checked;
          item.style.display = hideCompleted && checked ? "none" : "flex";
        });

        filterBtn.textContent = hideCompleted
          ? "Show Completed"
          : "Hide Completed";
      });
    });
    </script>

  </body>
</html>
