<?php
$host = "127.0.0.1";
$dbname = "seconddb";
$dbport = "3306";
$username = "db"; // Change if using a different user
$password = "myp@ssword1234"; // Change if using a password

try {
    $conn = new PDO("mysql:host=$host;port=$dbport;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        fullname VARCHAR(255) NOT NULL,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
        data_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        cover VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        published_year INT NOT NULL,
        quantity    INT NOT NULL,
        owner_id INT NOT NULL,
        date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS borrowed_books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        book_id INT NOT NULL,
        borrowed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        due_date DATE NOT NULL,
        returned_at TIMESTAMP NULL DEFAULT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
    );
    ";

    $conn->exec($sql);


  // Check if the admin user exists, if not, create it
    $email = "admin@example.com";
    $username = "admin";
    $password = password_hash("adminpassword", PASSWORD_DEFAULT); // Hash the password
    $role = "admin";

    // Check if admin already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $adminExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$adminExists) {
        // Insert the admin user if not exists
        $insertUser = $conn->prepare("INSERT INTO users (email, fullname, username, password, role) VALUES (:email, :fullname, :username, :password, :role)");
        $insertUser->execute([
            'email' => $email,
            'fullname' => 'Admin User',
            'username' => $username,
            'password' => $password,
            'role' => $role
        ]);

        $adminId = $conn->lastInsertId();

$books = [
    [
        'title' => 'The Great Gatsby',
        'cover' => 'https://covers.openlibrary.org/b/id/10441894-L.jpg', // Book cover
        'author' => 'F. Scott Fitzgerald',
        'published_year' => 1925,
        'quantity' => 10,
        'owner_id' => $adminId
    ],
    [
        'title' => 'To Kill a Mockingbird',
        'cover' => 'https://covers.openlibrary.org/b/id/8225261-L.jpg', // Book cover
        'author' => 'Harper Lee',
                'quantity' => 10,
        'published_year' => 1960,
        'owner_id' => $adminId
    ],
    [
        'title' => '1984',
        'cover' => 'https://covers.openlibrary.org/b/id/7222246-L.jpg', // Book cover
        'author' => 'George Orwell',
        'published_year' => 1949,
        'quantity' => 10,
        'owner_id' => $adminId
    ],
    [
        'title' => 'The Catcher in the Rye',
        'cover' => 'https://covers.openlibrary.org/b/id/11137223-L.jpg', // Book cover
        'author' => 'J.D. Salinger',
        'published_year' => 1951,
        'quantity' => 10,
        'owner_id' => $adminId
    ],
    [
        'title' => 'The Hobbit',
        'cover' => 'https://covers.openlibrary.org/b/id/11139444-L.jpg', // Book cover
        'author' => 'J.R.R. Tolkien',
        'quantity' => 10,
        'published_year' => 1937,
        'owner_id' => $adminId
    ]
];

    // Insert books into the database
    foreach ($books as $book) {
        $insertBook = $conn->prepare("INSERT INTO books (title, cover, author, quantity, published_year, owner_id) VALUES (:title, :cover, :author, :quantity, :published_year, :owner_id)");
        $insertBook->execute($book);
    }
    } 
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
