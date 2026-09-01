<?php
$title = 'Produits';
$css = '';
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
      <h1 class="h3 mb-2 text-gray-800">Gestion de Produits</h1>
                            
      <?php
      if (isset($_POST['ajouter'])){
        $date=date('y-m-d à H:i');
        if (isset($_FILES["Image"]) && $_FILES["Image"]["error"] == 0) {
          $uploadDir = "img/";
          $ImgName= time().'-'.$_FILES["Image"]["name"];
          $uploadFile = $uploadDir . basename($ImgName);
          if (move_uploaded_file($_FILES["Image"]["tmp_name"], $uploadFile)) {
              echo ($ProduitController->addtab($_POST['Titre'],$_POST['Prix'],$ImgName,$_POST['Description'],$_POST['idCat'],$date,$currentUser['id'],'1') ? "success" : "failed");
          } else {
              echo "Error uploading file.";
          }
        } else {
            echo "No file uploaded or an error occurred during upload.";
        }
      }
      if (isset($_POST['modifier'])) {
        if (isset($_FILES["Image"]) && $_FILES["Image"]["error"] == 0) {
          $uploadDir = "img/";
          $ImgName= time().'-'.$_FILES["Image"]["name"];
          $uploadFile = $uploadDir . basename($ImgName);
          if (move_uploaded_file($_FILES["Image"]["tmp_name"], $uploadFile)) {
        echo ($ProduitController->UpdateTab($_POST['modifier'], $_POST['Titre'], $_POST['Prix'], $ImgName, $_POST['Description']) ? "success" : "failed");
      }else {
        echo "Error uploading file.";
    }
  } else {
      echo "No file uploaded or an error occurred during upload.";
  }
}
      if (isset($_POST['supp'])){
        
        echo ($ProduitController->delete($_POST['supp']) ? "success" : "failed");
      }
      if (isset($_POST['modifieretat'])) {
        echo ($ProduitController->UpdateEtat($_POST['id'], $_POST['Etat']) ? "success" : "failed");
    }
    
      ?>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h5 class=" mb-0 text-gray-800">Table de produits</h5>
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"data-bs-toggle="modal" data-bs-target="#add">Ajouter</button>
                    </div>
         
           
        
          <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title fs-5" id="exampleModalLabel">Nouveau Produit</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                  <form class="form-group" method="post" enctype="multipart/form-data" id="ajoutForm">
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Image</label>
                      <input type="file" class="form-control" name="Image" id="recipient-name" placeholder="Image" required>
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Titre</label>
                      <input type="text" class="form-control" name="Titre"  id="recipient-name" placeholder="Titre" required>
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Prix</label>
                      <input type="text" class="form-control" name="Prix" id="recipient-name"placeholder="Prix" required>
                    </div>
                    <div class="mb-3">
                      <label for="message-text" class="col-form-label">Description</label>
                      <input type="text" class="form-control" name="Description"id="recipient-name" placeholder="Description" required>
                    </div>    
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Catégorie</label>
                      <select name="idCat" id="recipient-name" required>
                        <?php
                          $All = $CategoriesController->getList();
                          foreach ($All as $key => $cat): ?>
                        <option value="<?= $cat['id'] ; ?>"><?= $cat['Titre'] ; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-primary" name='ajouter' > Ajouter</button>
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
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th>Date_De_Creation</th>
                    <th>Auteur</th>
                    <th>Etat</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $listproduits = $ProduitController->getList();
                  foreach ($listproduits as $i) :
                  ?>
                    <tr>
                      <th><img src="img/<?= $i['Image']; ?>" alt="" style="width: 150px !important;"></th>
                      <th><?= $i['Titre']; ?></th>
                      <th><?= $i['Prix']; ?></th>
                      
                      <th>
                        <?php
                          $cat=$CategoriesController->getById($i['idCat']);
                          echo $cat['Titre'] ;
                        ?>
                      </th>
                      <th><?= $i['Description']; ?></th>
                      <th><?= $i['Date_De_Creation']; ?></th>
                      <th>
                        <?php 
                          $Auteur=$CompteController->getById($i['C_par']);
                          echo $Auteur['Nom'] ;
                        ?>
                      </th>
                      <th><?php if ($i['Etat']==1): echo 'Disponible' ;else: echo 'Indisponible' ; endif; ?></th>
                      <th>
                        <center> <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#update<?= $i['id']; ?>"><i class="fa fa-pen"></i></button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $i['id']; ?>"><i class="fa fa-trash"></i></button>
                        </center> <br><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifieretat<?= $i['id']; ?>">
                          <?php if ($i['Etat'] == 0): ?>
                              <i class="fas fa-check"></i> Disponible
                          <?php else: ?>
                              <i class="fas fa-times"></i> Indisponible
                          <?php endif; ?>
                      </button>

                        <div class="modal fade" id="update<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title fs-5" id="exampleModalLabel1">Modifier Produit</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                              </div>
                              <form class="form-group" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Image</label>
                                    <input type="file" class="form-control" name="Image" value="<?= $i['Image']; ?>" placeholder="<?= $i['Image']; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Titre</label>
                                    <input type="text" class="form-control" name="Titre" value="<?= $i['Titre']; ?>" placeholder="<?= $i['Titre']; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Prix</label>
                                    <input type="text" class="form-control" name="Prix" value="<?= $i['Prix']; ?>" placeholder="<?= $i['Prix']; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Description</label>
                                    <input type="text" class="form-control" name="Description" value="<?= $i['Description']; ?>" placeholder="<?= $i['Description']; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Catégorie</label>
                                    <select name="idCat">
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
                                  <button type="submit" class="btn btn-primary" name="modifier" value="<?= $i['id']; ?>"> Modifier</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="delete<?= $i['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title fs-5" id="exampleModalLabel">Supprimer Produit</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                              </div>
                              <form class="form-group" method="POST" enctype="multipart/form-data">
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
                              <h4 class="modal-title fs-5" id="exampleModalLabel">Modifier Etat du Produit</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <form class="form-group" method="POST" enctype="multipart/form-data">
                              <div class="modal-body">
                                Voulez-vous modifier l'etat de ce Produit ?
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
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th>Date_De_Creation</th>
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