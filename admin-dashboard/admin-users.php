<?php
  require "../db.php";
  session_start();

  if(!isset($_SESSION['user-id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
  }

    $users = $conn->prepare("SELECT * FROM users WHERE username != 'admin' AND email != 'admin@example.com'");
    $users->execute();
    

    $allUsers = $users->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookHive - Admin Users</title>
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="admin-dashboard.css" />
    <link rel="stylesheet" href="admin-users.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  </head>
  <body>
    <div class="dashboard-container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="logo-container">
          <a class="logo-link" href="admin-dashboard.php">
                      <h1 class="logo"><i class="fas fa-book-open"></i> BookHive</h1>
          </a>
        </div>

        <nav class="sidebar-nav">
          <ul>
            <li>
              <a href="admin-dashboard.php"
                ><i class="fas fa-home"></i> Home</a
              >
            </li>
            <li class="active">
              <a href="#"><i class="fas fa-users"></i> Users</a>
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
                alt="Sophia Williams" />
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

        <!-- Users Section -->
        <section class="users-section">
          <div class="section-header">
            <h2 class="section-title">Users</h2>
            <button id="addUserBtn" class="add-user-btn">Add user</button>
          </div>

          <div class="users-table-container">
            <table class="users-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Date Registered</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <!-- User 1 -->
                <?php foreach ($allUsers as $user): ?>
                <tr data-user-id="<?php echo htmlspecialchars($user['id']); ?>">
                  <td class="user-name-cell">
                    <div class="user-avatar-small">
                      <img
                        s src="https://randomuser.me/api/portraits/men/<?php echo rand(0, 99); ?>.jpg" 
  alt="<?php echo htmlspecialchars($user['fullname']); ?>" />
                    </div>
                    <span><?php echo htmlspecialchars($user['fullname']); ?></span>
                  </td>
                  <td><?php echo htmlspecialchars($user['email']); ?></td>
                  <td><?php echo htmlspecialchars($user['username']); ?></td>
                  <td><?php echo htmlspecialchars($user['role']); ?></td>
                  <td>24 March, 2025</td>
                  <td>
                    <button class="user-actions-btn">
                      <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="user-actions-menu">
                      <button class="edit-user-btn">Edit</button>
                      <button class="delete-user-btn">Delete</button>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </section>
      </main>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Add New User</h2>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="addUserForm">
            <div class="form-group">
              <label for="userName">Full Name</label>
              <input type="text" id="userName" required />
            </div>

            <div class="form-group">
              <label for="userUserName">Username</label>
              <input type="text" id="userUserName" required />
            </div>

            <div class="form-group">
              <label for="userEmail">Email</label>
              <input type="email" id="userEmail" required />
            </div>

            <div class="form-group">
              <label for="userPassword">Password</label>
              <input type="password" id="userPassword" required />
            </div>

            <div class="form-group">
              <label for="userRole">Role</label>
              <select id="userRole" required>
                <option value="User">User</option>
                <option value="Admin">Admin</option>
              </select>
            </div>

            <div class="form-actions">
              <button type="button" class="cancel-btn">Cancel</button>
              <button type="submit" class="submit-btn">Add User</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Edit User</h2>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="editUserForm">
            <input type="hidden" id="editUserId" />

            <div class="form-group">
              <label for="editUserFullName">Full Name</label>
              <input type="text" id="editUserFullName" required />
            </div>

            <div class="form-group">
              <label for="editUserName">Username</label>
              <input type="text" id="editUserName" required />
            </div>

            <div class="form-group">
              <label for="editUserEmail">Email</label>
              <input type="email" id="editUserEmail" required />
            </div>

            <div class="form-group">
              <label for="editUserRole">Role</label>
              <select id="editUserRole" required>
                <option value="User">User</option>
                <option value="Admin">Admin</option>
              </select>
            </div>

            <div class="form-group">
              <label for="editUserPassword"
                >New Password (leave blank to keep current)</label
              >
              <input type="password" id="editUserPassword" />
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
    <div id="deleteUserModal" class="modal">
      <div class="modal-content delete-modal">
        <div class="modal-header">
          <h2>Confirm Deletion</h2>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>
            Are you sure you want to delete user "<span
              id="deleteUserName"></span
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

    <!-- Add Book Modal (same as in admin-dashboard.html) -->
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

    <script src="/js/admin-users.js"></script>
  </body>
</html>
