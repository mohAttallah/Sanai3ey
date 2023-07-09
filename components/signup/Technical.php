<form method="POST">

    <label for="category_name">Category Name:</label>
    <input type="text" name="category_name" id="category_name" required><br><br>

    <label for="project_done">Project Done:</label>
    <input type="text" name="project_done" id="project_done" required><br><br>

    <label for="bio">Bio:</label>
    <textarea name="bio" id="bio" rows="5" required></textarea><br><br>

    <button type="submit" name="save">save</button>
</form>

<?php

$id_user = $_GET['id_user'];
echo "id_user= " . $id_user;

$category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
$project_done = isset($_POST['project_done']) ? $_POST['project_done'] : '';
$bio = isset($_POST['bio']) ? $_POST['bio'] : '';


function postData($userData)
{
    // Perform POST request
    $postData = json_encode($userData);

    $url = 'http://localhost/sanai3ey/server/technical.php/technicals';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    $returnedId = $responseData['ID_Technical'];

    return $returnedId;
}


$technicalData = [

    "ID_User" => $id_user,
    "Category_Name" => $category_name,
    "Project_Done" => $project_done,
    "Bio" => $bio

];



if (isset($_POST['save'])) {
    $savedId = postData($technicalData);
    echo "Returned ID: " . $savedId;
}

<<<<<<< HEAD
?>
=======
?>
>>>>>>> cfb93661bae7fc1fc96cadc9d2df0c591acb0ca4
