<?php

namespace App\Models;

use PDO;
use \App\Token;

class User extends \Core\Model{

    // public static function getAll()
    // {
    //     $db = static::getDB();
    //     $stmt = $db->query('SELECT id, name FROM tbl_user');
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public $errors = [];

    public function __construct($data = []){
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public function save(){
        $this->validate();
        if (empty($this->errors)) {
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = 'INSERT INTO tbl_user (user_name, user_email, password)
                    VALUES (:user_name, :email, :password_hash)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':user_name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email',$this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $hashed_password, PDO::PARAM_STR);

            return $stmt->execute();
         }

        return false;
  }

  public function validate(){
    // Name
       if ($this->name == '') {
           $this->errors[] = 'Name is required';
       }

       // email address
       if ($this->email == '') {
           $this->errors[] = 'required email';
       }

       if (static::emailExist($this->email)) {
           $this->errors[] = 'email already exits';
       }

       if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
           $this->errors[] = 'Invalid email';
       }

       // Password
       // if ($this->password != $this->repeat_password) {
       //     $this->errors[] = 'Password must match confirmation';
       // }

       if ($this->password == '') {
           $this->errors[] = 'Password required';
       }

       if (strlen($this->password) < 6) {
           $this->errors[] = 'Please enter at least 6 characters for the password';
       }

       if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
           $this->errors[] = 'Password needs at least one letter';
       }

       if (preg_match('/.*\d+.*/i', $this->password) == 0) {
           $this->errors[] = 'Password needs at least one number';
       }
  }

  public static function emailExist($email){
    // $sql = "SELECT * FROM tbl_user WHERE email = :email";
    // $db = static::getDB();
    // $stmt = $db->prepare($sql);
    // $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    // $stmt->execute();

    // return $stmt->fetch() !== false;
    return static::findByMail($email) !== false;
  }

  public static function findByMail($email){
    $sql = "SELECT * FROM tbl_user WHERE user_email = :email";
    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    $stmt->execute();

    return $stmt->fetch();

  }

  public static  function authenticate($email, $password){
    $user = static::findByMail($email);

    if ($user) {
      if (password_verify($password, $user->password)) {
        return $user;
      }
    }
    return false;
  }

  public static function findById($id){
    //echo $id;
    $sql = "SELECT * FROM tbl_user WHERE user_id = :id";
    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    $stmt->execute();

    return $stmt->fetch();

  }
  public function remember_login(){
    $token = new Token();
    $hashed_token = $token->get_hash();
    $this->remember_token = $token->get_value();
    $this->expire_timestamp = time() + 60 * 60 * 24 * 30;

    $sql = 'INSERT INTO remembered_login(token_hash, user_id, expires_at)
            VALUES(:token_hash, :user_id, :expires_at)';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
    $stmt->bindValue(':expires_at', date('y-m-d H:i:s', $this->expire_timestamp), PDO::PARAM_STR);

    return $stmt->execute();
  }

}
