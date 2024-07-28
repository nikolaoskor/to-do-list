# To-Do List Web App

## Description

This is a To-Do List web application developed using PHP and MySQL. It allows users to create, edit, and delete daily tasks, manage their accounts, and customize their settings.

## Technologies Used

- **PHP:** For server-side logic and data management.
- **MySQL:** For storing and retrieving data.
- **HTML:** For structuring the web pages.
- **CSS:** For styling and formatting the application.
- **JavaScript:** For enhancing interactivity and user experience.

## Tools Used

- **Visual Studio Code:** For code editing and development.
- **XAMPP:** For setting up a local server environment, including Apache (web server) and MySQL (database server).
- **phpMyAdmin:** For managing the MySQL database through a web interface.

## Features

1. **Account Creation:**
   - Users can create an account by providing an email, name, and password.

2. **Account Management:**
   - In account settings, users can update their details or delete their account.
   - Users can also change their profile picture.

3. **Task Management:**
   - **Add Task:** Users can add new tasks with a description, type (Note or To-Do), and urgency (Normal or Urgent).
   - **Edit Task:** Users can update tasks by changing their status to Done or In Progress, modify the description, or delete the task.

## How to Run

Follow these steps to set up and run the application:

1. **Download the Application:**
   - Clone the repository to your local machine using the following command:
     ```bash
     git clone https://github.com/nikolaoskor/to-do-list.git
     ```
   - Alternatively, download the project as a ZIP file from the repository and extract it to your desired location.

2. **Install XAMPP:**
   - Download and install [XAMPP](https://www.apachefriends.org/index.html) if you haven't already.
   - Launch the XAMPP Control Panel and start both **Apache** and **MySQL** services.

3. **Create the Database:**
   - Open phpMyAdmin by navigating to `http://localhost/phpmyadmin` in your web browser.
   - Use the **Import** feature to run the queries in `dbtoto.sql`:
     - Click on the **Import** tab in phpMyAdmin.
     - Click **Choose File** and navigate to the project folder on your local machine.
     - Select the `dbtoto.sql` file from within the project folder.
     - Click **Go** to execute the SQL script. This will create the database, tables, and insert initial data into your application.

4. **Configure the Application:**
   - You have two options for setting the project path:

     **Option A: Use the Default `htdocs` Directory:**
     
     - Place the project folder into the `htdocs` directory of your XAMPP installation. The typical path is `C:/xampp/htdocs/` on Windows or `/Applications/XAMPP/htdocs/` on macOS.

     **Option B: Change the Apache Document Root (Alternative):**

     - Open the Apache configuration file located at `C:/xampp/apache/conf/httpd.conf`.
     - Find the line that starts with `DocumentRoot` and update it to the path where your project folder is located. For example:
       ```apache
       DocumentRoot "C:/path/to/your/project"
       <Directory "C:/path/to/your/project">
       ```
     - Save the changes and restart Apache from the XAMPP Control Panel.

5. **Update Database Connection Settings (If Necessary):**
   - Open the `functions/functionsdb.php` file.
   - Update the database connection parameters to match your setup:
     ```php
     <?php
     function connectDB() {
         $servername = "localhost";
         $username = "root"; // Default XAMPP MySQL username
         $password_db = "";  // Default XAMPP MySQL password (usually empty)
         $dbname = "dbtodo"; // The name of the database created by the SQL script

         $conn = new mysqli($servername, $username, $password_db, $dbname);

         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }

         return $conn;
     }
     ?>
     ```

6. **Run the Application:**
   - Open a web browser and navigate to `http://localhost/<project name>` (if using the `htdocs` method) or simply `http://localhost` (if using the alternative document root method).

   Example: If your project folder is named `to-do-list`, you would go to `http://localhost/to-do-list` using the `htdocs` method.
