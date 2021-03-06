<?php 
session_start();
require_once "pdo.php";
if ( isset($_POST['cancel'] ) ) {
  // Redirect the browser to game.php
  header("Location: index.php");
  return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is meow123

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
  if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
      $_SESSION['error'] = "E-Mail und Passwort sind erforderlich";
      header("Location: index.php");
      return;
      
  } 
  else if ( strpos(($_POST['email']),'@' ) === false ) {
      $_SESSION['error'] = "E-Mail muss ein at-Zeichen (@) enthalten";
      header("Location: index.php");
      return;
  }    
  
  
  else {
      
      $check = hash('md5', $salt.$_POST['pass']);
      $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
      $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);


      if ( $row !== false ) {
          $_SESSION['name'] = $row['name'];
          $_SESSION['user_id'] = $row['user_id'];  
          // Redirect the browser to index.php 
          
          header("Location: contactus.php");  
          $_SESSION['success'] = "Anmeldung erfolgreich";
          return;
          error_log("Login success ".$_row['user_id']);
          return; }

      else {
              $_SESSION['error'] = "Falsches Passwort";
              header("Location: contactus.php");
              return;
           error_log("Login fail ".$_row['user_id']." $check");
      }
  }
}

// Fall through into the View

?>





<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>


<script>

function doValidate() {

console.log('Validating...');

try {

    pw = document.getElementById('id_1723').value;
    eml = document.getElementById('nam').value;
    console.log("Validating pw="+pw);

    if (pw == null || pw == ""|| eml==null || eml=="" ) {
        alert("Beide Felder m??ssen ausgef??llt werden");
        return false; }
     if  (eml.indexOf('@') == -1)
  { alert("Ung??ltige E-Mail Adresse");
  return false; } 
else
   {return true; }

} catch(e) {
    return false;
}
return false;
}
</script>

    <!DOCTYPE html>
    <html lang="de">
    <head>
    <title>Kontakt ResumePro Team</title>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
     
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="css/styles.css">
</head>


<body>
     <nav class="navbar navbar-dark navbar-expand-sm  fixed-top">
     <div class="container">
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar">
           <span class="navbar-toggler-icon"></span>
         </button>
          
         <a class="navbar-brand mr-auto" href="#"><img src="img/logo.png" height="33.8" width="60"></a>

          <div class="collapse navbar-collapse" id="Navbar" >
        
          <ul class="navbar-nav mr-auto">
          <li class="nav-item"><a class="nav-link" href="./index.php"><span class="fa fa-home fa-lg"></span > Startseite</a></li>
            <li class="nav-item"><a class="nav-link" href="./add.php"><span class="fa fa-plus fa-lg"></span> Lebenslauf hinzuf??gen</a></li>
            <li class="nav-item"><a class="nav-link" href="./list.php" ><span class="fa fa-list fa-lg"></span>Lebenslauf Datenbank</a></li>
            <li class="nav-item"><a class="nav-link active" href="./contactus.php"><span class="fa fa-address-card fa-lg"></span >Kontakt</a></li>
        
        </ul>
        <?php
        if ( !isset($_SESSION['name']) ){
                

                echo '<span class="navbar-text" id="loginButton">
                <a>
                <span class="fa fa-sign-in"></span> Anmeldung</a>
            </span>';
                
            
                    }
                    if ( isset($_SESSION['name']) ){
                

                      echo '<span class="navbar-text" >
                      <a href="logout.php">
                      <span class="fa fa-sign-out"></span> Abmeldung</a>
                  </span>';
                      
                  
                          }
            
                
            ?>
        
        </div>
     
     </nav>


     <script>

function doValidate() {

console.log('Validating...');

try {

    pw = document.getElementById('id_1723').value;
    eml = document.getElementById('nam').value;
    console.log("Validating pw="+pw);

    if (pw == null || pw == ""|| eml==null || eml=="" ) {
        alert("Beide Felder m??ssen ausgef??llt werden");
        return false; }
     if  (eml.indexOf('@') == -1)
  { alert("Ung??ltige E-Mail Adresse");
  return false; } 
else
   {return true; }

} catch(e) {
    return false;
}
return false;
}
</script>


<div id="loginModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="content">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Anmeldung </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group col-sm-4">
                                    <label class="sr-only" for="nam">E-Mail Adresse</label>
                                    <input type="text"  name="email"  class="form-control form-control-sm mr-1" id="nam" placeholder="E-Mail eingeben">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="sr-only" for="id_1723">Passwort</label>
                                <input type="password" name="pass" class="form-control form-control-sm mr-1" id="id_1723" placeholder="Passwort">
                            </div>
                            <div class="col-sm-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label"> Erinnere mich
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            
                            <input type="submit" name="login"    class="btn btn-primary btn-sm ml-1" value="Einloggen">
                            <input type="submit" class="btn btn-secondary btn-sm ml-auto" name="cancel" value="Abbrechen" data-dismiss="modal">    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <header class="jumbotron">
        <div class=container>
            <div class="row row-header">
                <div class="col-12 col-sm-7">
                    <h1>ResumePro : Ihre L??sung zur Verwaltung von Lebensl??ufen!</h1>
                    <p>ResumePro ist eine Webanwendung f??r die Verwaltung von Lebensl??ufen. Sie k??nnen jetzt eine unbegrenzte Anzahl von Lebensl??ufen in dieser App speichern, bearbeiten und aktualisieren!
                    G??ste k??nnen ohne Registrierung testen. <strong>Gast-E-Mail : guest@test.com , Gast-Passwort : php123  </strong>
                    </p>
                </div>
                <div class="col-12 col-sm-3 align-self-center">
                    <img src="img/logo.png" class="img-fluid">  
                </div>
                
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <ol class="col-12 breadcrumb">
                <li class="breadcrumb-item"><a href="./index.php">Startseite</a></li>
                <li class="breadcrumb-item active">Kontakt</li>
            </ol>
            <div class="col-12">
               <h3>Kontakt</h3>
               <hr>
            </div>
        </div>
        <?php

if ( isset($_SESSION['success']) ) {
    echo('<div class="container"> <div  class="col-12 col-sm-4 col-md-3" style="color: green;"><h4>'.htmlentities($_SESSION['success']).'</h4></div></div>');
    unset($_SESSION['success']);
  }

  if ( isset($_SESSION['error']) ) {
    echo('<div class="container"> <div  class="col-12 col-sm-4 col-md-3" style="color: red;"><h4>'.htmlentities($_SESSION['error']).'</h4></div></div>');
    unset($_SESSION['error']);
  }
 

  
  
?>

        <div class="row row-content">
           <div class="col-12">
              <h3>Informationen zum Standort</h3>
           </div>
            <div class="col-12 col-sm-4 offset-sm-1">
                   <h5>Unsere Adresse</h5>
                    <address style="font-size: 100%">
		             J.-G.-Nathusius-Ring 7<br>
		              39106, Magdeburg<br>
		              Germany<br>
		              <i class="fa fa-phone"></i>: +4917676497855<br>
		              <i class="fa fa-fax"></i>: +492 8765 4321<br>
		              <i class="fa fa-envelope"></i>:
                        <a href="srnasib@gmail.com">linkedin.com/in/srnasib/</a>
		           </address>
            </div>
            <div class="col-12 col-sm-6 offset-sm-1">
                <h5>Karte unseres Standortes</h5>
            </div>
            <div class="col-12 col-sm-11 offset-sm-1">
                <div class="btn-group" role="group">
                    <a role="button" class="btn btn-primary" href="tel:+4917676497855"><i class="fa fa-phone"></i> Aufruf</a>
                    <a role="button" class="btn btn-info"><i class="fa fa-skype"></i> Skype</a>
                    <a role="button" class="btn btn-success" href="mailto:srnasib@gmail.com"><i class="fa fa-envelope-o"></i> Email</a>
                </div>
            </div>
        </div>

        <div class="row row-content">
           <div class="col-12">
              <h3>Senden Sie uns Ihr Feedback</h3>
           </div>
            <div class="col-12 col-md-9">
            
                <form>
                    <div class="form-group row">
                        <label for="firstname" class="col-md-2 col-form-label">Vorname</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Vornamen eingeben">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lastname" class="col-md-2 col-form-label">Nachname</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nachname eingeben">
                        </div>
                    </div>
                   

                    <div class="form-group row">
                        <label for="telnum" class="col-12 col-md-2 col-form-label">Kontakt Num.</label>
                        <div class="col-5 col-md-3">
                            <input type="tel" class="form-control" id="areacode" name="areacode" placeholder="Vorwahl">
                        </div>
                        <div class="col-7 col-md-7">
                            <input type="tel" class="form-control" id="telnum" name="telnum" placeholder="Rufnummer">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="emailid" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" id="emailid" name="emailid" placeholder="E-Mail eingeben">
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-md-6 offset-md-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="approve" id="approve" value="">
                                <label class="form-check-label" for="approve">
                                    <strong>D??rfen wir Sie kontaktieren?</strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 offset-md-1">
                            <select class="form-control">
                                <option>Rufnummer.</option>
                                <option>E-Mail</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="feedback" class="col-md-2 col-form-label">Ihr Feedback</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="feedback" name="feedback" rows="12"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="offset-md-2 col-md-10">
                            <button type="submit" class="btn btn-primary">Feedback senden</button>
                        </div>
                    </div>

                </form>





            </div>
             <div class="col-12 col-md">
            </div>
       </div>

    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">             
                <div class="col-4 offset-1 col-sm-2">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="./index.php">Startseite</a></li>
                        <li><a href="./add.php">Lebenslauf hinzuf??gen</a></li>
                        <li><a href="./list.php">Lebenslauf Datenbank</a></li>
                        <li><a href="./contactus.php">Kontaktieren Sie uns</a></li>
                    </ul>
                </div>
                <div class="col-7 col-sm-5">
                    <h5>Unsere Adresse</h5>
                    <address style="font-size: 100%">
		             J.-G.-Nathusius-Ring 7<br>
		              39106, Magdeburg<br>
		              Deutschland<br>
                      <i class="fa fa-phone fa-lg"></i>: +4917676497855<br>
                      <i class="fa fa-fax fa-lg"></i>: +492 8765 4321<br>
                      <i class="fa fa-envelope fa-lg"></i>: 
                      <a href="mailto:srnasib@gmail.com">srnasib@gmail.com</a>
		           </address>
                </div>
                <div class="col-12 col-sm-4 align-self-center">
                    <div class="text-center">
                        <a class="btn btn-social-icon btn-google" href="http://google.com/+"><i class="fa fa-google-plus"></i></a>
                        <a class="btn btn-social-icon btn-facebook" href="http://www.facebook.com/profile.php?id="><i class="fa fa-facebook"></i></a>
                        <a class="btn btn-social-icon btn-linkedin" href="http://www.linkedin.com/in/srnasib/"><i class="fa fa-linkedin"></i></a>
                        <a class="btn btn-social-icon btn-twitter" href="http://twitter.com/"><i class="fa fa-twitter"></i></a>
                        <a class="btn btn-social-icon btn-google" href="http://youtube.com/"><i class="fa fa-youtube"></i></a>
                        <a class="btn btn-social-icon" href="mailto:srnasib@gmail.com"><i class="fa fa-envelope-o"></i></a>
                    </div>
                </div>
           </div>
           <div class="row justify-content-center">             
                <div class="col-auto">
                    <p>?? Urheberrecht 2021 Md Shohanoor Rahman</p>
                </div>
           </div>
        </div>
    </footer>
    <!-- jQuery first, then Popper.js, then Bootstrap JS. -->
    <script src="node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


                  <script>
                 $("#loginButton").click(function(){
                $('[id="loginModal"]').modal();
                });
                 </script>
</body>

</html>
