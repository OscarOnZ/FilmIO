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

        /**
         * User constructor.
         */
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

        /**
         * @param User $user
         * @return bool
         *
         */
        public function existsInDB($user){
            global $client;
            //Check User doesn't exist.
            
            $query = "MATCH(n:User) WHERE n.username = '" . $user->_username . "' RETURN COUNT(n) AS no;";
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
            if($this->existsInDB($this)){
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
                if($record != null){ //
                    $filmsLiked[] = new Film($record->value("ID"));
                }
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
                $client->run("MATCH(u:User), (u1:User) WHERE u.username = '" . $this->_username . "' AND u1.username ='" . $user->getUsername() . "' CREATE (u)-[:friendRequest]->(u1)");
            }
        }

        /**
         * @param User $user
         */
        public function acceptFriendRequest($user){
            if($this->existsInDB($user)){
                if($this->checkRelationExists($user,"friendReq")){
                    global $client;
                    $client->run("MATCH (u1:User)-[r:friendRequest]->(u:User) WHERE u1.username = '" . $user->getUsername() . "' AND u.username = '" . $this->_username . "' DELETE r");
                    $client->run("MATCH(u:User), (u1:User) WHERE u.username = '" . $this->_username . "' AND u1.username ='" . $user->getUsername() . "' CREATE (u)-[:friends]-(u1)");
                }

            }
        }
        /**
         * @param User $user
         */
        public function denyFriendRequest($user){
            if($this->existsInDB($user)){
                if($this->checkRelationExists($user,"friendReq")){
                    global $client;
                    $client->run("MATCH (u1:User)-[r:friendRequest]->(u:User) WHERE u1.username = '" . $user->getUsername() . "' AND u.username = '" . $this->_username . "' DELETE r");
                }
            }
        }
        /**
         * @param User $user
         */
        public function unfriend($user){
            if($this->existsInDB($user)){
                if($this->checkRelationExists($user, "friends")){
                    global $client;
                    $client->run("MATCH (u1:User)-[r:friends]-(u:User) WHERE u1.username = '" . $user->getUsername() . "' AND u.username = '" . $this->_username . "' DELETE r");
                }
            }
        }

        /**
         * @param Film $film
         * @return int;
         */
        public function likes($film){
            if(!$this->checkRelationExists($film, "likes")){
                global $client;
                try{
                    $client->run('MATCH(u:User),(f:Film) WHERE u.username="' . $this->_username .'" AND f.ID="'. $film->getFilmID() .'" CREATE (u)-[r:likes]->(f)');
                    return 1; //Success
                }catch(Exception $e) {
                    return 0; //Error Code - Failed
                }
            }else{
                return -1; //Error Code - Already Exists
            }
        }

        /**
         * @param Film $film
         * @return int;
         */
        public function dislikes($film){
            if(!$this->checkRelationExists($film, "dislikes")){
                global $client;
                try{
                    $client->run('MATCH(u:User),(f:Film) WHERE u.username="' . $this->_username .'" AND f.ID="'. $film->getFilmID() .'" CREATE (u)-[r:dislikes]->(f)');
                    return 1; //Success
                }catch(Exception $e) {
                    return 0; //Error Code - Failed
                }
            }else{
                return -1; //Error Code - Already Exists
            }
        }



        /**
         * @param object $subject
         * @param string $linkType
         * @return bool
         */
        public function checkRelationExists($subject, $linkType){
            if($linkType == "friends" || $linkType == "likes" || $linkType == "dislikes" || $linkType == "friendReq"){
                global $client;
                if(get_class($subject) == "Film"){
                    $result = $client->run('MATCH(u:User)-[r:'. $linkType . ']->(f:Film) WHERE u.username ="' . $this->_username . '" AND f.ID="' . $subject->getFilmID() . '"RETURN COUNT(r) as no');
                    $number = $result->firstRecord()->value('no');

                }else if(get_class($subject) == "User" && $linkType == "friends"){
                    $result = $client->run('MATCH(u:User)-[r:'. $linkType . ']-(u1:User) WHERE u.username ="' . $this->_username . '" AND u1.username="' . $subject->getUsername() . '"RETURN COUNT(r) as no');
                    $number = $result->firstRecord()->value('no');
                }
            else if(get_class($subject) == "User" && $linkType == "friendReq"){
                    $result = $client->run('MATCH(u1:User)-[r:'. $linkType . ']->(u:User) WHERE u.username ="' . $this->_username . '" AND u1.username="' . $subject->getUsername() . '"RETURN COUNT(r) as no');
                    $number = $result->firstRecord()->value('no');
                }else{
                    $number = 0;
                }

                if($number > 0){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }

        public function getRecommendations(){
            $recFilms = array();
            $topFilms = [new Film("0111161"),
                        new Film("0068646"),
                        new Film("0071562"),
                        new Film("0468569"),
                        new Film("0050083"),
                        new Film("0108052")];



            //TODO
            //METHOD
            //1. Get all films user has liked.
            //2. Check if any of the user's friends like that film
            //IF has friends
            //3. Recommend a film that the friend likes
            //ELSE
            //4. Recommend a top film
            //6. RETURN 5 films

            //1.
            $filmsLiked = $this->getLikes();
            $filmsDisliked = $this->getDislikes();
            //2.
            $friends = $this->getFriends();

            if(count($friends) > 0 && count($filmsLiked) > 0){

                foreach($friends as $friend){ //For every friend
                    $friendsLikedFilms = $friend->getLikes(); //Get the films they like
                    foreach($filmsLiked as $film){ //For each of the films found

                        if(in_array($film, $friendsLikedFilms)){ //Check if any friends liked that film
                            //3.
                            foreach ($friendsLikedFilms as $friendFilm){ //For each film the friend liked
                                if(!in_array($friendFilm, $filmsDisliked) && !in_array($friendFilm, $filmsLiked) && !in_array($friendFilm, $recFilms)){ // make sure i haven't seen it
                                    $recFilms[] = $friendFilm;
                                }

                            }

                        }
                    }
                }






            }
            if(count($recFilms) < 5 || $recFilms == null){
                for ($i = 0; $i < 6 - count($recFilms); $i++){
                    if(!in_array($topFilms[$i], $filmsDisliked) && !in_array($topFilms[$i], $filmsLiked) && !in_array($topFilms[$i], $recFilms)){
                        $recFilms[] = $topFilms[$i];
                    }
                }
            }


            //             $freqs = array_count_values($recFilms);
            //             $recFilmsFreq = array();
            //             foreach($recFilms as $film){
            //                 $recFilmsFreq = [
            //                     $film => $freqs[$film]


            //                 ];
            //             }

            return $recFilms;


            //Get all users that like that film
            //Recommend film that them users like
            //RETURN 5 films

            //6.
        }



    }
    
    

