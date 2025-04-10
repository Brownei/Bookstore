# Bookstore Project

## 📚 About the Project

This is a simple **Bookstore Web Application** that allows users to browse and search for books. The application includes features like displaying books, a basic search functionality, and simple interaction with a backend written in **PHP**. The front end is styled with **CSS** and includes interactive features using **JavaScript**.

## 🚀 Features

- **Home Page**: Displays a list of available books.
- **Search**: Allows users to search for books by title, author, or genre.
- **Book Details**: Each book has a dedicated page showing more detailed information like the author, genre, price, and description.
- **Basic PHP Backend**: Handles storing and serving book data (mocked with an array or basic MySQL setup).
- **Responsive Design**: Optimized for both desktop and mobile devices.
- **Interactive UI**: Uses JavaScript to enhance user experience (search filtering and page navigation).

---

## 🧑‍💻 Technologies Used

- **HTML**: Structure of the web pages.
- **CSS**: Styling and layout of the pages (with responsive design).
- **JavaScript**: Adds interactivity like search filtering and dynamic content updates.
- **PHP**: Server-side scripting for backend logic (handling book data).
- **MySQL**: Can be used to store book data in a real-world scenario.

---

## 🛠️ Installation Instructions

### Prerequisites
- Web server (e.g., Apache or Nginx)
- PHP installed (v7.x or higher)
- MySQL database (optional, if using a database to store books)

### Steps to Run the Project

1. **Clone the repository**:
    ```bash
    git clone https://github.com/Brownei/Bookstore.git
    ```

2. **Set up the environment**:
   - Move to the project directory:
     ```bash
     cd Bookstore
     ```

3. **Start up the web server**:
   - You just have to run 
        ```bash 
        php -S localhost:4000
        ```
    This command can be able to run the PHP server on port 4000 without the need of Apache servers.
    You can use Apache servers if needed to 
    N.B: This command runs on linux if you have downloaded the right package on your machine.
    ***WINDOWS USERS, SORRY YOU MAY NEED APACHE SERVERS, LOL!***

4. **Setting database**:
    - You will need mysql or postgres drivers on your machine to be able to have the project connect to the database. 
    On Linux:
        ```bash
        sudo apt install php-mysql
        sudo apt install php-pgsql
        ```
    - Sadly if you have the knowledge of Docker, Docker cannot connect to MySQL but it can on Postgres but MySQL was chosen for this project. So you can be able to download MySQL server on your local machine and set up everything to make sure it is working well. 
        ```bash
        # Downloads mysql server on laptop
        sudo apt install mysql-server 

        # Login into the mysql server
        mysql -u root

        # Create database and setup the user you will use for your project
        CREATE DATABASE mydatabase;
        CREATE USER 'myuser'@'localhost' IDENTIFIED BY 'mypassword';
        GRANT ALL PRIVILEGES ON mydatabase.* TO 'myuser'@'localhost';
        USE mydatabase;
        ```
    - The previous method will make everything connect which you will be able to setup on the file **db.php**


6. **Access the website**:
   - Open your browser and go to `http://localhost:4000` to view the bookstore app.

---

## 🔧 Usage

- **Home Page**: Browse through the available books.
- **Search Bar**: Enter a book title, author, or genre to filter the book list dynamically.
<!--- **Book Details**: Click on a book to view detailed information.-->
- **Admin Dashboard**: Functionality for creating more books and be able to lend them out and see the users which you lended them to.
- **User Dashboard**: Functionality for being able to borrow books and return them.

---

## 🧑‍💻 Code Structure


