/**
 * BookHive Authentication System
 * This file handles authentication functionality for both login and signup pages
 */

// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
  // Initialize UI components

  initializePasswordToggle();

  // Initialize forms based on which page we're on
  const loginForm = document.getElementById("loginForm");
  const signupForm = document.getElementById("signupForm");

  if (loginForm) {
    initializeLoginForm(loginForm);
  }

  if (signupForm) {
    initializeSignupForm(signupForm);
  }
});

/**
 * Initialize password visibility toggle functionality
 */
function initializePasswordToggle() {
  const toggleButtons = document.querySelectorAll(".toggle-password");

  toggleButtons.forEach((button) => {
    button.addEventListener("click", function() {
      const passwordInput = this.parentElement.querySelector("input");
      const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Toggle the eye icon
      const icon = this.querySelector("i");
      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");
    });
  });
}

/**
 * Initialize login form validation and submission
 * @param {HTMLFormElement} form - The login form element
 */
function initializeLoginForm(form) {
  form.addEventListener("submit", function(event) {
    event.preventDefault();

    // Get form values
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;
    const role = document.getElementById("role").value;

    // Clear previous errors
    clearErrors();

    // Validate form
    let isValid = true;

    if (!username) {
      showError("username", "Username is required");
      isValid = false;
    }

    if (!password) {
      showError("password", "Password is required");
      isValid = false;
    }

    if (!role) {
      showError("role", "Please select a role");
      isValid = false;
    }

    // If form is valid, proceed with login
    if (isValid) {
      login(username, password, role);
    }
  });
}

/**
 * Initialize signup form validation and submission
 * @param {HTMLFormElement} form - The signup form element
 */
function initializeSignupForm(form) {
  form.addEventListener("submit", function(event) {
    event.preventDefault();

    // Get form values
    const fullname = document.getElementById("fullname").value.trim();
    const email = document.getElementById("email").value.trim();
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;
    const role = document.getElementById("role").value;

    // Clear previous errors
    clearErrors();

    // Validate form
    let isValid = true;

    if (!fullname) {
      showError("fullname", "Full name is required");
      isValid = false;
    }

    if (!email) {
      showError("email", "Email is required");
      isValid = false;
    } else if (!isValidEmail(email)) {
      showError("email", "Please enter a valid email address");
      isValid = false;
    }

    if (!username) {
      showError("username", "Username is required");
      isValid = false;
    }

    if (!password) {
      showError("password", "Password is required");
      isValid = false;
    } else if (password.length < 8) {
      showError("password", "Password must be at least 8 characters long");
      isValid = false;
    }

    if (!role) {
      showError("role", "Please select a role");
      isValid = false;
    }

    // If form is valid, proceed with signup
    if (isValid) {
      signup(fullname, email, username, password, role);
    }
  });
}

/**
 * Show error message for a specific input field
 * @param {string} inputId - The ID of the input field
 * @param {string} message - The error message to display
 */
function showError(inputId, message) {
  const inputElement = document.getElementById(inputId);
  let container = inputElement;

  // For password and select fields, we need to target the parent container
  if (
    inputElement.parentElement.classList.contains("password-input-container") ||
    inputElement.parentElement.classList.contains("select-container")
  ) {
    container = inputElement.parentElement;
  }

  // Remove any existing error message
  const existingError = container.parentElement.querySelector(".error-message");
  if (existingError) {
    existingError.remove();
  }

  // Add error class to input
  inputElement.classList.add("input-error");

  // Create and append error message
  const errorElement = document.createElement("div");
  errorElement.className = "error-message";
  errorElement.textContent = message;

  // Insert error message after the input container
  container.parentElement.appendChild(errorElement);
}

/**
 * Clear all error messages and error states
 */
function clearErrors() {
  // Remove all error messages
  const errorMessages = document.querySelectorAll(".error-message");
  errorMessages.forEach((message) => message.remove());

  // Remove error class from all inputs
  const errorInputs = document.querySelectorAll(".input-error");
  errorInputs.forEach((input) => input.classList.remove("input-error"));
}

/**
 * Validate email format
 * @param {string} email - The email to validate
 * @returns {boolean} - Whether the email is valid
 */
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

/**
 * Show success message
 * @param {string} message - The success message to display
 */
function showSuccess(message) {
  // Remove any existing success message
  const existingSuccess = document.querySelector(".success-message");
  if (existingSuccess) {
    existingSuccess.remove();
  }

  // Create and append success message
  const successElement = document.createElement("div");
  successElement.className = "success-message";
  successElement.textContent = message;

  // Find the form to append after
  const form = document.querySelector(".auth-form");
  form.parentElement.insertBefore(successElement, form.nextSibling);

}

/**
 * Handle login process
 * @param {string} username - The username
 * @param {string} password - The password
 * @param {string} role - The selected role
 */
function login(username, password, role) {
  // This is where you would implement your actual authentication logic
  // For example, making an API call to your backend

  console.log("Login attempt:", { username, password, role });

  // Example API call (commented out)
  /*
    fetch('/api/auth/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password, role })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Login failed');
        }
        return response.json();
    })
    .then(data => {
        // Store authentication token
        localStorage.setItem('authToken', data.token);
        localStorage.setItem('userRole', role);
        
        // Redirect based on role
        if (role === 'admin') {
            window.location.href = '/admin/dashboard';
        } else {
            window.location.href = '/dashboard';
        }
    })
    .catch(error => {
        console.error('Login error:', error);
        showError('username', 'Invalid username or password');
    });
    */

  // For demonstration purposes only
  // Simulate successful login
  showSuccess("Login successful! Redirecting...");

  // Simulate redirect after delay
  setTimeout(() => {
    if (role === "admin") {
      alert("Redirecting to admin dashboard...");
      window.location.replace("admin-dashboard/admin-dashboard.php")
    } else {
      alert("Redirecting to user dashboard...");
      window.location.replace("user-dashboard/user-dashboard.php")
    }
  }, 1500);
}

/**
 * Handle signup process
 * @param {string} fullname - The user's full name
 * @param {string} email - The user's email
 * @param {string} username - The username
 * @param {string} password - The password
 * @param {string} role - The selected role
 */
function signup(fullname, email, username, password, role) {
  // This is where you would implement your actual registration logic
  // For example, making an API call to your backend

  console.log("Signup attempt:", { fullname, email, username, password, role });

  // Example API call (commented out)
  /*
    fetch('/api/auth/signup', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ fullname, email, username, password, role })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Signup failed');
        }
        return response.json();
    })
    .then(data => {
        showSuccess('Account created successfully! Redirecting to login...');
        
        // Redirect to login page after delay
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 2000);
    })
    .catch(error => {
        console.error('Signup error:', error);
        
        // Handle specific errors
        if (error.message.includes('email already exists')) {
            showError('email', 'This email is already registered');
        } else if (error.message.includes('username already exists')) {
            showError('username', 'This username is already taken');
        } else {
            showError('username', 'Registration failed. Please try again.');
        }
    });
    */

  // For demonstration purposes only
  // Simulate successful signup
  showSuccess("Account created successfully! Redirecting to login...");

  // Simulate redirect after delay
  setTimeout(() => {
    alert("Redirecting to login page...");
  }, 2000);
}
