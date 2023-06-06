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
- EndPoint

-- GET 

http://localhost/sanai3ey/restfull/account.php/accounts


-- GET by id  



-- POST 

http://localhost/sanai3ey/restfull/account.php/accounts

-- JSON Example

{
    "Status": "Active",
    "Account_Type": "Standard"
}
-- DELETE

*/
// Function to handle GET, POST, and DELETE requests for Account
function handleAccount($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $statement = $pdo->prepare("SELECT * FROM Account WHERE ID_Account = ?");
                $statement->execute([$id]);
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
        } else {
            try {
                $statement = $pdo->query("SELECT * FROM Account");
                $accounts = $statement->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($accounts);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Internal server error']);
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = json_decode(file_get_contents('php://input'), true);

        $status = $postData['Status'];
        $accountType = $postData['Account_Type'];

        try {
            $statement = $pdo->prepare("INSERT INTO `Account`(`Status`, `Account_Type`) VALUES (?, ?)");
            $statement->execute([
                $status,
                $accountType
            ]);

            http_response_code(201);
            echo json_encode(['message' => 'Account created successfully']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $statement = $pdo->prepare("DELETE FROM Account WHERE ID_Account = ?");
            $statement->execute([$id]);

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
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
}

// Establish database connection
handleAccount($pdo)

// Call the handleAccount function to




?>