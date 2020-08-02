<?php

	class Database{
		
		private $host = 'localhost';
		private $user = 'id14517495_rosecake';
		private $password = '@Normarosita161197';
		private $database = 'id14517495_dapoerrosecake';
		
		public function koneksi(){
		
				try{
					$conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
                    return $conn;
				}
				catch(PDOException $e){
					echo "Koneksi gagal : " . $e->getMessage();
				}
		
		}
	
	}

