<?php

require_once 'db_connection.php';
/*
- EndPoint

-- GET 

http://localhost/sanai3ey/server/account.php/accounts


-- GET by id  



-- POST 

http://localhost/sanai3ey/server/account.php/accounts

-- JSON Example

{
    "Status": "Active",
    "Account_Type": "Standard"
}
-- DELETE

*/

function handleAccount($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        handleGetRequest($pdo);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        handlePostRequest($pdo);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        handleDeleteRequest($pdo);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
}

function handleGetRequest($pdo)
{
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
}

function handlePostRequest($pdo)
{
    $postData = json_decode(file_get_contents('php://input'), true);

    $status = $postData['Status'];
    $accountType = $postData['Account_Type'];

    try {
        $statement = $pdo->prepare("INSERT INTO `Account`(`Status`, `Account_Type`) VALUES (?, ?)");
        $statement->execute([
            $status,
            $accountType
        ]);

        $id = $pdo->lastInsertId(); // Get the ID of the newly inserted account

        http_response_code(201);
        echo json_encode(['id_Account' => $id]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
    }
}


function handleDeleteRequest($pdo)
{
    if (isset($_GET['id'])) {
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