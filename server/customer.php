<?php

require_once 'db_connection.php';

/* 

GET http://localhost/sanai3ey/server/customer.php/customers - Get all customers
GET by ID : http://localhost/sanai3ey/server/customer.php/customers?id=123
POST http://localhost/sanai3ey/server/customer.php/customers - Create a new customer (accepts JSON payload)
DELETE http://localhost/sanai3ey/server/customer.php/customers?id={id} - Delete a customer by ID


*/

function handleRequests($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            handleGetByIdRequest($pdo);
        } else {
            handleGetRequest($pdo);
        }
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
    try {
        $statement = $pdo->query("SELECT * FROM Customer");
        $customers = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($customers);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}
function handleGetByIdRequest($pdo)
{
    $id = $_GET['id'];

    try {
        $statement = $pdo->prepare("SELECT * FROM Customer WHERE ID_Customer = ?");
        $statement->execute([$id]);
        $customer = $statement->fetch(PDO::FETCH_ASSOC);

        if ($customer) {
            echo json_encode($customer);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Customer not found']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}






function handlePostRequest($pdo)
{
    $postData = json_decode(file_get_contents('php://input'), true);

    $idUser = $postData['ID_User'];

    try {
        $statement = $pdo->prepare("INSERT INTO Customer (ID_User) VALUES (?)");
        $statement->execute([$idUser]);

        $id = $pdo->lastInsertId();

        http_response_code(201);
        echo json_encode(['ID_Customer' => $id, 'message' => 'Customer created successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
    }
}

function handleDeleteRequest($pdo)
{
    if (isset($_GET['id'])) {
        $customerId = $_GET['id'];

        try {
            $statement = $pdo->prepare("DELETE FROM Customer WHERE ID_Customer = ?");
            $statement->execute([$customerId]);

            if ($statement->rowCount() > 0) {
                echo json_encode(['message' => 'Customer deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Customer not found']);
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