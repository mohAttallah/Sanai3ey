<form method="POST">

    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" required><br><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" required><br><br>

    <label for="gender">Gender:</label>
    <select name="gender" id="gender" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select><br><br>

    <label for="age">Age:</label>
    <input type="number" name="age" id="age" required><br><br>

    <label for="photo">Photo:</label>
    <input type="file" name="photo" id="photo"><br><br>

    <label for="date_join">Date of Joining:</label>
    <input type="date" name="date_join" id="date_join" required><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br><br>

    <label for="phone_number">Phone Number:</label>
    <input type="tel" name="phone_number" id="phone_number" required><br><br>

    <label for="district">District:</label>
    <input type="text" name="district" id="district" required><br><br>

    <label for="city_name">City Name:</label>
    <input type="text" name="city_name" id="city_name" required><br><br>

    <button type="submit" name="save">save</button>
</form>

<?php

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

?>