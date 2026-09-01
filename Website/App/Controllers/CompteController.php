<?php
// Show Error
error_reporting(E_ALL);
// Start Class to manage methods for website
class CompteController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    // Login
    public function getCnxCpt($Login, $Password)
    {
        $stmt = mysqli_prepare($this->db, "SELECT * FROM `user` WHERE `Login` = ? AND `Password` = ?");
        if ($stmt === false) {
          
            return false;
        }
      //  header("Location:bbbb.php");
        mysqli_stmt_bind_param($stmt, "ss", $Login, $Password);
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            header("Location:aaaa.php");
            return false;
        }
       
        // echo "SELECT * FROM `user` WHERE `Login` = '{$Login}' AND `Password` = '{$Password}'";
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

      

        return ($user !== null) ? $user : false;
    }
    //Save last date connexion
    public function savedate($id)
    {
        $date = date('Y/m/d à h:i');
        $stmt = mysqli_prepare($this->db, "UPDATE `user` SET `last_cnx` = ? WHERE `id` = ?");
        if ($stmt === false) {
            return false;
        }
        mysqli_stmt_bind_param($stmt, "si", $date, $id);
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            return false;
        }
        mysqli_stmt_close($stmt);
        return true;
    }
    // Get user by id
    public function getCurrentUserById($id)
    {
        $stmt = mysqli_prepare($this->db, "SELECT * FROM `user` WHERE `id` = ?");
        if ($stmt === false) {
            return false;
        }
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            return false;
        }
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return ($user !== null) ? $user : false;
    }
    // Get by Id
    public function getById($id)
    {
        $stmt = mysqli_prepare($this->db, "SELECT * FROM `user` WHERE `id` = ?");
        if ($stmt === false) {
            return false;
        }
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            return false;
        }
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return ($user !== null) ? $user : false;
    }
   

}