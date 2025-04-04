/**
 * BookHive Admin Dashboard JavaScript
 */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize modals
  initializeModals();

  // Initialize book actions
  initializeBookActions();

  // Initialize form submissions
  initializeFormSubmissions();
});

/**
 * Initialize modal functionality
 */
function initializeModals() {
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
 * Initialize book action buttons (Edit and Delete)
 */
function initializeBookActions() {
  // Edit buttons
  const editButtons = document.querySelectorAll(".edit-btn");
  const editBookModal = document.getElementById("editBookModal");

  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const bookCard = this.closest(".book-card");
      const bookId = bookCard.getAttribute("data-id");
      const bookTitle = bookCard.querySelector(".book-title").textContent;
      const bookAuthor = bookCard.querySelector(".book-author").textContent;

      // In a real application, you would fetch the book details from the server
      // For this demo, we'll just populate with the data we have
      document.getElementById("editBookId").value = bookId;
      document.getElementById("editBookTitle").value = bookTitle;
      document.getElementById("editBookAuthor").value = bookAuthor;
      document.getElementById("editBookGenre").value = "Fiction"; // Placeholder
      document.getElementById("editBookCover").value =
        bookCard.querySelector("img").src;
      document.getElementById("editBookDescription").value =
        "Book description placeholder"; // Placeholder

      openModal(editBookModal);
    });
  });

  // Delete buttons
  const deleteButtons = document.querySelectorAll(".delete-btn");
  const deleteConfirmModal = document.getElementById("deleteConfirmModal");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const bookCard = this.closest(".book-card");
      const bookId = bookCard.getAttribute("data-id");
      const bookTitle = bookCard.querySelector(".book-title").textContent;

      // Set the book title in the confirmation modal
      document.getElementById("deleteBookTitle").textContent = bookTitle;

      // Store the book ID for deletion
      deleteConfirmModal.setAttribute("data-book-id", bookId);

      openModal(deleteConfirmModal);
    });
  });

  // Delete confirmation button
  const deleteConfirmBtn = document.querySelector(".delete-confirm-btn");

  deleteConfirmBtn.addEventListener("click", function () {
    const bookId = deleteConfirmModal.getAttribute("data-book-id");
    deleteBook(bookId);
    closeModal(deleteConfirmModal);
  });
}

/**
 * Initialize form submissions
 */
function initializeFormSubmissions() {
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

    addBook(bookData);
    closeModal(document.getElementById("addBookModal"));
    addBookForm.reset();
  });

  // Edit Book Form
  const editBookForm = document.getElementById("editBookForm");

  editBookForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const bookId = document.getElementById("editBookId").value;
    const bookData = {
      title: document.getElementById("editBookTitle").value,
      author: document.getElementById("editBookAuthor").value,
      genre: document.getElementById("editBookGenre").value,
      coverUrl: document.getElementById("editBookCover").value,
      description: document.getElementById("editBookDescription").value,
    };

    updateBook(bookId, bookData);
    closeModal(document.getElementById("editBookModal"));
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
 * Add a new book
 * @param {Object} bookData - The book data
 */
function addBook(bookData) {
  // In a real application, you would send this data to the server
  console.log("Adding book:", bookData);

  // For this demo, we'll create a new book card and add it to the grid
  const booksGrid = document.querySelector(".books-grid");
  const newBookId = Date.now(); // Generate a unique ID

  const bookCard = document.createElement("div");
  bookCard.className = "book-card";
  bookCard.setAttribute("data-id", newBookId);

  bookCard.innerHTML = `
        <div class="book-cover">
            <img src="${bookData.coverUrl}" alt="${bookData.title}">
        </div>
        <h3 class="book-title">${bookData.title}</h3>
        <p class="book-author">${bookData.author}</p>
        <div class="book-actions">
            <button class="edit-btn">Edit</button>
            <button class="delete-btn">Delete</button>
        </div>
    `;

  booksGrid.prepend(bookCard);

  // Add event listeners to the new buttons
  const editBtn = bookCard.querySelector(".edit-btn");
  const deleteBtn = bookCard.querySelector(".delete-btn");

  editBtn.addEventListener("click", function () {
    const bookCard = this.closest(".book-card");
    const bookId = bookCard.getAttribute("data-id");
    const bookTitle = bookCard.querySelector(".book-title").textContent;
    const bookAuthor = bookCard.querySelector(".book-author").textContent;

    document.getElementById("editBookId").value = bookId;
    document.getElementById("editBookTitle").value = bookTitle;
    document.getElementById("editBookAuthor").value = bookAuthor;
    document.getElementById("editBookGenre").value = bookData.genre;
    document.getElementById("editBookCover").value = bookData.coverUrl;
    document.getElementById("editBookDescription").value = bookData.description;

    openModal(document.getElementById("editBookModal"));
  });

  deleteBtn.addEventListener("click", function () {
    const bookCard = this.closest(".book-card");
    const bookId = bookCard.getAttribute("data-id");
    const bookTitle = bookCard.querySelector(".book-title").textContent;

    document.getElementById("deleteBookTitle").textContent = bookTitle;
    document
      .getElementById("deleteConfirmModal")
      .setAttribute("data-book-id", bookId);

    openModal(document.getElementById("deleteConfirmModal"));
  });

  // Show success notification
  showNotification(
    `"${bookData.title}" has been added successfully.`,
    "success"
  );
}

/**
 * Update an existing book
 * @param {string} bookId - The ID of the book to update
 * @param {Object} bookData - The updated book data
 */
function updateBook(bookId, bookData) {
  // In a real application, you would send this data to the server
  console.log("Updating book:", bookId, bookData);

  // For this demo, we'll update the book card
  const bookCard = document.querySelector(`.book-card[data-id="${bookId}"]`);

  if (bookCard) {
    bookCard.querySelector(".book-title").textContent = bookData.title;
    bookCard.querySelector(".book-author").textContent = bookData.author;
    bookCard.querySelector("img").src = bookData.coverUrl;
    bookCard.querySelector("img").alt = bookData.title;

    // Show success notification
    showNotification(
      `"${bookData.title}" has been updated successfully.`,
      "success"
    );
  }
}

/**
 * Delete a book
 * @param {string} bookId - The ID of the book to delete
 */
function deleteBook(bookId) {
  // In a real application, you would send this request to the server
  console.log("Deleting book:", bookId);

  // For this demo, we'll remove the book card from the DOM
  const bookCard = document.querySelector(`.book-card[data-id="${bookId}"]`);

  if (bookCard) {
    const bookTitle = bookCard.querySelector(".book-title").textContent;

    // Add a fade-out animation
    bookCard.style.opacity = "0";
    bookCard.style.transform = "scale(0.9)";
    bookCard.style.transition = "opacity 0.3s, transform 0.3s";

    setTimeout(() => {
      bookCard.remove();

      // Show success notification
      showNotification(
        `"${bookTitle}" has been deleted successfully.`,
        "success"
      );
    }, 300);
  }
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
