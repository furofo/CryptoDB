
<?php
//initalize the session
    session_start();
    
    
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: loggedin.php");
    exit;
}
 
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT UserID, username, Password FROM login WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <img id = "topLeftCorner" src ="img/topLeftCorner.png"> <!-- top and bottom wavy images-->
    <img id = "bottomRightCorner" src = "img/bottomRightCorner.png"> </img>
    <div class = 'vertHorizCenter'>

        <div class = "innerCenter">
            <h1 class = "title" id = "loginTitle"> LOGIN</h1>
            <h2 class = "titleSubheading" id = "loginSubheading"> EL PSY CONGROO</h2>


            <!-- need to make this  aform for submiting stuff too -->
            <form id ="loginForm">
            <div class = "inputLabel">

                <label class = "inputLabelParagraph" for = "username">Username:</label>
                <input type = "text" name = "username" id = "username">
            </div>
            
                
            <div class = "inputLabel">
                <label class = "inputLabelParagraph" for = "password">Password:</label>
                <input type = "password" name = "password" id = "password">
            </div>
            <div class = "formButtons">
                <button class ="topBtn" id = "topBtnLogin">Sign Up</button>
                <button type = "submit" class = "bottomBtn" id = "bottomBtnLogin">Sign In</button>
            </div>
            <h3 class = "reset">Reset?</h3>
            </form>
        </div>
    </div>


</body>
</html>