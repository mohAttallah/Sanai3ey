<?php
$host = 'localhost';
$dbName = 'sanai3ey';
$user = 'root';
$password = '';

// Create PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

/*

POST : http://localhost/sanai3ey/server/customer_ID.php

JSON example (body): 
{
  "email": "example@somthing.com"
}

*/

// Function to get Customer ID by email
function handlePostRequest($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = json_decode(file_get_contents('php://input'), true);

        $email = $postData['email'];

        try {
            $statement = $pdo->prepare("SELECT c.ID_Customer
                                       FROM Customer c
                                       INNER JOIN User u ON u.ID_User = c.ID_User
                                       WHERE u.Email = ?");
            $statement->execute([$email]);

            $customerId = $statement->fetchColumn();

            if ($customerId) {
                http_response_code(200);
                echo json_encode(['ID_Customer' => $customerId]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Customer not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }
}

try {
    handlePostRequest($pdo);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred']);
}
?>