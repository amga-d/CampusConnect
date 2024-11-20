<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "ecommerce";

    

    try {
        $conn = mysqli_connect($db_server,
                                $db_user,
                                $db_pass,
                                $db_name);

    } catch (mysqli_sql_exception) {
        echo "failed to connect to the data base";
        // echo "<script>consol.log('dsdfdsf');</script>";
    }
    

?>