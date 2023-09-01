<?php

$servername = "localhost";
$username = "Yair";
$password = "zerozero";
$db = "SocialLogin";



$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "
CREATE TABLE users (
    id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    provider_user_id VARCHAR(255) NULL,
    provider_name VARCHAR(255) NULL,
    name VARCHAR(255),
    email VARCHAR(255) NULL DEFAULT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
)";

if ($conn->query($sql) === TRUE)
{
    echo "Table UserList created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
//file create
// if (!is_dir('../Tutorial_10/uploads'))
// {
//     mkdir('../Tutorial_10/uploads', 0777, true);
//     echo "suc";
// }
