<?php

  // Include config file
  require_once "../config_anas.php";
  
  // Define variables and initialize with empty values
  $nom = $phone = $email = "";

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])){

    // Get hidden input value
    $id = $_POST["id"];
    
    $nom = trim($_POST["nom"]);

    $phone = trim($_POST["phone"]);

    $email = trim($_POST["email"]);
      

    $sql = "INSERT INTO pret VALUES (pret_seq.nextval, '$nom', '$phone', NULL, NULL, '$email', 'reserver', '$id')";

    if($stmt = $link->prepare($sql)){

        if($stmt->execute()){

          // Records created successfully. Redirect to landing page
          header("location: ../index.php#livres");
          exit();

        }else{
          header("location: ./erreur.php");
          exit();
        }

    }

    $stmt->closeCursor(); //PDO close

  }

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>Contact Form #9</title>
  </head>
  <body style="background-color: #166ab5;">
  

  <div class="content">
    
    <div class="container">
      <div class="row align-items-stretch no-gutters contact-wrap">
        <div class="col-md-12">
          <div class="form h-100">

            <h3 style="color:#166ab5;">Veuillez renseigner le formulaire pour réserver ce livre !</h3>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

              <div class="row">
                <div class="col-md-6 form-group mb-3">
                  <label for="" class="col-form-label">Nom *</label>
                  <input type="text" class="form-control" name="nom" id="nom" placeholder="Saisir votre nom..." required><?php echo $nom; ?></input>
                </div>
                <div class="col-md-6 form-group mb-3">
                  <label for="" class="col-form-label">Numero de téléphone *</label>
                  <input type="number" class="form-control" name="phone" id="phone"  placeholder="Saisir votre numéro de téléphone..." required><?php echo $phone; ?></input>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 form-group mb-3">
                  <label for="" class="col-form-label">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="domaine@exemple.com" required><?php echo $email; ?></input>                 
                </div>
              </div>
              <br>
              
              <div class="row">
                <div class="col-md-12 form-group">
                  <div class="text-center">
                    <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                    <a href="../index.php#livres" class="btn btn-danger rounded-0 py-2 px-4" style="margin-right:20px">Annuler</a>
                    <input type="submit" value="Réserver le livre" class="btn rounded-0 py-2 px-4" style="background-color: #f0ad4e;color:white;margin-left:20px">
                  </div>
                </div>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>

  </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/main.js"></script>

  </body>
</html>