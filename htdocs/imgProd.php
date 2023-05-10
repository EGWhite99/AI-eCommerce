<?php 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "store";
	$conn = new mysqli($servername, $username, $password, $database);

	$image_titles = array("Abstract AI", "Astronaut on a Horse", "Balloon Dog", "Coffee and Laptop", "Neon Cyborg Face", "DJ David", "Semester is Almost Over", "Shiba Inu", "Synth Sunset", "Watercolor Future");
	$product_type = array("phonecase", "sweatshirt", "tshirt");
	$product_prices = array("phonecase"=>10.99,"sweatshirt"=>49.50,"tshirt"=>22.98);
	$product_info = array();
	$pathToProducts = "./Product Images";

	for($i = 1; $i <= 3; $i++){
		$key = $product_type[$i-1];
		for($j = 1; $j <= 10; $j++){
			$prodPath = $pathToProducts."/".$key."_".$j.".jpg";
			array_push($product_info, array($image_titles[$j-1], $product_prices[$key], $product_type[$i-1], $prodPath, $j));
		}
	}

	$product_sql = "INSERT INTO products (itemNum, title, price, merchType, merchImagePath) VALUES (?,?,?,?, ?)";
	$count = 1;
	foreach ($product_info as $prod){
		$q = $conn->prepare($product_sql);
    	$q->bind_param('isiss', $count, $prod[0], $prod[1], $prod[2], $prod[3]); 
    	$q->execute();
    	$count++;
	}


?>

<!--Fatal error: Uncaught mysqli_sql_exception: Unknown column 'imgNum' in 'field list' in C:\xampp\htdocs\imgProd.php:26 Stack trace: #0 C:\xampp\htdocs\imgProd.php(26): mysqli->prepare('INSERT INTO pro...') #1 C:\xampp\htdocs\index.php(6): require_once('C:\\xampp\\htdocs...') #2 {main} thrown in C:\xampp\htdocs\imgProd.php on line 26-->