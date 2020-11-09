<?php
class session {
    private $signed_in = false;
    public $user_id;

    public function __construct(){
        session_start();
        $this->check_login();
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
            session_unset();
            session_destroy();
            unset($this->user_id);
            $this->signed_in=false;
        }
    }

}

?>
