<?php
// Show Error
error_reporting(E_ALL);
// Start Class to manage methods for website
class BaController
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
   // Get by Id
   public function getById($id)
   {
       $stmt = mysqli_prepare($this->db, "SELECT * FROM `ba` WHERE `id` = ?");
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
   // get list categorie
    public function getList()
    {
        $stmt = mysqli_prepare($this->db, "SELECT * FROM `ba`");
        if ($stmt===false) {
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
    public function getLastId()
    {
        $stmt = mysqli_prepare($this->db, "SELECT id FROM `ba` ORDER BY id DESC LIMIT 1");
        if ($stmt === false) {
            return false;
        }
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            return false;
        }
        mysqli_stmt_bind_result($stmt, $lastId);
        $result = mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $result ? $lastId : false;
    }
    public function delete($id) {
        $stmt = mysqli_prepare($this->db, "DELETE FROM `ba` WHERE `id` = ?");
        if ($stmt === false) {
            return false; 
        }
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $success; 
    }
     public function UpdateTab($id,$id_produit, $id_fournisseur,$Qte) {
      $stmt = mysqli_prepare($this->db, "UPDATE `ba` SET `id_produit` = ?, `id_fournisseur` = ?, `Qte`= ? WHERE `id` = ?");
        if ($stmt === false) {
            return false; 
        }
        mysqli_stmt_bind_param($stmt, "iiii",$id_produit, $id_fournisseur,$Qte, $id);
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            mysqli_stmt_close($stmt);
            return false; 
        } 
        $updatedRow = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `produit` WHERE `id` = $id"));
        mysqli_stmt_close($stmt);
        return $updatedRow; 
    }
public function addtab($Ref, $id_produit, $id_fournisseur, $Etat, $Date_De_Creation, $C_par, $Qte) { 
    $stmt = mysqli_prepare($this->db, "INSERT INTO `ba` (`Ref`, `id_produit`, `id_fournisseur`, `Etat`, `Date_De_Creation`, `C_par`, `Qte`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        return false; 
    }
    mysqli_stmt_bind_param($stmt, "siiissi", $Ref, $id_produit, $id_fournisseur, $Etat, $Date_De_Creation, $C_par, $Qte);
    $success = mysqli_stmt_execute($stmt);
      if (!$success) {
        mysqli_stmt_close($stmt);
        return false; 
    }
    $newId = mysqli_insert_id($this->db);
    $newRow = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `ba` WHERE `id` = $newId"));
    mysqli_stmt_close($stmt);
    return $newRow;
}
public function countba() {
    $stmt = mysqli_prepare($this->db, "SELECT COUNT(*) AS total FROM `ba`"); 
    if ($stmt===false) {
        return false;
     }
    $success = mysqli_stmt_execute($stmt);
    if (!$success) {
        return false;
    }
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $totalProducts = $row['total'];
        return $totalProducts;
    } else {
        return false;
    }
}
public function UpdateEtat($id, $Etat) {
    if ($Etat != 0 && $Etat != 1) {
        return false;
    }
    $newEtat = ($Etat == 1) ? 0 : 1;
    $stmt = mysqli_prepare($this->db, "UPDATE `ba` SET `Etat` = ? WHERE `id` = ?");
    if ($stmt === false) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "ii", $newEtat, $id);
    $success = mysqli_stmt_execute($stmt);
    if (!$success) {
        mysqli_stmt_close($stmt);
        return false;
    } 
    mysqli_stmt_close($stmt);
    return true;
}

}