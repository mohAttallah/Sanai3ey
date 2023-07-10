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

http://localhost/sanai3ey/server/order_service.php/api/orders?service_id=1

-- POST 

http://localhost/sanai3ey/server/order_service.php/api/orders

-- JSON Example
{
    "State": "Order state",
    "description": "Order description",
    "Rate": 4.5,
    "Creation_Date": "2023-07-10",
    "ID_Service": 1,
    "ID_Customer": 1
}

-- DELETE

*/
function handleOrder($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['service_id'])) {
            handleGetByServiceIdRequest($pdo);
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
        $statement = $pdo->query("SELECT * FROM Order_Service");
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($orders);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

function handleGetByServiceIdRequest($pdo)
{
    $serviceId = $_GET['service_id'];

    try {
        $statement = $pdo->prepare("SELECT * FROM Order_Service WHERE ID_Service = ?");
        $statement->execute([$serviceId]);
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($orders) {
            echo json_encode($orders);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No orders found for the specified service ID']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
    }
}

function handlePostRequest($pdo)
{
    $postData = json_decode(file_get_contents('php://input'), true);

    $state = $postData['State'];
    $description = $postData['description'];
    $rate = $postData['Rate'];
    $creationDate = $postData['Creation_Date'];
    $serviceId = $postData['ID_Service'];
    $customerId = $postData['ID_Customer'];

    try {
        $statement = $pdo->prepare("INSERT INTO Order_Service (State, description, Rate, Creation_Date, ID_Service, ID_Customer) VALUES (?, ?, ?, ?, ?, ?)");
        $statement->execute([$state, $description, $rate, $creationDate, $serviceId, $customerId]);

        $orderId = $pdo->lastInsertId();

        http_response_code(201);
        echo json_encode(['ID_Order' => $orderId]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
    }
}

function handleDeleteRequest($pdo)
{
    if (isset($_GET['id'])) {
        $orderId = $_GET['id'];

        try {
            $statement = $pdo->prepare("DELETE FROM Order_Service WHERE ID_Order = ?");
            $statement->execute([$orderId]);

            if ($statement->rowCount() > 0) {
                echo json_encode(['message' => 'Order deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Order not found']);
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

handleOrder($pdo);
?>
