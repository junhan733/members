<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Member</title>
</head>
<body>
    <?php 

    /* var_dump
https://www.php.net/manual/en/function.var-dump.php
This function displays structured information about one or more expressions that includes its type and value. */

/* $_GET and $_POST are used to collect form-data. 
$_GET is an array of variables passed to the current script via the URL parameters.
$_POST is an array of variables passed to the current script via the HTTP POST method.

Before the browser sends the information, it encodes it using a scheme called URL encoding.
.
The GET method sends the encoded user information appended to the page request. 
The page and the encoded information are separated by the ? character.

The POST method transfers information via HTTP headers. 
The information is encoded as described in case of GET method and put into a header called QUERY_STRING.
https://www.w3schools.com/php/php_forms.asp
*/
    //to see that actual POST data
        echo "<pre>";
            var_dump($_POST); 
        echo "</pre>";



    //htmlspecialchars---Convert special characters "<" or ">"to HTML entities
//https://www.php.net/manual/en/function.htmlspecialchars.php

/* //stripslashes() can be used if you aren't inserting this data into a place (such as a database) 
that requires escaping.  For example, if you're simply outputting data straight from an HTML form.
//https://www.php.net/manual/en/function.stripslashes.php

//The trim() function removes whitespace and other predefined characters from both sides of a string.
//https://www.php.net/manual/en/function.trim.php */
        //function to clean input but not validate type and content
        function cleanInput($data){
            return htmlspecialchars(stripslashes(trim($data)));
        }


        if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] =='Register')){
            include "config.php";  
            $DBC =mysqli_connect ("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

            //check connection
            if (mysqli_connect_errno()){
              echo "Error: Unable to connect to MySQL." .mysqli_connect_error();
             exit;  //stop processing the page further
            };

            $error = 0;
            $msg ='Error: ';

            if (isset($_POST['firstname']) and !empty($_POST['firstname']) and is_string($_POST['firstname'])){
                $fn = cleanInput($_POST['firstname']);
                $firstname = (strlen($fn) > 50)?substr($fn, 1, 50):$fn;
             
            }else{
                $error++;
                $msg .='Invliad firstname';
                $firstname = '';
                
            }

            //lastname
                 $lastname = cleanInput($_POST['lastname']);        
            //email
                 $email = cleanInput($_POST['email']);  

              //username
                  $username = cleanInput($_POST['username']);        
             //password    
                  $password = cleanInput($_POST['password']);   
                
            
           /* A prepared statement is a feature used to execute the same (or similar)
             SQL statements repeatedly with high efficiency.
            i - integer
            d - double
            s - string
            b - BLOB 
            https://www.w3schools.com/php/php_mysql_prepared_statements.asp
            */       


            //save the customer data if the error flag is still clear
            if ($error == 0) {
                $query = "INSERT INTO member (firstname,lastname,email,username,password) 
                VALUES (?,?,?,?,?)";
                $stmt = mysqli_prepare($DBC,$query); //prepare the query
                mysqli_stmt_bind_param($stmt,'sssss', $firstname, $lastname, $email,$username, $password); 
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);    
                echo "<h2> New Member saved</h2>";        
            } else { 
              echo "<h2>$msg</h2>".PHP_EOL;
            }      
            mysqli_close($DBC); //close the connection once done
        }
    
    ?>



        <h1>Member Registration Form</h1>
         <h2><a href="listmembers.php">[Return to the member listing]</a></h2>

         <form method ="POST" action="registermember.php">

            <p>
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name ="firstname" minlength="3" maxlength="50" required>
            </p>

            <p>
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name ="lastname" minlength="3" maxlength="50" required>
            </p>

            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" name ="email" maxlength="100" size ="20" required>
            </p>

            <p>
                <label for="username">Username: </label>
                 <input type="text" id="username" name="username" minlength="5" maxlength="32" required> 
            </p> 

             <p>
                 <label for="password">Password: </label>
                 <input type="password" id="password" name="password" minlength="5" maxlength="32" required> 
             </p> 


            <input type="submit" name ='submit' value ="Register">

         </form>
</body>
</html>