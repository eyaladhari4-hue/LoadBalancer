<?php
// Show Error
error_reporting(E_ALL);
// Start Class to manage methods for website
class MagasinController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
      // Get by Id
      public function getById($id)
      {
          $stmt = mysqli_prepare($this->db, "SELECT * FROM `magasin` WHERE `id` = ?");
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
        $stmt = mysqli_prepare($this->db, "SELECT * FROM `magasin`");
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
    public function delete($id) {
        $stmt = mysqli_prepare($this->db, "DELETE FROM `magasin` WHERE `id` = ?");
        if ($stmt === false) {
            return false; 
        }
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
    
        mysqli_stmt_close($stmt);
        return $success; 
    }
    


     public function UpdateTab($id, $Titre, $Adresse, $id_be) {
      $stmt = mysqli_prepare($this->db, "UPDATE `magasin` SET `Titre` = ?, `Adresse` = ?, `id_be` = ? WHERE `id` = ?");
        if ($stmt === false) {
            return false; 
        }
        mysqli_stmt_bind_param($stmt, "ssii", $Titre, $Adresse, $id_be, $id);
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            mysqli_stmt_close($stmt);
            return false; 
        } 
        
        $updatedRow = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `magasin` WHERE `id` = $id"));
        mysqli_stmt_close($stmt);
        return $updatedRow; 
    }
    
public function addtab($Titre, $Adresse, $id_be, $Date_de_Creation, $C_par, $Etat ) { 
    $stmt = mysqli_prepare($this->db, "INSERT INTO `magasin` (`Titre`, `Adresse`, `id_be`, `Date_de_Creation`, `C_par`, `Etat`) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        return false; 
    }
    mysqli_stmt_bind_param($stmt, "ssissi", $Titre, $Adresse, $id_be, $Date_de_Creation, $C_par,  $Etat);
    $success = mysqli_stmt_execute($stmt);
      if (!$success) {
        mysqli_stmt_close($stmt);
        return false; 
    }
    $newId = mysqli_insert_id($this->db);
    
    $newRow = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `magasin` WHERE `id` = $newId"));
    mysqli_stmt_close($stmt);
    return $newRow;
}

    

public function countMagasins() {
    $stmt = mysqli_prepare($this->db, "SELECT COUNT(*) AS total FROM `magasin`"); 
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
        $totalMagasins = $row['total'];
        return $totalMagasins;
    } else {
        return false;
    }
}

public function UpdateEtat($id, $Etat) {
    if ($Etat != 0 && $Etat != 1) {
        return false;
    }
    $newEtat = ($Etat == 1) ? 0 : 1;

    $stmt = mysqli_prepare($this->db, "UPDATE `magasin` SET `Etat` = ? WHERE `id` = ?");
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
    $selectStmt = mysqli_prepare($this->db, "SELECT * FROM `magasin` WHERE `id` = ?");
    mysqli_stmt_bind_param($selectStmt, "i", $id);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);
    $updatedRow = mysqli_fetch_assoc($result);
    
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($selectStmt);
    
    return $updatedRow;
}
public function QteStock() {
    // Préparation de la requête SQL pour récupérer les quantités de la table be par magasin
    $stmt_be = mysqli_prepare($this->db, "SELECT `id_magasin`, `id_ba` FROM `be` ");
    
    // Vérification de la préparation de la requête
    if ($stmt_be === false) {
        throw new Exception("Erreur lors de la préparation de la requête BE.");
    }
    
    // Exécution de la requête
    $success_be = mysqli_stmt_execute($stmt_be);
    
    // Vérification de l'exécution de la requête
    if (!$success_be) {
        throw new Exception("Erreur lors de l'exécution de la requête BE.");
    }
    
    // Récupération du résultat
    $result_be = mysqli_stmt_get_result($stmt_be);
    
    // Vérification du résultat
    if ($result_be) {
        // Création d'un tableau pour stocker les quantités par magasin
        $quantitiesByMagasin = array();
        // Création d'un tableau pour stocker le nombre de BE par magasin
        $countBEByMagasin = array();
        
        // Parcours des résultats de la table be
        while ($row_be = mysqli_fetch_assoc($result_be)) {
            $id_magasin = $row_be['id_magasin'];
            $id_ba = $row_be['id_ba'];
            
            // Requête pour récupérer la quantité correspondante à l'id_ba de la table be dans la table ba
            $stmt_ba = mysqli_prepare($this->db, "SELECT `Qte` FROM `ba` WHERE `id` = ?");
            
            // Vérification de la préparation de la requête
            if ($stmt_ba === false) {
                throw new Exception("Erreur lors de la préparation de la requête BA.");
            }
            
            // Liaison des paramètres
            mysqli_stmt_bind_param($stmt_ba, 'i', $id_ba);
            
            // Exécution de la requête
            $success_ba = mysqli_stmt_execute($stmt_ba);
            
            // Vérification de l'exécution de la requête
            if ($success_ba) {
                // Récupération du résultat
                $result_ba = mysqli_stmt_get_result($stmt_ba);
                
                // Vérification du résultat
                if ($result_ba) {
                    $row_ba = mysqli_fetch_assoc($result_ba);
                    if ($row_ba) {
                        $Qte = $row_ba['Qte'];
                        
                        // Si le magasin existe déjà dans le tableau, on ajoute la quantité
                        if (isset($quantitiesByMagasin[$id_magasin])) {
                            $quantitiesByMagasin[$id_magasin] += $Qte;
                            $countBEByMagasin[$id_magasin]++;
                        } else { // Sinon, on crée une nouvelle entrée pour le magasin
                            $quantitiesByMagasin[$id_magasin] = $Qte;
                            $countBEByMagasin[$id_magasin] = 1;
                        }
                    }
                }
            } else {
                throw new Exception("Erreur lors de l'exécution de la requête BA.");
            }
            
            // Fermeture du statement de la table ba
            mysqli_stmt_close($stmt_ba);
        }
        
        // Construction de la sortie HTML
        $output = '';
        $max_stock = 100;
        foreach ($quantitiesByMagasin as $id_magasin => $moyenneQte) {
            $stock = $moyenneQte / $countBEByMagasin[$id_magasin];
            $stock_percentage = ($stock / $max_stock) * 100; 

            // Déterminer la classe de la barre de progression en fonction du pourcentage de stock
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

           // Construction de la sortie HTML
$output .= '<div class="card-body">' .
'<h4 class="small font-weight-bold"> ' .'M'. $id_magasin . '<span class="float-right">' . number_format($stock_percentage, 2) . '%</span></h4>' .

'<div class="progress mb-4">' .
'<div class="progress-bar ' . $progress_bar_class . '" role="progressbar" style="width: ' . number_format($stock_percentage, 2) . '%" aria-valuenow="' . $stock_percentage . '" aria-valuemin="0" aria-valuemax="100"></div>' .
'</div>' .
'</div>';

        }

        // Libération du résultat de la requête BE
        mysqli_free_result($result_be);

        return $output; 
    } else {
        throw new Exception("Aucun résultat trouvé pour la requête BE.");
    }
}

}