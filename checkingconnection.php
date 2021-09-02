<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Connection</title>
</head>
<body>
    <?php 
        include "config.php";
        $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD,DBDATABASE);

        //check connection
        if(!$DBC){
            echo "Error : unable to connect to MySQL,\n". mysqli_connect_errno()."=".mysqli_connect_error();
            exit;
        };


            /* The connect_errno / mysqli_connect_errno() function returns the error code 
            from the last connection error, if any.
            https://www.w3schools.com/php/func_mysqli_connect_errno.asp*/
        echo "Connectted via" . mysqli_get_host_info($DBC); 
    ?>
</body>
</html>