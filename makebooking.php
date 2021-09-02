<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <link rel="stylesheet" href="/resources/demos/style.css">
     <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <title>make a booking</title>
</head>
<body>


<h2>Make a booking</h2>
        <a href="">[Return to the Booking listing]</a> <a href="">[Return to the main page]</a> 

  <form>
            <br>
            <label for="room" id="room" name="room">Room (Name, Type, Beds): </label>
            <select name="room" id="room"></select><br>

            <label for="checkIn">Check in Date:</label>
            <input type="text" id="checkin" name="checkIn" placeholder="mm/dd/yyyy" required> <br>
            <label for="checkOut">Check out Date:</label>
            <input type="text" id="checkout" name="checkOut" placeholder="mm/dd/yyyy" required> <br>

            <label for="phoneNumber" id="phoneNumber" name="phoneNumber">Contact Number:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="###-###-####" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required><br>

            <label for="bookingExtra" id="bookingExtra">Booking Extras:</label>
            <textarea id= "bookingExtra" name="bookingExtra"></textarea> <br>

            <label id = "roomAvailable">Room Available:</label>  
                <input type = "radio" name="roomAvailable" checked onclick="this.checked = false"> 
                <label id="Yes">Yes</label>
                <input type = "radio" name="roomAvailable" onclick="this.checked = false">
                <label id="No">No</label> <br>
            <!--<input type="text" id="bookingExtra" name="bookingExtra">-->
            <button type="submit">Add</button>
            <a href="">[Cancel]</a> 
        </form>


        <hr>
        <div id="mydatePicker">
      <h3>Search for room availability</h3>
      Start Date: <input id="checkin" type="text" placeholder="start date"> &nbsp;
        End date: <input id="checkout" type="text" placeholder="end date">
      <input type="submit" value="Search">
  </div>

</body>

<script>
    $("#checkin").datepicker({
     numberOfMonths:1,
     changeYear:true,
     changeMonth:true,
     showWeek:true,
     weekHeader:"Weeks",
     showOtherMonths:true,
     minDate: new Date (2020, 0,1),
     maxDate: new Date (2022,0, 5)

    }); 
    
    $("#checkout").datepicker({
     numberOfMonths:1,
     changeYear:true,
     changeMonth:true,
     showWeek:true,
     weekHeader:"Weeks",
     showOtherMonths:true,
     minDate: new Date (2020, 0,1),
     maxDate: new Date (2022,0, 5)

    });
 </script>
</html>