<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View members</title>
</head>
<body>
    <?php
    
    include "config.php";  
    $DBC =mysqli_connect ("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

    //check connection
    if (mysqli_connect_errno()){
        echo "Error: Unable to connect to MySQL." .mysqli_connect_error();
        exit;  //stop processing the page further
    }

    //check if id exists
    $id = $_GET['id']; 
    if (empty ($id) or  !is_numeric($id)){
        echo "<h2>Invalid memberID</h2>"  ;
        exit;
    }

    //prepart a query and send it to the server
        $query ='SELECT * FROM member WHERE memberID =' .$id;
        $result =mysqli_query($DBC,$query);
        $rowcount  = mysqli_num_rows($result);

    ?>
     
     <h1>Member detail view</h1>
    <h2><a href="listmembers.php">[Return to the member listing]</a></h2>

    <?php
        if ($rowcount >0){
            echo "<fieldset><legend>Member detail #$id</legend><dl>";
            $row =mysqli_fetch_assoc($result);
            echo "<dt>First Name:</dt><dd>". $row['firstname'] ."</dd>".PHP_EOL;
            echo "<dt>Last Name:</dt><dd>". $row['lastname'] ."</dd>".PHP_EOL;
            echo "<dt>Email:</dt><dd>". $row['email'] ."</dd>".PHP_EOL;
            echo "<dt>Username:</dt><dd>". $row['username'] ."</dd>".PHP_EOL;
            echo "<dt>Password:</dt><dd>". $row['password'] ."</dd>".PHP_EOL;
            echo "<dt>Role:</dt><dd>". $row['role'] ."</dd>".PHP_EOL;   
            echo '</dl></fieldset>'.PHP_EOL;
        }else echo "<h2>No member found!</h2>";
    
        mysqli_free_result($result);
        mysqli_close($DBC);
    ?>


</body>
</html>