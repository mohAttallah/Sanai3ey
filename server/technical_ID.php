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


// find the id_techincal using the Email from table user

/*
Endpoint : 

POST: http://localhost/sanai3ey/server/technical_ID.php

JSON Example (body)

{
  "email": "example@something.com"
}

*/




// Function to handle the request
function handleRequest($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = json_decode(file_get_contents('php://input'), true);

        $email = $postData['email'];

        try {
            $statement = $pdo->prepare("SELECT t.ID_Technical
                                       FROM Technical t
                                       INNER JOIN User u ON u.ID_User = t.ID_User
                                       WHERE u.Email = ?");
            $statement->execute([$email]);

            $technicalId = $statement->fetchColumn();

            if ($technicalId) {
                http_response_code(200);
                echo json_encode(['ID_Technical' => $technicalId]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Technical not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }
}

handleRequest($pdo);
?>