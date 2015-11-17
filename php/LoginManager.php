<?php
include_once('Connection.php');
include_once('User.php');
session_start();

/**
 * Description of LoginManager
 *
 * @author bryan
 */
class LoginManager {

    private $link;
    private $location;
    
    public function __construct($location) {
        $this->link = new Connection();
        $this->location = $location;
    }

    public function getLoginForm() {
        if (isset($_SESSION['auth'])) {
            $id = $_SESSION['auth'];
            $user = $this->link->getUsers([$id])[0];
            $username = $user->getUsername();
            
            $link = "'profile.php?id=".$id."'";
            $a = "<a href=$link>$username</a>";
            
            $loggedInAs = $this->tag("p", "Logged in as $a");
            $sourceInput = $this->input("hidden", "source", $this->location);
            $submit = $this->input("submit", "submit", "Logout");
            return $loggedInAs.$this->tag("p", $sourceInput.$submit);
        } else {
            $email = $this->tag("p", $this->tag("label", "Email: ".$this->input("email", "email", "", true)));
            $password = $this->tag("p", $this->tag("label", "Password: ".$this->input("password", "password", "", true)));
            $source = $this->input("hidden", "source", $this->location);
            $submit = $this->input("submit", "submit", "Login");
            $signUp = "<input type='button' id='btnAddUser' value='Sign Up'>";
            $buttons = $this->tag("p", $source.$submit."\n".$signUp);
            return $email.$password.$buttons;
        }
    }

    public function login($email, $password) {
        $id = $this->link->checkLogin($email, $password);
        if ($id) {
            $_SESSION['auth'] = $id;
        }
    }
    
    public function logout() {
        session_destroy();
    }
    
    private function tag($tag, $content) {
        return "<$tag>$content</$tag>";
    }
    
    private function input($type, $name, $value, $required = false) {
        $input = "<input type='".$type."' name='".$name."' value='".$value."' "; 
        $input .= $required ? "required>" : ">";
        return $input;
    }
}
