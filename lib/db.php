<?php

	// OOP + PDO 

	class Database
	{
		private $dbhost = "localhost";
		private $dbuser = "root";
		private $dbpass = "";
		private $dbname = "ssb275oop";
		private $pdo;


		function __construct()
		{
			if ( !isset($this->pdo) )
			{
				try
				{
					$link = new PDO("mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname, $this->dbuser, $this->dbpass );
					$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$link->exec("SET CHARACTER SET utf8");

					// Assign the value into the PDO 
					$this->pdo = $link;

				} 
				catch( PDOException $e )
				{
					die("MySQL Connection Failed. " . $e->getMessage() );
				}
			}
		}



		// $sql = "SELECT * FROM tablename WHERE cl_name = '$cl_value' AND cl_name = '$cl_value' LIMIT 1,5 ORDER BY DESC";

		public function select( $table, $data = array() )
		{
			$sql = 'SELECT ';
			$sql .= array_key_exists("select", $data) ? $data['select'] : '*';
			$sql .= ' FROM ' . $table;

			// WHERE Condition Check
			if ( array_key_exists("where", $data) ){
				$sql .= ' WHERE ';
				$i = 0;
				foreach ($data['where'] as $key => $value) {
					$add = ( $i > 0 ) ? ' AND ' : '';
					$sql .= "$add" . "$key=$value";
					$i++;
				}
			}

			// ORDER Check
			if ( array_key_exists("order_by", $data) ){
				$sql .= ' ORDER BY ' . $data['order_by'];
			}

			// Prepare the SQL Line using PDO
			$query = $this->pdo->prepare($sql);

			if ( array_key_exists("where", $data) ){
				foreach ($data['where'] as $key => $value) {
					$query->bindValue(":$key", $value);
				}
			}

			$query->execute();

			if ( array_key_exists('return_type', $data) )
			{
				switch ( $data['return_type'] ) {
					case 'count':
						$value = $query->rowCount();
						break;

					case 'single':
						$value = $query->fetch(PDO::FETCH_ASSOC);
						break;
					
					default:
						$value = "Sorry! No record found in Database";
						break;
				}
			}
			else
			{
				if ( $query->rowCount() > 0 )
				{
					$value = $query->fetchAll();
				}
			}
			return !empty($value)?$value:false;
		}



		// INSERT INTO users (name, email, phone) VALUES (':name', ':email', ':phone');
		public function insert( $table, $data )
		{
			// $key 	= '';
			// $value 	= '';
			// $i 		= 0;

			$keys = implode(',', array_keys($data));
			$values = ":" . implode(', :', array_keys($data));
			$sql = "INSERT INTO " . $table . " (" . $keys . ") VALUES (" . $values . ")";
			$query = $this->pdo->prepare($sql);

			foreach( $data as $key => $val ){
				$query->bindValue(":$key", $val);
			}

			$insertData = $query->execute();

			if ( $insertData ){
				$lastID = $this->pdo->lastInsertID();
				return $lastID;
			}	
			else{
				return false;
			}
		}


		// UPDATE users SET name=':$name', email=':$email', phone=':$phone' WHERE id = '$id';

		public function update( $table, $data, $condition )
		{
			if ( !empty($data) && is_array($data) )
			{
				$keyValue = ''; 
				$whereCond = ''; 
				$i = 0;

				foreach( $data as $key => $val ){
					$add = ( $i > 0 ) ? ' , ' : '';
					$keyValue .= "$add" . "$key='$val'";
					$i++;
				} 

				if ( !empty( $condition ) && is_array($condition) )
				{
					$whereCond .= " WHERE ";
					$i=0;
					foreach( $condition as $key => $val ){
						$add = ( $i > 0 ) ? ' AND ' : '';
						$whereCond .= "$add" . "$key=$val";
						$i++;
					}
				}

				$sql = "UPDATE " . $table . " SET " . $keyValue . " " . $whereCond;

				$query = $this->pdo->prepare($sql);

				foreach( $data as $key => $val ){
					$query->bindValue(":$key", $val);
				}

				foreach( $condition as $key => $val ){
					$query->bindValue(":$key", $val);
				}


				// var_dump($sql);
				// exit();

				$update = $query->execute();
				return $update?$query->rowCount():false;
			}
			else{
				return false;
			}

		}


		// DELETE FROM users WHERE id = '1';
		public function delete( $table, $data )
		{
			if ( !empty( $data ) && is_array($data) )
			{
				$whereCond .= " WHERE ";
				$i = 0;
				foreach( $data as $key => $val ){
					$add = ( $i > 0 ) ? ' AND ' : '';
					$whereCond .= $add.$key . " = ' " . $val . " '";
					$i++;
				} 

				$sql = "DELETE FROM " . $table . $whereCond;
				$delete = $this->pdo->exec($sql);
				return $delete?true:false;
			}
		}







	}

?>