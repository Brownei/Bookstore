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
                alt="Sophia Williams" />
            </div>
            <div class="user-details">
              <h2 class="user-name">Sophia Williams</h2>
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
            <div class="book-card" data-id="1">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._SX331_BO1,204,203,200_.jpg"
                  alt="Long Lost" />
              </div>
              <h3 class="book-title">Long Lost</h3>
              <p class="book-author">Linda Castillo</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 2 -->
            <div class="book-card" data-id="2">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51mN3bY0JjL._SX329_BO1,204,203,200_.jpg"
                  alt="Dead Wake" />
              </div>
              <h3 class="book-title">Dead Wake</h3>
              <p class="book-author">Erik Larson</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 3 -->
            <div class="book-card" data-id="3">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41aM4xOZxaL._SX377_BO1,204,203,200_.jpg"
                  alt="The Design of Everyday Things" />
              </div>
              <h3 class="book-title">The Design of Everyday Things</h3>
              <p class="book-author">Don Norman</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 4 -->
            <div class="book-card" data-id="4">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51wOOMQ+F3L._SX312_BO1,204,203,200_.jpg"
                  alt="Rich Dad, Poor Dad" />
              </div>
              <h3 class="book-title">Rich Dad, Poor Dad</h3>
              <p class="book-author">Robert Kiyosaki</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 5 -->
            <div class="book-card" data-id="5">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41ZbQwCkJWL._SX322_BO1,204,203,200_.jpg"
                  alt="Lost and Found" />
              </div>
              <h3 class="book-title">Lost and Found</h3>
              <p class="book-author">Dara Girard</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 6 -->
            <div class="book-card" data-id="6">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._SX331_BO1,204,203,200_.jpg"
                  alt="Lost" />
              </div>
              <h3 class="book-title">Lost</h3>
              <p class="book-author">Dara Girrad</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 7 -->
            <div class="book-card" data-id="7">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41c4LP5otIL._SX329_BO1,204,203,200_.jpg"
                  alt="All of This" />
              </div>
              <h3 class="book-title">All of This</h3>
              <p class="book-author">Rebecca Woole</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 8 -->
            <div class="book-card" data-id="8">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41GHThc4v6L._SX258_BO1,204,203,200_.jpg"
                  alt="Don't Make Me Think" />
              </div>
              <h3 class="book-title">Don't Make Me Think</h3>
              <p class="book-author">Steve King</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 9 -->
            <div class="book-card" data-id="9">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51RWk4tR5LL._SX322_BO1,204,203,200_.jpg"
                  alt="Living Dead Girl" />
              </div>
              <h3 class="book-title">Living Dead Girl</h3>
              <p class="book-author">Tod Goldberg</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>

            <!-- Book 10 -->
            <div class="book-card" data-id="10">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41yJ75gpV-L._SX381_BO1,204,203,200_.jpg"
                  alt="Scope & Closures" />
              </div>
              <h3 class="book-title">Scope & Closures</h3>
              <p class="book-author">Kyle Simpson</p>
              <div class="book-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>
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
              <label for="bookGenre">Genre</label>
              <input type="text" id="bookGenre" required />
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
