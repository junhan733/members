
<?php
include "checksession.php";
checkUser();
loginStatus(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List members</title>
</head>
<body>
   <?php
    include "config.php";   //load in any variables
    $DBC =mysqli_connect ("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);


    //check connection
    if (!$DBC){
        echo "Error: Unable to connect to MySQL." .mysqli_connect_error();
        exit;  //stop processing the page further
    }

    // echo "Connectted via" .mysqli_get_host_info($DBC);
    // mysqli_close($DBC);
   

    // prepare a query and send it to the server

    $query ='SELECT memberID, firstname, lastname FROM member ORDER BY lastname';
    $result = mysqli_query($DBC, $query);
    $rowCount = mysqli_num_rows($result);

   ?> 
       
       <h1>Member list (CRUD)</h1>
       <h2>Member count <?php echo$rowCount?></h2>
       <h2><a href="registermember.php">[Create new member]</a> <a href="newlistmembers.php">[Search member]</a></h2>
       <h2><a href="login.php">[Log out]</a> 

       <table border ="1">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Actions</th>
                </tr>
            </thead>

        <?php 

         //To show the members


    /*      We are using the mysqli_fetch_assoc method, as we can access the record data by their field names. 
            This makes for much easier handling and readability as we just treat the data like any other associative array.
            The fetch_assoc() / mysqli_fetch_assoc() function fetches a result row as an associative array.
            https://www.w3schools.com/php/func_mysqli_fetch_assoc.asp */


           /*  PHP_EOL (string)
            You use PHP_EOL when you want a new line, and you want to be cross-platform */

       /*  https://chartio.com/learn/sql-tips/single-double-quote-and-backticks-in-mysql-queries/ */


         if ($rowCount > 0) {  
            while ($row = mysqli_fetch_assoc($result)) {
              $id = $row['memberID'];	
              echo '<tr><td>'.$row['firstname'].'</td><td>'.$row['lastname'].'</td>';
              echo     '<td><a href="viewmember.php?id='.$id.'">[view]</a>';
              echo         '<a href="editmember.php?id='.$id.'">[edit]</a>';
              echo         '<a href="deletemember.php?id='.$id.'">[delete]</a></td>';
              echo '</tr>'.PHP_EOL;


                }

                
            }else echo "<h2>NO members found!</h2>";

                mysqli_free_result($result);
                mysqli_close($DBC);
        ?>






       </table>
</body>
</html>