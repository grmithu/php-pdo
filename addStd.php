<?php
	include "lib/db.php";
  	include "inc/header.php";
?>


	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Add New Student</h2>

					<form action="lib/users.php" method="POST">
						<div class="form-group">
							<label>Full Name</label>
							<input type="text" name="name" class="form-control">
						</div>

						<div class="form-group">
							<label>Email Address</label>
							<input type="email" name="email" class="form-control">
						</div>

						<div class="form-group">
							<label>Phone No</label>
							<input type="text" name="phone" class="form-control">
						</div>

						<div class="form-group">
							<input type="hidden" name="action" value="add">
							<input type="submit" name="addStd" value="Register Student" class="btn btn-primary">
						</div>



					</form>
				</div>
			</div>
		</div>
	</section>

<?php
  include "inc/footer.php";
?>