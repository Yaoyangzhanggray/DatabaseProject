<html>
    <head><title>Hotel Website</title></head>
    <link rel="stylesheet" type="text/css" href="style.css">
<body>

	<?php

		include 'header.php';
	?>

    <h3 style='margin-left:5px;'>Enter your SIN Number.</h3>

    <form action="" method="post">
		<label>Enter a SIN:</label><input autocomplete="off" style='width:800px;padding:5px;' type="text" name="sqlq" value='<?php echo $sqlQ; ?>'/><br><br>
		<input name="submit" type="submit" value="Submit"/><br><br>
	</form>
</body>

