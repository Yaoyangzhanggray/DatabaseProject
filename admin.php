<html>
    <head><title>Hotel Website</title></head>
    <link rel="stylesheet" type="text/css" href="style.css">
<body>

	<?php

		include 'header.php';

		
        
	?>

	<h1>Hotel Administrator</h1>
	<p>The administrator should be able to insert/delete/update all information related to customers,
employees, hotels and rooms using SQL Queries inputted in the following box.</p>
	<form action="" method="post">
		<label>Enter an SQL Query:</label><input autocomplete="off" style='width:800px;padding:5px;' type="text" name="sqlq" value='<?php echo $sqlQ; ?>'/><br><br>
		<input name="submit" type="submit" value="Submit"/><br><br>
	</form>

	<?php

		if(isset($_POST['submit']))
		{

			$conn_string = "host=localhost port=5432 user=postgres password=root dbname=hotelapplication";
			$dbconn = pg_connect($conn_string) or die("Connection Failed");

			$sqlquery = $_POST['sqlq'];
			

			echo $sqlquery;


			$result = pg_query($dbconn,$sqlquery);

			if(!$result){
				die("Error in SQL Query:" .pg_last_error());
			}

			echo"Query Successfully Run";

			pg_free_result($result);
			pg_close($dbconn);

		}	

	?>

	<p>Rules for submission: Include project schema as project.table_name when referring to any table in your query.</p>

 
</body>


