
document.addEventListener("DOMContentLoaded", async function() {
  // Simple script to handle active state for sidebar navigation
  const borrowBtn = document.querySelectorAll(".books-grid .book-card .borrow-btn")
  const navItems = document.querySelectorAll(".sidebar-nav li");
  const logoutBtn = document.querySelector(".sidebar #logout-button")

  // Check session at this route which isnt auth
  //checkSession()

  navItems.forEach((item) => {
    item.addEventListener("click", function() {
      navItems.forEach((i) => i.classList.remove("active"));
      this.classList.add("active");
    });
  });

  logoutBtn.addEventListener("click", async function() {
    const res = await fetch("../api/auth-actions/logout.php")
    const text = await res.text()
    const { message } = JSON.parse(text)

    if (message === true) {
      window.location.replace("/")
      localStorage.removeItem("session")
    }
  })

  borrowBtn.forEach(function(borrowbtn) {
    borrowbtn.addEventListener("click", async function() {
      const bookId = borrowbtn.getAttribute("data-book-id")
      const response = await fetch('../api/user-actions/borrow.php', {
        method: 'POST',
        body: new URLSearchParams({
          book_id: bookId
        }),
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      });

      const result = await response.json();

      if (result.success) {
        alert(`Book borrowed successfully! Due Date: ${result.due_date}`);
        window.location.reload()
      } else {
        alert('Error: ' + result.error);
      }
    })

  })
})
