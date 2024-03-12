<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background-image: url('background.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            
        }

        .container {
            background-color: burlywood;
            padding: 20px;
            border-radius: 10px;
            opacity: 0.8; /* Adjust the opacity as needed */
           
            opacity: 1; /* Initially invisible */
        }
       
        .reg{
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $Name = $_POST["name"];
           $email = $_POST["email"];
           $phonenumber = $_POST["phonenum"];
           $address = $_POST["address"];
           $dobs = $_POST["dob"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($Name)  OR empty($email) OR empty($phonenumber) OR empty($address) OR empty($dobs) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
           require_once "database.php";
        //    $sql = "SELECT * FROM user_credentials WHERE email = '$email'";
        //    $result = mysqli_query($conn, $sql);
        //    $rowCount = mysqli_num_rows($result);
        //    if ($rowCount>0) {
        //     array_push($errors,"Email already exists!");
        //    }
        //    if (count($errors)>0) {
        //     foreach ($errors as  $error) {
        //         echo "<div class='alert alert-danger'>$error</div>";
        //     }
        //    }else{
            
            $sql = "INSERT INTO user_cred (name, email, phonenum, address, dob, password) VALUES ( ?, ?, ?, ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"ssssss",$Name, $email, $phonenumber, $address, $dobs, $passwordHash);
                mysqli_stmt_execute($stmt);
               
                echo "<div id='successMessage' class='alert alert-success'>Your registration was successful.</div>";
                echo "<script>setTimeout(function() { document.getElementById('successMessage').style.display = 'none'; }, 2000);</script>";
            }else{
                die("Something went wrong");
            }
           }
          

        
        ?>
        <form action="registration.php" method="post">
       
        <div class="row">
   
                <!-- <div class="col-md-12 md-4 text-end">
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> -->
            </div>


            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Name:" required>
            </div>
            
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:" required>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="phonenum" placeholder="Phone Number:" required>
            </div>
            <div class="form-group">
            <textarea name="address" class="form-control shadow-none" rows="2" placeholder="address" required></textarea>
                
            </div>
            <!-- <div class="form-group">
                <input type="date" class="form-control" name="dob" id="dob" max="2005-12-31" placeholder="dob:">
            </div> -->

            <div class="form-group">
                <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" required>
                <small id="ageMessage" class="form-text text-muted"></small>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit" id="registerBtn">
            </div>
        </form>
        <div>
        <div class="reg"><p>Already Registered <a href="../index.php">     Click here to login</a></p></div>
      </div>
    </div>


    <script>
   document.getElementById('dob').addEventListener('change', function() {
            var dob = new Date(this.value);
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            if (age >= 18) {
                document.getElementById('ageMessage').innerHTML = "<span style='color:green'>You are " + age + " years old. You can continue.</span>";
                document.getElementById('registerBtn').removeAttribute('disabled');
            } else {
                document.getElementById('ageMessage').innerHTML = "<span style='color:red'>You are " + age + " years old. You must be 18 years and above.</span>";
                document.getElementById('registerBtn').setAttribute('disabled', 'disabled');
            }
        });
</script>

</body>
</html>