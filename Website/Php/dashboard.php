<?php
$title = 'Dashboard';
$css = '';
$js = '';
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
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      </div>
      <?php
      if (isset($_POST['ajouterp'])){
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
      if (isset($_POST['ajouterc'])){
        $date=date('y-m-d à H:i');
        echo ($CategoriesController->addtab($_POST['Titre'],$_POST['idParrin'],$date,$currentUser['id']) ? "success" : "failed");
      }
       if (isset($_POST['ajouterb'])){
        $date=date('y-m-d à H:i');
        $lastId = $BaController->getLastId() +1;
        $ref="BA".date('y').str_pad($lastId, 6, '0', STR_PAD_LEFT) ;
        echo ($BaController->addtab($ref,$_POST['id_produit'],$_POST['id_fournisseur'],'0',$date,$currentUser['id'],$_POST['Qte']) ? "success" : "failed");
      }
      if (isset($_POST['ajouterf'])){
        $date=date('y-m-d à H:i');
        echo ($FournisseursController->addtab($_POST['Nom'],$_POST['tel'],$date,$currentUser['id'],'1','2') ? "success" : "failed");
      }
      ?>
      <!-- Content Row -->
      <div class="row" style="width: 1101px">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary1 text-uppercase mb-1">
                    Nombre de Produits</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $totalProducts = $ProduitController->countProducts();
                    echo $totalProducts; ?>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-box-open fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success1 text-uppercase mb-1">
                    Nombre de Catégories</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $totalcategories = $CategoriesController->countcategorie();
                    echo $totalcategories; ?>
                  </div>
                </div>

                <div class="col-auto">
                  <i class="fas fa-edit fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info1 text-uppercase mb-1">Nombre de Magasins
                  </div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $totalMagasins = $MagasinController->countMagasins();
                    echo $totalMagasins; ?>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-store-alt fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    ID du dernier Bon d'entré</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php
                    $latestBeId = $BeController->getLatestBeId();
                    echo $latestBeId; ?>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Row -->

      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Stock/Magasins</h6>

            </div>
            <!-- Card Body -->
            <div class="card-body">
              <?php
              $output = $MagasinController->QteStock();
              echo $output;
              ?>
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Categories/Produits</h6>

            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
              </div>
              <div class="mt-4 text-center small">
                <span class="mr-2">
                  <i class="fas fa-circle text-primary"></i> Categorie 1
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-success"></i> Categorie 2
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-info"></i> Categorie 3
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Color System -->
      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="card bg-primary text-white shadow">
            <div class="card-body"> <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduit">Ajouter Produit</button>
              <div class="modal fade" id="addproduit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title fs-5" id="exampleModalLabel">Nouveau Produit</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                  <form class="form-group" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Image</label>
                      <input type="file" class="form-control" name="Image" placeholder="Image">
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Titre</label>
                      <input type="text" class="form-control" name="Titre" placeholder="Titre">
                    </div>
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Prix</label>
                      <input type="text" class="form-control" name="Prix" placeholder="Prix">
                    </div>
                    <div class="mb-3">
                      <label for="message-text" class="col-form-label">Description</label>
                      <input type="text" class="form-control" name="Description" placeholder="Description">
                    </div>    
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">Catégorie</label>
                      <select class="form-control" name="idCat">
                        <?php
                          $All = $CategoriesController->getList();
                          foreach ($All as $key => $cat): ?>
                        <option value="<?= $cat['id'] ; ?>"><?= $cat['Titre'] ; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-primary" name='ajouterp' data-bs-dismiss="modal" value="<?= $i['id']; ?>"> Ajouter</button>
                    </div>
                  </form>
                </div>
                  </div>
                </div>
              </div>
              <div class="text-white-50 small"><i class="fas fa-box-open fa-2x text-gray-300"></i></div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card bg-success text-white shadow">
            <div class="card-body">
              <button type="button" class="btn btn-primary1" data-bs-toggle="modal" data-bs-target="#addCat">Ajouter Catégorie</button>
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
                      <select class="form-control" name="idParrin">
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
                      <button type="submit" class="btn btn-primary" name='ajouterc' data-bs-dismiss="modal" value="<?= $i['id']; ?>"> Ajouter</button>
                    </div>
                  </form>
                  
                </div>
                  </div>
                </div>
              </div>

              <div class="text-white-50 small"><i class="fas fa-edit fa-2x text-gray-300"></i></div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card bg-info text-white shadow">
            <div class="card-body">
              <button type="button" class="btn btn-primary2" data-bs-toggle="modal" data-bs-target="#addBA">Ajouter Bon d'Achat</button>
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
                      <select class="form-control" name="id_produit"><option value="0">Produit</option>
                        <?php
                          $All = $ProduitController->getList();
                          foreach ($All as $key => $cat): ?>
                        <option value="<?= $cat['id'] ; ?>"><?= $cat['Titre'] ; ?></option>
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
                      <input type="text" class="form-control" name="Qte" placeholder="Qte">
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-primary" name='ajouterb' data-bs-dismiss="modal" value="<?= $i['id']; ?>"> Ajouter</button>
                     
                    </div>
                  </form>
                </div>
              </div>
            </div>
          
              <div class="text-white-50 small"><i class="fas fa-money-bill fa-2x text-gray-300"></i></div>
            </div>
          </div>
        </div>
       
        <div class="col-lg-6 mb-4">
          <div class="card bg-warning text-white shadow">
            <div class="card-body">
              <button type="button" class="btn btn-primary3" data-bs-toggle="modal" data-bs-target="#addFr">Ajouter Fournisseur</button>
              <div class="modal fade" id="addFr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <button type="submit" class="btn btn-primary" name='ajouterf'>Ajouter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="text-white-50 small"><i class="fas fa-store-alt fa-2x text-gray-300"></i></div>
            </div>
          </div>
        </div>


      </div>

    </div>









    <!-- End of Main Content -->

    <?php
    include('includes/_footer.php');
    ?>
    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>