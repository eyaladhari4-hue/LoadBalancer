<?php
$title = 'Fournisseurs';
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
      <h1 class="h3 mb-2 text-gray-800">Gestion de Fournisseurs</h1>
                      
    <?php
      if (isset($_POST['ajouter'])){
        $date=date('y-m-d à H:i');
        echo ($FournisseursController->addtab($_POST['Nom'],$_POST['tel'],$date,$currentUser['id'],'1','2') ? "success" : "failed");
      }
      if (isset($_POST['modifier'])) {
        echo ($FournisseursController->UpdateTab($_POST['modifier'], $_POST['Nom'],$_POST['tel']) ? "success" : "failed");
      }
      if (isset($_POST['supp'])){
        echo ($FournisseursController->delete($_POST['supp']) ? "success" : "failed");
      }
      if (isset($_POST['modifieretat'])) {
        echo ($FournisseursController->UpdateEtat($_POST['id'], $_POST['Etat']) ? "success" : "failed");
    }
    ?>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
      <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h5 class=" mb-0 text-gray-800">Table de Fournisseurs</h5>
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"data-bs-toggle="modal" data-bs-target="#addCat">Ajouter</button>
                    </div>
                    <div class="modal fade" id="addCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title fs-5" id="exampleModalLabel">Nouveau Fournisseur</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-group" method="post" id="ajoutForm">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nom</label>
                                        <input type="text" class="form-control" name="Nom" id="recipient-name" placeholder="Nom" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Numero de telephone</label>
                                        <input type="text" class="form-control" name="tel" id="recipient-name" placeholder="Numero de telephone" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary" name='ajouter'>Ajouter</button>
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
                    
                    <th>Nom</th>
                    <th>Numero de telephone</th>
                    <th>Date De Creation</th>
                    <th>Auteur</th>
                    <th>Etat</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $listcategories = $FournisseursController->getList();
                  foreach ($listcategories as $i) :
                  ?>
                    <tr>
                      <th><?= $i['Nom']; ?></th>
                      <th><?= $i['tel']; ?></th>
                      <th><?= $i['Date_de_creation']; ?></th>
                      <th>
                        <?php 
                          $Auteur=$CompteController->getById($i['C_par']);
                          echo $Auteur['Nom'] ;
                        ?>
                      </th> 
                      <th><?php if ($i['Etat']==1): echo 'Actif' ;else: echo 'Inactif' ; endif; ?></th>
                      <th>
                        <center><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#update<?= $i['id']; ?>"><i class="fa fa-pen"></i></button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i['id']; ?>"><i class="fa fa-trash"></i></button>
                        <br><br><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifieretat<?= $i['id']; ?>">
                        <?php if ($i['Etat'] == 0): ?>
                            <i class="fas fa-check"></i> Actif
                        <?php else: ?>
                            <i class="fas fa-times"></i> Inactif
                        <?php endif; ?>
                    </button></center>

                        <div class="modal fade" id="update<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title fs-5" id="exampleModalLabel1">Modifier Fournisseur</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                              </div>
                              <form class="form-group" method="POST">
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Nom</label>
                                    <input type="text" class="form-control" name="Nom" value=" <?=$i['Nom']; ?>" placeholder="<?= $i['Nom']; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Numero de telephone</label>
                                    <input type="text" class="form-control" name="tel" value=" <?=$i['tel']; ?>" placeholder="<?= $i['tel']; ?>">
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
                                <h4 class="modal-title fs-5" id="exampleModalLabel">Supprimer Fournisseur</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                              </div>
                              <form method="POST">
                                <div class="modal-body">
                                  Voulez-vous supprimer ce Fournisseur ?
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
                              <h4 class="modal-title fs-5" id="exampleModalLabel">Modifier Etat du Fournisseur</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form method="POST">
                              <div class="modal-body">
                                Voulez-vous modifier l'etat de ce Fournisseur ?
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
                    <th>Nom</th>
                    <th>Numero de telephone</th>
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

      </div>
      <!-- /.container-fluid -->

    </div>
    <?php
    include('includes/_footer.php');
    ?>


    <!-- Page level plugins -->

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

      