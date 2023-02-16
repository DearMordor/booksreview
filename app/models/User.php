<?php

/**
 * User model is responsible for working with user data
 */
class User
{
    /**
     *
     * @var Database
     */
    private $db;

    /**
     * Init database
     */
    public function __construct()
    {
        $this->db = new Database;
    }


    /**
     * Register User
     * @param $data
     * @return mixed
     */
    public function register($data)
    {
        $this->db->query('INSERT INTO users (name, email, password, birthday, role) VALUES(:name, :email, :password, :birthday, :role)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':birthday', $data['birthday']);
        $this->db->bind(':role', 'user');

        return $this->db->execute();
    }


    /**
     * Login User
     * @param $email
     * @param $password
     * @return false|mixed
     */
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password)) {
            // Row is data pulled from DB, which includes everything: name, id, email and password
            return $row;
        } else {
            return false;
        }
    }


    /**
     * Find user by email
     * @param $email
     * @return bool
     */
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $this->db->single();

        return $this->db->rowCount() > 0;
    }

    /**
     * Get User by ID
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        //  Bind value
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }
}
