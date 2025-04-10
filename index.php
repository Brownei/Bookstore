<?php
require "./db.php"; // Include database connection
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookHive - Login</title>
    <link rel="stylesheet" href="auth-globals.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
  </head>
  <body>
    <!-- Logo positioned at the top -->
    <div class="logo-container">
      <h1 class="logo"><i class="fas fa-book-open"></i> BookHive</h1>
    </div>

    <div class="auth-container">
      <div class="auth-card">
        <div class="auth-content">
          <h2 class="auth-title">Welcome</h2>
          <p class="auth-subtitle">Enter your details to Login</p>

          <form id="loginForm" class="auth-form">
            <div class="form-group">
              <label for="username">User name</label>
              <input
                id="username"
                type="text"
                placeholder="Enter your user name"
              />
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <div class="password-input-container">
                <input
                  id="password"
                  type="password"
                  placeholder="Enter your Password"
                />
                <button
                  type="button"
                  class="toggle-password"
                  aria-label="Toggle password visibility"
                >
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="form-group">
              <label for="role">Role</label>
              <div class="select-container">
                <select id="role">
                  <option value="" disabled selected>Select your role</option>
                  <option value="user">User</option>
                  <option value="admin">Administrator</option>
                </select>
                <i class="fas fa-chevron-down"></i>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">
              <span>Login</span>
              <div id="spinner" style="display: none"></div>
            </button>
          </form>

          <p class="auth-redirect">
            Don't have an Account? <a href="signup.html">Register</a>
          </p>
        </div>
      </div>

      <div class="illustration">
        <img
          src="/illustration.png"
          alt="People reading"
          class="auth-illustration"
        />
      </div>
    </div>

    <script type="module" src="/js/auth.js"></script>
  </body>
</html>
