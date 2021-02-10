<?php

$mysqli = mysqli_connect("enpoint", "username", "password", "thedatabasenameonserver");
$res = mysqli_query($mysqli, "SELECT * FROM  cryptoid");




while($row = mysqli_fetch_assoc($res)) {
    foreach($row as $field =>$value) {
        echo $value;
        echo '<br>';
    }

}

?>