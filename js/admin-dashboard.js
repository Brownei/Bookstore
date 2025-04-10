/**
 * BookHive Admin Dashboard JavaScript
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
 * Initialize book action buttons (Edit and Delete)
 */
function initializeBookActions() {
  // Edit buttons
  const editButtons = document.querySelectorAll(".edit-btn");
  const editBookModal = document.getElementById("editBookModal");

  editButtons.forEach((button) => {
    button.addEventListener("click", function() {
      const bookCard = this.closest(".book-card");
      const bookId = bookCard.getAttribute("data-id");
      const bookTitle = bookCard.querySelector(".book-title").textContent;
      const bookAuthor = bookCard.querySelector(".book-author").textContent;
      const bookPublishedYear = bookCard.querySelector(".book-published-year").textContent;

      // In a real application, you would fetch the book details from the server
      // For this demo, we'll just populate with the data we have
      document.getElementById("editBookId").value = bookId;
      document.getElementById("editBookTitle").value = bookTitle;
      document.getElementById("editBookAuthor").value = bookAuthor;
      document.getElementById("editBookPublishedYear").value = bookPublishedYear;
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
    button.addEventListener("click", function() {
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

  deleteConfirmBtn.addEventListener("click", async function() {
    const formData = new FormData();
    const bookId = deleteConfirmModal.getAttribute("data-book-id");
    formData.append("id", bookId)
    await deleteBook(formData, bookId);
    closeModal(deleteConfirmModal);
  });
}

/**
 * Initialize form submissions
 */
function initializeFormSubmissions() {
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
      quantity: document.getElementById("bookQuantity").value,
    };

    formData.append("title", bookData.title)
    formData.append("author", bookData.author)
    formData.append("cover", bookData.coverUrl)
    formData.append("published_year", bookData.published_year)
    formData.append("quantity", bookData.quantity)

    await addBook(bookData, formData);
    closeModal(document.getElementById("addBookModal"));
    addBookForm.reset();
  });

  // Edit Book Form
  const editBookForm = document.getElementById("editBookForm");

  editBookForm.addEventListener("submit", async function(event) {
    event.preventDefault();

    const formData = new FormData()
    const bookId = document.getElementById("editBookId").value;
    const bookData = {
      title: document.getElementById("editBookTitle").value,
      author: document.getElementById("editBookAuthor").value,
      genre: document.getElementById("editBookGenre").value,
      published_year: document.getElementById("editBookPublishedYear").value,
      quantity: document.getElementById("editBookQuantity").value,
      coverUrl: document.getElementById("editBookCover").value,
      description: document.getElementById("editBookDescription").value,
    };
    formData.append('id', bookId)
    formData.append('title', bookData.title)
    formData.append('cover', bookData.coverUrl)
    formData.append('author', bookData.author)
    formData.append('quantity', bookData.quantity)
    formData.append('published_year', bookData.published_year)


    await updateBook(formData);
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
async function addBook(bookData, formData) {
  // In a real application, you would send this data to the server
  const res = await fetch("../api/admin-actions/add-book.php", {
    method: "POST",
    body: formData
  })

  const resText = await res.text();
  const response = JSON.parse(resText)

  if (response.success === true) {
    setTimeout(() => {
      // Show success notification
      showNotification(
        `This book has been added successfully.`,
        "success"
      );
    }, 300);

    setTimeout(() => {
      window.location.reload();
    }, 1000);
  } else {
    if (response.message === 'All fields are required') {
      setTimeout(() => {
        showNotification(
          `All fields are required`,
          "error"
        );
      }, 300);
    } else {
      setTimeout(() => {
        showNotification(
          `Something happened`,
          "error"
        );
      }, 300);

    }
  }


  // Add event listeners to the new buttons
  const editBtn = bookCard.querySelector(".edit-btn");
  const deleteBtn = bookCard.querySelector(".delete-btn");

  editBtn.addEventListener("click", function() {
    const bookCard = this.closest(".book-card");
    const bookId = bookCard.getAttribute("data-id");
    const bookTitle = bookCard.querySelector(".book-title").textContent;
    const bookAuthor = bookCard.querySelector(".book-author").textContent;
    const bookPublishedYear = bookCard.querySelector(".book-published-year").textContent;

    document.getElementById("editBookId").value = bookId;
    document.getElementById("editBookTitle").value = bookTitle;
    document.getElementById("editBookAuthor").value = bookAuthor;
    document.getElementById("editBookGenre").value = bookData.genre;
    document.getElementById("editBookCover").value = bookData.coverUrl;
    document.getElementById("editBookDescription").value = bookData.description;
    document.getElementById("editBookPublishedYear").value = bookPublishedYear

    openModal(document.getElementById("editBookModal"));
  });

  deleteBtn.addEventListener("click", function() {
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
async function updateBook(formData) {
  const res = await fetch("../api/admin-actions/edit-book.php", {
    method: "POST",
    body: formData
  })

  const resText = await res.text();
  const response = JSON.parse(resText)

  if (response.success === true) {
    setTimeout(() => {
      // Show success notification
      showNotification(
        `This book has been updated successfully.`,
        "success"
      );
    }, 300);

    setTimeout(() => {
      window.location.reload();
    }, 1000);
  } else {
    if (response.message === 'Book is currently borrowed and cannot be edited') {
      setTimeout(() => {
        showNotification(
          `This book is currently in use`,
          "error"
        );
      }, 300);
    } else {
      setTimeout(() => {
        showNotification(
          `Something happened`,
          "error"
        );
      }, 300);

    }
  }
}

/**
 * Delete a book
 * @param {string} bookId - The ID of the book to delete
 */
async function deleteBook(formData, bookId) {
  // In a real application, you would send this request to the server
  const res = await fetch("../api/admin-actions/delete-book.php", {
    method: "POST",
    body: formData
  })

  const resText = await res.text();
  const response = JSON.parse(resText)

  if (response.success === true) {
    setTimeout(() => {
      // Show success notification
      showNotification(
        `This book has been deleted successfully.`,
        "success"
      );
    }, 300);

    setTimeout(() => {
      window.location.reload();
    }, 1000);
  } else {
    setTimeout(() => {
      // Show success notification
      showNotification(
        `This book is currently in use`,
        "error"
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
