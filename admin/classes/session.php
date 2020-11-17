<?php
class session {
    private $signed_in = false;
    public $user_id;
    public $count;
    public $msg;

    public function __construct(){
        session_start();
        $this->check_login();
        $this->check_message();
    }

    public function visitor_count (){
        if(isset($_SESSION['count_visit'])){
            return $this->count = ++$_SESSION['count_visit'];
        }else{
            return $this->count = $_SESSION['count_visit'] = 1;
        }
    }

    public function message($msg=""){
        if(!empty($msg)){ //set message
            $_SESSION['message'] = $msg;
        }else{  //get message
            return $this->msg;
        }
    }

    private function check_message(){
        if(isset($_SESSION['message'])){ //check if you have message when reload page
            $this->msg = $_SESSION['message'];
            unset($_SESSION['message']);
        }else{
            $this->msg = "";
        }
    }

    public function get_signed_in (){
        return $this->signed_in;
    }

    public function login($user) {
        if($user) {
            $this->user_id = $_SESSION['userid'] = $user->id;
            $this->signed_in=true;
        }
    }

    private function check_login() {
        if (isset($_SESSION['userid'])) {
            $this->user_id = $_SESSION['userid'];
            $this->signed_in=true;
        }else{
            
            unset($this->user_id);
            $this->signed_in=false;
        }
    }

    public function logout() {
        if(isset($_SESSION['userid']) && $this->signed_in=true) {
            unset($_SESSION['userid']);
            unset($this->user_id);
            $this->signed_in=false;
        }
    }

}

?>
