<?php
session_start();
require "../db.php";

// Ensure the user is logged in
if (!isset($_SESSION['user-id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$userId = $_SESSION['user-id'];

// Fetch all borrowed books by the user (including returned)
$stmt = $conn->prepare("
    SELECT 
        books.id, books.title, books.cover, books.author, books.published_year, 
        borrowed_books.due_date, borrowed_books.borrowed_at, borrowed_books.returned_at
    FROM borrowed_books
    JOIN books ON borrowed_books.book_id = books.id
    WHERE borrowed_books.user_id = :user_id
    ORDER BY borrowed_books.borrowed_at DESC
");
$stmt->execute(['user_id' => $userId]);

$all_borrowed = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Split into current and returned
$current_borrowed_books = array_filter($all_borrowed, fn($book) => is_null($book['returned_at']));
$returned_books = array_filter($all_borrowed, fn($book) => !is_null($book['returned_at']));

// Re-index
$current_borrowed_books = array_values($current_borrowed_books);
$returned_books = array_values($returned_books);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookHive - My Shelf</title>
    <link rel="stylesheet" href="user-dashboard.css" />
    <link rel="stylesheet" href="user-shelf.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  </head>
  <body>
    <div class="dashboard-container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="logo-container">
          <a class="logo-link" href="user-dashboard.php">
                      <h1 class="logo"><i class="fas fa-book-open"></i> BookHive</h1>
          </a>
        </div>

        <nav class="sidebar-nav">
          <ul>
            <li>
              <a href="user-dashboard.php"><i class="fas fa-home"></i> Home</a>
            </li>
            <li class="active">
              <a href="user-shelf.php"
                ><i class="fas fa-bookmark"></i> My Shelf</a
              >
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
        <!-- Header with user info and search -->
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
        </header>

        <!-- Shelf Section -->
        <section class="shelf-section">
          <h2 class="section-title">Your Shelf</h2>

          <!-- Tabs -->
          <div class="shelf-tabs">
            <button class="tab-btn active" data-tab="all">All Books</button>
            <button class="tab-btn" data-tab="returned">Returned Books</button>
          </div>

          <!-- Books Grid -->
          <div class="shelf-books-container">
            <!-- All Books Tab Content -->
            <div class="tab-content active" id="all-books">
              <div class="shelf-books-grid">
                <!-- Book 1 -->
            <?php foreach ($current_borrowed_books as $book): ?>
                <div class="shelf-book-card">
                  <div class="book-cover">
                <img src="<?php echo htmlspecialchars($book['cover']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                  </div>
                  <div class="book-info">
                    <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p class="book-author"><?php echo htmlspecialchars($book['author']); ?></p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span data-borrow-date="<?php echo htmlspecialchars($book['borrowed_at']); ?>" class="borrow-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Submission Due</span>
                        <span data-due-date="<?php echo htmlspecialchars($book['due_date']); ?>" class="due-date">11 April, 2025</span>
                      </div>
                      <!--<div class="status-item">-->
                      <!--  <span class="status-label">Time Left</span>-->
                      <!--  <div id="countdown"></div>-->
                      <!--</div>-->
                    </div>

                    <button data-book-id="<?php echo htmlspecialchars($book['id']); ?>" class="return-btn">Return</button>
                  </div>
                
                </div>
            <?php endforeach; ?>
              </div>
            </div>

            <!-- Returned Books Tab Content -->
            <div class="tab-content" id="returned-books">
              <div class="shelf-books-grid">
            <?php foreach ($returned_books as $book): ?>
                <div class="shelf-book-card">
                  <div class="book-cover">
                <img src="<?php echo htmlspecialchars($book['cover']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                  </div>
                  <div class="book-info">
                    <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p class="book-author"><?php echo htmlspecialchars($book['author']); ?></p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span data-borrow-date="<?php echo htmlspecialchars($book['borrowed_at']); ?>" class="borrow-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Returned on</span>
                        <span data-due-date="<?php echo htmlspecialchars($book['returned_at']); ?>" class="due-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="returned-btn" disabled>Returned</button>
                  </div>
                </div>
            <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>

    <script src="/js/shelf.js"></script>
  </body>
</html>
