<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete member</title>
</head>
<body>
    <?php

include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
 
if (mysqli_connect_errno()) {
  echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
  exit; //stop processing the page further
};
echo "<pre>"; var_dump($_POST); var_dump($_GET);echo "</pre>";
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
   and ($_POST['submit'] == 'Delete')) {
      
/* validate incoming data - only the first field is done for 
  you in this example - rest is up to you do*/
   $error = 0; //clear our error flag
   $msg = 'Error: ';  
    
/* memberID (sent via a form it is a string not a number so we try
  a type conversion!) */
   if (isset($_POST['id']) and !empty($_POST['id']) 
       and is_integer(intval($_POST['id']))) {
      $id = cleanInput($_POST['id']); 
   } else {
      $error++; //bump the error flag
      $msg .= 'Invalid member ID '; //append error message
      $id = 0;  
   }   

   
//save the member data if the error flag is still clear and member id is > 0
   if ($error == 0 and $id > 0) {
       $query = "DELETE FROM member WHERE memberID=?";
       $stmt = mysqli_prepare($DBC,$query); //prepare the query
       mysqli_stmt_bind_param($stmt,'i',$id); 
       mysqli_stmt_execute($stmt);
       mysqli_stmt_close($stmt);    
       echo "<h2>Member details deleted.</h2>";     
       
   } else { 
     echo "<h2>$msg</h2>".PHP_EOL;
   }      

}
//locate the member to edit by using the memberID
//we also include the member ID in our form for sending it back for saving the data
$query = 'SELECT * FROM member WHERE memberid='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result);

?>
<h1>Member Detail View</h1>
<h2><a href='listmembers.php'>[Return to the member listing]</a></h2>


<?php 

//makes sure we have the member
if ($rowcount > 0) {  
    echo "<fieldset><legend>Member detail #$id</legend><dl>"; 
    $row = mysqli_fetch_assoc($result);
    echo "<dt>Name:</dt><dd>".$row['firstname']."</dd>".PHP_EOL;
    echo "<dt>Lastname:</dt><dd>".$row['lastname']."</dd>".PHP_EOL;
    echo "<dt>Email:</dt><dd>".$row['email']."</dd>".PHP_EOL;
    echo "<dt>Username:</dt><dd>".$row['username']."</dd>".PHP_EOL;
    echo "<dt>Password:</dt><dd>".$row['password']."</dd>".PHP_EOL; 
    echo "<dt>Role:</dt><dd>".$row['role']."</dd>".PHP_EOL;  
    echo '</dl></fieldset>'.PHP_EOL;  
    ?>
    
    <form method="POST" action="deletemember.php">

      <h2>Are you sure you want to delete this member?</h2>

      <input type="hidden" name="id" value="<?php echo $id; ?>">

      <input type="submit" name="submit" value="Delete">

      <a href="listmembers.php">[Cancel]</a>
      
      </form>

      <?php

} else echo "<h2>No member found, possibly deleted!</h2>"; //suitable feedback

mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done
?>
</body>
</html>