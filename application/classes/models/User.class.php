<?php

class User {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    private function getUserData($username){

        $sql = "SELECT * FROM users WHERE username = ?;";
        $stmt = $this->db->run($sql, [$username]);
        $user = $stmt->fetch();

        if($user) return $user;
        return null;
    }

    public function onlineUsers() {
        $sql = "SELECT * FROM users WHERE session_id <> '';";
        $stmt = $this->db->run($sql);
        $users_online = $stmt->fetchAll();

        return [
            'users' => $users_online,
            'count' => count($users_online)
        ];
    }

    public function logout() {
        session_start();

        $updateSessiong = "UPDATE users SET session_id = NULL WHERE session_id = ?;";
        $stmt = $this->db->run($updateSessiong, [session_id()]);

        session_unset();
        session_destroy();
    }

    private function getIp() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
        else{  
            $ip = $_SERVER['REMOTE_ADDR'];  
        }  
        return $ip;
    }

    public function signUp($username, $email, $password, $confirmpassword) {

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                "success" => false,
                "message" => "invalid_email"
            ];
        }

        if(empty($username) || empty($email) || empty($password) || empty($confirmpassword)) {
            return [
                "success" => false,
                "message" => "fill_fields"
            ];
        }


        if($password != $confirmpassword) {
            return [
                "success" => false,
                "message" => "passwords_do_not_match"
            ];
        }

        $foundUser = "SELECT * FROM users WHERE username = ? OR email = ?;";
        $stmt = $this->db->run($foundUser, [$username, $email]);
        $results = $stmt->fetch();
        if($results) {
            return [
                "success" => false,
                "message" => "Username or email already taken"
            ];
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $createdUser = "INSERT INTO users (username, email, password, session_id, session_ip) VALUES (?, ?, ?, ?, ?);";
        $stmt = $this->db->run($createdUser, [$username, $email, $hashedPassword, session_id(), $this->getIp()]);

        session_start();
        $_SESSION['username'] = $username;

        return [
            "success" => true,
            "message" => "Successfully created a new user, welcome!"
        ];
    }

    public function signIn($username, $password){

        $user = $this->getUserData($username);
        if(!$user) {
            return [
                "success" => false,
                "message" => "Username or password is incorrect"
            ];
        }
        
        $doesPasswordMatch = password_verify($password, $user['password']);
        if(!$doesPasswordMatch) {
            return [
                "success" => false,
                "message" => "Username or password is incorrect"
            ];
        }

        session_start();
        $_SESSION['username'] = $username;

        $updateSession = "UPDATE users SET session_id = ?, session_ip = ? WHERE username = ?;";
        $stmt = $this->db->run($updateSession, [session_id(), $this->getIp(), $username]);

        return [
            "success" => true,
            "message" => "Successfully signed in, welcome!"
        ];

    }

}