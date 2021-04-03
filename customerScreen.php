<html>
    <head>
    <title>Hotel Customer</title>
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
        <h2>Hello Customer</h2>
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
        <th>Hotel ID</th>
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
    </div>
    <hr>

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
    

    </body>
</html>