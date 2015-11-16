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
    
    public function __construct() {
        $this->link = new Connection();
    }

    public function getLoginForm() {
        if (isset($_SESSION['auth'])) {
            $id = $_SESSION['auth'];
            $user = $this->link->getUsers([$id])[0];
            $userName = $user->getUsername();
            return "<p>
                        Logged in as $userName
                    <p>
                        <input type='submit' name='submit' value='Logout'>
                    </p>";
        } else {
            return "<p>
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
                    </p>";
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
}
