<?php
  require "../db.php";
  session_start();

  if(!isset($_SESSION['user-id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
  }

    $stmt_books = $conn->prepare("SELECT * FROM books");
    $stmt_books->execute();

    $allBooks = $stmt_books->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookHive - Admin Dashboard</title>

    <link rel="stylesheet" href="admin-dashboard.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  </head>
  <body>
    <div class="dashboard-container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="logo-container">
          <a class="logo-link" href="#">
                      <h1 class="logo"><i class="fas fa-book-open"></i> BookHive</h1>
          </a>
        </div>

        <nav class="sidebar-nav">
          <ul>
            <li class="active">
              <a href="#"
                ><i class="fas fa-home"></i> Home</a
              >
            </li>
            <li>
              <a href="admin-users.php"><i class="fas fa-users"></i> Users</a>
            </li>
                        <li>
              <button id="logout-button" type="button"
                ><i class="fas fa-sign-out-alt"></i>Logout</button
              >
            </li>
          </ul>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="main-content">
        <!-- Header with user info and add book button -->
        <header class="dashboard-header">
          <div class="user-info">
            <div class="user-avatar">
              <img
                src="https://randomuser.me/api/portraits/women/44.jpg"
                alt="Profile dp" />
            </div>
            <div class="user-details">
              <h2 class="user-name">
<?php echo htmlspecialchars($_SESSION['fullname']); ?>
              </h2>
              <p class="user-welcome">Welcome back to BookHive</p>
            </div>
          </div>

          <button id="addBookBtn" class="add-book-btn">
            <i class="fas fa-plus"></i> Add a Book
          </button>
        </header>

        <!-- Books Section -->
        <section class="books-section">
          <h2 class="section-title">Books</h2>
          <p class="section-subtitle">Books available for users to borrow</p>

          <div class="books-grid">
            <!-- Book 1 -->
            <?php foreach ($allBooks as $book): ?>
            <div class="book-card" data-id="<?php echo $book['id']; ?>">
              <div class="book-cover">
                <img src="<?php echo htmlspecialchars($book['cover']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
              </div>
              <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
              <p style="display: none;" class="book-published-year"><?php echo htmlspecialchars($book['published_year']); ?></p>
              <p class="book-author"><?php echo htmlspecialchars($book['author']); ?></p>
              <?php if ($book['owner_id'] == $_SESSION['user-id']): ?>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          </div>
        </section>
      </main>
    </div>

    <!-- Add Book Modal -->
    <div id="addBookModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Add New Book</h2>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="addBookForm">
            <div class="form-group">
              <label for="bookTitle">Title</label>
              <input type="text" id="bookTitle" required />
            </div>

            <div class="form-group">
              <label for="bookAuthor">Author</label>
              <input type="text" id="bookAuthor" required />
            </div>

            <div class="form-group">
              <label for="bookPublishedYear">Published year</label>
              <input type="text" id="bookPublishedYear" required />
            </div>

            <div class="form-group">
              <label for="bookGenre">Genre</label>
              <input type="text" id="bookGenre" required />
            </div>

            <div class="form-group">
              <label for="bookQuantity">Quantity</label>
              <input type="number" id="bookQuantity" required />
            </div>

            <div class="form-group">
              <label for="bookCover">Cover Image URL</label>
              <input type="url" id="bookCover" required />
            </div>

            <div class="form-group">
              <label for="bookDescription">Description</label>
              <textarea id="bookDescription" rows="4" required></textarea>
            </div>

            <div class="form-actions">
              <button type="button" class="cancel-btn">Cancel</button>
              <button type="submit" class="submit-btn">Add Book</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit Book Modal -->
    <div id="editBookModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Edit Book</h2>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="editBookForm">
            <input type="hidden" id="editBookId" />

            <div class="form-group">
              <label for="editBookTitle">Title</label>
              <input type="text" id="editBookTitle" required />
            </div>

            <div class="form-group">
              <label for="editBookAuthor">Author</label>
              <input type="text" id="editBookAuthor" required />
            </div>

            <div class="form-group">
              <label for="editBookGenre">Genre</label>
              <input type="text" id="editBookGenre" required />
            </div>

            <div class="form-group">
              <label for="editBookPublishedYear">Published Year</label>
              <input type="text" id="editBookPublishedYear" required />
            </div>

            <div class="form-group">
              <label for="editBookQuantity">Quantity</label>
              <input type="number" id="editBookQuantity" required />
            </div>

            <div class="form-group">
              <label for="editBookCover">Cover Image URL</label>
              <input type="url" id="editBookCover" required />
            </div>

            <div class="form-group">
              <label for="editBookDescription">Description</label>
              <textarea id="editBookDescription" rows="4" required></textarea>
            </div>

            <div class="form-actions">
              <button type="button" class="cancel-btn">Cancel</button>
              <button type="submit" class="submit-btn">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="modal">
      <div class="modal-content delete-modal">
        <div class="modal-header">
          <h2>Confirm Deletion</h2>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>
            Are you sure you want to delete "<span id="deleteBookTitle"></span
            >"?
          </p>
          <p class="warning-text">This action cannot be undone.</p>

          <div class="form-actions">
            <button type="button" class="cancel-btn">Cancel</button>
            <button type="button" class="delete-confirm-btn">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <script src="/js/admin-dashboard.js"></script>
  </body>
</html>
