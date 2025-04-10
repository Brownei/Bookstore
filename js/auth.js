/**
 * BookHive Authentication System
 * This file handles authentication functionality for both login and signup pages
 */

// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", async function() {
  // Check if there is a user already

  const formData = new FormData();
  const token = localStorage.getItem("session")
  console.log(token)

  if (token !== null) {
    formData.append("token", token)
    try {
      const res = await fetch("../api/user-actions/get-user.php", {
        method: "POST",
        body: formData,
      })
      const response = await res.json()
      //const response = JSON.parse(resText)
      if (response.success) {
        if (response.message.role === "admin") {
          window.location.replace("admin-dashboard/admin-dashboard.php")
        } else {
          window.location.replace("user-dashboard/user-dashboard.php")
        }
      } else {
        showErrorMessage(response.message)
      }
    } catch (error) {
      showErrorMessage(error)
    }
  }
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
  form.addEventListener("submit", async function(event) {
    event.preventDefault();

    // Form data
    const formData = new FormData();

    // For the button
    const signupBtn = document.querySelector("#loginForm .btn span")
    const spinner = document.getElementById("spinner")

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

    formData.append("username", username)
    formData.append("password", password)
    formData.append("role", role)

    // If form is valid, proceed with login
    if (isValid) {
      signupBtn.textContent = ""
      signupBtn.ariaDisabled = true
      spinner.style.display = 'inline-block'
      await login(formData, role);
    }

    setTimeout(() => {
      signupBtn.ariaDisabled = false
      signupBtn.textContent = 'Register'
      spinner.style.display = 'none'
    }, 2000)
  });
}

/**
 * Initialize signup form validation and submission
 * @param {HTMLFormElement} form - The signup form element
 */
function initializeSignupForm(form) {
  form.addEventListener("submit", async function(event) {
    event.preventDefault();

    // Form Data
    const formData = new FormData()

    // For the button
    const signupBtn = document.querySelector("#signupForm .btn span")
    const spinner = document.getElementById("spinner")

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

    formData.append("fullname", fullname)
    formData.append("email", email)
    formData.append("role", role)
    formData.append("password", password)
    formData.append("username", username)

    // If form is valid, proceed with signup
    if (isValid) {
      signupBtn.textContent = ""
      signupBtn.ariaDisabled = true
      spinner.style.display = 'inline-block'
      await signup(formData, role);
    }

    setTimeout(() => {
      signupBtn.ariaDisabled = false
      signupBtn.textContent = 'Register'
      spinner.style.display = 'none'
    }, 2000)
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
 * Show error message if request failed
 * @param {string} message - The error message to display
 */
function showErrorMessage(message) {
  // Remove any existing success message
  const existingSuccess = document.querySelector(".error-req-message");
  if (existingSuccess) {
    existingSuccess.remove();
  }

  // Create and append success message
  const errorElement = document.createElement("div");
  errorElement.className = "error-req-message";
  errorElement.textContent = message;

  // Find the form to append after
  const form = document.querySelector(".auth-form");
  form.parentElement.insertBefore(errorElement, form.nextSibling);

}

/**
 * Handle login process
 * @param {string} username - The username
 * @param {string} password - The password
 * @param {string} role - The selected role
 */
async function login(formData, role) {
  // This is where you would implement your actual authentication logic
  try {
    const res = await fetch('../api/auth-actions/login.php', {
      method: "POST",
      body: formData
    })

    const response = await res.json()
    //const response = JSON.parse(resText); // Try parsing
    console.log(response.message);

    if (response.success === true) {
      showSuccess("Login successful! Redirecting...");
      localStorage.setItem("session", response.message)
      // Simulate redirect after delay
      setTimeout(() => {
        if (role === "admin") {
          window.location.replace("admin-dashboard/admin-dashboard.php")
        } else {
          window.location.replace("user-dashboard/user-dashboard.php")
        }
      }, 1500);
    } else {
      showErrorMessage(response.message)
    }

  } catch (error) {
    showErrorMessage(error.message)
  }
}

/**
 * Handle signup process
 * @param {string} fullname - The user's full name
 * @param {string} email - The user's email
 * @param {string} username - The username
 * @param {string} password - The password
 * @param {string} role - The selected role
 */
async function signup(formData, role) {
  // This is where you would implement your actual registration logic
  try {
    const res = await fetch('../api/auth-actions/signup.php', {
      method: "POST",
      body: formData
    })

    const resText = await res.text()
    const response = JSON.parse(resText); // Try parsing
    console.log(response.message);

    if (response.success === true) {
      showSuccess("Account created successfully! Redirecting to login...");

      // Simulate redirect after delay
      setTimeout(() => {
        if (role === "admin") {
          window.location.replace("admin-dashboard/admin-dashboard.php")
        } else {
          window.location.replace("user-dashboard/user-dashboard.php")
        }
      }, 1500);
    } else {
      showErrorMessage(response.message)
    }

  } catch (error) {
    showErrorMessage(error.message)
  }
}
