<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search member with AJAX autocomplete</title>
    <script>
        function searchResult(searchstr) {
            if (searchstr.length==0) {
             document.getElementById("memberlist").innerHTML="";
             return;
        }
                xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange=function() {
         if (this.readyState==4 && this.status==200) {
            document.getElementById("memberlist").innerHTML=this.responseText;
        }
  }
  xmlhttp.open("GET","membersearch.php?sq="+searchstr,true);
  xmlhttp.send();
}

    </script>
</head>
<body>
    
<h1>Member list search by lastname</h1>
<h2><a href='registermember.php'>[Create new member]</a><a href="listmembers.php">[Return to the member listing]</a></h2>
<form>
  <label for="lastname">Lastname: </label>
  <input id="lastname" type="text" size="30" onkeyup="searchResult(this.value)" 
         onclick="javascript: this.value = ''"  placeholder="Start typing a last name">
 
</form>
 
<div id="memberlist"></div>
 
</body>
</html>