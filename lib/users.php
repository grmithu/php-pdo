<?php
	include "db.php";

	$db = new Database();
	$table = "users";

	if ( isset($_REQUEST['action']) && !empty($_REQUEST['action']) )
	{
		if ( $_REQUEST['action'] == 'add' )
		{
			$data = array(
				'name' 		=> $_POST['name'],
				'email' 	=> $_POST['email'],
				'phone' 	=> $_POST['phone'],
			);

			$insert = $db->insert($table, $data);

			// Send Message Through Session
			if ( $insert ){
				$msg = "Registered Successfully";
			}
			else{
				$msg = "Operation Failed";
			}

			$homeUrl = '../index.php';
			header("Location: " . $homeUrl);
		}
		else if ( $_REQUEST['action'] == 'edit' )
		{
			$id = $_POST['id'];
			if ( !empty($id) )
			{
				$data = array(
					'name' 		=> $_POST['name'],
					'email' 	=> $_POST['email'],
					'phone' 	=> $_POST['phone'],
				);

				$table = 'users';
				$condition = array( 'id' => $id );
				$update = $db->update($table, $data, $condition);

				// Send Message Through Session
				if ( $update ){
					$msg = "Updated Successfully";
				}
				else{
					$msg = "Operation Failed";
				}

				$homeUrl = '../index.php';
				header("Location: " . $homeUrl);

			}
		}
		else if ( $_REQUEST['action'] == 'delete' ){
			$id = $_GET['id'];
			if ( !empty($id) )
			{
				$table = "users";
				$condition = array('id' => $id);
				$delete = $db->delete($table, $condition);

				if ( $delete ){
					$msg = "Deleted Successfully";
				}
				else{
					$msg = "Operation Failed";
				}

				$homeUrl = '../index.php';
				header("Location: " . $homeUrl);
			}
		}
	}
?>