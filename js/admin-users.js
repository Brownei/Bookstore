/**
 * BookHive Admin Users JavaScript
 */

document.addEventListener("DOMContentLoaded", function () {
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

  addUserBtn.addEventListener("click", function () {
    openModal(addUserModal);
  });

  // Add Book button
  const addBookBtn = document.getElementById("addBookBtn");
  const addBookModal = document.getElementById("addBookModal");

  addBookBtn.addEventListener("click", function () {
    openModal(addBookModal);
  });

  // Close buttons
  const closeButtons = document.querySelectorAll(".close-modal, .cancel-btn");

  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modal = this.closest(".modal");
      closeModal(modal);
    });
  });

  // Close modal when clicking outside
  window.addEventListener("click", function (event) {
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
    button.addEventListener("click", function (e) {
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
  document.addEventListener("click", function () {
    document.querySelectorAll(".user-actions-menu.active").forEach((menu) => {
      menu.classList.remove("active");
    });
  });

  // Edit user buttons
  const editButtons = document.querySelectorAll(".edit-user-btn");
  const editUserModal = document.getElementById("editUserModal");

  editButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.stopPropagation();

      const row = this.closest("tr");
      const userId = row.getAttribute("data-user-id");
      const userName = row.querySelector(".user-name-cell span").textContent;
      const userEmail = row.querySelector("td:nth-child(2)").textContent;
      const userRole = row.querySelector("td:nth-child(3)").textContent;

      document.getElementById("editUserId").value = userId;
      document.getElementById("editUserName").value = userName;
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
    button.addEventListener("click", function (e) {
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

  deleteConfirmBtn.addEventListener("click", function () {
    const userId = deleteUserModal.getAttribute("data-user-id");
    deleteUser(userId);
    closeModal(deleteUserModal);
  });
}

/**
 * Initialize form submissions
 */
function initializeFormSubmissions() {
  // Add User Form
  const addUserForm = document.getElementById("addUserForm");

  addUserForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const userData = {
      name: document.getElementById("userName").value,
      email: document.getElementById("userEmail").value,
      password: document.getElementById("userPassword").value,
      role: document.getElementById("userRole").value,
    };

    addUser(userData);
    closeModal(document.getElementById("addUserModal"));
    addUserForm.reset();
  });

  // Edit User Form
  const editUserForm = document.getElementById("editUserForm");

  editUserForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const userId = document.getElementById("editUserId").value;
    const userData = {
      name: document.getElementById("editUserName").value,
      email: document.getElementById("editUserEmail").value,
      role: document.getElementById("editUserRole").value,
      password: document.getElementById("editUserPassword").value,
    };

    updateUser(userId, userData);
    closeModal(document.getElementById("editUserModal"));
  });

  // Add Book Form
  const addBookForm = document.getElementById("addBookForm");

  addBookForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const bookData = {
      title: document.getElementById("bookTitle").value,
      author: document.getElementById("bookAuthor").value,
      genre: document.getElementById("bookGenre").value,
      coverUrl: document.getElementById("bookCover").value,
      description: document.getElementById("bookDescription").value,
    };

    // In a real application, you would send this data to the server
    console.log("Adding book:", bookData);

    showNotification(
      `"${bookData.title}" has been added successfully.`,
      "success"
    );
    closeModal(document.getElementById("addBookModal"));
    addBookForm.reset();
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
function addUser(userData) {
  // In a real application, you would send this data to the server
  console.log("Adding user:", userData);

  // For this demo, we'll create a new user row and add it to the table
  const usersTable = document.querySelector(".users-table tbody");
  const newUserId = Date.now(); // Generate a unique ID

  const userRow = document.createElement("tr");
  userRow.setAttribute("data-user-id", newUserId);

  userRow.innerHTML = `
        <td class="user-name-cell">
            <div class="user-avatar-small">
                <img src="https://randomuser.me/api/portraits/men/${Math.floor(
                  Math.random() * 100
                )}.jpg" alt="${userData.name}">
            </div>
            <span>${userData.name}</span>
        </td>
        <td>${userData.email}</td>
        <td>${userData.role}</td>
        <td>${formatDate(new Date())}</td>
        <td>
            <button class="user-actions-btn">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="user-actions-menu">
                <button class="edit-user-btn">Edit</button>
                <button class="delete-user-btn">Delete</button>
            </div>
        </td>
    `;

  usersTable.prepend(userRow);

  // Add event listeners to the new buttons
  const actionsBtn = userRow.querySelector(".user-actions-btn");
  const editBtn = userRow.querySelector(".edit-user-btn");
  const deleteBtn = userRow.querySelector(".delete-user-btn");

  actionsBtn.addEventListener("click", function (e) {
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

  editBtn.addEventListener("click", function (e) {
    e.stopPropagation();

    const row = this.closest("tr");
    const userId = row.getAttribute("data-user-id");
    const userName = row.querySelector(".user-name-cell span").textContent;
    const userEmail = row.querySelector("td:nth-child(2)").textContent;
    const userRole = row.querySelector("td:nth-child(3)").textContent;

    document.getElementById("editUserId").value = userId;
    document.getElementById("editUserName").value = userName;
    document.getElementById("editUserEmail").value = userEmail;
    document.getElementById("editUserRole").value = userRole;
    document.getElementById("editUserPassword").value = "";

    openModal(document.getElementById("editUserModal"));
  });

  deleteBtn.addEventListener("click", function (e) {
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
  showNotification(
    `User "${userData.name}" has been added successfully.`,
    "success"
  );
}

/**
 * Update an existing user
 * @param {string} userId - The ID of the user to update
 * @param {Object} userData - The updated user data
 */
function updateUser(userId, userData) {
  // In a real application, you would send this data to the server
  console.log("Updating user:", userId, userData);

  // For this demo, we'll update the user row
  const userRow = document.querySelector(`tr[data-user-id="${userId}"]`);

  if (userRow) {
    userRow.querySelector(".user-name-cell span").textContent = userData.name;
    userRow.querySelector("td:nth-child(2)").textContent = userData.email;
    userRow.querySelector("td:nth-child(3)").textContent = userData.role;

    // Show success notification
    showNotification(
      `User "${userData.name}" has been updated successfully.`,
      "success"
    );
  }
}

/**
 * Delete a user
 * @param {string} userId - The ID of the user to delete
 */
function deleteUser(userId) {
  // In a real application, you would send this request to the server
  console.log("Deleting user:", userId);

  // For this demo, we'll remove the user row from the DOM
  const userRow = document.querySelector(`tr[data-user-id="${userId}"]`);

  if (userRow) {
    const userName = userRow.querySelector(".user-name-cell span").textContent;

    // Add a fade-out animation
    userRow.style.opacity = "0";
    userRow.style.transition = "opacity 0.3s";

    setTimeout(() => {
      userRow.remove();

      // Show success notification
      showNotification(
        `User "${userName}" has been deleted successfully.`,
        "success"
      );
    }, 300);
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
