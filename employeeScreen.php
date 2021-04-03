<html>
    <head>
    <title>Hotel Website</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
    #roomList {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        #roomList li a {
            padding: 12px;
            text-decoration: none;
            color: black;
            display: block
        }
        #roomList li a:hover {
            background-color: #eee;
        }   
    </style>
    </head>
    <body>
    <?php

        include 'header.php';
    ?>
        <h2>Hello Employee</h2>
        <h3>Available Rooms</h3>
        <hr>

    <div class='roomsTable'>
        <table style="width:100%">
      <tr>
        <th>Room ID</th>
        <th>Room_Number</th>
        <th>Price</th>
        <th>Capacity</th>
        <th>Room View</th>
        <th>Hotel</th>
      </tr>
        <?php

            $conn_string = "host=localhost port=5432 user=postgres password=root dbname=hotelapplication";
            $dbconn = pg_connect($conn_string) or die("Connection Failed");

            $selAvailRooms = "SELECT r.* 
                            FROM project.room r
                            WHERE r.roomid NOT IN (SELECT b.roomid FROM project.books b WHERE b.roomid IS NOT null);";

            $selAvailRoomsQuery =pg_query($dbconn,$selAvailRooms);

            
            while($selectedAvailRooms =pg_fetch_assoc($selAvailRoomsQuery))
                {

                    $selRoomID  = $selectedAvailRooms["roomid"];
                    $selRoomNum  = $selectedAvailRooms["room_number"];
                    $selPrice  = $selectedAvailRooms["price"];
                    $selCapacity  = $selectedAvailRooms["capacity"];
                    $selRoomView  = $selectedAvailRooms["roomview"];
                    $selHotelID  = $selectedAvailRooms["hotelid"];
                    

                    echo"<tr>
        <td>$selRoomID</td>
        <td>$selRoomNum</td>
        <td>$selPrice</td>
        <td>$selCapacity</td>
        <td>$selRoomView</td>
        <td>$selHotelID</td>
      </tr>";
}

                

                

            pg_free_result($selAvailRoomsQuery);
            pg_close($dbconn);

        ?>
    </table>
    <hr>
    </div>

    <h3>Booked Rooms</h3>

   

        <hr>
        
    <div class='roomsTable'>
        <table style="width:100%">
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Room ID</th>
        <th>Room #</th>
        <th>Room View</th>
        <th>Price</th>
        <th>Extendible</th>
        <th>Date</th>
        <th>Hotel Brand</th>
      </tr>
       <?php

            $conn_string = "host=localhost port=5432 user=postgres password=root dbname=hotelapplication";
            $dbconn = pg_connect($conn_string) or die("Connection Failed");

            $selBookedRooms = "SELECT C.firstname, C.lastname, R.extendible, R.price, R.room_number, R.roomid, R.roomview, B.date,
HB.hotelbrandname
FROM project.Customer C INNER JOIN project.Books B ON C.customerid = B.customerid
INNER JOIN project.Room R ON B.roomid = R.roomid
INNER JOIN project.Hotel H ON R.hotelid = H.hotelid
INNER JOIN project.HotelBrand HB ON H.brandid = HB.brandid
";

            $selBookedRoomsQuery =pg_query($dbconn,$selBookedRooms);

            
            while($selectedBookedRooms =pg_fetch_assoc($selBookedRoomsQuery))
                {

                    $selFirstName  = $selectedBookedRooms["firstname"];
                    $selLastName  = $selectedBookedRooms["lastname"];
                    $selExt  = $selectedBookedRooms["extendible"];
                    $selPrice  = $selectedBookedRooms["price"];
                    $selRoomID  = $selectedBookedRooms["roomid"];
                    $selRoomView  = $selectedBookedRooms["roomview"];
                    $selDate  = $selectedBookedRooms["date"];
                    $selHBName  = $selectedBookedRooms["hotelbrandname"];
                    $selRoomNum  = $selectedBookedRooms["room_number"];

                    echo"<tr>
        <td>$selFirstName</td>
        <td>$selLastName</td>
        <td>$selRoomID</td>
        <td>$selRoomNum</td>
        <td>$selRoomView</td>
        <td>$selPrice</td>
        <td>$selExt</td>
        <td>$selDate</td>
        <td>$selHBName</td>
      </tr>";
}

                

                

            pg_free_result($selBookedRoomsQuery);
            pg_close($dbconn);

        ?>
    </table>
    <hr>
    </div>

   <h3>Book a Room</h3>
    <form action="" method="post">
        <label>Enter a Room ID:</label><input autocomplete="off" style='width:200px;padding:5px;' type="text" name="roomid"/><br><br>
        <label>Enter your Customer ID:</label><input autocomplete="off" style='width:200px;padding:5px;' type="text" name="customerid"/><br><br>
        <label>Enter the Date:</label><input autocomplete="off" style='width:200px;padding:5px;' type="date" name="date"/><br><br>
        <label>Enter the # Of Occupants:</label><input autocomplete="off" style='width:200px;padding:5px;' type="number" name="numOccupants"/><br><br>
        <label>Enter Payment Option:</label><select name="paymentoption" id="paymentoption">
  <option value="Cash">Cash</option>
  <option value="Credit">Credit</option>
</select><br><br>
        <input name="submitPay" type="submit" value="Pay Now"/><br><br>
        <input name="submitPayLater" type="submit" value="Pay Later"/><br><br>
    </form>

        <?php

        if(isset($_POST['submitPay']))
        {

            $conn_string = "host=localhost port=5432 user=postgres password=root dbname=hotelapplication";
            $dbconn = pg_connect($conn_string) or die("Connection Failed");

            $roomID = pg_escape_string($dbconn,$_POST['roomid']);
            $customerID = pg_escape_string($dbconn,$_POST['customerid']);
            $date = pg_escape_string($dbconn,$_POST['date']);
            $numOccupants = pg_escape_string($dbconn,$_POST['numOccupants']);
            $paymentOption = pg_escape_string($dbconn,$_POST['paymentoption']);

            if($roomID==NULL)
            {

                echo "<script>alert('Please Enter a Room ID')</script>";
                exit();
            }

            if($customerID==NULL)
            {

                echo "<script>alert('Please Enter a Customer ID')</script>";
                exit();
            }

            if($date==NULL)
            {

                echo "<script>alert('Please Enter a Date')</script>";
                exit();
            }

            if($numOccupants==NULL)
            {

                echo "<script>alert('Please Enter a Number of Occupants')</script>";
                exit();
            }

            if($paymentOption==NULL)
            {

                echo "<script>alert('Please Enter a payment option.</script>";
                exit();
            }

            $insert = "INSERT INTO project.books (roomid,customerid,date,paid,numoccupants) VALUES ('$roomID','$customerID',CURRENT_DATE,'true',$numOccupants)";

            $result = pg_query($dbconn,$insert);

            if(!$result){
                die("Error in SQL Query:" .pg_last_error());
            }

            echo"Room Successfully Booked";

            pg_free_result($result);
            pg_close($dbconn);

        }


        if(isset($_POST['submitPayLater']))
        {
            $conn_string = "host=localhost port=5432 user=postgres password=root dbname=hotelapplication";
            $dbconn = pg_connect($conn_string) or die("Connection Failed");

            $roomID = pg_escape_string($dbconn,$_POST['roomid']);
            $customerID = pg_escape_string($dbconn,$_POST['customerid']);
            $date = pg_escape_string($dbconn,$_POST['date']);
            $numOccupants = pg_escape_string($dbconn,$_POST['numOccupants']);
           

            if($roomID==NULL)
            {

                echo "<script>alert('Please Enter a Room ID')</script>";
                exit();
            }

            if($customerID==NULL)
            {

                echo "<script>alert('Please Enter a Customer ID')</script>";
                exit();
            }

            if($date==NULL)
            {

                echo "<script>alert('Please Enter a Date')</script>";
                exit();
            }

            if($numOccupants==NULL)
            {

                echo "<script>alert('Please Enter a Number of Occupants')</script>";
                exit();
            }



            $insert = "INSERT INTO project.books (roomid,customerid,date,paid,numoccupants) VALUES ('$roomID','$customerID',CURRENT_DATE,'false',$numOccupants)";

            $result = pg_query($dbconn,$insert);

            if(!$result){
                die("Error in SQL Query:" .pg_last_error());
            }

            echo"Room Successfully Booked";

            pg_free_result($result);
            pg_close($dbconn);

        }

        ?>

        <h3>Rent a Room</h3>
        <p>Has the customer arrived? Check if payment is complete for the Room ID, and transfer the room to rented status</p>

        <form action="" method="post">
        <label>Enter a Room ID:</label><input autocomplete="off" style='width:200px;padding:5px;' type="text" name="roomid"/><br><br>
        <label>Enter your Customer ID:</label><input autocomplete="off" style='width:200px;padding:5px;' type="text" name="customerid"/><br><br>
        <label>Enter your Employee ID:</label><input autocomplete="off" style='width:200px;padding:5px;' type="text" name="employeeid"/><br><br>
        <input name="submitRent" type="submit" value="Rent"/><br><br>
    </form>

    <?php

     if(isset($_POST['submitRent']))
        {

            $conn_string = "host=localhost port=5432 user=postgres password=root dbname=hotelapplication";
            $dbconn = pg_connect($conn_string) or die("Connection Failed");

            $roomID = pg_escape_string($dbconn,$_POST['roomid']);
            $customerID = pg_escape_string($dbconn,$_POST['customerid']);
            $employeeID = pg_escape_string($dbconn,$_POST['employeeid']);

            $insert = "INSERT INTO project.assigns (roomid,employeeid,customerid) VALUES ('$roomID','$employeeID','$customerID')";

            $result = pg_query($dbconn,$insert);

            if(!$result){
                die("Error in SQL Query:" .pg_last_error());
            }

            echo"Room Successfully Rented";

            pg_free_result($result);
            pg_close($dbconn);

        }


    ?>
    </body>

</html>