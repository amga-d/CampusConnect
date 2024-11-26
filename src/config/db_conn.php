<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "campusconnect";

    
    

    try {
        $conn = mysqli_connect($db_server,
                                $db_user,
                                $db_pass,
                                $db_name);

    } catch (mysqli_sql_exception) {
        // echo "failed to  to the data base";
        echo "<script>alart('dsdfdsf');</script>";
    }
    

?>