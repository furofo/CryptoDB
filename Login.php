

<form action="Login.php" method="post">
 <p>User Name: <input type="text" name="name" /></p>
 <p>Password: <input type="text" name="password" /></p>
 <p><input type="submit" /></p>
</form>

<?php

if (!empty($_POST))
{

    

  $mysqli = mysqli_connect("localhost", "root", "", "crypto");
  $res = mysqli_query($mysqli, "SELECT * FROM login WHERE username = '{$_POST['name']}' AND  password = '{$_POST['password']}'");
  $affectedRows = mysqli_affected_rows($mysqli);
  echo $affectedRows, '<br>';
  if($affectedRows > 0)
  {
    $row = mysqli_fetch_row($res);
    echo 'Valid Username  ', $row[0], ': ', $row[1], '<br>';
  }

  else{
    echo 'Incorrect Username or password';
  }

  /*
  
  if(!$res === FALSE) {
      echo 'Incorrect Username or password';
  }
  else{
  $row = mysqli_fetch_row($res);
  echo 'Total Bought Of  ', $row[0], ': ', $row[1], '<br>';
  }
  */
  
  
   }
?>