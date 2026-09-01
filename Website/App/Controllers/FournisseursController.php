<?php
// Show Error
error_reporting(E_ALL);
// Start Class to manage methods for website
class FournisseursController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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
    // get list user
    public function getList() {
        $stmt = mysqli_prepare($this->db, "SELECT `id`, `Nom`, `Date_de_creation`, `Etat`, `Type`, `C_par`, `tel`  FROM `user` WHERE `Type`=2");
        if ($stmt === false) {
            return false;
        }
        
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            return false;
        }
        
        $result = mysqli_stmt_get_result($stmt);
        
        $data = array();
        
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return !empty($data) ? $data : false;
    }
    
    public function delete($id) {
        $stmt = mysqli_prepare($this->db, "DELETE FROM `user` WHERE `id` = ?");
        if ($stmt === false) {
            return false; 
        }
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
    
        mysqli_stmt_close($stmt);
        return $success; 
    }
    


    public function UpdateTab($id, $Nom, $tel) {
        $stmt = mysqli_prepare($this->db, "UPDATE `user` SET `Nom` = ?, `tel` = ? WHERE `id` = ?");
        if ($stmt === false) {
            return false; 
        }
        mysqli_stmt_bind_param($stmt, "ssi", $Nom, $tel, $id);
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            mysqli_stmt_close($stmt);
            return false; 
        } 
        
        $updatedRow = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `user` WHERE `id` = $id"));
        mysqli_stmt_close($stmt);
        return $updatedRow; 
    }
    
    
public function addtab($Nom, $tel, $Date_de_Creation, $C_par, $Etat, $Type) { 
    $stmt = mysqli_prepare($this->db, "INSERT INTO `user` (`Nom`,`tel`, `Date_de_Creation`,`C_par`,`Etat`,  `Type`) VALUES ( ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        return false; 
    }
    mysqli_stmt_bind_param($stmt, "sssssi", $Nom, $tel, $Date_de_Creation, $C_par, $Etat, $Type);
    $success = mysqli_stmt_execute($stmt);
      if (!$success) {
        mysqli_stmt_close($stmt);
        return false; 
    }
    $newId = mysqli_insert_id($this->db);
    
    $newRow = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `user` WHERE `id` = $newId"));
    mysqli_stmt_close($stmt);
    return $newRow;
}

    


public function UpdateEtat($id, $Etat) {
    if ($Etat != 0 && $Etat != 1) {
        return false;
    }
    $newEtat = ($Etat == 1) ? 0 : 1;

    $stmt = mysqli_prepare($this->db, "UPDATE `user` SET `Etat` = ? WHERE `id` = ?");
    if ($stmt === false) {
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, "ii", $newEtat, $id);
    $success = mysqli_stmt_execute($stmt);
    
    if (!$success) {
        mysqli_stmt_close($stmt);
        return false;
    } 
    
    // Sélectionner la ligne mise à jour avec le nouvel état
    $selectStmt = mysqli_prepare($this->db, "SELECT * FROM `user` WHERE `id` = ?");
    mysqli_stmt_bind_param($selectStmt, "i", $id);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);
    $updatedRow = mysqli_fetch_assoc($result);
    
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($selectStmt);
    
    return $updatedRow;
}

}