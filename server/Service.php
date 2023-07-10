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

http://localhost/sanai3ey/server/service.php/api/services?technical_id=1

-- POST 

http://localhost/sanai3ey/server/service.php/api/services

-- JSON Example
{
    "Description": "Service description",
    "Service_Date": "2023-07-10",
    "price": 9.99,
    "Category_Name": "Category name",
    "ID_Technical": 1
}

-- DELETE

*/
function handleService($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['technical_id'])) {
            handleGetByTechnicalIdRequest($pdo);
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
        $statement = $pdo->query("SELECT * FROM Service");
        $services = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($services);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

function handleGetByTechnicalIdRequest($pdo)
{
    $technicalId = $_GET['technical_id'];

    try {
        $statement = $pdo->prepare("SELECT * FROM Service WHERE ID_Technical = ?");
        $statement->execute([$technicalId]);
        $services = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($services) {
            echo json_encode($services);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No services found for the specified technical ID']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

function handlePostRequest($pdo)
{
    $postData = json_decode(file_get_contents('php://input'), true);

    $description = $postData['Description'];
    $serviceDate = $postData['Service_Date'];
    $price = $postData['price'];
    $categoryName = $postData['Category_Name'];
    $technicalId = $postData['ID_Technical'];

    try {
        $statement = $pdo->prepare("INSERT INTO Service (Description, Service_Date, price, Category_Name, ID_Technical) VALUES (?, ?, ?, ?, ?)");
        $statement->execute([$description, $serviceDate, $price, $categoryName, $technicalId]);

        $serviceId = $pdo->lastInsertId();

        http_response_code(201);
        echo json_encode(['ID_Service' => $serviceId]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
    }
}

function handleDeleteRequest($pdo)
{
    if (isset($_GET['id'])) {
        $serviceId = $_GET['id'];

        try {
            $statement = $pdo->prepare("DELETE FROM Service WHERE ID_Service = ?");
            $statement->execute([$serviceId]);

            if ($statement->rowCount() > 0) {
                echo json_encode(['message' => 'Service deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Service not found']);
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

handleService($pdo);
?>
