<?php
$title = 'Magasins';
$css = '<!-- Custom styles for this page -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
';
$js = '
<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>
';
include('includes/_head.php');

?>

<?php
include('includes/_sidebar.php');
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">

    <?php
    include('includes/_nav.php');
    ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Gestion de Magasins</h1>
      <?php
      if (isset($_POST['ajouter'])) {
        $date = date('y-m-d à H:i');
        echo ($MagasinController->addtab($_POST['Titre'], $_POST['Adresse'], $_POST['id_be'],$date, $currentUser['id'], '1') ? "success" : "failed");
      }
      if (isset($_POST['modifier'])) {
        echo ($MagasinController->UpdateTab($_POST['modifier'], $_POST['Titre'], $_POST['Adresse'],$_POST['id_be']) ? "success" : "failed");
      }
      if (isset($_POST['supp'])) {
        echo ($MagasinController->delete($_POST['supp']) ? "success" : "failed");
      }
      if (isset($_POST['modifieretat'])) {
        echo ($MagasinController->UpdateEtat($_POST['id'], $_POST['Etat']) ? "success" : "failed");
      }

      ?>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class=" mb-0 text-gray-800">Table de Magasins</h5>
          <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#add">Ajouter</button>
        </div>
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Nouveau Magasin</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
              </div>
              <div class="modal-body">
                <form class="form-group" method="post">
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Titre</label>
                    <input type="text" class="form-control" name="Titre" placeholder="Titre" required>
                  </div>
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Adresse</label>
                    <input type="text" class="form-control" name="Adresse" placeholder="Adresse"required>
                  </div>
                  <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Ref_BE</label>
                      <input type="hidden" name="id_be" value="0">
                    </div>  
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name='ajouter' value="<?= $i['id']; ?>"> Ajouter</button>

                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Titre</th>
                  <th>Adresse</th>
                  <th>Bons d'entrés</th>
                  <th>Date de Creation</th>
                  <th>Auteur</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $listMagasins = $MagasinController->getList();
                foreach ($listMagasins as $i) :
                ?>
                  <tr>
                  <th><?= $i['Titre']; ?></th>
                    <th><?= $i['Adresse']; ?></th>
                    <th>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary7" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i['id']; ?>">
                        Voir plus
                      </button>
                      <div class="modal fade" id="exampleModal<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title fs-5" id="exampleModalLabel">
                                Bons d'entrés de
                                <?php
                                $cat = $MagasinController->getById($i['id']);
                                echo $cat['Titre'];
                                ?>
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>

                            <div class="modal-body">
                              <?php
                              $listeBE = $BeController->getListByMagasin($i['id']);
                              $nombreBE = 0;
                              $sommeQte = 0;

                              foreach ($listeBE as $be) {
                                $BonAchat = $BeController->getById($be['id']);
                                $Bon = $BaController->getById($BonAchat['id_ba']);
                                $sommeQte += $Bon['Qte'];
                                $nombreBE++; ?>
                                <button type="button" class="btn btn-primary7" data-bs-toggle="modal" data-bs-target="#exampleModale<?= $be['id']; ?>">
                                  <?php
                                  $cat = $BeController->getById($be['id']);
                                  echo $cat['Ref'];
                                  ?>
                                </button>
                              <?php
                                echo  "<br>";
                                echo "<hr>";
                              } ?>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                            </div>
                          </div>
                        </div>
                      </div>

                      
                      <?php
                              $listeBE = $BeController->getListByMagasin($i['id']);
                              $nombreBE = 0;
                              $sommeQte = 0;

                              foreach ($listeBE as $be) {
                                $BonAchat = $BeController->getById($be['id']);
                                $Bon = $BaController->getById($BonAchat['id_ba']);
                                $sommeQte += $Bon['Qte'];
                                $nombreBE++; ?>
                      <div class="modal fade" id="exampleModale<?= $be['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4 class="modal-title fs-5" id="exampleModalLabel">
                                          Details de
                                          <?php
                                          $cat = $BeController->getById($be['id']);
                                          echo $cat['Ref'];
                                          ?>
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                      </div>

                                      <div class="modal-body">
                                        <div class="mb-3">
                                          <label for="message-text" class="col-form-label">Ref Bon d'achat :</label><br>
                                          <?php
                                          $BonAchat = $BeController->getById($be['id']);
                                          $BonAchat['id_ba'];
                                          $Bon = $BaController->getById($BonAchat['id_ba']);
                                          echo $Bon['Ref'];
                                          ?>
                                          <hr>
                                        </div>
                                        <div class="mb-3">
                                          <label for="message-text" class="col-form-label">Titre du produit :</label><br>
                                          <?php
                                          $BonAchat = $BeController->getById($be['id']);
                                          $BonAchat['id_ba'];
                                          $Bon = $BaController->getById($BonAchat['id_ba']);
                                          $Bon['id_produit'];
                                          $Prod = $ProduitController->getById($Bon['id_produit']);
                                          echo $Prod['Titre'];
                                          ?>
                                          <hr>
                                        </div>
                                        <div class="mb-3">
                                          <label for="message-text" class="col-form-label">Fournisseur :</label><br>
                                          <?php
                                          $BonAchat = $BeController->getById($be['id']);
                                          $BonAchat['id_ba'];
                                          $Bon = $BaController->getById($BonAchat['id_ba']);
                                          $Bon['id_fournisseur'];
                                          $Fo = $FournisseursController->getById($Bon['id_fournisseur']);
                                          echo $Fo['Nom'];
                                          ?>
                                          <hr>
                                        </div>
                                        <div class="mb-3">
                                          <label for="message-text" class="col-form-label">Quantité :</label><br>
                                          <?php
                                          $BonAchat = $BeController->getById($be['id']);
                                          $BonAchat['id_ba'];
                                          $Bon = $BaController->getById($BonAchat['id_ba']);
                                          echo $Bon['Qte'];
                                          ?>
                                          <hr>
                                        </div>
                                        <div class="mb-3">
                                          <label for="message-text" class="col-form-label">Etat :</label><br>
                                          <?php
                                          $BonAchat = $BeController->getById($be['id']);
                                          $BonAchat['id_ba'];
                                          $Bon = $BaController->getById($BonAchat['id_ba']);
                                          if ($Bon['Etat'] == 1) : echo 'payer';
                                          else : echo 'non payer';
                                          endif;
                                          ?>
                                          <hr>
                                        </div>
                                        <div class="mb-3">
                                          <label for="message-text" class="col-form-label">Date d'entrée :</label><br>
                                          <?php
                                          $BonAchat = $BeController->getById($be['id']);
                                          echo $BonAchat['date_entree'];

                                          ?>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <?php
                              } ?>
                    </th>
                    
                    
                    <th><?= $i['Date_de_Creation']; ?></th>
                    <th>
                      <?php
                      $Auteur = $CompteController->getById($i['C_par']);
                      echo $Auteur['Nom'];
                      ?>
                    </th>
                    <th><?php if ($i['Etat'] == 1) : echo 'Approvisionné';
                        else : echo 'Non approvisionné';
                        endif; ?></th>
                    <th>

                     <center> <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#update<?= $i['id']; ?>"><i class="fa fa-pen"></i></button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i['id']; ?>"><i class="fa fa-trash"></i></button>
                      <br><br><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifieretat<?= $i['id']; ?>">
                      <?php if ($i['Etat'] == 0): ?>
                          <i class="fas fa-boxes"></i> Approvisionné
                      <?php else: ?>
                          <i class="fas fa-box-open"></i> Non approvisionné
                      <?php endif; ?>
                  </button></center>


                      <div class="modal fade" id="update<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title fs-5" id="exampleModalLabel1">Modifier Magasin</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form class="form-group" method="POST" >
                              <div class="modal-body">
                                <div class="mb-3">
                                  <label for="recipient-name" class="col-form-label">Titre</label>
                                  <input type="text" class="form-control"  name="Titre" value="<?= $i['Titre']; ?>" placeholder="<?= $i['Titre']; ?>" required>
                                </div>
                                <div class="mb-3">
                                  <label for="recipient-name" class="col-form-label">Adresse</label>
                                  <input type="text" class="form-control"  name="Adresse" value="<?= $i['Adresse']; ?>" placeholder="<?= $i['Adresse']; ?>"required>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Ref_BE</label>
                                    <select class="form-control"  name="id_be" required><option value="0">Ref</option>
                                      <?php
                                        $All = $BeController->getList();
                                        foreach ($All as $key => $cat): ?>
                                      <option value="<?= $cat['id'] ; ?>"><?= $cat['Ref'] ; ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>   
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" name='modifier' value="<?= $i['id']; ?>"> Modifier</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="modal fade" id="delete<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title fs-5" id="exampleModalLabel">Supprimer Magasin</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form method="POST">
                              <div class="modal-body">
                                Voulez-vous supprimer ce Magasin ?
                              </div>
                              <input type="hidden" name="id" value="<?= $i['id']; ?>">
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" name='supp' data-bs-dismiss="modal" value="<?= $i['id']; ?>"> Supprimer</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="modal fade" id="modifieretat<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title fs-5" id="exampleModalLabel">Modifier Etat du Magasin</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                            </div>
                            <form method="POST">
                              <div class="modal-body">
                                Voulez-vous modifier l'etat de ce Magasin ?
                              </div>
                              <input type="hidden" name="id" value="<?= $i['id']; ?>">
                              <input type="hidden" name="Etat" value="<?= $i['Etat']; ?>">
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" name='modifieretat' data-bs-dismiss="modal" value="<?= $i['id']; ?>"> Modifier</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </th>
                  </tr>
                <?php
                endforeach;
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Titre</th>
                  <th>Adresse</th>
                  <th>Bons d'entrés</th>
                  <th>Date de Creation</th>
                  <th>Auteur</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>
              </tfoot>


            </table>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <?php
  include('includes/_footer.php');
  ?>


  <!-- Page level plugins -->

  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>