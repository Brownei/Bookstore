<?php
require "../db.php";
session_start();

if (!isset($_SESSION['user-id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

// Fetch all books
$stmt = $conn->prepare("SELECT * FROM books");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filter out books with quantity 0
$available_books = array_filter($books, function($book) {
    return $book['quantity'] > 0;
});

// Reindex the array
$available_books = array_values($available_books);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookHive - Dashboard</title>
    <link rel="stylesheet" href="user-dashboard.css" />
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
              <a href="#"><i class="fas fa-home"></i> Home</a>
            </li>
            <li>
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

        <!-- Books Section -->
        <section class="books-section">
          <h2 class="section-title">Available Books</h2>
          <p class="section-subtitle">Books you can borrow</p>

          <div class="books-grid">
            <?php foreach ($available_books as $book): ?>
           <div class="book-card">
              <div class="book-cover">
                <img src="<?php echo htmlspecialchars($book['cover']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
              </div>
              <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
              <p class="book-author"><?php echo htmlspecialchars($book['author']); ?></p>
              <div class="book-quantity">
                <p>Quantity: </p>
                <span class="book-quantity-number"><?php echo htmlspecialchars($book['quantity']); ?></span>
              </div>
              <button class="borrow-btn" data-book-id="<?php echo $book['id']; ?>">Borrow</button>
            </div>
            <?php endforeach; ?>
                     </div>
        </section>
      </main>
    </div>

    <script type="module" src="/js/user-dashboard.js"></script>
  </body>
</html>
