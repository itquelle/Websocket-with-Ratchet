<?php
class chatrooms extends DbConnect{

    private $id;
    private $userId;
    private $msg;
    private $createdOn;
    public $dbConn;

    function setId($id){ $this->id = $id; }
    function getId(){ return $this->id; }
    function setUserId($userId){ $this->userId = $userId; }
    function getUserId(){ return $this->userId; }
    function setMsg($msg){ $this->msg = $msg; }
    function getMsg(){ return $this->msg; }
    function setCreatedOn($createdOn){ $this->createdOn = $createdOn; }
    function getCreatedOn(){ return $this->createdOn; }

    public function __construct(){
        parent::__construct();
    }

    public function saveChatRoom(){
        echo $this->msg;
        //$this->db->query("INSERT INTO chatrooms SET userid = '".$this->userId."', msg = '".$this->msg."', created_on = '".time()."'");
    }

    public function getAllChatRooms(){

        return $this->db->query("
            SELECT      c.*, u.name
            FROM        chatrooms c 
            JOIN        users u ON (c.userid = u.id)
            ORDER BY    c.id DESC
        ")->fetchAll();

    }

}