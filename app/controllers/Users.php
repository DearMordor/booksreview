<?php

/**
 * Provide functionality for user actions
 */
class Users extends Controller
{
    /**
     * @var User
     */
    private $userModel;

    /**
     * Init User model
     */
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    /**
     * Register a new user if all checks are ok, then show page for a user.
     * @return void
     */
    public function register()
    {
        // Check for POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'token' => trim($_POST['token']),
                'birthday' => $_POST['birthday'],
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'birthday_err' => '',
                'token_err' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = "Please enter email";
            } else if (strlen($data['email']) > 50) {
                $data['email_err'] = "Email length is too long!";
            } else if ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = "Email is already taken";
            }

            // Validate Name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            } else if (strlen($data['name']) > 40) {
                $data['name_err'] = 'Full name is too long!';
            } else if (!preg_match("/^[a-zA-Z-' ]*$/", $data['name'])) {
                $data['name_err'] = 'Only letters and whitespaces allowed!';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 8) {
                $data['password_err'] = "Password must be at least 8 characters";
            }

            // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Validate birthday
            if (empty($data['birthday'])) {
                $data['birthday_err'] = "Please enter birthday";
            }

            // Validate token
            if (!empty($_POST['token'])) {
                if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                    $data['token_err'] = 'Detected CSRF ATTACK. Please resubmit.';
                }
            }

            // Make sure all errors are empty 
            if (
                empty($data['email_err']) && empty($data['name_err'])
                && empty($data['password_err'])
                && empty($data['confirm_password_err']
                    && empty($data['birthday_err']))
                && empty($data['token_err'])
            ) {
                // Then user data are right

                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->userModel->register($data)) {
                    header('location: ' . URLROOT . '/users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // In case of error, load view
                $this->view('users/register', $data);
            }
        } else {
            // Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'birthday' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'birthday_err' => ''
            ];

            // Load empty view 
            $this->view('users/register', $data);
        }
    }

    /**
     * Login a user into a website. Check all inputs, then show a page for a user.
     * @return void
     */
    public function login()
    {
        // Check for POST req
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'token' => trim($_POST['token']),
                'password_err' => '',
                'confirm_password_err' => '',
                'token_err' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = "Please enter email";
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = "Please enter password";
            }

            // Check for user/email
            if (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'No user found';
            }

            // Validate token
            if (!empty($_POST['token'])) {
                if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                    $data['token_err'] = 'Detected CSRF ATTACK. Please resubmit.';
                }
            }

            // Make sure errors are empty 
            if (empty($data['email_err']) && empty($data['password_err']) && empty($data['token_err'])) {
                // Validated 
                // Check and set logger in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';

                    $this->view('users/login', $data);
                }
            } else {
                // Load view with error
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            // Load view 
            $this->view('users/login', $data);
        }
    }

    /**
     * Create user session for future accessing to SESSION variables
     * @param $user
     * @return void
     */
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        header('location: ' . URLROOT);
    }

    /**
     * Logout a signed user, clear all SESSION data
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        header('location: ' . URLROOT . '/' . 'users/login');
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}
