<?php


//http://localhost/sanai3ey/server/technicalLogin.php

/*
{
  "email": "mohmohmoud28@gmail.com",
  "password": "123"
}


*/

// Assuming this code is in login.php
require_once 'db_connection.php';

function login(PDO $pdo, $email, $password)
{
    // Prepare the SQL query to fetch user data from the "User" table
    $query = "SELECT * FROM User WHERE Email = :email AND Password = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    // Execute the query
    $stmt->execute();

    // Fetch the row (if any)
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userRow) {
        // Remove the password field from the user row (for security)
        unset($userRow['Password']);

        // Get the ID_User from the user row
        $userID = $userRow['ID_User'];

        // Prepare the SQL query to fetch technical data from the "Technical" table
        $query = "SELECT * FROM Technical WHERE ID_User = :userID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userID', $userID);

        // Execute the query
        $stmt->execute();

        // Fetch the technical row (if any)
        $technicalRow = $stmt->fetch(PDO::FETCH_ASSOC);

        // Merge the user and technical data
        $data = array_merge($userRow, $technicalRow);

        // Create the response JSON
        $response = [
            "success" => true,
            "data" => $data
        ];
    } else {
        // No user found with the provided email and password
        $response = [
            "success" => false,
            "message" => "Invalid email or password"
        ];
    }

    // Convert the response to JSON
    $responseJson = json_encode($response);

    // Set the response content type as JSON
    header('Content-Type: application/json');

    // Send the JSON response
    echo $responseJson;
}


// Extract the email and password from the request JSON
$requestData = json_decode(file_get_contents('php://input'), true);
$email = $requestData['email'];
$password = $requestData['password'];

// Connect to your database (adjust the connection details as per your setup)
login($pdo, $email, $password);


?>