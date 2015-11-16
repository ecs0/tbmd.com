<?php
include_once('Connection.php');

/**
 * Description of LoginManager
 *
 * @author bryan
 */
class LoginManager {

    private $link;
    
    public function __construct() {
        $this->link = new Connection();
    }

    public function getLoginForm() {
        session_start();
        $form = "<form method='post' action='php/login_handler.php'>
                    <p>
                        <label>Email:
                            <input type='email' name='email' required>
                        </label>
                    </p>
                    <p>
                        <label>Password:
                            <input type='password' name='password' required>
                        </label>
                    </p>
                    <p>
                        <input type='submit' name='submit' value='Login'>
                        <input type='button' id='btnAddUser' value='Sign Up'>
                    </p>
                </form>";
        $userID = "logged in!";
        
        if (isset($_SESSION['auth'])) {
            return $userID;
        } else {
            return $form;
        }
    }

    
    public function login($email, $password) {
        $id = $this->link->checkLogin($email, $password);
        if ($id) {
            session_start();
            $_SESSION['auth'] = $id;
        } else {
            session_destroy();
        }
    }
    
    public function logout() {
        session_destroy();
    }
}
