
<?php

$id_user = $_GET['id_user'];
echo "id_user= " . $id_user;

$category_name = "Flooring Installers";

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
    "Project_Done" => " ",
    "Bio" => " "

];



if (isset($_POST['save'])) {
    $savedId = postData($technicalData);
    echo "Returned ID: " . $savedId;

    $id_user = strval($savedId);   
    $url = "Customer.php?id_user=" . urlencode($id_user);
    header("Location: " . $url);
    exit;
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleSubList(event) {
            var listItem = event.currentTarget;
            var subList = listItem.querySelector('.sub-list');
            subList.style.display = subList.style.display === 'none' ? 'block' : 'none';
        }

        window.addEventListener('DOMContentLoaded', function () {
            var listItems = document.querySelectorAll('.list-container li');
            listItems.forEach(function (listItem) {
                listItem.addEventListener('click', toggleSubList);
            });
        });

        $(document).ready(function () {
            $('#back-to-top').click(function () {
                $('html, body').animate({
                    scrollTop: 0
                },
                    2000);
                return false;
            });
        });

        window.addEventListener("scroll", function () {
            var button = document.getElementById("back-to-top");
            if (window.pageYOffset > 100) {
                button.style.display = "block";
            } else {
                button.style.display = "none";
            }
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-...أضف الكود الخاص بك هنا..." crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Add your CSS code here */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .title {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .bo {
            width: 33.33%;
            padding: 10px;
        }

        .profession-button {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            border: none;
            background-color: #f8f8f8;
            color: #000;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 5px;
        }

        .profession-button.selected {
            background-color: #007bff;
            color: #fff;
        }

        .selected-options {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
        }

        .selected-option {
            display: inline-block;
            margin: 5px;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .next-button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .next-button:hover {
            background-color: #0056b3;
        }

        .next-button i {
            margin-right: 5px;
        }
        
    </style>
    

</head>
<body>
    <h2 class="title">Choose one or more services you want to provide</h2>

    <div class="container" style="margin-top: 15px;">
        <div class="bo">
            <button class="profession-button" data-value="Plumbers">Plumbers</button>
        </div>
        <div class="bo">
            <button class="profession-button" data-value="Electrician">Electrician</button>
        </div>
        <div class="bo">
            <button class="profession-button" data-value="General Contractor">General Contractor</button>
        </div>
        <div class="bo">
            <button class="profession-button" data-value="Carpenters">Carpenters</button>
        </div>
        <div class="bo">
            <button class="profession-button" data-value="Flooring Installers">Flooring Installers</button>
        </div>
        <div class="bo">
            <button class="profession-button" data-value="Builders">Builders</button>
        </div>
        <div class="bo">
            <button class="profession-button" data-value="Home Clean Service">Home Clean Service</button>
        </div>
        <div class="bo">
            <button class="profession-button" data-value="Knitting and Embroidery">Knitting and Embroidery</button>
        </div>
        <div class="bo">
            <button class="profession-button" data-value="Painters">Painters</button>
        </div>
    </div>

    <div class="selected-options"></div>
    <form method="POST">
        <button type="submit" name="save" class="next-button">
            <i class="fas fa-arrow-right"></i>
            Next
        </button>
    </form>

    <script>
        $(document).ready(function () {
            var selectedOptionsContainer = $('.selected-options');
            var selectedOptions = [];

            function updateSelectedOptions() {
                selectedOptionsContainer.empty();

                for (var i = 0; i < selectedOptions.length; i++) {
                    var option = selectedOptions[i];
                    selectedOptionsContainer.append('<span class="selected-option" data-value="' + option + '">' + option + '</span>');
                }

                $('.selected-option').click(function () {
                    var value = $(this).data('value');
                    $(this).remove();
                    var index = selectedOptions.indexOf(value);
                    if (index > -1) {
                        selectedOptions.splice(index, 1);
                    }
                    updateButtons();
                });
            }

            function updateButtons() {
                $('.profession-button').removeClass('selected');
                for (var i = 0; i < selectedOptions.length; i++) {
                    $('.profession-button[data-value="' + selectedOptions[i] + '"]').addClass('selected');
                }
            }

            $('.profession-button').click(function () {
                var value = $(this).data('value');

                if (selectedOptions.indexOf(value) === -1) {
                    selectedOptions.push(value);
                } else {
                    var index = selectedOptions.indexOf(value);
                    if (index > -1) {
                        selectedOptions.splice(index, 1);
                    }
                }

                updateSelectedOptions();
                updateButtons();
            });

            $('.next-button').click(function () {
                // Perform your next action here
            });
        });
    </script>

</body>
</html>
