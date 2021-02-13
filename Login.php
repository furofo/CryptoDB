

<form action="Login.php" method="post"> 
 <p>User Name: <input type="text" name="name" /></p>
 <p>Password: <input type="text" name="password" /></p>
 <p><input type="submit" /></p>
</form>

<?php

if (!empty($_POST)) // basically if submit button clicked
{
$servername = "localhost"; // all the variables needed to connect to database
$username = "root";
$password = "";
$dbname = "crypto";

$conn = new mysqli($servername, $username, $password, $dbname); // this will be connection to database
if ($conn->connect_error) { //if it doesn't connect log the error
  die("Connection failed: " . $conn->connect_error);
}
else {
  $username = $_POST['name']; // get post variables and assign them to intenral variable
  $password = $_POST['password'];
  $stmt = $conn->prepare("SELECT username, Password FROM login WHERE username = ? AND Password = ?"); // this is to sanitize inputs and protect agains injection attacks
  $stmt->bind_param("ss", $username, $password);
  
  $stmt -> execute();

  $stmt->bind_result($name, $retrievedPassword);  // assign the  columns username and passowrd to variables name and passowrd

 if($stmt -> fetch()) {
    echo 'Succesful login user: ' . $name . ' Password: '. $retrievedPassword;
  }

 else  {
   echo 'Invalid login attemnpt. Please input valid username or password';
  }
  

}

  
  
   }
?>