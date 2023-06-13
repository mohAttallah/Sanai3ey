<form method="POST">
    Account_Type : <input type="text" name="Account_Type" required/>
    <br>
    <button type="submit" name="save" >save</button>
</form>
<form action="signupuser.php">

    <button type="submit" name="continuation" >continuation</button>
</form>

<?php
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost;dbname=sanai3ey;charset=utf8;",$username,$password);

if(isset($_POST['save'])){
    $Account_Type = $_POST['Account_Type'];

    function createAccount($url, $data)
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
            echo "Account created successfully.";
        } else {
            echo "Failed to create an account.";
        }
        // if ($result !== false) {
        //     $response = json_decode($result, true);
        //     if (isset($response['ID_Account'])) {
        //         $accountId = $response['ID_Account'];
        //         echo "Account created successfully. ID: $accountId";
        //     } else {
        //         echo "Failed to retrieve the account ID.";
        //     }
        // } else {
        //     echo "Failed to create an account.";
        // }
    }

    $url = 'http://localhost/sanai3ey/restfull/account.php/accounts';

    // Create a new account
    $data = json_encode([
        'Status' => 'active',
        'Account_Type' => $Account_Type
    ]);

    createAccount($url, $data);


}   
?>