<form method="POST">
    Account_Type : <input type="text" name="Account_Type" required />
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

    return $savedId;
}

// Usage example
$savedId = handlePostRequest();
echo "Returned ID: " . $savedId;
?>