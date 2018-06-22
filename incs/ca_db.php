

<?php
     class Database{
         private $servername="localhost";
         private $dbusername="root";
         private $dbpassword="";
         private $database="artisan_test_db";
         private $socket_type="mysql";
         private $instance= null; //the actual instance of the class

         // constrcutor is used to make db connection using PDO
         protected function _construct(){
             if($this->instance==null){
                 try{
                    $db = new PDO(
                     ''.$this->socket_type.':servername='.$this->servername.';dbusername='.
                     $this->dbusername.'', $this->dbpassword, $this->database);

                    $this->instance=$db;
                 }catch(PDOException $e){
                        die($e->getMessage());
                 }
             }
             
         }
         public function query($sql){
            $query = $this->instance->prepare($sql);
            $query->execute();
            return $query;
         }
         

     }
?>