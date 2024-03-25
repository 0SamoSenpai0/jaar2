<?php
require_once "database.php";
class User extends database{
public $username;
private $password;
private $role;

public function registerUser($username,$pwd,$role){
echo "Registreer";
$this->username = $username;
$this->password = $pwd;
$this->role = $role;

}}