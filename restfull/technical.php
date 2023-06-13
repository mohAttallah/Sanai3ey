<?php
// Database connection settings
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

GET http://localhost/sanai3ey/restfull/technical.php/technicals - Get all customers
POST http://localhost/sanai3ey/restfull/technical.php/technicals - Create a new customer (accepts JSON payload)
DELETE http://localhost/sanai3ey/restfull/technical.php/technicals?id={id} - Delete a customer by ID


*/



function handleRequests($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        try {
            $statement = $pdo->query("SELECT * FROM Technical");
            $technicals = $statement->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($technicals);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = json_decode(file_get_contents('php://input'), true);

        $idUser = $postData['ID_User'];
        $categoryName = $postData['Category_Name'];
        $projectDone = $postData['Project_Done'];
        $bio = $postData['Bio'];

        try {
            $statement = $pdo->prepare("INSERT INTO Technical (ID_User, Category_name, Project_Done, Bio) VALUES (?, ?, ?, ?)");
            $statement->execute([$idUser, $categoryName, $projectDone, $bio]);

            http_response_code(201);
            echo json_encode(['message' => 'Technical created successfully']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
        $technicalId = $_GET['id'];

        try {
            $statement = $pdo->prepare("DELETE FROM Technical WHERE ID_Technical = ?");
            $statement->execute([$technicalId]);

            if ($statement->rowCount() > 0) {
                echo json_encode(['message' => 'Technical deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Technical not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
}

// Call the function to handle requests
handleRequests($pdo);
?>