<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
</head>
<body>

<?php
    include "connection.php";

    $emailErr = $passwordErr = $success = "";

    if (isset($_POST['userLogin'])) {
        $email = test_input($_POST['userEmail']);
        $password = test_input($_POST['userPassword']);

        if (empty($email)) {
            $emailErr = "Email is empty!";
        }

        if (empty($password)) {
            $passwordErr = "Password is empty!";
        }

        if (!empty($email) && !empty($password)) {

            //password_verify();
            $sql = "SELECT * FROM registration WHERE email = '$email' ";
            $result = mysqli_query($connection, $sql) or die(mysqli_error($connection));

            if ($row = mysqli_fetch_assoc($result)) {

                $passwordHash = $row['password'];
                $passwordVerify = password_verify($password, $passwordHash);

                if ($passwordVerify) {
                    $_SESSION['userEmail'] = $email;
                header('location:products.php');
                }
                else {
                    $passwordErr = "password is wrong";
                }
                
              
            }
            else {
                $emailErr = "email is wrong";
            }
        }
     
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>

<div class="container">
    <h2 class="l_header">Login Form</h2>
    <div class="success"><?php echo $success ?></div>
    
    <form action="" method="post">

        <div class="input-box">                
            <label for="email">Phone Number</label>
            <input name="userEmail" type="email" placeholder="Enter email"  value="<?php
                if (isset($_POST['userEmail'])) echo $_POST['userEmail'];
                ?>"><span class="error"><?php  echo $emailErr;  ?></span>
        </div>

        <div class="input-box">
            <label for="password">Password</label>
            <input name="userPassword" type="password" placeholder="Enter Password" id="u_password" value="<?php
                if (isset($_POST['userPassword'])) echo $_POST['userPassword'];
                ?>"><span class="error"><?php  echo $passwordErr;  ?></span>
        </div>

        <div class="input-box">
            <input type="checkbox" name="checkbox" onclick="showFunction()">Show Password  
        </div> 

        <div class="submit-button">
            <input type="submit" value="Login" name="userLogin">
        </div>

    </form>
</div>

        <!-- Javascript -->
    <script>
    function showFunction() {
        const password = document.getElementById("u_password");
        
        if (password.type === "password") {
            password.type = "text";
        } else {
            password.type = "password";
        }    
    }
    </script>
</body>
</html>