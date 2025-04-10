/**
 * BookHive Shelf Page JavaScript
 */

document.addEventListener("DOMContentLoaded", async function() {
  //Logoout Button event 
  const returnBtns = document.querySelectorAll(".book-info .return-btn")
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

  //Data rearrangement
  const borrowDateElements = document.querySelectorAll(".book-status .status-item .borrow-date");
  const dueDateElements = document.querySelectorAll(".book-status .status-item .due-date");
  const countdownEl = document.getElementById("countdown");

  borrowDateElements.forEach(function(borrowElement) {
    const borrowDateString = borrowElement.getAttribute("data-borrow-date");

    // Convert the string to a Date object
    const borrowDate = new Date(borrowDateString);

    // Format the date as "11 March, 2025"
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = borrowDate.toLocaleDateString('en-GB', options); // 'en-GB' for the British format (day month year)

    // Update the borrow date text on the page
    borrowElement.textContent = formattedDate;
  })

  dueDateElements.forEach(function(dueElement) {
    const dueDateString = dueElement.getAttribute("data-due-date");

    // Convert the string to a Date object
    const dueDate = new Date(dueDateString);
    const dueDateTiem = dueDate.getTime()
    const timerInterval = setInterval(updateCountDownTime, 1000);


    //updateCountDownTime(dueDateTiem, countdownEl, timerInterval)

    // Format the date as "11 March, 2025"
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = dueDate.toLocaleDateString('en-GB', options); // 'en-GB' for the British format (day month year)

    // Update the due date text on the page
    dueElement.textContent = formattedDate;
  })



  returnBtns.forEach(function(returnBtn) {
    returnBtn.addEventListener("click", async function() {
      const bookCard = this.closest(".shelf-book-card");
      const bookTitle = bookCard.querySelector(".book-title").textContent;
      if (confirm(`Are you sure you want to return "${bookTitle}"?`)) {
        const bookId = returnBtn.getAttribute("data-book-id")
        const response = await fetch('../api/user-actions/return.php', {
          method: 'POST',
          body: new URLSearchParams({
            book_id: bookId
          }),
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });

        const result = await response.json();
        //const result = JSON.parse(resText)

        if (result.success) {
          alert(`Book returned successfully at ${result.date}!`);
          window.location.reload()
        } else {
          alert('Error: ' + result.error);
        }
      }
    })
  })

  // Initialize tab functionality
  initializeTabs();

  // Initialize return buttons
  //initializeReturnButtons();


});

/**
 * Initialize tab switching functionality
 */
function initializeTabs() {
  const tabButtons = document.querySelectorAll(".tab-btn");
  const tabContents = document.querySelectorAll(".tab-content");

  tabButtons.forEach((button) => {
    button.addEventListener("click", function() {
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
//function initializeReturnButtons() {
//  const returnButtons = document.querySelectorAll(".return-btn");
//
//  returnButtons.forEach((button) => {
//    button.addEventListener("click", function() {
//      const bookCard = this.closest(".shelf-book-card");
//      const bookTitle = bookCard.querySelector(".book-title").textContent;
//
//      // Confirm return
//      if (confirm(`Are you sure you want to return "${bookTitle}"?`)) {
//        // Update status labels
//        const statusItems = bookCard.querySelectorAll(".status-item");
//        statusItems[1].querySelector(".status-label").textContent =
//          "Returned on";
//
//        // Get current date
//        const today = new Date();
//        const formattedDate = formatDate(today);
//        statusItems[1].querySelector(".status-date").textContent =
//          formattedDate;
//
//        // Replace return button with returned button
//        this.classList.remove("return-btn");
//        this.classList.add("returned-btn");
//        this.textContent = "Returned";
//        this.disabled = true;
//
//        // Add book to returned books tab
//        addToReturnedBooks(bookCard);
//
//        // Show success message
//        showNotification(`"${bookTitle}" has been returned successfully.`);
//      }
//    });
//  });
//}

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

function updateCountDownTime(dueDate, countdownEl, timerInterval) {
  const now = new Date().getTime();
  const distance = dueDate - now;

  if (distance < 0) {
    countdownEl.innerHTML = "Book is overdue!";
    clearInterval(timerInterval);
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  countdownEl.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s left`;
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
