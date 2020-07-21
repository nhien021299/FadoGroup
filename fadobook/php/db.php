<?php
    $server = "sql200.epizy.com";
    $username ="epiz_26317427";
    $password="0xk0l1WnlrrZm";
    $dbname="epiz_26317427_FadoBook";    

    $conn = mysqli_connect($server,$username,$password,$dbname);

    if(!$conn)
    {
        die("Connection Failed!:".mysqli_connect_error());
    }
?>