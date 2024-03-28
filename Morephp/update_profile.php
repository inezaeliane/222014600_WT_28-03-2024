<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the input data (you can add more validation as needed)
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Replace this with your database connection code
    $connection = new mysqli("localhost", "root", "", "your_database_name");

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare a SQL statement to fetch user data based on username and password
    $stmt = $connection->prepare("SELECT id, username FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the provided credentials exists
    if ($result->num_rows == 1) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        // Redirect to the dashboard
        header("Location: dashboard.html");
        exit();
    } else {
        // Invalid credentials, show an error message or redirect back to login page
        echo "Invalid username or password";
    }

    // Close the statement and connection
    $stmt->close();
    $connection->close();
} else {
    // Redirect back to the login page if the form is not submitted
    header("Location: update_profile.html");
    exit();
}
?>
