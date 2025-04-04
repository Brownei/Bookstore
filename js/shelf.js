/**
 * BookHive Shelf Page JavaScript
 */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize tab functionality
  initializeTabs();

  // Initialize return buttons
  initializeReturnButtons();
});

/**
 * Initialize tab switching functionality
 */
function initializeTabs() {
  const tabButtons = document.querySelectorAll(".tab-btn");
  const tabContents = document.querySelectorAll(".tab-content");

  tabButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Remove active class from all buttons and contents
      tabButtons.forEach((btn) => btn.classList.remove("active"));
      tabContents.forEach((content) => content.classList.remove("active"));

      // Add active class to clicked button
      this.classList.add("active");

      // Show corresponding tab content
      const tabId = this.getAttribute("data-tab");
      document.getElementById(`${tabId}-books`).classList.add("active");
    });
  });
}

/**
 * Initialize return button functionality
 */
function initializeReturnButtons() {
  const returnButtons = document.querySelectorAll(".return-btn");

  returnButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const bookCard = this.closest(".shelf-book-card");
      const bookTitle = bookCard.querySelector(".book-title").textContent;

      // Confirm return
      if (confirm(`Are you sure you want to return "${bookTitle}"?`)) {
        // Update status labels
        const statusItems = bookCard.querySelectorAll(".status-item");
        statusItems[1].querySelector(".status-label").textContent =
          "Returned on";

        // Get current date
        const today = new Date();
        const formattedDate = formatDate(today);
        statusItems[1].querySelector(".status-date").textContent =
          formattedDate;

        // Replace return button with returned button
        this.classList.remove("return-btn");
        this.classList.add("returned-btn");
        this.textContent = "Returned";
        this.disabled = true;

        // Add book to returned books tab
        addToReturnedBooks(bookCard);

        // Show success message
        showNotification(`"${bookTitle}" has been returned successfully.`);
      }
    });
  });
}

/**
 * Add a book to the returned books tab
 * @param {HTMLElement} bookCard - The book card element
 */
function addToReturnedBooks(bookCard) {
  // Clone the book card
  const clonedCard = bookCard.cloneNode(true);

  // Add to returned books tab
  const returnedBooksContainer = document.querySelector(
    "#returned-books .shelf-books-grid"
  );
  returnedBooksContainer.appendChild(clonedCard);
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
 */
function showNotification(message) {
  // Create notification element
  const notification = document.createElement("div");
  notification.className = "notification";
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

// Add notification styles to the document
const notificationStyles = document.createElement("style");
notificationStyles.textContent = `
    .notification {
        position: fixed;
        bottom: -100px;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--accent-color);
        color: white;
        padding: 1rem 2rem;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        transition: bottom 0.3s ease-in-out;
    }
    
    .notification.show {
        bottom: 20px;
    }
`;
document.head.appendChild(notificationStyles);
