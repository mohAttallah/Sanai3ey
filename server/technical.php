<?php
// Database connection settings
require_once 'db_connection.php';


/* 

GET http://localhost/sanai3ey/server/technical.php/technicals - Get all technicals
POST http://localhost/sanai3ey/server/technical.php/technicals - Create a new technicals  (accepts JSON payload)
DELETE http://localhost/sanai3ey/server/technical.php/technicals?id={id} - Delete a technicals  by ID


*/

function handleRequests($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            handleGetByIdRequest($pdo);
        } else {
            handleGetAllRequest($pdo);
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

function handleGetAllRequest($pdo)
{
    try {
        $statement = $pdo->query("SELECT * FROM Technical");
        $technicals = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($technicals);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

function handleGetByIdRequest($pdo)
{
    $id = $_GET['id'];

    try {
        $statement = $pdo->prepare("SELECT * FROM Technical WHERE ID_Technical = ?");
        $statement->execute([$id]);
        $technical = $statement->fetch(PDO::FETCH_ASSOC);

        if ($technical) {
            echo json_encode($technical);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Technical not found']);
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
    $categoryName = $postData['Category_Name'];
    $projectDone = $postData['Project_Done'];
    $bio = $postData['Bio'];

    try {
        $statement = $pdo->prepare("INSERT INTO Technical (ID_User, Category_name, Project_Done, Bio) VALUES (?, ?, ?, ?)");
        $statement->execute([$idUser, $categoryName, $projectDone, $bio]);

        $id = $pdo->lastInsertId();

        http_response_code(201);
        echo json_encode(['ID_Technical' => $id]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
    }
}

function handleDeleteRequest($pdo)
{
    if (isset($_GET['id'])) {
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