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

        <!-- Books Section -->
        <section class="books-section">
          <h2 class="section-title">Available Books</h2>
          <p class="section-subtitle">Books you can borrow</p>

          <div class="books-grid">
            <!-- Book 1 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._SX331_BO1,204,203,200_.jpg"
                  alt="Long Lost" />
              </div>
              <h3 class="book-title">Long Lost</h3>
              <p class="book-author">Linda Castillo</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 2 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51mN3bY0JjL._SX329_BO1,204,203,200_.jpg"
                  alt="Dead Wake" />
              </div>
              <h3 class="book-title">Dead Wake</h3>
              <p class="book-author">Erik Larson</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 3 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41aM4xOZxaL._SX377_BO1,204,203,200_.jpg"
                  alt="The Design of Everyday Things" />
              </div>
              <h3 class="book-title">The Design of Everyday Things</h3>
              <p class="book-author">Don Norman</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 4 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51wOOMQ+F3L._SX312_BO1,204,203,200_.jpg"
                  alt="Rich Dad, Poor Dad" />
              </div>
              <h3 class="book-title">Rich Dad, Poor Dad</h3>
              <p class="book-author">Robert Kiyosaki</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 5 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41ZbQwCkJWL._SX322_BO1,204,203,200_.jpg"
                  alt="Lost and Found" />
              </div>
              <h3 class="book-title">Lost and Found</h3>
              <p class="book-author">Dara Girard</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 6 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._SX331_BO1,204,203,200_.jpg"
                  alt="Lost" />
              </div>
              <h3 class="book-title">Lost</h3>
              <p class="book-author">Dara Girrad</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 7 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41c4LP5otIL._SX329_BO1,204,203,200_.jpg"
                  alt="All of This" />
              </div>
              <h3 class="book-title">All of This</h3>
              <p class="book-author">Rebecca Woole</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 8 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41GHThc4v6L._SX258_BO1,204,203,200_.jpg"
                  alt="Don't Make Me Think" />
              </div>
              <h3 class="book-title">Don't Make Me Think</h3>
              <p class="book-author">Steve King</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 9 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/51RWk4tR5LL._SX322_BO1,204,203,200_.jpg"
                  alt="Living Dead Girl" />
              </div>
              <h3 class="book-title">Living Dead Girl</h3>
              <p class="book-author">Tod Goldberg</p>
              <button class="borrow-btn">Borrow</button>
            </div>

            <!-- Book 10 -->
            <div class="book-card">
              <div class="book-cover">
                <img
                  src="https://images-na.ssl-images-amazon.com/images/I/41yJ75gpV-L._SX381_BO1,204,203,200_.jpg"
                  alt="Scope & Closures" />
              </div>
              <h3 class="book-title">Scope & Closures</h3>
              <p class="book-author">Kyle Simpson</p>
              <button class="borrow-btn">Borrow</button>
            </div>
          </div>
        </section>
      </main>
    </div>

    <script>
      // Simple script to handle active state for sidebar navigation
      const navItems = document.querySelectorAll(".sidebar-nav li");

      navItems.forEach((item) => {
        item.addEventListener("click", function () {
          navItems.forEach((i) => i.classList.remove("active"));
          this.classList.add("active");
        });
      });
    </script>
  </body>
</html>
