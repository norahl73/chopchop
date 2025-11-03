<!DOCTYPE html>
<html>
<head>
    <!-- URL to cs4640 server: https://cs4640.cs.virginia.edu/mbv7xs/ -->
    <meta
      name="author"
      content="Norah Lee: Favorites and Index html and css. Faniel Embaye: shoppinglist and recipelibrary html"
    />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ChopChop - Login</title>
    <link rel="stylesheet" href="styles/index.css">
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

        <!-- Main Nav (disabled on login page) -->
        <ul class="nav-links">
          <li><a href="#" class="disabled">Recipe Library</a></li>
          <li><a href="#" class="disabled">Favorites</a></li>
          <li><a href="#" class="disabled">Shopping List</a></li>
        </ul>
      </nav>
    </header>

    <!-- Login -->
    <main class="login-container">
        <h1>Welcome to ChopChop</h1>
        <p>Your Personal Recipe Library</p>
        
        <form method="POST" action="index.php?url=login">
            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <button type="submit" class="button">Login</button>
        </form>
        
        <p>Don't have an account? <a href="index.php?url=register">Sign up</a></p>
    </main>

    <!-- Footer -->
    <footer>
      <p>© ChopChop - Your Personal Recipe Library</p>
    </footer>
</body>
</html>