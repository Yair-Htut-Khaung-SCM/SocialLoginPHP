<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $name = $_POST['name'] ? $_POST['name'] : '' ;
    $email = $_POST['email'] ? $_POST['email'] : '' ;
    $password = $_POST['password'] ? $_POST['password'] : '';

    $providerName = 'system';

    // Generate a random remember_token
    $rememberToken = bin2hex(random_bytes(32));

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query to insert user data into the users table
    $sql = "INSERT INTO users (name, email, password, provider_name, remember_token) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $hashedPassword, $providerName, $rememberToken);
    
    if ($stmt->execute()) {
        echo 'User data inserted successfully. Redirecting to login page in 3 seconds...';
        header("refresh:3;url=login.php");
    } else {
        echo 'Error inserting user data: ' . $stmt->error;
    }

}