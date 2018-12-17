<?php
require 'db_connect.php';

class Film{
    
    private $_name;
    private $_filmID;
    private $_year;
    private $_description;
    private $_imgPath;
    /**
     * @return mixed
     */
    public function getImgPath()
    {
        return $this->_imgPath;
    }

    /**
     * @param mixed $_imgPath
     */
    public function setImgPath($_imgPath)
    {
        $this->_imgPath = $_imgPath;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }
    

    /**
     * @return mixed
     */
    public function getFilmID()
    {
        return $this->_filmID;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param mixed $_name
     */
    public function setName($_name)
    {
        $this->_name = $_name;
    }

    /**
     * @param mixed $_filmID
     */
    public function setFilmID($_filmID)
    {
        $this->_filmID = $_filmID;
    }

    /**
     * @param mixed $_year
     */
    public function setYear($_year)
    {
        $this->_year = $_year;
    }

    /**
     * @param mixed $_description
     */
    public function setDescription($_description)
    {
        $this->_description = $_description;
    }
    
    function __construct($filmID){
        global $apiKey;
        $data = file_get_contents("http://www.omdbapi.com/?apikey=". $apiKey ."&i=tt". $filmID);
        $filmInfo = json_decode($data);
        $this->setName($filmInfo->Title);
        $this->setDescription($filmInfo->Plot);
        $this->setYear($filmInfo->Released);
        $this->setImgPath($filmInfo->Poster);
        $this->setFilmID($filmID);
        
    }

    
    
}