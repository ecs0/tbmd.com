<?php
include_once('Connection.php');
include_once('User.php');
session_start();

/**
 * This class is used by the login_handler to log the user in, and out
 *
 * @author bryan
 */
class LoginManager {

    private $link;
    private $location;
    private $type;
    
    /**
     * Creates an instance of LoginManager
     * 
     * @param type $location - calling location of the form, will be the return point
     */
    public function __construct($location) {
        $this->link = new Connection();
        $this->location = $location;

        if (strpos($location, "movie.php") === FALSE && strpos($location, "person.php") === FALSE) {
            $this->type = null;
        } else if (strpos($location, "movie.php") !== FALSE) {
            $this->type = "Movie";
        } else {
            $this->type = "Person";
        }
    }
    
    /**
     * @return boolean|int - logged in users id if logged in, false otherwise
     */
    public function getLoggedInUserId() {
        if ($this->isLoggedIn()) {
            return $_SESSION['auth'];
        } else {
            return FALSE;
        }
    }

    /**
     * Manages the state of the login panel at the top left of the website
     * Pages can simply request the form, and this function will return the 
     * proper form based on the session's authentication state.
     * 
     * @return type
     */
    public function getLoginForm() {
        if ($this->isLoggedIn()) {
            $id = $_SESSION['auth'];
            $user = $this->link->getUsers([$id])[0];
            $username = $user->getUsername();
            
            $link = "'profile.php?id=".$id."'";
            $a = "<a href=$link>$username</a>";
            
            $loggedInAs = "Logged in as $a";
            $sourceInput = $this->input("hidden", "source", $this->location);
            $submit = $this->input("submit", "submit", "Logout");
            return $loggedInAs.$sourceInput."\n".$submit;
        } else {
            $email = $this->tag("label", "Email: ".$this->input("email", "email", "", true));
            $password = $this->tag("label", "Password: ".$this->input("password", "password", "", true));
            $source = $this->input("hidden", "source", $this->location);
            $submit = $this->input("submit", "submit", "Login");
            $signUp = "<input type='button' id='btnAddUser' value='Sign Up'>";
            $buttons = $source.$submit."\n".$signUp;
            return $email."\n".$password."\n".$buttons;
        }
    }

    /**
     * Logs the user in to the system, if their email and password authenticate
     * 
     * @param type $email
     * @param type $password
     */
    public function login($email, $password) {
        $id = $this->link->checkLogin($email, $password);
        if ($id) {
            $_SESSION['auth'] = $id;
        }
    }
    
    /**
     * Logs the user out of the system by clearing all session variables.
     */
    public function logout() {
        session_destroy();
    }
    
    /**
     * Returns content generation buttons if the user is logged in
     *  
     * @return String
     */
    public function getContentButtons() {
        
        if ($this->isLoggedIn()) {
            $btnAddPerson = $this->inputById("button", "btnAddPerson", "Add an Actor or Director!");
            $btnAddMovie = $this->inputById("button", "btnAddMovie", "Add a Movie!");
            $btnAddReview = $this->inputById("button", "btnAddReview", "Review Your Favourite Movie!");
            
            if ($this->type == "Person") {
                $btnEdit = $this->inputById("button", "btnEditPerson", "Edit");
                $btnAddActor = $this->inputById("button", "btnAddActorToMovie", "Quick Add");
            } else if ($this->type == "Movie") {
                $btnEdit = $this->inputById("button", "btnEditMovie", "Edit");
                $btnAddActor = $this->inputById("button", "btnAddMovieToActor", "Quick Add");
            } else {
                $btnEdit = "";
                $btnAddActor = "";
            }
            
            return "$btnAddPerson\n$btnAddMovie\n$btnAddReview\n$btnEdit\n$btnAddActor";
        } else {
            return "";
        }
    }
    
    /**
     * Helper function for marking up form components
     * 
     * @param type $tag
     * @param type $content
     * @return String
     */
    private function tag($tag, $content) {
        return "<$tag>$content</$tag>";
    }

    /**
     * Helper function that creates an input element
     * 
     * @param type $type
     * @param type $name
     * @param type $value
     * @param type $required
     * @return String
     */
    private function input($type, $name, $value, $required = false) {
        $input = "<input type='".$type."' name='".$name."' value='".$value."' "; 
        $input .= $required ? "required>" : ">";
        return $input;
    }
    
    /**
     * Helper function that creates an input with a custom id
     * 
     * @param type $type
     * @param type $id
     * @param type $value
     * @return String
     */
    private function inputById($type, $id, $value) {
        return "<input type='".$type."' id='".$id."' value='".$value."'>";
    }
    
    /**
     * Checks if the session has a logged in user
     * 
     * @return Bool
     */
    public function isLoggedIn() {
        return isset($_SESSION['auth']); 
    }
}
