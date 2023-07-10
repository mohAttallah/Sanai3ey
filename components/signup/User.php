<?php

    $id_Account = $_GET['id_Account'];
    echo "id_Account= " . $id_Account . "<br>";

    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $photo = isset($_POST['photo']) ? $_POST['photo'] : '';
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
        echo "user ID: " . $savedId . "<br>";

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

?>



<!DOCTYPE html>
<html>
<head>
    <title>Registration Sanai3ey</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F2EAD3;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            margin-bottom: 150px;
            padding: 80px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block;
            margin-bottom: 10px;
        }

        .gender-label {
            margin-bottom: 5px;
        }

        .btn-signup {
            width: 100%;
            padding: 10px;
            background-color: #000000;
            color: #ffffff;
            border: none;
            border-radius: 25px;
            font-family: 16px;
            cursor: pointer;
        }
            .btn-signup:hover {
                background-color: #F2EAD3;
            }
            .already-account {
                text-align: center;
                margin-top: 15px;
            }

                .already-account a {
                    color: #000000;
                }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* تخصيص حقل تحديد المدينة */
        label[for="city"],
        select#city {
            display: block;
            margin-bottom: 10px;
        }

        /* تخصيص حقل تحديد الحي */
        label[for="district"],
        select#district {
            display: block;
            margin-bottom: 10px;
        }

        .phone-number-label::before {
            content: "+962 ";
        }
    </style>
</head>
<body>
    <h1>Sanai3ey</h1>
    <div class="container">
        <h2>Create a new account</h2>
        <p style="text-align: center;">It’s quick and easy</p>
        <form method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" placeholder="Enter the First Name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" placeholder="Enter the Last Name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter the Email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter the Password" required>

            <label for="age">Age:</label>
            <input type="text" name="age" id="age" placeholder="Enter the Age" required>

            <label class="gender">Gender:</label>
            <select name="gender" id="gender">
                <option value="" selected disabled>--Choose the gender--</option>
                <option value="m">Male</option>
                <option value="f">Female</option>
            </select>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" name="phone_number" id="phone_number" placeholder="+962" required>

            <label for="district">District:</label>
            <input type="text" name="district" id="district" placeholder="Enter the district" required>

            <label for="city_name">Select Your City:</label>
            <select id="city_name" name="city_name">
                <option value="" selected disabled>--Choose the city--</option>
                <option value="Irbid">Irbid</option>
                <option value="Ajloun">Ajloun</option>
                <option value="Jerash">Jerash</option>
                <option value="Mafraq">Mafraq</option>
                <option value="Balqa">Balqa</option>
                <option value="Amman">Amman</option>
                <option value="Zarqa">Zarqa</option>
                <option value="Madaba">Madaba</option>
                <option value="Karak">Karak</option>
                <option value="Tafilah">Tafilah</option>
                <option value="Ma'an">Ma'an</option>
                <option value="Aqaba">Aqaba</option>
            </select>

            <label for="photo">Photo:</label>
            <input type="file" name="photo" id="photo"><br><br>


            <p> By clicking Sign Up, you agree to our <u>Tems, Privacy Policy</u> and <u>Cookies Policy</u>. You may receive Email Notifications from us and can opt out any time.</p>
            <button type="submit" name="save" class="btn-signup">Sign Up</button>
        </form>

        <p class="already-account">Already have an account? <a href="LOGIN1.html">Sign In</a></p>
    </div>
</body>
</html>