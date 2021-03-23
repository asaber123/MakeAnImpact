<?php
// Made by Åsa Berglund 2021

//class for users registration and log in fnctions

class UsersImpact
{
    private $db;
    private $name;
    private $username;
    private $password;


    //constructor, connect to database
    function __construct()
    {
        $this->db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBDATABASE); 
        if ($this->db->connect_errno > 0) {
            die("Fel vid anlutning:" . $this->db->connect_error);
        }
    }
    //set name, chec if size is bigger than 2 characters
    public function setName(string $name): bool
    {
        if (strlen($name) > 1) {
            $this->name = $name;
            return true;
        } else {
            return false;
        }
    }
    //set username check if size is bigger than 2 characters
    public function setUsername(string $username): bool
    {
        if (strlen($username) > 1) {
            $this->username = $username;
            return true;
        } else {
            return false;
        }
    }

    //set password check if size is bigger than 7 characters and that they are matching
    public function setPassword(string $password, string $password2): bool
    {   if ($password == $password2 && strlen($password) > 6){
            $this->password = $password;
            return true;
        } else {
            return false;
        }
    }
    //get name 
    public function getName(string $name): string
    {
        return $this->name;
    }


    //get username
    public function getUsername(string $name): string
    {
        return $this->username;
    }
    //get db
    public function getdb(){
        return $this->db;
    }


    //register new users and store data to database
    public function registerUser($name,$username, $password)
    {
        $name = $this->db->real_escape_string($name);
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);

        //Hash password
        $salt = '$2a$07$HAURGDABDCNSMLAPSNDIABFMSAP05H$';
        $password = crypt($password, $salt);

        $sql = "INSERT INTO UsersImpact(name, username, password)VALUES('$name','$username', '$password')";

        //send data to database
        $result = $this->db->query($sql);
        return $result;
    }


    //logg in existing user
    public function loginUser($username, $password)
    {
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);

        $sql = "SELECT password FROM UsersImpact WHERE username= '$username'";
        //send data to database
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['password'];
            if ($storedPassword == crypt($password, $storedPassword)) {
                $_SESSION['username'] = $username;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    //check if username is alreddy taken
    public function UsernameTaken($username)
    {
        $username = $this->db->real_escape_string($username);

        $sql = "SELECT username FROM UsersImpact WHERE username ='$username'";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    //function to get all registered usernames
    public function getAllUsers() : array{
        $sql = "SELECT user_id, username FROM UsersImpact;";
        $result = $this->db->query($sql);

         //return result as an array
         return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }

}