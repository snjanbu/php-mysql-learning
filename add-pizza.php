<?php
	
	$conn = mysqli_connect("localhost", "sanjay", "sanjay", "php_learning");

	if (!$conn) {
		echo "Error connecting database:".mysqli_connect_error();
	} 
	$ages1 = [10,20,30];

	//$ages[] = 40;
	$ages1[4] = 40;
	
	$ages2 = [50, 60, 70];

	//print_r(count($ages2));

	$names1 = array('sanjay','anbu');

	$names2 = array('key'=>'value');

	//print_r(array_merge($names1,$names2));

	//Multi-Dimensional Arrays
	$array1=[
		['start'=>'hello','end'=>'how are you?'],
		['start'=>'welcome','end'=>'enjoy the party']
	];

	$array1[]=['start'=>'hurray','end'=>'Enjoying the stuff'];

	//print_r($array1);

	$products=[
		['name'=>'sony','cost'=>'20000'],
		['name'=>'apple','cost'=>'50000'],
		['name'=>'samsung','cost'=>'40000']
	];

	function describeProduct($product = ['name'=>'nokia', 'cost'=>'12000']) {
		return "The product {$product['name']} costs {$product['cost']}.<br>";
	}

	// foreach ($products as $product) {
	// 	echo describeProduct($product);
	// }
	// echo describeProduct();

	$name = 'Anbu';

	function getName(&$name) {
		// global $name;
		$name = 'Sanjay';
		// echo $name;
	}

	// getName($name);
	// echo $name;

	// include('./contents.php');
	// echo "END";

	$errors = ['email'=>'', 'pizzaName'=>'','ingredients'=>'' ];
	$email = $pizzaName = $ingredients = '';

	if (isset($_POST['submit'])) {

		if (empty($_POST['email']) === false) {
			$email = $_POST['email'];
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Enter a valid email";
			}
		} else {
			$errors['email'] = "Email is required";
		}

		if (empty($_POST['pizzaName']) === false) {
			$pizzaName = $_POST['pizzaName'];
			if (!preg_match('/^[A-Za-z\s]+$/', $pizzaName)) {
				$errors['pizzaName'] = "Enter a valid name";
			} 
		} else {
			$errors['pizzaName'] = "Pizza Name is required";
		}

		if (empty($_POST['ingredients']) === false) {
			$ingredients = $_POST['ingredients'];
			if (!preg_match('/^([A-Za-z\s]+)(,\s*[A-Za-z\s]*)*$/', $ingredients)) {
				$errors['ingredients'] = "Enter a valid ingredient";
			}
		} else {
			$errors['ingredients'] = "Ingredients is required";			
		}
		if (!array_filter($errors)) {
			$name = mysqli_real_escape_string($conn, $_POST['pizzaName']);
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
			echo $name;

			$query = "INSERT INTO pizzas(name,email,ingredients) VALUES('$name', '$email', '$ingredients')";
			if (mysqli_query($conn, $query)) {
				header('Location:/');
			} else {
				echo "Error "+mysqli_error($conn);
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<?php include('templates/header.php') ?>

		<form class="m-5" action="add-pizza.php" method="POST">
		<div class="form-group">
			<label for="email">
				Email
			</label>
			<input id="email" type="text" class="form-control" name="email" value="<?php echo $email?>">
			<div class="text-danger"><?php echo $errors['email']?></div>
		</div>
		<div class="form-g">
			<label for="pizzaName">
				Pizza Name
			</label>
			<input type="text" name="pizzaName" class="form-control" value="<?php echo $pizzaName?>">
			<div class="text-danger"><?php echo $errors['pizzaName']?></div>
		</div>
		<div class="form-group">
			<label for="ingredients">
				Ingredients
			</label>
			<input type="text" name="ingredients" class="form-control" value="<?php echo $ingredients?>">
			<div class="text-danger"><?php echo $errors['ingredients']?></div>
		</div>
		<input type="submit" name="submit" value="Submit" class="btn btn-primary mb-2"></button>
	</form>
	<?php include('templates/footer.php') ?>
</html>