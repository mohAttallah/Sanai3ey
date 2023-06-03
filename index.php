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

// GET /accounts/{id}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $accountId = $_GET['id'];

    try {
        $statement = $pdo->prepare("SELECT * FROM Account WHERE ID_Account = :id");
        $statement->bindParam(':id', $accountId);
        $statement->execute();
        $account = $statement->fetch(PDO::FETCH_ASSOC);

        if ($account) {
            echo json_encode($account);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Account not found']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

// POST /accounts
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);

    $accountId = $postData['ID_Account'];
    $status = $postData['Status'];
    $accountType = $postData['Account_Type'];

    try {
        $statement = $pdo->prepare("INSERT INTO Account (ID_Account, Status, Account_Type) VALUES (:id, :status, :accountType)");
        $statement->bindParam(':id', $accountId);
        $statement->bindParam(':status', $status);
        $statement->bindParam(':accountType', $accountType);
        $statement->execute();

        http_response_code(201);
        echo json_encode(['message' => 'Account created successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

// DELETE /accounts/{id}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $accountId = $_GET['id'];

    try {
        $statement = $pdo->prepare("DELETE FROM Account WHERE ID_Account = :id");
        $statement->bindParam(':id', $accountId);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            echo json_encode(['message' => 'Account deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Account not found']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}


?>