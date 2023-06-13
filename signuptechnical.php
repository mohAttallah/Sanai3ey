 <form method="POST">
    <label for="id_user">ID_User:</label>
    <input type="text" name="id_user" id="id_user" required><br><br>

    <label for="category_name">Category Name:</label>
    <input type="text" name="category_name" id="category_name" required><br><br>

    <label for="project_done">Project Done:</label>
    <input type="text" name="project_done" id="project_done" required><br><br>

    <label for="bio">Bio:</label>
    <textarea name="bio" id="bio" rows="5" required></textarea><br><br>

    <button type="submit" name="save" >save</button>
</form>
<form action="signupcustomer.php">

    <button type="submit" name="continuation" >continuation</button>
</form>

<?php
    $username = "root";
    $password = "";
    $database = new PDO("mysql:host=localhost;dbname=sanai3ey;charset=utf8;",$username,$password);

    if(isset($_POST['save'])){        
        $id_user = $_POST['id_user'];
        $category_name = $_POST['category_name'];
        $project_done = $_POST['project_done'];
        $bio = $_POST['bio'];

        function createTechnical($url, $data)
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
                    echo "Technical created successfully. Message: " . $response['message'];
                } else {
                    echo "Failed to create the technical.";
                }
            } else {
                echo "Failed to create the technical.";
            }
        }

        $url = 'http://localhost/sanai3ey/restfull/technical.php/technicals';

        // Create a new technical
        $data = json_encode([
            'ID_User' => $id_user,
            'Category_Name' => $category_name,
            'Project_Done' => $project_done,
            'Bio' => $bio
        ]);

        createTechnical($url, $data);

    }    

?>