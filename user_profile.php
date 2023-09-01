<?php

include 'ProviderEnum.php';
include 'connection.php';

// Retrieve the encoded user data from the URL parameter
$encodedUserData = $_GET['data'];

// Decode the JSON-encoded user data
$userData = json_decode(urldecode($encodedUserData), true);

// Extract user information
$providerUserId = $userData['provider_user_id'];
$displayName = $userData['provider_user_name'];
$userPhoto = $userData['provider_user_picture'] ? $userData['provider_user_picture'] : '';
$userEmail = $userData['provider_user_email'] ? $userData['provider_user_email'] : '';
$providerName = $userData['providerName'];
$providerAccessToken = $userData['access_token'];

// Execute the SQL query
$query = "SELECT * FROM provider_information WHERE provider_name = ? AND provider_user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $providerName, $providerUserId);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    // Update user information in provider_information table
    $sqlUpdate = "UPDATE provider_information 
    SET provider_user_name = ?, 
        provider_user_email = ?, 
        provider_user_picture = ?, 
        access_token = ? 
    WHERE provider_name = ? AND provider_user_id = ?";

    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssssss", $displayName, $userEmail, $userPhoto, $providerAccessToken, $providerName, $providerUserId);

    if ($stmtUpdate->execute() && $stmtUpdate->affected_rows > 0) {
    // Fetch the updated user's id from provider_information
    $sqlFetchUserId = "SELECT user_id FROM provider_information WHERE provider_name = ? AND provider_user_id = ?";
    $stmtFetchUserId = $conn->prepare($sqlFetchUserId);
    $stmtFetchUserId->bind_param("ss", $providerName, $providerUserId);

    if ($stmtFetchUserId->execute()) {
    $resultUserId = $stmtFetchUserId->get_result();

    if ($resultUserId->num_rows > 0) {
    $userData = $resultUserId->fetch_assoc();

    // Update the corresponding user information in users table
    $sqlUpdateUser = "UPDATE users 
    SET name = ?, 
        email = ?, 
        provider_name = ?, 
        provider_user_id = ?,
        remember_token = ?
    WHERE id = ?";
    $stmtUpdateUser = $conn->prepare($sqlUpdateUser);
    $stmtUpdateUser->bind_param("ssssss", $displayName, $userEmail, $providerName, $providerUserId, $providerAccessToken, $userData['user_id']);

    if ($stmtUpdateUser->execute()) {
        echo 'User data updated successfully.';
    } else {
        echo 'Error updating user data in users table: ' . $stmtUpdateUser->error;
    }
    } else {
        echo 'No matching record found in provider_information.';
    }
    } else {
        echo 'Error fetching updated user id: ' . $stmtFetchUserId->error;
    }
    } else {
        echo 'No matching record found for update.';
    }
} else {

    // Prepare and execute the SQL query to insert user data into the users table
        $sql = "INSERT INTO users (provider_user_id, provider_name, name, email, remember_token) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $providerUserId, $providerName, $displayName, $userEmail, $providerAccessToken);

        if ($stmt->execute()) {
            // Retrieve the inserted user_id
            $userId = $conn->insert_id;

            // Now you can use $userId in the next SQL query
            $sql = "INSERT INTO provider_information (user_id, provider_name, provider_user_id, provider_user_name, provider_user_email, provider_user_picture, access_token) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $userId, $providerName, $providerUserId, $displayName, $userEmail, $userPhoto, $providerAccessToken);

            if ($stmt->execute()) {
                echo 'User data inserted successfully.';
            } else {
                echo 'Error inserting user data into provider_information: ' . $stmt->error;
            }
        } else {
            echo 'Error inserting user data into users: ' . $stmt->error;
        }
}

$conn->close();
$stmt->close();

header("Location: user_profile_detail.php?token=" . urlencode($providerAccessToken));
exit();

