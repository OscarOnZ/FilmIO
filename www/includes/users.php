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
        private $_firstName;
        private $_secondName;



        /**
         * @return mixed
         */
        public function getFirstName()
        {
            return $this->_firstName;
        }

        /**
         * @param mixed $firstName
         */
        public function setFirstName($firstName)
        {
            $this->_firstName = $firstName;
        }

        /**
         * @return mixed
         */
        public function getSecondName()
        {
            return $this->_secondName;
        }

        /**
         * @param mixed $secondName
         */
        public function setSecondName($secondName)
        {
            $this->_secondName = $secondName;
        }

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
         * Can take up to 6 arguments - however can take less.
         * Php doesn't support overloading methods, therefore func_num_args is used.
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

                $result = $client->run("MATCH (n:User) WHERE n.username = '" . $this->_username ."' RETURN
                 n.dateCreated as DateCreated, n.DOB as DOB, n.email as Email, n.fullName as FullName");
                $this->_dateCreated = $result->firstRecord()->value("DateCreated");
                $this->_dob = $result->firstRecord()->value("DOB");
                $this->_email= $result->firstRecord()->value("Email");
                $this->_fullName = $result->firstRecord()->value("FullName");
                $this->splitName();
            }
            
            
            
        }

        /**
         * @param $newPassword
         * @return bool
         */
        public function changePassword($newPassword){
            global $client;
            $pw = password_hash($newPassword, PASSWORD_DEFAULT);
            if($client->run("MATCH (n:User) WHERE n.username= '" . $this->getUsername() . "' SET n.password= '"
                . $pw . "'")){
                return true;
            }else{
                return false;
            }


    }

        private function splitName(){
            $fullName = trim($this->_fullName);
            $this->_secondName = (strpos($fullName, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#'
                , '$1', $fullName);
            $this->_firstName = trim( preg_replace('#'.$this->_secondName.'#', '', $fullName ) );
        }

        /**
         * @param User $user
         * @return bool
         *
         */
        public function existsInDB($user){
            global $client;
            //Check User doesn't exist.
            
            $query = "MATCH(n:User) WHERE n.username = '" . $user->_username . "' RETURN COUNT(n) AS no";
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
         * Pushes user class onto DB
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
            $result = $client->run('MATCH(u:User), (u1:User) WHERE (u)-[:friends]-(u1) AND u.username="'
                . $this->_username . '" RETURN u1, COUNT(u1) as no');
            try{
                if($result->firstRecord() != null){
                    $number = $result->firstRecord()->value("no");
                }else{
                    return 0;
                }

            }catch(UnexpectedValueException $e){
                return 0;
            }

            return $number;
        }

        /**
         * @return Film[]
         */
        public function getLikes(){
            global $client;
            $filmsLiked = array();
            $result = $client->run('MATCH(u:User), (f:Film) WHERE (u)-[:likes]->(f) AND u.username="'
                . $this->_username .'" RETURN f, f.ID as ID, COUNT(f) as no');
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
            $result = $client->run('MATCH(u:User), (f:Film) WHERE (u)-[:dislikes]->(f) AND u.username="'
                . $this->_username .'" RETURN f, f.ID as ID, COUNT(f) as no');
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
                $client->run("MATCH(u:User), (u1:User) WHERE u.username = '" . $this->_username .
                    "' AND u1.username ='" . $user->getUsername() . "' CREATE (u)-[:friendRequest]->(u1)");
            }
        }

        /**
         *
         * First delete the friend request
         * Second make the friend link
         * @param User $user
         */
        public function acceptFriendRequest($user){
                    global $client;
                    $client->run("MATCH (u1:User)-[r:friendRequest]->(u:User) WHERE u1.username = '"
                        . $user->getUsername() . "' AND u.username = '" . $this->_username . "' DELETE r");
                    $client->run("MATCH(u:User), (u1:User) WHERE u.username = '" . $this->_username
                        . "' AND u1.username ='" . $user->getUsername() . "' CREATE (u)-[:friends]->(u1)");

        }
        /**
         * @param User $user
         */
        public function denyFriendRequest($user){
            global $client;
            $client->run("MATCH (u1:User)-[r:friendRequest]->(u:User) WHERE u1.username = '"
                . $user->getUsername() . "' AND u.username = '" . $this->_username . "' DELETE r");
        }

        /**
         * @param User $user
         * @return bool
         */
        public function withdrawFriendRequest($user){
            if($this->existsInDB($user)){
                    global $client;
                    $client->run("MATCH (u:User)-[r:friendRequest]->(u1:User) WHERE u.username = '"
                        . $this->getUsername() . "' AND u1.username = '" . $user->getUsername() . "' DELETE r");
                    return true;
            }
        }

        /**
         * @param User $user
         */
        public function unfriend($user){
            if($this->existsInDB($user)){
                if($this->checkRelationExists($user, "friends")){
                    global $client;
                    $client->run("MATCH (u1:User)-[r:friends]-(u:User) WHERE u1.username = '"
                        . $user->getUsername() . "' AND u.username = '" . $this->_username . "' DELETE r");
                }
            }
        }

        /**
         * @return User[]
         */
        public function getSentFriendRequests(){
            global $client;
            $users = array();
            $result = $client->run('MATCH(u:User), (u1:User) WHERE (u)-[:friendRequest]->(u1) AND u.username="'
                . $this->getUsername() . '" RETURN u1.username as username');
            foreach ($result->records() as $record){
                if($record != null){ //
                    $users[] = new User($record->value("username"));
                }else{
                }
            }
            return $users;
        }

        /**
         * @return User[]
         */
        public function getFriendRequests(){
            global $client;
            $users = array();
            $result = $client->run('MATCH(u:User), (u1:User) WHERE (u1)-[:friendRequest]->(u) AND u.username="'
                . $this->getUsername() . '" RETURN u1.username as username');
            foreach ($result->records() as $record){
                if($record != null){ //
                    $users[] = new User($record->value("username"));
                }else{
                }
            }
            return $users;
        }


        /**
         * @param Film $film
         * @return int;
         */
        public function likes($film){
            if(!$this->checkRelationExists($film, "likes")){
                global $client;
                try{
                    $client->run('MATCH(u:User),(f:Film) WHERE u.username="' . $this->_username .'" AND f.ID="'.
                        $film->getFilmID() .'" CREATE (u)-[r:likes]->(f)');
                    $this->notifyFriends($film);
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
                    $client->run('MATCH(u:User),(f:Film) WHERE u.username="' . $this->_username .'" AND f.ID="'.
                        $film->getFilmID() .'" CREATE (u)-[r:dislikes]->(f)');
                    $this->notifyFriends($film);
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

        /**
         * @return Film[]
         */
        public function newGetRecommendations(){
            //Method

            //1. Get the users friends
            //2. Associate a score with each of these friends
            //3. Get all the films that the user's friends like
            //4. Get all the films the user likes
            //5. Foreach film that the user likes and their friend likes, add 1 to that friend's score.
            //6. Foreach film that the user dislikes and their friend likes, take 1 from that friend's score.
            //6. For the top friends, look at the films they like minus the films the user has seen.
            //7. Associate a score with each of these films
            //8. The score of each film is the number of times that that film appears in the top friends' lists.
            //9. IF 5 films are not found from the top 3 friends, extend to the top 5 friends, then the top 10 friends.




            //Implementation

            //1 & 2
            //friends[friendNumber]["friend"] returns friend class
            //friends[friendNumber]['score'] returns friend score
            //friends[friendNumber]['films'] returns the films that friend likes
            $friends = array();
            $nFriends = 0;
            foreach($this->getFriends() as $friend){
                $friends[] = array("friend" => $friend, "score" => 0, "films" => $friend->getLikes());
                $nFriends++;
            }

            if($nFriends == 0){ //Algorithm won't work without friends, we'll just have to recommend generic films.
                $topFilms = array_column(getGlobalFilmList(5), 0);
                return $topFilms;
            }

            $userLikes = $this->getLikes();

            $userDislikes = $this->getDislikes();

            //thisFriend['score'] returns friend score
            //thisFriend['films'] returns the films that friend likes



                for($i = 0; $i < $nFriends; $i++){
                    foreach($friends[$i]['films'] as $thisFilm){
                        if(in_array($thisFilm, $userLikes)){
                            $friends[$i]['score']++;
                            //echo $friends[$i]['friend']->getUsername() . " score increased to " . $friends[$i]['score'] . "\n";
                        }
                        else if(in_array($thisFilm, $userDislikes)){
                            $friends[$i]['score']--;
                            //echo $friends[$i]['friend']->getUsername() . " score decreased to " . $friends[$i]['score'] . "\n";
                        }
                    }
                }




            usort($friends, function($a, $b) {
                return $a['score'] <=> $b['score'];
            });


            //6
            $nFriendsToLookAt = 0;
            if($nFriends > 3) {
                $nFriendsToLookAt = 3;
            }else{
                $nFriendsToLookAt = $nFriends;
            }

            $allFilmsUserSeen = array_merge($userLikes, $userDislikes);
            $recommendedFilms = $this->getXFilms(5, $nFriendsToLookAt, $friends, $nFriends);
            $finalFilms = [];
            foreach($recommendedFilms as $film){
                if(!in_array($film, $allFilmsUserSeen)){
                    $finalFilms[] = $film;
                }
            }
            return $finalFilms;

        }

        /**
         * @param int $x
         * @param int $n
         * @param Friend[] $friends
         * @param int $nFriends
         * @return Film[]
         */
        private function getXFilms($x, $n, $friends, $nFriends){
            $topFilms = [];
            for ($i = 0; $i < $n; $i++){
                foreach($friends[$i]['films'] as $thisFilm){
                    if(in_array($thisFilm, $topFilms)){
                        $key = array_search(($thisFilm), $topFilms);
                        $topFilms[$key]['score']++;
                    }else{
                        $topFilms[] = array($thisFilm, "score" => 0);
                    }
                }
            }

            if($topFilms > $x){
                //found enough films
                return array_column($topFilms, 0);
            }
            else{ //not enough films found
                if($n + 2 > $nFriends){
                    return array_column($topFilms, 0);
                }else{
                    $this->getXFilms($x, $n + 2, $friends, $nFriends);
                }

            }


        }

        //UNIMPLEMENTED CODE

        /**
         * @return Toast[]
         */
        public function getToasts(){
            global $client;
            $result = $client->run("MATCH (n:User) WHERE n.username = '" . $this->getUsername() .
                "' RETURN n.toasts as serial");
            $serial = $result->firstRecord()->value("serial");
            $toasts = unserialize(base64_decode($serial));
            return $toasts;
        }

        /**
         * @return array
         */
        public function getUnviewedToasts(){
            $unviewed = [];
            $toasts = $this->getToasts();
            for($i = 0; $i < count($toasts) - 1; $i++){
                if(!$toasts[$i]->getViewed()){
                    $unviewed[] = $toasts[$i];
                    $toasts[$i]->setViewed();
                }
            }
            return $unviewed;
        }

        public function setToasts($toasts){
            global $client;
            $serial = base64_encode(serialize($toasts));
            $client->run("MATCH (n:User) WHERE n.username='" . $this->getUsername() . "' SET n.toasts ='" . $serial . "''");
        }

        public function notifyFriends($film){
            $thisToast = new Toast($this->getUsername(), $film->getFilmName, false);
            $friends = $this->getFriends();
            foreach ($friends as $friend){
                $toasts = $this->getToasts();
                $toasts[] = $thisToast;
                $friend->setToasts($toasts);
            }
        }





    }





    
    

