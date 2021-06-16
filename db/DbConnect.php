<?php 
	class DbConnect {

        /**
         * @var PDO
         */
	    var $db;

        public $host = 'localhost';
        public $dbName = 'chatsocket';
        public $user = 'root';
        public $pass = '';

		public function __construct() {
			try {
				$this->db = new PDO("mysql:host=localhost;dbname=chatsocket;charset=utf8", $this->user, $this->pass, [
				    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => true
                ]);
			} catch( PDOException $e) {
			    $this->db = null;
				echo 'Database Error: ' . $e->getMessage();
			}
		}
	}