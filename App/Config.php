<?php
require_once "Controllers/DatabaseController.php";
$DatabaseController = new DatabaseController();
$db = $DatabaseController->getConnectionDB();

require_once "Controllers/CompteController.php";
$CompteController = new CompteController($db);

require_once "Controllers/ProduitController.php";
$ProduitController = new Produitcontroller($db);

require_once "Controllers/BeController.php";
$BeController = new BeController($db);

require_once "Controllers/BaController.php";
$BaController = new BaController($db);

require_once "Controllers/MagasinController.php";
$MagasinController = new MagasinController($db);


require_once "Controllers/StockController.php";
$StockController = new StockController($db);

require_once "Controllers/CategoriesController.php";
$CategoriesController = new CategoriesController($db);

require_once "Controllers/ReglementsController.php";
$ReglementsController = new ReglementsController($db);

require_once "Controllers/FournisseursController.php";
$FournisseursController = new FournisseursController($db);