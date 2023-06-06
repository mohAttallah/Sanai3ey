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





// Handle user requests

// --------------------------------------------------------------------
// --------------------------------------------------------------------

function handleAccount($pdo)
{
    // Get the request method and URI
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    // Get all accounts
    if ($method === 'GET' && $uri === '/accounts') {
        $query = "SELECT * FROM Account";
        $stmt = $pdo->query($query);
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($accounts);
    }

    // Create a new account
    if ($method === 'POST' && $uri === '/accounts') {
        $requestData = json_decode(file_get_contents('php://input'), true);
        $status = $requestData['Status'];
        $accountType = $requestData['Account_Type'];

        $query = "INSERT INTO Account (Status, Account_Type) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$status, $accountType]);

        $accountId = $pdo->lastInsertId();
        echo json_encode(['ID_Account' => $accountId]);
    }

    // Delete an account
    if ($method === 'DELETE' && preg_match('//accounts/(\d+)/', $uri, $matches)) {
        $accountId = $matches[1];

        $query = "DELETE FROM Account WHERE ID_Account = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$accountId]);

        $deletedRows = $stmt->rowCount();
        echo json_encode(['deleted_rows' => $deletedRows]);
    }
}





// Function to retrieve all records from the Account table
// function getAccounts($pdo)
// {
//     $query = "SELECT * FROM Account";
//     $statement = $pdo->prepare($query);
//     $statement->execute();
//     return $statement->fetchAll(PDO::FETCH_ASSOC);
// }

// // Function to delete an account based on the provided ID
// function deleteAccount($pdo, $accountId)
// {
//     $query = "DELETE FROM Account WHERE ID_Account = :id";
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':id', $accountId);
//     return $statement->execute();
// }

// // Function to insert a new account into the table
// function createAccount($pdo, $status, $accountType)
// {
//     $query = "INSERT INTO Account (Status, Account_Type) VALUES (:status, :accountType)";
//     $statement = $pdo->prepare($query);
//     $statement->bindParam(':status', $status);
//     $statement->bindParam(':accountType', $accountType);
//     return $statement->execute();
// }

// // Example usage

// // Assuming you have established a PDO connection to your database
// $pdo = new PDO('your_connection_string');

// // Get all accounts
// $accounts = getAccounts($pdo);
// print_r($accounts);

// // Delete an account
// $accountId = 1; // Specify the account ID you want to delete
// $result = deleteAccount($pdo, $accountId);
// if ($result) {
//     echo "Account deleted successfully.";
// } else {
//     echo "Failed to delete the account.";
// }

// // Create a new account
// $status = "Active";
// $accountType = "Savings";
// $result = createAccount($pdo, $status, $accountType);
// if ($result) {
//     echo "Account created successfully.";
// } else {
//     echo "Failed to create the account.";
// }


// getAccounts($pdo);
// Call the handleUser function
handleUser($pdo);

handleAccount($pdo);
// Call the function to handle requests
?>