<?php 
	$conn = mysqli_connect("localhost", "sanjay", "sanjay", "php_learning");

	if (!$conn) {
		echo "Error connecting database:".mysqli_connect_error();
	} 

	if (isset($_POST['delete_id'])) {
		$deleteId = $_POST['delete_id'];
		echo $deleteId;
		$query = "DELETE FROM pizzas WHERE id=$deleteId";

		echo $query;

		if (mysqli_query($conn, $query)) {
			header('Location:/');
		} else {
			echo mysqli_error($conn);
		}
	} 
 ?>
<html>

	<?php include('templates/header.php') ?>
	<?php 
		$result = mysqli_query($conn, 'select * from pizzas');

		$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

		if (count($pizzas) > 0) {
	?>
		<table class="table">
			<thead>
				<tr>
					<th scope="col"> Name </th>
					<th scope="col"> Email </th>
					<th scope="col"> Ingredients </th>
					<th scope="col"> Created At </th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($pizzas as $pizza) {
				?>
				<tr>
					<td><?php echo $pizza['name']	?></td>
					<td><?php echo $pizza['email']	?></td>
					<td>
						<ul>
							<?php 
								$ingredients = explode(",", $pizza['ingredients']);
								foreach ($ingredients as $ingredient) {
							?>
							<li>
								<?php
										echo $ingredient;
								?>
							</li>
							<?php } ?>
						</ul>					
					</td>
					<td><?php echo $pizza['created_at']	?></td>
					<td>
						<form action="/" method="POST">
							<input type="hidden" name="delete_id" value="<?php echo $pizza['id'] ?>">
							<button type="submit" value="DELETE" class="btn btn-danger">DELETE</button>
						</form>
					</td>
				</tr>
				<?php 
					}
				?>
			</tbody>
		</table>
	<?php
		}
 	?>
	<?php include('templates/footer.php') ?>

</html>