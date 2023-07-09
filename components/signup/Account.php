<form method="POST">
    Account_Type : <br>
    <input type="radio" name="Account_Type" value="technical" checked> technical<br>
    <input type="radio" name="Account_Type" value="customer"> customer<br>

    <br>
    <button type="submit" name="save">save</button>
</form>



<?php
// $username = "root";
// $password = "";
// $database = new PDO("mysql:host=localhost;dbname=sanai3ey;charset=utf8;", $username, $password);
function handlePostRequest()
{
    $postData = json_encode([
        'Status' => 'example_status',
        'Account_Type' => 'example_account_type'
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/sanai3ey/server/account.php/accounts');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    $id = $responseData['id_Account'];

    // Save the ID in a variable
    $savedId = $id;
    // Use the $savedId variable for further processing

<<<<<<< HEAD
    return $savedId;
}
=======
        // Save the ID in a variable
        $savedId = $id;
        // Use the $savedId variable for further processing

        return $savedId;
    }

    if (isset($_POST['save'])) {
        $Account_Type = $_POST['Account_Type'];
    
        // Usage example
        $savedId = handlePostRequest($Account_Type);
        echo "Returned ID: " . $savedId;
    
        $id_Account = strval($savedId);
        $url = "User.php";
        $params = array('id_Account' => $id_Account, 'Account_Type' => $Account_Type);
        $queryString = http_build_query($params);
        header("Location: " . $url . "?" . $queryString);
        exit;
    }
>>>>>>> cfb93661bae7fc1fc96cadc9d2df0c591acb0ca4

// Usage example
$savedId = handlePostRequest();
echo "Returned ID: " . $savedId;
?>