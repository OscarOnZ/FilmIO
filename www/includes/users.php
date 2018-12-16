<?php

    
require 'db_connect.php';
    
    class user
    {
        
        private $_username;
        private $_password;
        private $_email;
        private $_dob;
        private $_dateCreated;
        private $_fullName;
        /**
         * @return mixed
         */
        public function getFullName()
        {
            return $this->_fullName;
        }
    
        /**
         * @return mixed
         */
        public function getUsername()
        {
            return $this->_username;
        }
        
        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->_password;
        }
        
        /**
         * @return mixed
         */
        public function getEmail()
        {
            return $this->_email;
        }
        
        /**
         * @return mixed
         */
        public function getDob()
        {
            return $this->_dob;
        }
        
        /**
         * @return mixed
         */
        public function getDateCreated()
        {
            return $this->_dateCreated;
        }
        
        /**
         * @param mixed $username
         */
        public function setUsername($username)
        {
            $this->_username = $username;
        }
        
        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->_password = $password;
        }
        
        /**
         * @param mixed $email
         */
        public function setEmail($email)
        {
            $this->_email = $email;
        }
        
        /**
         * @param mixed $dob
         */
        public function setDob($dob)
        {
            $this->_dob = $dob;
        }
        
        /**
         * @param mixed $dateCreated
         */
        public function setDateCreated($dateCreated)
        {
            $this->_dateCreated = $dateCreated;
        }
        
        function __construct() //$fullName, $username, $password, $email, $dob, $datecreated
        {
            $numargs = func_num_args();
            
            if($numargs > 2){
                $this->_fullName = func_get_arg(0);
                $this->_username = func_get_arg(1);
                $this->_password = password_hash(func_get_arg(2), PASSWORD_DEFAULT);
                $this->_email = func_get_arg(3);
                $this->_dob = func_get_arg(4);
                $this->_dateCreated = func_get_arg(5);
            }
            else{
                
                $this->_username = func_get_arg(0);
                $this->_password = password_hash(func_get_arg(1), PASSWORD_DEFAULT);
                
            }
            
            
            
        }   
        
        public function existsInDB(){
            global $client;
            //Check User doesn't exist.
            
            $query = "MATCH(n:User) WHERE n.username = '" . $this->_username . "' RETURN COUNT(n) AS no;";
            $result = $client->run($query);
            $noOfUsers = $result->firstRecord()->get('no');
            
            if($noOfUsers != 0){
                return true;
            }
            else{
                return false;
            }
        }
        
        public function createUser()
        {
            global $client;
            if($this->existsInDB()){
                return false;
            }
            else{
                $query = "CREATE (n:User{
            username: '". $this->_username ."',
            password: '". $this->_password ."',
            email: '". $this->_email ."',
            DOB: '". $this->_dob . "',
            dateCreated: '". $this->_dateCreated ."',
            fullName: '". $this->_fullName ."'
            
                })";
                try{
                    $client->run($query);
                    return true;
                }catch(Exception $e){
                    return false;
                }
                
            }
        }
    }
    
    

