<?php


require_once 'db_connection.php';
 //localhost/sanai3ey/server/CustomerLogin.php
/*
{
  "email": "abd@gmail.com",
  "password": "123"
}

*/

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

        // Prepare the SQL query to fetch customer data from the "Customer" table
        $query = "SELECT * FROM Customer WHERE ID_User = :userID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userID', $userID);

        // Execute the query
        $stmt->execute();

        // Fetch the customer row (if any)
        $customerRow = $stmt->fetch(PDO::FETCH_ASSOC);

        // Merge the user and customer data
        $data = array_merge($userRow, $customerRow);

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


// Call the login function passing the PDO object and login credentials
login($pdo, $email, $password);

?>