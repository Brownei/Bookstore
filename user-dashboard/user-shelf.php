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
          <h1 class="logo"><i class="fas fa-book-open"></i> BookHive</h1>
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
                alt="Sophia Williams" />
            </div>
            <div class="user-details">
              <h2 class="user-name">Sophia Williams</h2>
              <p class="user-welcome">Welcome back to BookHive</p>
            </div>
          </div>

          <div class="search-container">
            <div class="search-bar">
              <i class="fas fa-search search-icon"></i>
              <input
                type="text"
                placeholder="Title"
                class="search-input title-search" />
              <span class="search-divider"></span>
              <input
                type="text"
                placeholder="Author"
                class="search-input author-search" />
              <span class="search-divider"></span>
              <input
                type="text"
                placeholder="Genre"
                class="search-input genre-search" />
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
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._SX331_BO1,204,203,200_.jpg"
                      alt="Long Lost" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">Long Lost</h3>
                    <p class="book-author">Linda Castillo</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Submission Due</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="return-btn">Return</button>
                  </div>
                </div>

                <!-- Book 2 -->
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/51mN3bY0JjL._SX329_BO1,204,203,200_.jpg"
                      alt="Dead Wake" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">Dead Wake</h3>
                    <p class="book-author">Erik Larson</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Submission Due</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="return-btn">Return</button>
                  </div>
                </div>

                <!-- Book 3 -->
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/41aM4xOZxaL._SX377_BO1,204,203,200_.jpg"
                      alt="The Design of Everyday Things" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">The Design of Everyday Things</h3>
                    <p class="book-author">Don Norman</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Returned on</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="returned-btn" disabled>Returned</button>
                  </div>
                </div>

                <!-- Book 4 -->
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/51wOOMQ+F3L._SX312_BO1,204,203,200_.jpg"
                      alt="Rich Dad, Poor Dad" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">Rich Dad, Poor Dad</h3>
                    <p class="book-author">Robert Kiyosaki</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Submission Due</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="return-btn">Return</button>
                  </div>
                </div>

                <!-- Book 5 -->
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/41ZbQwCkJWL._SX322_BO1,204,203,200_.jpg"
                      alt="Lost and Found" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">Lost and Found</h3>
                    <p class="book-author">Dara Girard</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Returned on</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="returned-btn" disabled>Returned</button>
                  </div>
                </div>

                <!-- Book 6 -->
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._SX331_BO1,204,203,200_.jpg"
                      alt="Lost" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">Lost</h3>
                    <p class="book-author">Dara Girrad</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Returned on</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="returned-btn" disabled>Returned</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Returned Books Tab Content -->
            <div class="tab-content" id="returned-books">
              <div class="shelf-books-grid">
                <!-- Book 3 (Returned) -->
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/41aM4xOZxaL._SX377_BO1,204,203,200_.jpg"
                      alt="The Design of Everyday Things" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">The Design of Everyday Things</h3>
                    <p class="book-author">Don Norman</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Returned on</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="returned-btn" disabled>Returned</button>
                  </div>
                </div>

                <!-- Book 5 (Returned) -->
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/41ZbQwCkJWL._SX322_BO1,204,203,200_.jpg"
                      alt="Lost and Found" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">Lost and Found</h3>
                    <p class="book-author">Dara Girard</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Returned on</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="returned-btn" disabled>Returned</button>
                  </div>
                </div>

                <!-- Book 6 (Returned) -->
                <div class="shelf-book-card">
                  <div class="book-cover">
                    <img
                      src="https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._SX331_BO1,204,203,200_.jpg"
                      alt="Lost" />
                  </div>
                  <div class="book-info">
                    <h3 class="book-title">Lost</h3>
                    <p class="book-author">Dara Girrad</p>

                    <div class="book-status">
                      <div class="status-item">
                        <span class="status-label">Borrowed on</span>
                        <span class="status-date">11 March, 2025</span>
                      </div>
                      <div class="status-item">
                        <span class="status-label">Returned on</span>
                        <span class="status-date">11 April, 2025</span>
                      </div>
                    </div>

                    <button class="returned-btn" disabled>Returned</button>
                  </div>
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
