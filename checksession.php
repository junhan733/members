
<!-- Basically, sessions are a way for our web application to maintain 
a ‘link’ between pages, in order to overcome 
the stateless nature of HTTP, and are also a means of tracking authentication. -->

<!-- When you create a session in PHP it will also create the global variable $_SESSION, 
which will survive page reloads and browsing to different pages within the web application. -->


<!-- We have four functions:

login() – log a user in and store the userid, username and set a login flag
logout() – clear all of the session variables
loginStatus() – simple indicate showing the current logged on user
checkUser() – this is the function that we add to each of the pages 
we want controlled by some authentication – more on this shortly. -->
<?php
session_start();
//URI -- Uniform Resource Identifier
//URIs encompass URLs, URNs, and other ways to identify a resource.

//log a user in
function login($id,$username) {
  //simple redirect if a user tries to access a page they have not logged in to
  if ($_SESSION['loggedin'] == 0 and !empty($_SESSION['URI']))        
       $uri = $_SESSION['URI'];          
  else { 
    $_SESSION['URI'] =  'http://localhost/members/listmembers.php';         
    $uri = $_SESSION['URI'];           
  }  
  
  $_SESSION['loggedin'] = 1;        
  $_SESSION['userid'] = $id;   
  $_SESSION['username'] = $username; 
  $_SESSION['URI'] = ''; 
  header('Location: '.$uri, true, 303);        
}


//function to check if the user is logged else send to the login page 
function checkUser() {
    $_SESSION['URI'] = '';    
    if ($_SESSION['loggedin'] == 1)
       return TRUE;
    else {
       $_SESSION['URI'] = 'http://localhost'.$_SERVER['REQUEST_URI']; //save current url for redirect     
       header('Location: http://localhost/members/login.php', true, 303);       
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
  $_SESSION['URI'] = '';
  header('Location: http://localhost/members/login.php', true, 303);    
}



?>