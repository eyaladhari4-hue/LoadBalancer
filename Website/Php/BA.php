<?php
$title = 'Bon Achat';
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
      <h1 class="h3 mb-2 text-gray-800">Gestion de Bons d'Achats</h1>

      <?php
      if (isset($_POST['ajouter'])) {
        $date = date('y-m-d à H:i');
        $lastId = $BaController->getLastId() + 1;
        $ref = "BA" . date('y') . str_pad($lastId, 6, '0', STR_PAD_LEFT);
        echo ($BaController->addtab($ref, $_POST['id_produit'], $_POST['id_fournisseur'], '0', $date, $currentUser['id'], $_POST['Qte']) ? "success" : "failed");
      }
      if (isset($_POST['modifier'])) {
        echo ($BaController->UpdateTab($_POST['modifier'], $_POST['id_produit'], $_POST['id_fournisseur'], $_POST['Qte']) ? "success" : "failed");
      }
      if (isset($_POST['supp'])) {
        echo ($BaController->delete($_POST['supp']) ? "success" : "failed");
      }
      if (isset($_POST['modifieretat'])) {
        echo ($BaController->UpdateEtat($_POST['id'], $_POST['Etat']) ? "success" : "failed");
      }

      ?>


      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class=" mb-0 text-gray-800">Table de Bons d'Achats</h5>
          <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addBA">Ajouter</button>

          <div class="modal fade" id="addBA" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title fs-5" id="exampleModalLabel">Nouveau Bon d'Achat</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                  <form class="form-group" method="post">
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Produit</label>
                      <select class="form-control" name="id_produit">
                        <option value="0">Liste des produits</option>
                        <?php
                        $All = $ProduitController->getList();
                        foreach ($All as $key => $produit) : ?>
                          <option value="<?= $produit['id']; ?>"><?= $produit['Titre']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Fournisseur</label>
                      <select class="form-control" name="id_fournisseur">
                        <option value="0">Liste des fournisseurs</option>
                        <?php
                        $All = $FournisseursController->getList();
                        foreach ($All as $key => $fournisseur) : ?>
                          <option value="<?= $fournisseur['id']; ?>"><?= $fournisseur['Nom']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Qte</label>
                      <input type="number" class="form-control" name="Qte" placeholder="Qte">
                    </div>
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
                  <th>Titre</th>
                  <th>fournisseur</th>
                  <th>Qte</th>
                  <th>Date_De_Creation</th>
                  <th>Auteur</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $listproduits = $BaController->getList();
                foreach ($listproduits as $i) :
                ?>
                  <tr>

                    <th><?= $i['Ref']; ?></th>
                    <th>
                      <?php
                      $produit = $ProduitController->getById($i['id_produit']);
                      echo $produit['Titre'];
                      ?>
                    </th>
                    <th> 
                      <?php
                      $fournisseur = $FournisseursController->getById($i['id_fournisseur']);
                      echo $fournisseur['Nom'];
                      ?>
                      </th>
                    <th><?= $i['Qte']; ?></th>
                    <th><?= $i['Date_De_Creation']; ?></th>
                    <th>
                      <?php
                      $Auteur = $CompteController->getById($i['C_par']);
                      echo $Auteur['Nom'];
                      ?>
                    </th>
                    <th><?php if ($i['Etat'] == 1) : echo 'Payé';
                        else : echo 'Non payé';
                        endif; ?></th>
                    <th>
                      <center><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#update<?= $i['id']; ?>"><i class="fa fa-pen"></i></button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i['id']; ?>"><i class="fa fa-trash"></i></button>
                       <br><br><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifieretat<?= $i['id']; ?>">
                          <?php if ($i['Etat'] == 0): ?>
                              <i class="fas fa-check"></i> Payé
                          <?php else: ?>
                              <i class="fas fa-times"></i> Non Payé
                          <?php endif; ?>
                      </button></center>
                      <div class="modal fade" id="update<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title fs-5" id="exampleModalLabel1">Modifier Bon d'Achat</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form class="form-group" method="POST">
                              <div class="modal-body">
                                <div class="mb-3">
                                  <label for="recipient-name" class="col-form-label">Produit</label>
                                  <select class="form-control" name="id_produit">
                                    <option value="0">Produit</option>
                                    <?php
                                    $All = $ProduitController->getList();
                                    foreach ($All as $key => $cat) : ?>
                                      <option value="<?= $cat['id']; ?>"><?= $cat['Titre']; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                 <div class="mb-3">
                                  <label for="recipient-name" class="col-form-label">Fournisseur</label>
                                  <select class="form-control" name="id_fournisseur">
                                    <option value="0">Liste des fournisseurs</option>
                                    <?php
                                    $All = $FournisseursController->getList();
                                    foreach ($All as $key => $fournisseur) : ?>
                                      <option value="<?= $fournisseur['id']; ?>"><?= $fournisseur['Nom']; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="mb-3">
                                  <label for="recipient-name" class="col-form-label">Qte</label>
                                  <input type="text" class="form-control" name="Qte" value="<?= $i['Qte']; ?>" placeholder="<?= $i['Qte']; ?>">
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
                              <h4 class="modal-title fs-5" id="exampleModalLabel">Supprimer Bon d'Achat</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form method="POST">
                              <div class="modal-body">
                                Voulez-vous supprimer ce produit ?
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
                              <h4 class="modal-title fs-5" id="exampleModalLabel">Modifier Etat du Bon d'Achat</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form method="POST">
                              <div class="modal-body">
                                Voulez-vous modifier l'etat de ce Bon d'Achat ?
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
                  <th>Ref</th>
                  <th>Titre</th>
                  <th>fournisseur</th>
                  <th>Qte</th>
                  <th>Date De Creation</th>
                  <th>Auteur</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>
              </tfoot>


            </table>
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