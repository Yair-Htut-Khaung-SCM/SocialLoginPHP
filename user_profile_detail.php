<?php 
    include 'header.php';
    include 'ProviderEnum.php';
    include 'connection.php';


    $token = $_GET['token'];// Replace with your actual token value

    // Prepare and execute the query
    $query = "SELECT * FROM provider_information WHERE access_token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch data from the result
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Access data using $row['column_name']
            $providerName = $row['provider_name'];
            $providerUserName = $row['provider_user_name'];
            $providerUserEmail = $row['provider_user_email'];
            $providerUserAvatar = $row['provider_user_picture'];
            $itsfromprovider = 'Provider';
        }
    } else {

        $query = "SELECT * FROM users WHERE remember_token = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Access data using $row['column_name']
                $providerName = $row['provider_name'];
                $providerUserName = $row['name'];
                $providerUserEmail = $row['email'];
                $providerUserAvatar = '';
                $itsfromprovider = 'System';
            }
        } else {
            echo "No record found";
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();



?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }



    .box {
        min-height: 380px;
        width: 350px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        text-align: center;
        align-items: center;
        padding: 30px 30px;
    }


    .profile-circle {
        margin-top: 2px;
        height: 90px;
        width: 90px;
        border-radius: 10px;
        box-shadow: -3px -3px 7px #ffffff, 3px 3px 5px #ceced1;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    img {
        width: 100px;
        border-radius: 50%;
    }

    .profile-info {
        height: 50px;
        width: 100%;
        margin: 10px 0px;
        line-height: 25px;
    }

    .profile-info p {
        color: #7c8293;
        font-size: 14px;
    }

    .provider-mail {
        text-align: left;
        color: #7c8293;
        font-size: 14px;
    }

    .social-icon {
        width: 70%;
        display: flex;
        justify-content: space-between;
    }

    .fb,
    .insta,
    .twitt,
    .uTube {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        box-shadow: -3px -3px 7px #ffffff, 3px 3px 5px #ceced1;
        cursor: pointer;
    }

    .btns {
        padding: 30px;
        display: flex;
        justify-content: center;
        gap: 10px;
        align-items: center;
        height: 80px;
        width: 100%;
    }

    .btns button {
        background: none;
        border: none;
        outline: none;
        height: 35px;
        width: 100%;
        border-radius: 4px;
        box-shadow: -3px -3px 7px #ffffff, 3px 3px 5px #ceced1;
        cursor: pointer;
    }

    .btns button:hover {
        background: none;
        border: none;
        background: #ecf0f3;
        outline: none;
        height: 35px;
        width: 100%;
        border-radius: 4px;
        box-shadow: inset -2px -2px 3px #ffffff, inset 2px 2px 3px #ceced1;
    }

    .extra-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: center;
        width: 100%;
        padding: 0px 25px;
        margin-top: 15px;
    }

    .fb,
    .insta,
    .uTube,
    .twitt {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .fb:hover,
    .insta:hover,
    .uTube:hover,
    .twitt:hover {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        box-shadow: inset -2px -2px 3px #ffffff, inset 2px 2px 3px #ceced1;
    }
    .logout {
        background: #f20359fa;
        text-decoration: none;
        color: white;
        padding: 6px 13px !important;
        border-radius: 8px;
        box-shadow: 3px 7px #f8ebeb, 3px 3px 5px #ceced1;
    }
    .logout:hover{
        box-shadow: inset -2px -2px 3px #ceced1, inset 2px 2px 3px #ceced1;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <!-- Your navigation content here -->
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
        <h1> Welcome, <?php echo $providerUserName; ?></h1>
        <a href="login.php" class="logout">Logout</a>
        </div>
        <div class="box">
            <div class="profile-circle">
                <?php if($itsfromprovider == 'Provider'): ?>
                    <?php if ($providerUserAvatar): ?>
                        <img src="<?php echo $providerUserAvatar; ?>" alt="">
                    <?php else: ?>
                        <img src="https://i.pravatar.cc/100" alt="">
                    <?php endif; ?>
                <?php else: ?>
                    <img src="https://i.pravatar.cc/100" alt="">
                <?php endif; ?>
            </div>

            <div class="profile-info">
                <h4><?php echo $providerUserName; ?></h4>
                
                <p> Member of the System with<span style="color:rgb(48, 71, 245);font-weight:bold;">
                        <?php echo $providerName; ?></span>
                </p>

            </div>
            <?php if ($providerUserAvatar): ?>
                    <p class="provider-mail"><?php echo $providerUserEmail; ?></p>
            <?php endif; ?>

            <div class="social-icon">
                <!-- Social icons here -->
            </div>

            <div class="btns">
                <button>Message</button>
                <button>Setting</button>
            </div>
        </div>
    </div>
</body>

</html>








