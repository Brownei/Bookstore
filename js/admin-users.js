/**
 * BookHive Admin Users JavaScript
 */
document.addEventListener("DOMContentLoaded", async function() {
  const logoutBtn = document.querySelector(".sidebar #logout-button")

  // Check session at this route which isnt auth
  //checkSession()

  logoutBtn.addEventListener("click", async function() {
    const res = await fetch("../api/auth-actions/logout.php")
    const text = await res.text()
    const { message } = JSON.parse(text)

    if (message === true) {
      window.location.replace("/")
      localStorage.removeItem("session")
    }
  })

  // Initialize modals
  initializeModals();

  // Initialize user actions
  initializeUserActions();

  // Initialize form submissions
  initializeFormSubmissions();
});

/**
 * Initialize modal functionality
 */
function initializeModals() {
  // Add User button
  const addUserBtn = document.getElementById("addUserBtn");
  const addUserModal = document.getElementById("addUserModal");

  addUserBtn.addEventListener("click", function() {
    openModal(addUserModal);
  });

  // Add Book button
  const addBookBtn = document.getElementById("addBookBtn");
  const addBookModal = document.getElementById("addBookModal");

  addBookBtn.addEventListener("click", function() {
    openModal(addBookModal);
  });

  // Close buttons
  const closeButtons = document.querySelectorAll(".close-modal, .cancel-btn");

  closeButtons.forEach((button) => {
    button.addEventListener("click", function() {
      const modal = this.closest(".modal");
      closeModal(modal);
    });
  });

  // Close modal when clicking outside
  window.addEventListener("click", function(event) {
    if (event.target.classList.contains("modal")) {
      closeModal(event.target);
    }
  });
}

/**
 * Initialize user action buttons (Edit and Delete)
 */
function initializeUserActions() {
  // User actions buttons (three dots)
  const actionButtons = document.querySelectorAll(".user-actions-btn");

  actionButtons.forEach((button) => {
    button.addEventListener("click", function(e) {
      e.stopPropagation();

      // Close all other menus
      document.querySelectorAll(".user-actions-menu.active").forEach((menu) => {
        if (menu !== this.nextElementSibling) {
          menu.classList.remove("active");
        }
      });

      // Toggle this menu
      this.nextElementSibling.classList.toggle("active");
    });
  });

  // Close menus when clicking elsewhere
  document.addEventListener("click", function() {
    document.querySelectorAll(".user-actions-menu.active").forEach((menu) => {
      menu.classList.remove("active");
    });
  });

  // Edit user buttons
  const editButtons = document.querySelectorAll(".edit-user-btn");
  const editUserModal = document.getElementById("editUserModal");

  editButtons.forEach((button) => {
    button.addEventListener("click", function(e) {
      e.stopPropagation();

      const row = this.closest("tr");
      const userId = row.getAttribute("data-user-id");
      const userName = row.querySelector(".user-name-cell span").textContent;
      const userEmail = row.querySelector("td:nth-child(2)").textContent;
      const userUsername = row.querySelector("td:nth-child(3)").textContent;
      const userRole = row.querySelector("td:nth-child(4)").textContent;

      document.getElementById("editUserId").value = userId;
      document.getElementById("editUserFullName").value = userName;
      document.getElementById("editUserName").value = userUsername;
      document.getElementById("editUserEmail").value = userEmail;
      document.getElementById("editUserRole").value = userRole;
      document.getElementById("editUserPassword").value = "";

      openModal(editUserModal);
    });
  });

  // Delete user buttons
  const deleteButtons = document.querySelectorAll(".delete-user-btn");
  const deleteUserModal = document.getElementById("deleteUserModal");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", function(e) {
      e.stopPropagation();

      const row = this.closest("tr");
      const userId = row.getAttribute("data-user-id");
      const userName = row.querySelector(".user-name-cell span").textContent;

      document.getElementById("deleteUserName").textContent = userName;
      deleteUserModal.setAttribute("data-user-id", userId);

      openModal(deleteUserModal);
    });
  });

  // Delete confirmation button
  const deleteConfirmBtn = document.querySelector(
    "#deleteUserModal .delete-confirm-btn"
  );

  deleteConfirmBtn.addEventListener("click", async function() {
    const formData = new FormData()
    const userId = deleteUserModal.getAttribute("data-user-id");

    formData.append("user_id", userId)
    await deleteUser(formData);
    closeModal(deleteUserModal);
  });
}

/**
 * Initialize form submissions
 */
function initializeFormSubmissions() {
  // Add User Form
  const addUserForm = document.getElementById("addUserForm");

  addUserForm.addEventListener("submit", async function(event) {
    event.preventDefault();

    const formData = new FormData()
    const userData = {
      name: document.getElementById("userName").value,
      username: document.getElementById("userUserName").value,
      email: document.getElementById("userEmail").value,
      password: document.getElementById("userPassword").value,
      role: document.getElementById("userRole").value,
    };

    formData.append("fullname", userData.name)
    formData.append("email", userData.email)
    formData.append("role", userData.role)
    formData.append("password", userData.password)
    formData.append("username", userData.username)
    await addUser(userData, formData);

    closeModal(document.getElementById("addUserModal"));
    addUserForm.reset();
  });

  // Edit User Form
  const editUserForm = document.getElementById("editUserForm");

  editUserForm.addEventListener("submit", async function(event) {
    event.preventDefault();

    const formData = new FormData()
    const userId = document.getElementById("editUserId").value;
    const userData = {
      name: document.getElementById("editUserFullName").value,
      username: document.getElementById("editUserName").value,
      email: document.getElementById("editUserEmail").value,
      role: document.getElementById("editUserRole").value,
      password: document.getElementById("editUserPassword").value,
    };

    formData.append("user_id", userId)
    formData.append("fullname", userData.name)
    formData.append("email", userData.email)
    formData.append("username", userData.username)
    formData.append("role", userData.role)

    await updateUser(formData, userData);
    closeModal(document.getElementById("editUserModal"));
  });

  // Add Book Form
  const addBookForm = document.getElementById("addBookForm");

  addBookForm.addEventListener("submit", async function(event) {
    event.preventDefault();

    const formData = new FormData()
    const bookData = {
      title: document.getElementById("bookTitle").value,
      author: document.getElementById("bookAuthor").value,
      genre: document.getElementById("bookGenre").value,
      coverUrl: document.getElementById("bookCover").value,
      description: document.getElementById("bookDescription").value,
      published_year: document.getElementById("bookPublishedYear").value,
    };
    formData.append('title', bookData.title)
    formData.append('cover', bookData.coverUrl)
    formData.append('author', bookData.author)
    formData.append('published_year', bookData.published_year)


    // In a real application, you would send this data to the server
    const res = await fetch("../api/admin-actions/add-book.php", {
      method: "POST",
      body: formData
    })

    const resText = await res.text();
    const response = JSON.parse(resText)

    if (response.success === true) {
      showNotification(
        `"${bookData.title}" has been added successfully.`,
        "success"
      );
      closeModal(document.getElementById("addBookModal"));
      addBookForm.reset();
    } else {
      if (response.message === 'All fields are required') {
        setTimeout(() => {
          showNotification(
            `All fields are required`,
            "success"
          );
        }, 300);
      } else {
        setTimeout(() => {
          showNotification(
            `Something happened`,
            "success"
          );
        }, 300);

      }
    }
  });
}

/**
 * Open a modal
 * @param {HTMLElement} modal - The modal element to open
 */
function openModal(modal) {
  modal.classList.add("active");
  document.body.style.overflow = "hidden";
}

/**
 * Close a modal
 * @param {HTMLElement} modal - The modal element to close
 */
function closeModal(modal) {
  modal.classList.remove("active");
  document.body.style.overflow = "";
}

/**
 * Add a new user
 * @param {Object} userData - The user data
 */
async function addUser(userData, formData) {
  // In a real application, you would send this request to the server
  const res = await fetch("../api/admin-actions/add-user.php", {
    method: "POST",
    body: formData
  })

  const resText = await res.text();
  const response = JSON.parse(resText)

  if (response.success === true) {
    setTimeout(() => {
      // Show success notification
      showNotification(
        `This user has been created successfully.`,
        "success"
      );
    }, 300);

    setTimeout(() => {
      window.location.reload();
    }, 1000);
  } else {
    showNotification(response.message, "error")
  }

  // Add event listeners to the new buttons
  const actionsBtn = document.querySelector(".users-table .user-actions-btn");
  const editBtn = document.querySelector(".users-table .edit-user-btn");
  const deleteBtn = document.querySelector(".users-table .delete-user-btn");

  console.log({ editBtn, deleteBtn, actionsBtn })

  actionsBtn.addEventListener("click", function(e) {
    e.stopPropagation();

    // Close all other menus
    document.querySelectorAll(".user-actions-menu.active").forEach((menu) => {
      if (menu !== this.nextElementSibling) {
        menu.classList.remove("active");
      }
    });

    // Toggle this menu
    this.nextElementSibling.classList.toggle("active");
  });

  editBtn.addEventListener("click", function(e) {
    e.stopPropagation();

    const row = this.closest("tr");
    const userId = row.getAttribute("data-user-id");
    const userName = row.querySelector(".user-name-cell span").textContent;
    const userEmail = row.querySelector("td:nth-child(2)").textContent;
    const username = row.querySelector("td:nth-child(3)").textContent;
    const userRole = row.querySelector("td:nth-child(4)").textContent;

    document.getElementById("editUserId").value = userId;
    document.getElementById("editUserFullName").value = userName;
    document.getElementById("editUserName").value = username;
    document.getElementById("editUserEmail").value = userEmail;
    document.getElementById("editUserRole").value = userRole;
    document.getElementById("editUserPassword").value = "";

    openModal(document.getElementById("editUserModal"));
  });

  deleteBtn.addEventListener("click", function(e) {
    e.stopPropagation();

    const row = this.closest("tr");
    const userId = row.getAttribute("data-user-id");
    const userName = row.querySelector(".user-name-cell span").textContent;

    document.getElementById("deleteUserName").textContent = userName;
    document
      .getElementById("deleteUserModal")
      .setAttribute("data-user-id", userId);

    openModal(document.getElementById("deleteUserModal"));
  });

  // Show success notification
  //showNotification(
  //  `User "${userData.name}" has been added successfully.`,
  //  "success"
  //);
}

/**
 * Update an existing user
 * @param {string} userId - The ID of the user to update
 * @param {Object} userData - The updated user data
 */
async function updateUser(formData, userData) {
  // In a real application, you would send this request to the server
  const res = await fetch("../api/admin-actions/edit-user.php", {
    method: "POST",
    body: formData
  })

  const resText = await res.text();
  const response = JSON.parse(resText)

  if (response.success === true) {
    setTimeout(() => {
      showNotification(
        `User "${userData.name}" has been updated successfully.`,
        "success"
      );
    }, 300);

    setTimeout(() => {
      window.location.reload();
    }, 1000);
  } else {
    showNotification(response.message, "error")
  }
}

/**
 * Delete a user
 * @param {string} userId - The ID of the user to delete
 */
async function deleteUser(formData) {
  // In a real application, you would send this request to the server
  const res = await fetch("../api/admin-actions/delete-user.php", {
    method: "POST",
    body: formData
  })

  const resText = await res.text();
  const response = JSON.parse(resText)

  if (response.success === true) {
    setTimeout(() => {
      // Show success notification
      showNotification(
        `This user has been deleted successfully.`,
        "success"
      );
    }, 300);

    setTimeout(() => {
      window.location.reload();
    }, 1000);
  } else {
    showNotification(response.message, "error")
  }
}

/**
 * Format date as "DD Month, YYYY"
 * @param {Date} date - The date to format
 * @returns {string} - Formatted date string
 */
function formatDate(date) {
  const day = date.getDate();
  const month = date.toLocaleString("default", { month: "long" });
  const year = date.getFullYear();

  return `${day} ${month}, ${year}`;
}

/**
 * Show a notification message
 * @param {string} message - The message to display
 * @param {string} type - The type of notification (success, error)
 */
function showNotification(message, type = "success") {
  // Remove any existing notification
  const existingNotification = document.querySelector(".notification");
  if (existingNotification) {
    existingNotification.remove();
  }

  // Create notification element
  const notification = document.createElement("div");
  notification.className = `notification ${type}`;
  notification.textContent = message;

  // Add to document
  document.body.appendChild(notification);

  // Show notification
  setTimeout(() => {
    notification.classList.add("show");
  }, 10);

  // Remove notification after 3 seconds
  setTimeout(() => {
    notification.classList.remove("show");
    setTimeout(() => {
      notification.remove();
    }, 300);
  }, 3000);
}
