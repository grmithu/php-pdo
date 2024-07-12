<?php
	include "lib/db.php";
  	include "inc/header.php";
?>


	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					
					<table class="table table-bordered table-stripped">
					  <thead class="thead-dark">
					    <tr>
					      <th scope="col">#Sl.</th>
					      <th scope="col">Full Name</th>
					      <th scope="col">Email Address</th>
					      <th scope="col">Phone No</th>
					      <th scope="col">Action</th>
					    </tr>
					  </thead>
					  <tbody>

					  	<?php
					  		$db = new Database;
					  		$table = "users";
					  		$order_by = array('order_by' => 'id DESC');

					  		$allStudents = $data = $db->select($table, $order_by);
					  		if ( !empty($allStudents) )
					  		{
					  			$i = 0;
					  			foreach ($allStudents as $student) {
					  				$i++;
					  			?>

					  			<tr>
							      <th scope="row"><?php echo $i; ?></th>
							      <td><?php echo $student['name']; ?></td>
							      <td><?php echo $student['email']; ?></td>
							      <td><?php echo $student['phone']; ?></td>
							      <td>
							      	<div class="btn-group">
							      		<a href="updateStd.php?id=<?php echo $student['id']; ?>" class="btn btn-success btn-sm">Update</a>
							      		<a href="lib/users.php?action=delete&id=<?php echo $student['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
							      	</div>
							      </td>
							    </tr>

					  		<?php	}
					  		}
					  	?>

						    
					    
					  </tbody>
					</table>

					<a href="addStd.php">Register New Student</a>

				</div>
			</div>
		</div>
	</section>


<?php
  include "inc/footer.php";
?>