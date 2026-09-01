<?php
$title = 'Bon Entrés';
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
      <h1 class="h3 mb-2 text-gray-800">Gestion de Bons d'Entrés</h1>
      <?php
      if (isset($_POST['ajouter'])) {
        $lastId = $BeController->getLastId() + 1;
        $ref = "BE" . date('y') . str_pad($lastId, 6, '0', STR_PAD_LEFT);
        $ajouterbe = $BeController->addtab($ref, $_POST['id_ba'], $_POST['id_Magasin'], $_POST['date_entree'],$_POST['date_paiement'], $currentUser['id'], '1') ? "success" : "failed";
        if (isset($ajouterbe)){
          $ba= $BaController->getById($_POST['id_ba']);
          echo ( $BaController->UpdateEtat($ba['id'], $ba['Etat']) ? "success" : "failed");
        }
      }
      if (isset($_POST['modifier'])) {
        echo ($BeController->UpdateTab($_POST['modifier'], $_POST['id_ba'],$_POST['id_Magasin'], $_POST['date_entree'], $_POST['date_paiement']) ? "success" : "failed");
      }
      if (isset($_POST['supp'])) {
        echo ($BeController->delete($_POST['supp']) ? "success" : "failed");
      }

      ?>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class=" mb-0 text-gray-800">Table de Bons d'Entrés</h5>
          <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#add">Ajouter</button>
        </div>

        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Nouveau Bon d'Entré</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
              </div>
              <div class="modal-body">
                <form class="form-group" method="post">

                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Bon d'achat</label>
                    <select class="form-control" name="id_ba">
                      <option value="0">Liste des bon d'achats</option>
                      <?php
                      $All = $BaController->getList();
                      foreach ($All as $key => $BonAchat) : ?>
                        <option value="<?= $BonAchat['id']; ?>"><?= $BonAchat['Ref']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Magasin</label>
                    <select class="form-control" name="id_Magasin">
                      <option value="0">Liste des Magasins</option>
                      <?php
                      $All = $MagasinController->getList();
                      foreach ($All as $key => $Magasin) : ?>
                        <option value="<?= $Magasin['id']; ?>"><?= $Magasin['Titre']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Date d'entrée</label>
                    <input type="date" class="form-control" name="date_entree" placeholder="date_entree">
                  </div>
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Date de paiement</label>
                    <input type="date" class="form-control" name="date_paiement" placeholder="date_paiement">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name='ajouter' data-bs-dismiss="modal" value="<?= $i['id']; ?>"> Ajouter</button>


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

                  <th>Ref</th>
                  <th>Ref Ba</th>
                  <th>Magasin</th>
                  <th>Date d'entrée</th>
                  <th>Date paiement</th>
                  <th>Auteur</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $listbe = $BeController->getList();
                foreach ($listbe as $i) :
                ?>
                  <tr>

                    <th><?= $i['Ref']; ?></th>
                    <th>
                      <?php
                      $cat = $BaController->getById($i['id_ba']);
                      echo $cat['Ref'];
                      ?>

                    </th>
                    <th><?php
                      $cat = $MagasinController->getById($i['id_magasin']);
                      echo $cat['Titre'];
                      ?></th>
                    <th><?= $i['date_entree']; ?></th>
                    <th><?= $i['date_paiement']; ?></th>
                    <th>
                      <?php
                      $Auteur = $CompteController->getById($i['C_par']);
                      echo $Auteur['Nom'];
                      ?>
                    </th>
                    <th>
                      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#update<?= $i['id']; ?>"><i class="fa fa-pen"></i></button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i['id']; ?>"><i class="fa fa-trash"></i></button>
                      
                      <div class="modal fade" id="update<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title fs-5" id="exampleModalLabel1">Modifier Bon d'Entré</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form class="form-group" method="POST">
                              <div class="modal-body">

                                <div class="mb-3">
                                  <label for="recipient-name" class="col-form-label">Ref_BA</label>
                                  <select name="id_ba">
                                    <option value="0">Ref</option>
                                    <?php
                                    $All = $BaController->getList();
                                    foreach ($All as $key => $cat) : ?>
                                      <option value="<?= $cat['id']; ?>"><?= $cat['Ref']; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Magasin</label>
                                <select class="form-control" name="id_Magasin">
                                  <option value="0">Liste des Magasins</option>
                                  <?php
                                  $All = $MagasinController->getList();
                                  foreach ($All as $key => $Magasin) : ?>
                                    <option value="<?= $Magasin['id']; ?>"><?= $Magasin['Titre']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                                <div class="mb-3">
                                  <label for="message-text" class="col-form-label">date_entree</label>
                                  <input type="date" class="form-control" name="date_entree" value="<?= $i['date_entree']; ?>" placeholder="<?= $i['date_entree']; ?>">
                                </div>
                                <div class="mb-3">
                                  <label for="message-text" class="col-form-label">date_paiement</label>
                                  <input type="date" class="form-control" name="date_paiement" value="<?= $i['date_paiement']; ?>" placeholder="<?= $i['date_paiement']; ?>">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" name='modifier' data-bs-dismiss="modal" value="<?= $i['id']; ?>"> Modifier</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="modal fade" id="delete<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title fs-5" id="exampleModalLabel">Supprimer Bon d'Entré</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form method="POST">
                              <div class="modal-body">
                                Voulez-vous supprimer ce Bon d'Entré ?
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
                    </th>
                  </tr>
                <?php
                endforeach;
                ?>
              </tbody>
              <tfoot>
                <tr>

                  <th>Ref</th>
                  <th>Ref_ba</th>
                  <th>Magasin</th>
                  <th>date_d'entrée</th>
                  <th>date paiement</th>
                  <th>Auteur</th>
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