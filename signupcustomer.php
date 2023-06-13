<form method="POST">
    <label for="id_user">ID_User:</label>
    <input type="text" name="id_user" id="id_user" required><br><br>

    <button type="submit" name="save" >save</button>
</form>

<?php
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost;dbname=sanai3ey;charset=utf8;",$username,$password);

    if(isset($_POST['save'])){          
        $id_user = $_POST['id_user'];

        function createCustomer($url, $data)
        {
            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json',
                    'content' => $data
                ]
            ];

            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            if ($result !== false) {
                $response = json_decode($result, true);
                if (isset($response['message'])) {
                    echo "Customer created successfully. Message: " . $response['message'];
                } else {
                    echo "Failed to create the customer.";
                }
            } else {
                echo "Failed to create the customer.";
            }
        }

        $url = 'http://localhost/sanai3ey/restfull/customer.php/customers';

        // Create a new customer
        $data = json_encode([
            'ID_User' => $id_user
        ]);

        createCustomer($url, $data);

    }
?>