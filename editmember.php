<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit member</title>
</head>
<body>
<?php
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
 
if (mysqli_connect_errno()) {
  echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
  exit; //stop processing the page further
};

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

echo "<pre>"; var_dump($_POST); var_dump($_GET);echo "</pre>";




//htmlspecialchars---Convert special characters "<" or ">"to HTML entities
//https://www.php.net/manual/en/function.htmlspecialchars.php

/* //stripslashes() can be used if you aren't inserting this data into a place (such as a database) 
that requires escaping.  For example, if you're simply outputting data straight from an HTML form.
//https://www.php.net/manual/en/function.stripslashes.php

//The trim() function removes whitespace and other predefined characters from both sides of a string.
//https://www.php.net/manual/en/function.trim.php */

//function to clean input but not validate type and content
function cleanInput($data) {  
    return htmlspecialchars(stripslashes(trim($data)));
  }



  //retrieve the memberid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid memberID</h2>"; //simple error feedback
        exit;
    } 
}


/* the data was sent using a form therefore we use the $_POST instead of $_GET
   check if we are saving data first by checking if the submit button exists in
   the array */
   if (isset($_POST['submit']) and !empty($_POST['submit'])
   and ($_POST['submit'] == 'Update')) {
    
    

/* validate incoming data - only the first field is done for 
  you in this example - rest is up to you do*/
   $error = 0; //clear our error flag
   $msg = 'Error: ';  


    
/* memberID (sent via a form it is a string not a number so we try
  a type conversion!) */

  //The intval() function is an inbuilt function in PHP which returns the integer value of a variable.

   if (isset($_POST['id']) and !empty($_POST['id']) 
       and is_integer(intval($_POST['id']))) {

      $id = cleanInput($_POST['id']); 

   } else {
      $error++; //bump the error flag
      $msg .= 'Invalid member ID '; //append error message
      $id = 0;  
   } 
   
   
//firstname
      $firstname = cleanInput($_POST['firstname']); 
//lastname
      $lastname = cleanInput($_POST['lastname']);        
//email
      $email = cleanInput($_POST['email']);        
//username
      $username = cleanInput($_POST['username']);        
   

/* A prepared statement is a feature used to execute the same (or similar)
SQL statements repeatedly with high efficiency.
i - integer
d - double
s - string
b - BLOB 
https://www.w3schools.com/php/php_mysql_prepared_statements.asp
*/
//save the member data if the error flag is still clear and member id is > 0
   if ($error == 0 and $id > 0) {
       $query = "UPDATE member SET firstname=?,lastname=?,email=?,username=? WHERE memberID=?";
      
       $stmt = mysqli_prepare($DBC,$query); //prepare the query
       
       mysqli_stmt_bind_param($stmt,'ssssi', $firstname, $lastname, $email,$username,$id); 
      
       mysqli_stmt_execute($stmt);
      
       
       mysqli_stmt_close($stmt);    
       echo "<h2>Member details updated.</h2>";     
       
   } else { 
     echo "<h2>$msg</h2>".PHP_EOL;
   }      

}

//locate the member to edit by using the memberID
//we also include the member ID in our form for sending it back for saving the data
$query = 'SELECT memberid,firstname,lastname,email,username FROM member WHERE memberid='.$id;

$result = mysqli_query($DBC,$query);

$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) {
 $row = mysqli_fetch_assoc($result);
?>





<h1>Member update</h1>
<h2><a href='listmembers.php'>[Return to the member listing]</a></h2>

<form method="POST" action="editmember.php">
 <input type="hidden" name="id" value="<?php echo $id;?>">
 <p>
   <label for="firstname">First Name: </label>
   <input type="text" id="firstname" name="firstname" minlength="5" 
          maxlength="50" required value="<?php echo $row['firstname']; ?>"> 
 </p> 
 <p>
   <label for="lastname">Last Name: </label>
   <input type="text" id="lastname" name="lastname" minlength="5" 
          maxlength="50" required value="<?php echo $row['lastname']; ?>"> 
 </p>  
 <p>  
   <label for="email">Email: </label>
   <input type="email" id="email" name="email" maxlength="100" 
          size="50" required value="<?php echo $row['email']; ?>"> 
  </p>
 <p>
   <label for="username">Username: </label>
   <input type="text" id="username" name="username" minlength="8" 
          maxlength="32" required  value="<?php echo $row['username']; ?>">  
 </p> 
 
  <input type="submit" name="submit" value="Update">
</form>
<?php 
} else { 
 echo "<h2>Member not found with that ID</h2>"; //simple error feedback
}
mysqli_close($DBC); //close the connection once done
?>
</body>
</html>