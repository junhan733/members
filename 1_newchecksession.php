<?php

session_start();

//log a user in
function login($id,$username) {
   //simple redirect if a user tries to access a page they have not logged in to
   if ($_SESSION['loggedin'] == 0 and !empty($_SESSION['URL']))        
        $url = $_SESSION['URL'];          
   else { 
     $_SESSION['URL'] =  'http://localhost/newmembers/listmembers.php';         
     $url = $_SESSION['URL'];           
   }  
   
   $_SESSION['loggedin'] = 1;        
   $_SESSION['userid'] = $id;   
   $_SESSION['username'] = $username; 
   $_SESSION['URL'] = ''; 
   header('Location: '.$url, true, 303);        
}

//function to check if the user is logged else send to the login page 
function checkUser() {
    $_SESSION['URI'] = '';    
    if ($_SESSION['loggedin'] == 1)
       return TRUE;
    else {
       $_SESSION['URL'] = 'http://localhost/newmembers/listmembers.php'.$_SERVER['REQUEST_URL']; //save current url for redirect     
       header('Location: http://localhost/newmembers/login.php', true, 303);       
    }       
}
 
//just to show we are logged in
function loginStatus() {
    $un = $_SESSION['username'];
    if ($_SESSION['loggedin'] == 1)     
        echo "<h2>Logged in as $un</h2>";
    else
        echo "<h2>Logged out</h2>";            
}

//simple logout function
function logout(){
    $_SESSION['loggedin'] = 0;
    $_SESSION['userid'] = -1;        
    $_SESSION['username'] = '';
    $_SESSION['URL'] = '';
    header('Location: http://localhost/newmembers/login.php', true, 303);    
  }
  

?>