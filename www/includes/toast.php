<?php
/**
 * Copyright (c) Oscar Cameron 2019.
 */

/**
 * Created by PhpStorm.
 * User: oacam
 * Date: 22/01/2019
 * Time: 13:49
 */

class Toast
{

    private $_username;
    private $_filmName;
    private $viewed;

    /**
     * Toast constructor.
     * @param $_username
     * @param $_filmName
     * @param $viewed
     */


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->_username = $username;
    }


    /**
     * @return mixed
     */
    public function getFilmName()
    {
        return $this->_filmName;
    }

    /**
     * @param mixed $filmName
     */
    public function setFilmName($filmName): void
    {
        $this->_filmName = $filmName;
    }

    /**
     * @return mixed
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     * @param mixed $viewed
     */
    public function setViewed(){
        $this->viewed = true;
    }

    public function __construct($_username, $_filmName, $viewed)
    {
        $this->_username = $_username;
        $this->_filmName = $_filmName;
        $this->viewed = $viewed;
    }

}