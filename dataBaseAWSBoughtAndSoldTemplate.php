<?php

$mysqli = mysqli_connect("endpint", "username", "password", "databaseName");
$res = mysqli_query($mysqli, "SELECT StockName, Sum(TotalValue) FROM cryptotransactions, cryptoid WHERE Type = 'Bought' AND Crypto = 'Yes' AND cryptotransactions.CryptoID = 2 AND cryptoid.CryptoID = cryptotransactions.CryptoID ");

$soldres = mysqli_query($mysqli, "SELECT StockName, Sum(TotalValue) FROM cryptotransactions, cryptoid WHERE Type = 'Sold' AND Crypto = 'Yes' AND cryptotransactions.CryptoID = 2 AND cryptoid.CryptoID = cryptotransactions.CryptoID ");
$row = mysqli_fetch_row($res);
$soldrow = mysqli_fetch_row($soldres);



echo 'Total Bought Of  ', $row[0], ': ', $row[1], '<br>';

echo 'Total Sold Of ', $soldrow[0], ': ', $soldrow[1], '<br>';
echo 'Total Difference is ', $soldrow[1]- $row[1];



/*while($row = mysqli_fetch_assoc($res)) {
    foreach($row as $field =>$value) {
        echo 'Total Bought: ';
        echo $value;
        echo '<br>';
    }

}*/
?>