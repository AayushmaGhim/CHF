
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./registerStyle.css">
    <title>Registration Form</title>
</head>
<body>         

<?php
    include "connection.php";

    $sql = "SELECT * FROM registration";
    $result = mysqli_query($connection, $sql);

    $phoneNumberErr = $firstNameErr = $lastNameErr = $emailErr = $addressErr = $passwordErr = $success = $genderErr = $msg="";
    
    if (isset($_POST['submitRegisterForm']))
    {
        $phoneNumber = test_input($_POST['userPhoneNumber']);
        $firstName = test_input($_POST['userFirstName']);
        $lastName = test_input($_POST['userLastName']);
        $email = test_input($_POST['userEmail']);
        $address = test_input($_POST['userAddress']);
        $password = test_input($_POST['userPassword']);
        $confirmPassword = test_input($_POST['confirmUserPassword']);
        $gender = test_input($_POST['gender']);

       
        // Phone Number Validation
        if (empty($phoneNumber)) {
            $phoneNumberErr = "Phone Number is empty!";
        }

        elseif (!is_numeric($phoneNumber)) {
            $phoneNumberErr = "Phone Number should always contains numberic values!";
            $phoneNumber = null;
        }

        elseif (strlen($phoneNumber) < 10) {
            $phoneNumberErr = "Phone Number must contains 10 digits number!";
            $phoneNumber = null;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $phoneCheck = $row['phoneNumber'];
            if ($phoneNumber === $phoneCheck) {
                $phoneNumberErr = "Phone number has been registered";
                $phoneNumber = null;
            }
        }

        // First Name validation
        if (empty($firstName)) {
            $firstNameErr = "First Name is empty!";
        }

        elseif (is_numeric($firstName)) {
            $firstNameErr = "Invalid First Name!";
            $firstName = null;
        }

        // Last Name validation
        if (empty($lastName)) {
            $lastNameErr = "Last Name is empty!";
        }

        elseif (is_numeric($lastName)) {
            $lastNameErr = "Invalid Last Name!";
            $lastName = null;
        }

        //Email validation
        if (empty($email)) {
            $emailErr = "Email is empty!";
        }

        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $emailErr = "Invalid email provided!";
            $email = null;
        }

        while ($row1 = mysqli_fetch_assoc($result)) {
            $emailCheck = $row1['email'];
            if ($email === $emailCheck) {
                $emailErr = "Email has been registered";
                $email = null;
            }
        }

        //Address Validation
        if (empty($address)) {
            $addressErr = "Address is empty!";
        }

        //Password Validation
        if (empty($password) || empty($confirmPassword)) {
            $passwordErr = "Password is empty!";
        }

        elseif ($password !== $confirmPassword) {
            $passwordErr = "Those passwords didn't match.Try again";
            $password = null;
        }

        elseif(strlen($password)  < 6)
        {
            $passwordErr =  "Password cannot be less than 6 character!";
            $password = null;
        }

        elseif(!preg_match("@[A-Z]@",$password))
        {
            $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
            $password = null;           
        }
        
        elseif(!preg_match("@[a-z]@",$password)) 
        {
            $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
            $password = null;
        }
        
        elseif(!preg_match("@[0-9]@", $password))
        {
            $passwordErr = "Your Password Must Contains at least 1 number!";
            $password = null;    
        }

        // Gender Validation
        if (empty($gender)) {
            $genderErr = "Please select the Gender";
            $gender = null;
        }

        if (!empty($phoneNumber) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($address) && !empty($password) && !empty($gender))
        {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO registration (phoneNumber, firstName, lastName, email, address, password, gender)
                        VALUES ('$phoneNumber', '$firstName', '$lastName', '$email', '$address', '$password', '$gender')";
            
            $query = mysqli_query($connection, $sql) or die(mysqli_error($connection));

            if ($query) {
                $msg = "Your account has been registered"; 
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

        <h2 class="r_header">Registration Form</h2>
        <form action="" method="post">
            <div class="msg"><?php echo $msg ?></div>
            <div class="input-box">
                
                <label for="phoneNumber">Phone Number</label>
                <input name="userPhoneNumber" type="text" placeholder="Enter Phone Number" value="<?php
                    if (isset($_POST['userPhoneNumber'])) echo $_POST['userPhoneNumber'];
                    ?>"><span class="error"><?php  echo $phoneNumberErr;  ?></span>
            </div>

            <div class="input-box">
               
                <label for="firstName">First Name</label>
                <input name="userFirstName" type="text" placeholder="First name" value="<?php
                    if (isset($_POST['userFirstName'])) echo $_POST['userFirstName'];
                    ?>"> <span class="error"><?php  echo $firstNameErr;  ?></span>
            </div>

            <div class="input-box">
                
                <label for="lastName">Last Name</label>
                <input name="userLastName" type="text" placeholder="Last name" value="<?php
                    if (isset($_POST['userLastName'])) echo $_POST['userLastName'];
                    ?>"><span class="error"><?php  echo $lastNameErr;  ?></span>
            </div>

            <div class="input-box">
                
                <label for="email">Email</label>
                <input  name="userEmail" type="text" placeholder="Enter Email" value="<?php
                    if (isset($_POST['userEmail'])) echo $_POST['userEmail'];
                    ?>"><span class="error"><?php  echo $emailErr;  ?></span>
            </div>

            <div class="input-box">               
                <label for="address">Address</label>
                <input  name="userAddress" type="text" placeholder="Enter Address" value="<?php
                    if (isset($_POST['userAddress'])) echo $_POST['userAddress'];
                    ?>"><span class="error"><?php  echo $addressErr;  ?></span>
            </div>

            <div class="input-box">
                
                <label for="password">Password: </label>
                <input name="userPassword" type="password" id="u_password" placeholder="Enter Password" value="<?php
                    if (isset($_POST['userPassword'])) echo $_POST['userPassword'];
                    ?>"><span class="error"><?php  echo $passwordErr;  ?></span>
            </div>

            <div class="input-box">
                <label for="confirmPassword">Confirm Password</label>
                <input name="confirmUserPassword" type="password" id="c_password" placeholder="Confirm Password" value="<?php
                    if (isset($_POST['confirmUserPassword'])) echo $_POST['confirmUserPassword'];
                    ?>">
            </div>
    
            <div class="input-box">
                <input type="checkbox" name="checkbox" onclick="showFunction()">Show Password  
            </div> 
            
            <div class="input-box">
                <label for="gender">Gender: </label>
                <select name="gender" >
                    <option value="">--Select--</option>
                    <option value="Male" >Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Others</option>
                </select><span class="error"><?php  echo $genderErr;  ?></span>
            </div>
                
            <div class="submit-box">
                <input  type="submit" name="submitRegisterForm" value="Register" >
            </div>

        </form>      
    </div>


    
  
        <!-- Javascript -->
    <script>
        function showFunction() {
            const password = document.getElementById("u_password");
            const confirm_password = document.getElementById("c_password");

            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }

            if (confirm_password.type === "password") {
                confirm_password.type = "text";
            } else {
                confirm_password.type = "password";
            }          
        }
    </script>
</body>
</html>