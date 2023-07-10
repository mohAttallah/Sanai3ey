<?php

    function handlePostRequest($Account_Type)
    {
        $postData = json_encode([
            'Status' => 'active',
            'Account_Type' => $Account_Type
        ]);

        // curl library in PHP to make an HTTP request and retrieve the ID from the response. Here's an example code snippet
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

    if (isset($_POST['button1'])) {
    
        // $Account_Type = $_POST['Account_Type'];
        $Account_Type = "technical";
        
        // Usage example
        $savedId = handlePostRequest($Account_Type);
        echo "Returned ID: " . $savedId;
    
        $id_Account = strval($savedId);
        $url = "User.php";
        $params = array('id_Account' => $id_Account, 'Account_Type' => $Account_Type);
        $queryString = http_build_query($params);
        header("Location: " . $url . "?" . $queryString);
        exit;

    } elseif (isset($_POST['button2'])) {

        $Account_Type = "customer";
        
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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Select login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
        body {
            background: #F2EAD3;
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .logo {
            display: inline-block;
            text-decoration: none;
            background-image: url('image/صنايعي.png');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            padding: 50px 100px;
        }
        .header-bar {
            display: flex;
            align-items:center;
            justify-content: space-between;
            background-color: #f2f2f2;
            padding: 10px;
        }
        :root {
            --box-width: 100px;
            --box-height: 30px;
            --main-color: black;
            --text-color: white;
            --explore-offer-margin: 450px;
        }
        .explore-offer-container {
            display: flex;
            font-size: 20px;
            justify-content: space-between;
            flex-direction: column;
            align-items: center;
        }

        .explore-text {
            margin-bottom: 5px;
            color: #000;
            text-decoration: none;
        }

        .offer-text {
            color: #000;
            text-decoration: none;
        }
        .request-service-container {
            display: flex;
            margin-left:30px;
            font-size: 20px;
            flex-direction: column;
            align-items: center;
        }

        .request-text {
            margin-bottom: 5px;
            color: #000;
            text-decoration: none;
        }
        .service-text {
            color: #000;
            text-decoration: none;
        }
        .nav-link-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            padding: 1px 15px;
            width: var(--box-width);
            height: var(--box-height);
        }
            .nav-link-box:hover {
                background-color: #F2EAD3;
            }
            .nav-link-box.signup {
                border-color: black;
                border: 4px solid black;
            }
        .logo {
            margin-right: 10px;
        }

            .logo img {
                height: 40px;
            }

        .nav-links {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .nav-link {
            margin-right: 20px;
            color: #000;
            text-decoration: none;
        }
        .flag img {
            height: 20px;
            margin-right: 20px;
        }
        .products {
            position:center;
            height:97vh;
        }
            .products span{
                font-size:30px;
            }

            .products .titlepage {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100px;
            }

        .our_products {
            padding: 0 15px 15px 15px;
            transition: ease-in all 0.3s;
            margin-bottom: 30px;
        }

        #ho_bo:hover.our_products {
            box-shadow: 0px 0px 9px rgba(255, 53, 86, 0.33);
            transition: ease-in all 0.3s;
            margin-top: -10px;
            cursor: pointer;
            background-color: #ffffff;
        }

        .our_products h3 {
            margin-top: 15px;
            font-size: 22px;
            line-height: 31px;
            color: #000;
            font-weight: 500;
            padding-bottom: 10px;
        }

        .our_products span {
            font-size: 17px;
            line-height: 20px;
            font-weight: 500;
            color: #ff3556;
        }

        .our_products p {
            font-size: 15px;
            line-height: 21px;
            font-weight: 400;
            color: #000000;
        }

        .product {
            background-color: #fff;
            text-align: center;
            display: inline-block;
            margin: 0 20px 0px 20px !important;
        }

        .products .row {
            display: flex;
            justify-content: space-between;
        }

        .our_products {
            flex-basis: calc(25% - 30px);
            box-sizing: border-box;
            margin-bottom: 30px;
        }
        .keep-going {
            display: block;
            width: 35%;
            padding: 10px;
            border: 25px;
            border-radius: 25px;
            background-color: #000;
            color: whitesmoke;
            font-weight: bold;
            cursor: pointer;
        }
        a.keep-going1 {
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="header-bar">
            <div class="logo"></div>
            
            <div class="nav-links">
                <div class="flag">
                    <img src="image/jordan.png" alt="Jordan Flag">
                </div>
                <div class="explore-offer-container">
                    <div class="explore-text">Explore</div>
                    <div class="offer-text">Offer</div>
                </div>
                <div class="request-service-container">
                    <div class="request-text">Request</div>
                    <div class="service-text">Service</div>
                </div>
                <div class="nav-link-box signup">
                    <a class="nav-link" href="REGISTRATION1.html"> <i class="fas fa-user-plus"></i> Sign-up</a>
                </div>

            </div>
        </div>
        </nav>
        <div class="products">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="titlepage">
                            <span>
                                Select Your Customer or Professional
                            </span>
                        </div>
                        <p><b>Please choose the role you would like to define: would you like to be a client(s) and benefit from the services available, or would you rather be a professional(s) and offer your services to others? Your choice will help us provide the right service for your needs. Thanks for your cooperation!</b></p>
                    </div>
                </div>

                <form method="POST" >
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div id="ho_bo" class="our_products">
                                <div class="product"></div>
                                <h3><i class="fas fa-user"></i> Customer</h3>
                                <span>Keep Going</span>
                                <p>With a Customer account, you can request services and order professional.</p>
                                <div>
                                
                                    <button type="submit" name="button1" class="keep-going">
                                        <a class="keep-going1"><i class="fas fa-arrow-right"></i> Keep Going</a>
                                        <!-- href="User.php"  -->
                                    </button>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div id="ho_bo" class="our_products">
                                <div class="product"></div>
                                <h3><i class="fas fa-wrench"></i> Professional</h3>
                                <span>Keep Going</span>
                                <p>With a Professional account, you can view your services and add offers to customer requests.</p>
                                <div>
                                    <button type="submit" name="button2" class="keep-going">
                                        <a class="keep-going1"><i class="fas fa-arrow-right"></i> Keep Going</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
</body>
</html>