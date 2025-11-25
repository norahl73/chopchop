<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ChopChop - Register</title>
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

        <!-- Main Nav -->
        <ul class="nav-links">
          <li><a href="#" class="disabled">Recipe Library</a></li>
          <li><a href="#" class="disabled">Favorites</a></li>
          <li><a href="#" class="disabled">Shopping List</a></li>
        </ul>
      </nav>
    </header>

    <!-- Register new user -->
    <main class="login-container">
        <h1>Create Your Account</h1>
        <p>Join ChopChop Today</p>

        <form id="registerForm" method="POST" action="index.php?url=register">
            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Choose a username" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Choose a password" required>
            
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            
            <button type="submit" class="button">Sign Up</button>
        </form>
        
        <p>Already have an account? <a href="index.php?url=home">Login</a></p>
    </main>

    <!-- Footer -->
    <footer>
      <p>© ChopChop - Your Personal Recipe Library</p>
    </footer>
    <script>
      document.getElementById("registerForm").addEventListener("submit", function (e) {
        const email = document.getElementById("email").value.trim();
        const pass = document.getElementById("password").value.trim();
        const confirm = document.getElementById("confirm_password").value.trim();

        let errors = [];

        if (email === "") {
          errors.push("Email is required.");
        }
        if (!email.includes("@")) {
          errors.push("Email must be valid.");
        }
        if (pass.length < 6) {
          errors.push("Password must be at least 6 characters.");
        }
        if (confirm !== pass) {
          errors.push("Passwords do not match.");
        }

        if (errors.length > 0) {
          e.preventDefault();
          alert(errors.join("\n"));
        }
      });
    </script>

</body>
</html>
