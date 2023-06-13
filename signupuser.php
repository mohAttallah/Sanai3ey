<form  method="POST">
    <label for="id_account">ID_Account:</label>
    <input type="text" name="id_account" id="id_account" required><br><br>

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
    <input type="file" name="photo" id="photo" ><br><br>

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

    <button type="submit" name="save" >save</button>
</form>
<form action="signuptechnical.php">

    <button type="submit" name="continuation" >continuation</button>
</form>

  <?php
    $username = "root";
    $password = "";
    $database = new PDO("mysql:host=localhost;dbname=sanai3ey;charset=utf8;",$username,$password);
    if(isset($_POST['save'])){
        $id_account = $_POST['id_account'];
        $first_name = $_POST['first_name'];
        $last_namet = $_POST['last_name'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $photo = $_POST['photo'];
        $date_join = $_POST['date_join'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone_number = $_POST['phone_number'];
        $district = $_POST['district'];
        $city_name = $_POST['city_name'];

         // URL to send the POST request
        $url = 'http://localhost/sanai3ey/restfull/user.php/api/users';

        // Data to be posted
        $data = array(
            "ID_Account" => $id_account,
            "First_Name" => $first_name,
            "Last_Name" => $last_namet,
            "Gender" => $gender,
            "age" => $age,
            "Photo" => $photo,
            "Date_Join" => $date_join,
            "Email" => $email,
            "Password" => $password,
            "Phone_Number" => $phone_number,
            "District" => $district,
            "City_Name" => $city_name
        );

        // Convert data to JSON
        $jsonData = json_encode($data);

        // Initialize cURL
        $curl = curl_init($url);

        // Set the necessary cURL options for the POST request
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Send the POST request
        $response = curl_exec($curl);

        // Check for errors
        if ($response === false) {
            $error = curl_error($curl);
            echo "cURL error: " . $error;
        } else {
            // Handle the response
            echo "Response: " . $response;
        }

        // Close cURL resource
        curl_close($curl);
    }
?>