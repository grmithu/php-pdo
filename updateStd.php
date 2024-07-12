<?php
	include "lib/db.php";
  	include "inc/header.php";
?>


	<?php
		$id = $_GET['id'];
		$db = new Database();
		$table = "users";

		$whereCondition = array(
			'where'	=> array('id' => $id),
			'return_type'	=> 'single'
		);
		$value = $db->select($table, $whereCondition);

		if ( !empty($value) ){ ?>

			<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Update Student Info</h2>
				

					<form action="lib/users.php" method="POST">
						<div class="form-group">
							<label>Full Name</label>
							<input type="text" name="name" class="form-control" value="<?php echo $value['name']; ?>">
						</div>

						<div class="form-group">
							<label>Email Address</label>
							<input type="email" name="email" class="form-control" value="<?php echo $value['email']; ?>">
						</div>

						<div class="form-group">
							<label>Phone No</label>
							<input type="text" name="phone" class="form-control" value="<?php echo $value['phone']; ?>">
						</div>

						<div class="form-group">
							<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
							<input type="hidden" name="action" value="edit">
							<input type="submit" name="editStd" value="Save Changes" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

		<?php }

	?>

	


<?php
  include "inc/footer.php";
?>