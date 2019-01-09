<?php

    
require_once 'db_connect.php';
    
    class User
    {
        
        private $_username;
        private $_password;
        private $_email;
        private $_dob;
        private $_dateCreated;
        private $_fullName;
        /**
         * @return string
         */
        public function getFullName()
        {
            return $this->_fullName;
        }
    
        /**
         * @return string
         */
        public function getUsername()
        {
            return $this->_username;
        }
        
        /**
         * @return string
         */
        public function getPassword()
        {
            return $this->_password;
        }
        
        /**
         * @return string
         */
        public function getEmail()
        {
            return $this->_email;
        }
        
        /**
         * @return DateTime
         */
        public function getDob()
        {
            return $this->_dob;
        }
        
        /**
         * @return DateTime
         */
        public function getDateCreated()
        {
            return $this->_dateCreated;
        }
        
        /**
         * @param string $username
         */
        public function setUsername($username)
        {
            $this->_username = $username;
        }
        
        /**
         * @param string $password
         */
        public function setPassword($password)
        {
            $this->_password = $password;
        }
        
        /**
         * @param string $email
         */
        public function setEmail($email)
        {
            $this->_email = $email;
        }
        
        /**
         * @param DateTime $dob
         */
        public function setDob($dob)
        {
            $this->_dob = $dob;
        }
        
        /**
         * @param DateTime $dateCreated
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
            else if($numargs == 2){

                $this->_username = func_get_arg(0);
                $this->_password = password_hash(func_get_arg(1), PASSWORD_DEFAULT);

            }
            else{
                $this->_username =func_get_arg(0);
                global $client;

                //Get non-sensitive data from db (not the hashed password)

                $result = $client->run("MATCH (n:User) WHERE n.username = '" . $this->_username ."' RETURN n.dateCreated as DateCreated, n.DOB as DOB, n.email as Email, n.fullName as FullName");
                $this->_dateCreated = $result->firstRecord()->value("DateCreated");
                $this->_dob = $result->firstRecord()->value("DOB");
                $this->_email= $result->firstRecord()->value("Email");
                $this->_fullName = $result->firstRecord()->value("FullName");
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

        /**
         * @return bool
         */
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

        /**
         * @return User[]
         */
        public function getFriends(){
            global $client;
            $friends = array();
            $result = $client->run('MATCH(u:User), (u1:User) WHERE (u)-[:friends]-(u1) AND u.username="' . $this->_username . '" RETURN u1, u1.username as Username, COUNT(u1) as no');
            foreach ($result->records() as $record){
                $thisUser = new User($record->value("Username"));
                $friends[] = $thisUser;
            }
            return $friends;
        }

        /**
         * @return integer
         */
        public function getNumberOfFriends(){
            global $client;
            $friends = array();
            $result = $client->run('MATCH(u:User), (u1:User) WHERE (u)-[:friends]-(u1) AND u.username="' . $this->_username . '" RETURN u1, COUNT(u1) as no');
            $number = $result->firstRecord()->value("no");
            return $number;
        }

        /**
         * @return Film[]
         */
        public function getLikes(){
            global $client;
            $filmsLiked = array();
            $result = $client->run('MATCH(u:User), (f:Film) WHERE (u)-[:likes]->(f) AND u.username="'. $this->_username .'" RETURN f, f.ID as ID, COUNT(f) as no');
            foreach ($result->records() as $record){
                $filmsLiked[] = new Film($record->value("ID"));
            }
            return $filmsLiked;
        }

        /**
         * @return Film[]
         */
        public function getDislikes(){
            global $client;
            $filmsLiked = array();
            $result = $client->run('MATCH(u:User), (f:Film) WHERE (u)-[:dislikes]->(f) AND u.username="'. $this->_username .'" RETURN f, f.ID as ID, COUNT(f) as no');
            foreach ($result->records() as $record){
                $filmsLiked[] = new Film($record->value("ID"));
            }
            return $filmsLiked;
        }

        /**
         * @param User $user
         */
        public function sendFriendRequest($user){
            if($this->existsInDB($user)){
                global $client;
                $client->run("MATCH(u:User), (u1:User) WHERE u.username = '" . $this->_username . "' AND u1.username ='" . $user->getUsername() . "' CREATE (u)-[:friends]-(u1)");
            }
        }

        /**
         * @param $film Film
         */
        public function likes($film){

        }

        /**
         * @param $subject object
         * @param $linkType string
         */
        public function checkRelationExists($subject, $linkType){
            if($linkType == "friends" || $linkType == "likes" || $linkType == "dislikes" || $linkType == "friendreq"){
                if(get_class($subject) == "User"){


                }else if(get_class($subject) == "Film"){

                }else{

                }
            }

        }

    }
    
    

