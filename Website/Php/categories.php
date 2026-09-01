<?php
$title = 'Categories';
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
      <h1 class="h3 mb-2 text-gray-800">Gestion de Catégories</h1>
                      
    <?php
      if (isset($_POST['ajouter'])){
        $date=date('y-m-d à H:i');
        echo ($CategoriesController->addtab($_POST['Titre'],$_POST['idParrin'],$date,$currentUser['id']) ? "success" : "failed");
      }
      if (isset($_POST['modifier'])) {
        echo ($CategoriesController->UpdateTab($_POST['modifier'], $_POST['Titre'], $_POST['idParrin']) ? "success" : "failed");
      }
      if (isset($_POST['supp'])){
        echo ($CategoriesController->delete($_POST['supp']) ? "success" : "failed");
      }
    ?>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
      <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h5 class=" mb-0 text-gray-800">Table de Categories</h5>
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"data-bs-toggle="modal" data-bs-target="#addCat">Ajouter</button>
                    </div>
          <div class="modal fade" id="addCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title fs-5" id="exampleModalLabel">Nouvelle Catégorie</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                  <form class="form-group" method="post">
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Titre</label>
                      <input type="text" class="form-control" name="Titre" placeholder="Titre">
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Catégorie Parrin</label>
                      <select name="idParrin">
                        <option value="0">Catégorie parrin</option>
                        <?php
                          $All = $CategoriesController->getList();
                          foreach ($All as $key => $cat): ?>
                        <option value="<?= $cat['id'] ; ?>"><?= $cat['Titre'] ; ?></option>
                        <?php endforeach; ?>
                      </select>
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
                    
                    <th>Titre</th>
                    <th>Catégorie Parrin</th>
                    <th>Date De Creation</th>
                    <th>Auteur</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $listcategories = $CategoriesController->getList();
                  foreach ($listcategories as $i) :
                  ?>
                    <tr>
                      <th><?= $i['Titre']; ?></th>
                      <th>
                        <?php
                        if ($i['idParrin']>0){
                          $cat=$CategoriesController->getById($i['idParrin']);
                          echo $cat['Titre'] ;
                        }else{
                          echo 'Catégorie parrin';
                        }
                        ?>
                      </th>
                      <th><?= $i['Date_de_Creation']; ?></th>
                      <th>
                        <?php 
                          $Auteur=$CompteController->getById($i['C_par']);
                          echo $Auteur['Nom'] ;
                        ?>
                      </th> 
                      <th>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#update<?= $i['id']; ?>"><i class="fa fa-pen"></i></button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i['id']; ?>"><i class="fa fa-trash"></i></button>
                        
                        <div class="modal fade" id="update<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title fs-5" id="exampleModalLabel1">Modifier Catégorie</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                              </div>
                              <form class="form-group" method="POST">
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Titre</label>
                                    <input type="text" class="form-control" name="Titre" value=" <?=$i['Titre']; ?>" placeholder="<?= $i['Titre']; ?>">
                                  </div>
                                  <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Catégorie Parrin</label>
                      <select name="idParrin">
                        <option value="0">Catégorie parrin</option>
                        <?php
                          $All = $CategoriesController->getList();
                          foreach ($All as $key => $cat): ?>
                        <option value="<?= $cat['id'] ; ?>"><?= $cat['Titre'] ; ?></option>
                        <?php endforeach; ?>
                      </select>
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
                                <h4 class="modal-title fs-5" id="exampleModalLabel">Supprimer catégorie</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                              </div>
                              <form method="POST">
                                <div class="modal-body">
                                  Voulez-vous supprimer cette catégorie ?
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
                    <th>Titre</th>
                    <th>Catégorie Parrin</th>
                    <th>Date De Creation</th>
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
    <?php
    include('includes/_footer.php');
    ?>


    <!-- Page level plugins -->

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

      