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
- EndPoint

-- GET 

http://localhost/sanai3ey/restfull/request.php/requests 

-- POST 

http://localhost/sanai3ey/restfull/request.php/requests 

-- JSON Example


-- DELETE

*/




function handleRequests($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        try {
            $statement = $pdo->query("SELECT * FROM Request");
            $requests = $statement->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($requests);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = json_decode(file_get_contents('php://input'), true);

        // $requestId = $postData['ID_Request'];
        $requestContent = $postData['Request_Content'];
        $requestDate = $postData['Request_Date'];
        $state = $postData['State'];
        $maxPrice = $postData['Max_price'];
        $categoryName = $postData['Category_Name'];
        $technicalId = $postData['ID_Technical'];
        $customerId = $postData['ID_Customer'];

        try { //`ID_Request`
            $statement = $pdo->prepare("INSERT INTO `request`( `Request_Content`, `Request_Date`, `State`, `Max_price`, `Category_Name`, `ID_Technical`, `ID_Customer`) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute([$requestContent, $requestDate, $state, $maxPrice, $categoryName, $technicalId, $customerId]);
            //$requestId,
            http_response_code(201);
            echo json_encode(['message' => 'Request created successfully']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
        $requestId = $_GET['id'];

        try {
            $statement = $pdo->prepare("DELETE FROM Request WHERE ID_Request = ?");
            $statement->execute([$requestId]);

            if ($statement->rowCount() > 0) {
                echo json_encode(['message' => 'Request deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Request not found']);
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