<form method="POST">

    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" ><br><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" ><br><br>

    <label for="gender">Gender:</label>
    <select name="gender" id="gender" >
        <option value="m">Male</option>
        <option value="f">Female</option>
    </select><br><br>

    <label for="age">Age:</label>
    <input type="number" name="age" id="age" ><br><br>

    <label for="photo">Photo:</label>
    <input type="file" name="photo" id="photo"><br><br>

    <!-- <label for="date_join">Date of Joining:</label>
    <input type="date" name="date_join" id="date_join" required><br><br> -->

    <label for="email">Email:</label>
    <input type="text" name="email" id="email"><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" ><br><br>

    <label for="phone_number">Phone Number:</label>
    <input type="tel" name="phone_number" id="phone_number" ><br><br>

    <label for="district">District:</label>
    <input type="text" name="district" id="district" ><br><br>

    <label for="city_name">City Name:</label>
    <input type="text" name="city_name" id="city_name" ><br><br>

    <button type="submit" name="save">save</button>
</form>

<?php

<<<<<<< HEAD
$id_Account = $_GET['id_Account'];
echo "id_Account= " . $id_Account;

$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$age = isset($_POST['age']) ? $_POST['age'] : '';
$photo = isset($_POST['photo']) ? $_POST['photo'] : '';
$date_join = isset($_POST['date_join']) ? $_POST['date_join'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
$district = isset($_POST['district']) ? $_POST['district'] : '';
$city_name = isset($_POST['city_name']) ? $_POST['city_name'] : '';


// hased Password 
// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password
echo 'Hashed Password: ' . $hashedPassword;


$userData = [
    'ID_Account' => $id_Account,
    'First_Name' => $first_name,
    'Last_Name' => $last_name,
    'Gender' => $gender,
    'age' => $age,
    'Photo' => $photo,
    'Date_Join' => $date_join,
    'Email' => $email,
    'Password' => $hashedPassword,
    'Phone_Number' => $phone_number,
    'District' => $district,
    'City_Name' => $city_name
];

function fetchAndPostData($userData)
{
    // Perform POST request
    $postData = json_encode($userData);

    $url = 'http://localhost/sanai3ey/server/user.php/api/users';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    $returnedId = $responseData['ID_User'];

    return $returnedId;
}

if (isset($_POST['save'])) {

    $savedId = fetchAndPostData($userData);
    echo "Returned ID: " . $savedId;

    $id_user = strval($savedId);
    $url = "Technical.php?id_user=" . urlencode($id_user);
    header("Location: " . $url);
    exit;

}
=======
    $id_Account = $_GET['id_Account'];
    echo "id_Account= " . $id_Account . "<br>";

    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $photo = isset($_POST['photo']) ? $_POST['photo'] : '';
    //$date_join = isset($_POST['date_join']) ? $_POST['date_join'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $district = isset($_POST['district']) ? $_POST['district'] : '';
    $city_name = isset($_POST['city_name']) ? $_POST['city_name'] : '';

    $userData = [
        'ID_Account' => $id_Account,
        'First_Name' => $first_name,
        'Last_Name' => $last_name,
        'Gender' => $gender,
        'age' => $age,
        'Photo' => $photo,
        'Date_Join' => $currentDate = date('Y-m-d'),
        'Email' => $email,
        'Password' => password_hash($password, PASSWORD_DEFAULT),
        'Phone_Number' => $phone_number,
        'District' => $district,
        'City_Name' => $city_name
    ];

    $allValuesEntered = true;
    foreach ($userData as $key => $value) {
        if (empty($value)) {
            $allValuesEntered = false;
            break;
        }
    }
    if ($allValuesEntered) {
        echo "All array values are entered. <br>";
    } else {
        echo "Some array values are empty or not entered. <br>";
    }



    function fetchAndPostData($userData)
    {
        // Perform POST request
        $postData = json_encode($userData);
    
        $url = 'http://localhost/sanai3ey/server/user.php/api/users';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $responseData = json_decode($response, true);
        $returnedId = $responseData['ID_User'];
    
        return $returnedId;
    }
     

    $Account_Type = $_GET['Account_Type'];
    echo "Account_Type: " . $Account_Type;
    
    if (isset($_POST['save'])) {

        $savedId = fetchAndPostData($userData);
        echo "Returned ID: " . $savedId . "<br>";

        // Validate email
        $Validate_email = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "The email address is valid. <br>";
            $Validate_email = true;
        } else {
            echo "The email address is not valid. <br>";
        }

        // Validate password
        $Validate_password = false;
        $length = strlen($password) >= 8; // Password should be at least 8 characters long
        $containsUpperCase = preg_match('/[A-Z]/', $password); // Password should contain at least one uppercase letter
        $containsLowerCase = preg_match('/[a-z]/', $password); // Password should contain at least one lowercase letter
        $containsNumber = preg_match('/[0-9]/', $password); // Password should contain at least one number

        if ($length && $containsUpperCase && $containsLowerCase && $containsNumber) {
            echo "The password is valid. <br>";
            $Validate_password = true;
        } else {
            echo "The password is not valid. <br>";
        }


        if ($Validate_email && $Validate_password && $allValuesEntered) {

            $id_user = strval($savedId);
            if ($Account_Type == "technical"){                      
                $url = "Technical.php?id_user=" . urlencode($id_user);            
            }elseif($Account_Type == "customer"){
                $url = "Customer.php?id_user=" . urlencode($id_user);
            }
            header("Location: " . $url);
            exit;
        }
 
    }
>>>>>>> cfb93661bae7fc1fc96cadc9d2df0c591acb0ca4

?>