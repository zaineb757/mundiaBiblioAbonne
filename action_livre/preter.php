<?php
// Include config file
require_once "../config_anas.php";
 
// Define variables and initialize with empty values
$nom = $phone = $debut = $fin = $email = "";
$nom_err = $phone_err = $debut_err = $fin_err = $email_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])){

  // Get hidden input value
  $id = $_POST["id"];
	
	// Validate titre du livre
  $input_nom = trim($_POST["nom"]);
  if(empty($input_nom)){
      $nom_err = "Please enter a name.";
  } else{
      $nom = $input_nom;
  }
  
  // Validate code catalogue
  $input_phone = trim($_POST["phone"]);
  if(empty($input_phone)){
      $phone_err = "Please enter an nom_auteur.";     
  } else{
      $phone = $input_phone;
  }
	
	// Validate code rayon
    $input_debut = trim($_POST["debut"]);
    if(empty($input_debut)){
        $debut_err = "Please enter an nom_auteur.";     
    } else{
        $debut = $input_debut;
    }

    // Validate code catalogue
    $input_fin = trim($_POST["fin"]);
    if(empty($input_fin)){
        $fin_err = "Please enter an nom_auteur.";     
    } else{
        $fin = $input_fin;
    }
	
	// Validate code rayon
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an nom_auteur.";     
    } else{
        $email = $input_email;
    }
    
    // Check input errors before inserting in database
    if(empty($nom_err) && empty($phone_err) && empty($debut_err) && empty($fin_err) && empty($email_err) && $fin>=$debut && $fin<=date('Y-m-d', strtotime($debut. ' + 14 days'))){

      $sql = "INSERT INTO pret VALUES (pret_seq.nextval, '$nom', '$phone', TO_DATE('$debut','YYYY-MM-DD'), TO_DATE('$fin','YYYY-MM-DD'), '$email', 'preter', '$id')";
        
      if($stmt = $link->prepare($sql)){
          if($stmt->execute()){

              $sql = "UPDATE livre SET disponible=0 WHERE ID_LIVRE='$id'"; 

              if($stmt = $link->prepare($sql)){
                if($stmt->execute()){
                  // Records created successfully. Redirect to landing page
                  header("location: ../index.php#livres");
                  exit();
                }
              }
          } else{
              echo "Something went wrong. Please try again later.";
          }
      }
      
      $stmt->closeCursor(); //PDO close
    }
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

            <h3>Veuillez renseigner le formulaire pour prêter ce livre !</h3>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

              <div class="row">
                <div class="col-md-6 form-group mb-3 <?php echo (!empty($nom_err)) ? 'has-error' : ''; ?>">
                  <label for="" class="col-form-label">Nom *</label>
                  <input type="text" class="form-control" name="nom" id="nom" placeholder="Saisir votre nom..."><?php echo $nom; ?></input>
                  <span class="help-block"><?php echo $nom_err;?></span>
                </div>
                <div class="col-md-6 form-group mb-3 <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                  <label for="" class="col-form-label">Numero de téléphone *</label>
                  <input type="number" class="form-control" name="phone" id="phone"  placeholder="Saisir votre numéro de téléphone..."><?php echo $phone; ?></input>
                  <span class="help-block"><?php echo $phone_err;?></span>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group mb-3 <?php echo (!empty($debut_err)) ? 'has-error' : ''; ?>">
                  <label for="" class="col-form-label">Date début *</label>
                  <input type="date" class="form-control" name="debut" id="debut"><?php echo $debut; ?></input>
                  <span class="help-block"><?php echo $debut_err;?></span>
                </div>
                <div class="col-md-6 form-group mb-3 <?php echo (!empty($fin_err)) ? 'has-error' : ''; ?>">
                  <label for="" class="col-form-label">Date fin *</label>
                  <input type="date" class="form-control" name="fin" id="fin" onchange="checkDates()"><?php echo $fin; ?></input>
                  <span class="help-block"><?php echo $fin_err;?></span>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 form-group mb-3 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                  <label for="" class="col-form-label">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="domaine@exemple.com"><?php echo $email; ?></input>     
                  <span class="help-block"><?php echo $email_err;?></span>             
                </div>
              </div>
              <br>
              
              <div class="row">
                <div class="col-md-12 form-group">
                  <div class="text-center">
                    <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                    <a href="../index.php#livres" class="btn btn-danger rounded-0 py-2 px-4" style="margin-right:20px">Annuler</a>
                    <input type="submit" value="Prêter le livre" class="btn rounded-0 py-2 px-4" style="background-color: #166ab5;color:white;margin-left:20px">
                    <span class="submitting"></span>
                  </div>
                </div>
              </div>

            </form>

            <div id="form-message-warning mt-4"></div> 
            <div id="form-message-success">
              Vous venez de prêter ce livre, merci !
            </div>
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
    <script src="js/date.js"></script>

  </body>
</html>