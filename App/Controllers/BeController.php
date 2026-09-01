<?php
// Show Error
error_reporting(E_ALL);
// Start Class to manage methods for website
class BeController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
     // Get by Id
     public function getById($id)
     {
         $stmt = mysqli_prepare($this->db, "SELECT * FROM `be` WHERE `id` = ?");
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
     public function getListByMagasin($idMagasin)
     {
         // Préparation de la requête SQL
         $stmt = mysqli_prepare($this->db, "SELECT * FROM `be` WHERE `id_magasin` = ?");
         if ($stmt === false) {
             return false;
         }
         mysqli_stmt_bind_param($stmt, "i", $idMagasin);
         $success = mysqli_stmt_execute($stmt);
         if (!$success) {
             return false;
         }
         $result = mysqli_stmt_get_result($stmt);
         $bes = [];
         while ($be = mysqli_fetch_assoc($result)) {
             $bes[] = $be;
         }
         mysqli_stmt_close($stmt);
         return $bes;
     }
     
     public function getList()
    
    {
        $stmt = mysqli_prepare($this->db, "SELECT * FROM `be`");
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
        $stmt = mysqli_prepare($this->db, "SELECT id FROM `be` ORDER BY id DESC LIMIT 1");
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
        $stmt = mysqli_prepare($this->db, "DELETE FROM `be` WHERE `id` = ?");
        if ($stmt === false) {
            return false; 
        }
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
    
        mysqli_stmt_close($stmt);
        return $success; 
    }
    


     public function UpdateTab($id,$id_ba,$id_magasin, $date_entree, $date_paiement) {
      $stmt = mysqli_prepare($this->db, "UPDATE `be` SET  `id_ba` = ?, `id_magasin`=?, `date_entree` = ?, `date_paiement` = ? WHERE `id` = ?");
        if ($stmt === false) {
            return false; 
        }
        mysqli_stmt_bind_param($stmt, "iissi", $id_ba,$id_magasin, $date_entree,$date_paiement, $id);
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            mysqli_stmt_close($stmt);
            return false; 
        } 
        
        $updatedRow = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `be` WHERE `id` = $id"));
        mysqli_stmt_close($stmt);
        return $updatedRow; 
    }
    
    public function addtab($Ref, $id_ba, $id_magasin, $date_entree, $date_paiement, $C_par, $Etat) { 
        
        $stmt_add_be = mysqli_prepare($this->db, "INSERT INTO `be` (`Ref`, `id_ba`, `id_magasin`, `date_entree`, `date_paiement`, `C_par`, `Etat`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_add_be, "siisssi", $Ref, $id_ba, $id_magasin, $date_entree, $date_paiement, $C_par, $Etat);
        $success_add_be = mysqli_stmt_execute($stmt_add_be);
    
        if (!$success_add_be) {
            mysqli_stmt_close($stmt_add_be);
            return false; 
        }
    
        $newId = mysqli_insert_id($this->db);
        mysqli_stmt_close($stmt_add_be);
    
        // Mettre à jour l'id_be dans la ligne existante de la table magasin
        $stmt_update_magasin_line = mysqli_prepare($this->db, "UPDATE `magasin` SET `id_be` = ? WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt_update_magasin_line, "ii", $newId, $id_magasin);
        $success_update_magasin_line = mysqli_stmt_execute($stmt_update_magasin_line);
    
        if (!$success_update_magasin_line) {
            mysqli_stmt_close($stmt_update_magasin_line);
            return false;
        }
    
        mysqli_stmt_close($stmt_update_magasin_line);
    
        // Récupérer et retourner les informations de la BE ajoutée
        $newRow = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `be` WHERE `id` = $newId"));
    
        return $newRow;
    }
    

public function getLatestBeId() {
    $stmt = mysqli_prepare($this->db, "SELECT id FROM `be` ORDER BY date_entree DESC LIMIT 1"); 
    if ($stmt === false) {
        return false;
    }
     
    $success = mysqli_stmt_execute($stmt);
    if (!$success) {
        return false;
    }
    
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $latestBeId = $row['id'];
        return $latestBeId;
    } else {
        return false;
    }
}

public function UpdateEtat($id, $Etat) {
    if ($Etat != 0 && $Etat != 1) {
        return false;
    }
    $newEtat = ($Etat == 1) ? 0 : 1;

    $stmt = mysqli_prepare($this->db, "UPDATE `be` SET `Etat` = ? WHERE `id` = ?");
    if ($stmt === false) {
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, "ii", $newEtat, $id);
    $success = mysqli_stmt_execute($stmt);
    
    if (!$success) {
        mysqli_stmt_close($stmt);
        return false;
    } 
    
    $selectStmt = mysqli_prepare($this->db, "SELECT * FROM `be` WHERE `id` = ?");
    mysqli_stmt_bind_param($selectStmt, "i", $id);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);
    $updatedRow = mysqli_fetch_assoc($result);
    
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($selectStmt);
    
    return $updatedRow;
}
public function QteStock() {
    $magasin_query = mysqli_query($this->db, "SELECT `id`, `id_magasin` FROM `be`");
    if (!$magasin_query) {
        return false;
    }

    $quantites_par_magasin = array();

    while ($magasin_row = mysqli_fetch_assoc($magasin_query)) {
        $id_magasin = $magasin_row['id_magasin'];

        $stmt_be = mysqli_prepare($this->db, "SELECT `Titre` FROM `magasin` WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt_be, "i", $id_magasin);
        $success_be = mysqli_stmt_execute($stmt_be);
        if (!$success_be) {
            mysqli_stmt_close($stmt_be);
            return false;
        }

        $result_be = mysqli_stmt_get_result($stmt_be);
        $row_be = mysqli_fetch_assoc($result_be);
        $titre_magasin = $row_be['Titre'];

        $i = 0;

        $id_be = $magasin_row['id'];
        $stmt_ba = mysqli_prepare($this->db, "SELECT `id_ba` FROM `be` WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt_ba, "i", $id_be);
        $success_ba = mysqli_stmt_execute($stmt_ba);
        if (!$success_ba) {
            mysqli_stmt_close($stmt_ba);
            return false;
        }

        $result_ba = mysqli_stmt_get_result($stmt_ba);

        $id_produits = array();

        while ($row_ba = mysqli_fetch_assoc($result_ba)) {
            $id_ba = $row_ba['id_ba'];

            $stmt_produit = mysqli_prepare($this->db, "SELECT `id_produit` FROM `ba` WHERE `id` = ?");
            mysqli_stmt_bind_param($stmt_produit, "i", $id_ba);
            $success_produit = mysqli_stmt_execute($stmt_produit);
            if (!$success_produit) {
                mysqli_stmt_close($stmt_produit);
                return false;
            }

            $result_produit = mysqli_stmt_get_result($stmt_produit);
            $row_produit = mysqli_fetch_assoc($result_produit);
            $id_produit = $row_produit['id_produit'];

            if (!in_array($id_produit, $id_produits)) {
                $id_produits[] = $id_produit;
                $i++;
            }

            mysqli_stmt_close($stmt_produit);
        }

        $stmt_qte = mysqli_prepare($this->db, "SELECT `Qte` FROM `ba` WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt_qte, "i", $id_ba);
        $success_qte = mysqli_stmt_execute($stmt_qte);
        if (!$success_qte) {
            mysqli_stmt_close($stmt_qte);
            return false;
        }

        $result_qte = mysqli_stmt_get_result($stmt_qte);
        $row_qte = mysqli_fetch_assoc($result_qte);
        $qte = $row_qte['Qte'];

        if (isset($quantites_par_magasin[$titre_magasin])) {
            if ($i > 0) {
                $quantites_par_magasin[$titre_magasin] += ($qte / $i);
            } else {
                $quantites_par_magasin[$titre_magasin] += $qte;
            }
        } else {
            if ($i > 0) {
                $quantites_par_magasin[$titre_magasin] = ($qte / $i);
            } else {
                $quantites_par_magasin[$titre_magasin] = $qte;
            }
        }

        mysqli_stmt_close($stmt_be);
        mysqli_stmt_close($stmt_ba);
        mysqli_stmt_close($stmt_qte);
    }

    $max_stock = 100;
    $output = "";

    foreach ($quantites_par_magasin as $titre_magasin => $total_qte) {
        $stock_percentage = ($total_qte / $max_stock) * 100;
        $progress_bar_class = '';

        if ($stock_percentage <= 25) {
            $progress_bar_class = 'bg-success';
        } elseif ($stock_percentage <= 50) {
            $progress_bar_class = 'bg-info';
        } elseif ($stock_percentage <= 75) {
            $progress_bar_class = 'bg-warning';
        } else {
            $progress_bar_class = 'bg-danger';
        }

        $output .= '<div class="card-body">' .
            '<h4 class="small font-weight-bold"> ' . $titre_magasin . '<span class="float-right">' . $stock_percentage . '%</span></h4>' .
            '<div class="progress mb-4">' .
            '<div class="progress-bar ' . $progress_bar_class . '" role="progressbar" style="width: ' . $stock_percentage . '%" aria-valuenow="' . $stock_percentage . '" aria-valuemin="0" aria-valuemax="100"></div>' .
            '</div>' .
            '</div>';
    }

    return $output;
}

}