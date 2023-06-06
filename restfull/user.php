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

http://localhost/sanai3ey/restfull/user.php/api/users

-- POST 

http://localhost/sanai3ey/restfull/user.php/api/users?email="john@example.com"

-- JSON Example
{
    "ID_Account": "1",
    "First_Name": "John",
    "Last_Name": "Doe",
    "Gender": "Male",
    "age": 25,
    "Photo": "photo_url",
    "Date_Join": "2023-06-06",
    "Email": "john@example.com",
    "Password": "password",
    "Phone_Number": "1234567890",
    "District": "Sample District",
    "City_Name": "Sample City"
}


-- DELETE

*/
function handleUser($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        try {
            $statement = $pdo->query("SELECT * FROM User");
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($users);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = json_decode(file_get_contents('php://input'), true);

        $idAccount = $postData['ID_Account'];
        $firstName = $postData['First_Name'];
        $lastName = $postData['Last_Name'];
        $gender = $postData['Gender'];
        $age = $postData['age'];
        $photo = $postData['Photo'];
        $dateJoin = $postData['Date_Join'];
        $email = $postData['Email'];
        $password = $postData['Password'];
        $phoneNumber = $postData['Phone_Number'];
        $district = $postData['District'];
        $cityName = $postData['City_Name'];

        try {
            $statement = $pdo->prepare("INSERT INTO `User`(`ID_Account`, `First_Name`, `Last_Name`, `Gender`, `age`, `Photo`,
`Date_Join`, `Email`, `Password`, `Phone_Number`, `District`, `City_Name`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
?)");
            $statement->execute([
                $idAccount,
                $firstName,
                $lastName,
                $gender,
                $age,
                $photo,
                $dateJoin,
                $email,
                $password,
                $phoneNumber,
                $district,
                $cityName
            ]);

            http_response_code(201);
            echo json_encode(['message' => 'User created successfully']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['email'])) {
        $email = $_GET['email'];

        try {
            $statement = $pdo->prepare("DELETE FROM User WHERE Email = ?");
            $statement->execute([$email]);

            if ($statement->rowCount() > 0) {
                echo json_encode(['message' => 'User deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
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
handleUser($pdo);
?>