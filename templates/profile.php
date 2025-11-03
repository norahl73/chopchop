<!DOCTYPE html>
<html>
  <head>
    <meta name="utf-8" />
    <meta name="description" content="Welcome to ChopChop!" />
    <link rel="stylesheet" href="styles/index.css" />
    <title>ChopChop - Profile</title>
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
          <li><a href="index.php?url=favorites">Favorites</a></li>
          <li><a href="index.php?url=shopping-list">Shopping List</a></li>
        </ul>

        <!-- Profile -->
        <a class="pfp" href="#">
          <img src="assets/pfp.jpg" alt="Profile" width="36" height="36" />
        </a>
      </nav>
    </header>
    <main class="profile-main">
    <section class="profile-info">
      <h1>Your Profile</h1>
      <p>Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?>!</p>

      <!-- Logout Button -->
      <form method="POST" action="index.php?url=logout">
        <button type="submit" class="button logout-btn">Logout</button>
      </form>
    </section>
  </main>
  </body>
</html>
