<?php
$title = 'Login';
$css = '';
$js = '';

include ('includes/_head.php') ;
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                <form class="user" method="post">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <?php
                    if (isset($_POST['cnx'])) {
                        $currentUser = $CompteController->getCnxCpt($_POST['Login'], $_POST['Password']);
                        if ($currentUser && is_array($currentUser)) {
                            if ($currentUser['Etat'] == 1) {
                                $_SESSION['Id'] = $currentUser['id'];
                                echo '<script>document.location.href="dashboard.php"</script>';
                            } else {
                                echo '
                                    <div class="alert alert-block alert-danger fade in">
                                        <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <strong>Erreur de connexion</strong> Compte innactif ou suspendu.
                                    </div>';
                            }
                        } else {
                            echo '
                                <div class="alert alert-block alert-danger fade in">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <strong>Erreur de connexion</strong> nom d\'utilisateur et/ou mot de passe invalide!
                                </div>';
                        }
                    }
                ?>
                                    <div class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" placeholder="Entrer nom d'utilisateur" name="Login" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="Password" class="form-control form-control-user" placeholder="Entrer mot de passe" name="Password" required >
                                        </div>
                                    
                                        <button class="btn btn-primary btn-user btn-block" type="submit" name="cnx">
                                            Login
                                        </button>
                                       
                                       
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>
