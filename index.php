<?php 
session_start();
require_once "pdo.php";
if ( isset($_POST['cancel'] ) ) {
  // Redirect the browser to game.php
  header("Location: index.php");
  return;
}

if ( isset($_POST['login']) )
{
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
          
          header("Location: index.php");  
          $_SESSION['success'] = "Anmeldung erfolgreich";
          return;
          error_log("Login success ".$_row['user_id']);
          return; }

      else {
              $_SESSION['error'] = "Falsches Passwort";
              header("Location: index.php");
              return;
           error_log("Login fail ".$_row['user_id']." $check");
      }
  }
}

// Fall through into the View
}
?>
<?php 
if ( isset($_POST['register']) )
{

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is meow123

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['regname']) && isset($_POST['regmail']) && isset($_POST['regpass']) && isset($_POST['regpass2']) ) {
  if ( strlen($_POST['regname']) < 1 || strlen($_POST['regmail']) < 1 || strlen($_POST['regpass']) < 1 || strlen($_POST['regpass2']) < 1) {
      $_SESSION['error'] = "Alle Felder sind erforderlich";
      header("Location: index.php");
      return;
      
  } 
  if (  strlen($_POST['regpass']) < 6 || strlen($_POST['regpass2']) < 6) {
    $_SESSION['error'] = "Das Passwort muss mehr als 6 Zeichen enthalten";
    header("Location: index.php");
    return;
    
} 

if (  ($_POST['regpass'])  != ($_POST['regpass2'])  ) {
    $_SESSION['error'] = "Passw??rter stimmen nicht ??berein";
    header("Location: index.php");
    return;
    
} 

if (  ($_POST['regpass'])  != ($_POST['regpass2'])  ) {
    $_SESSION['error'] = "Passw??rter stimmen nicht ??berein";
    header("Location: index.php");
    return;
    
} 

$stmt = $pdo->prepare('SELECT email FROM users WHERE email = :emle ');
$stmt->execute(array( ':emle' => $_POST['regmail']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ( ($_POST['regmail']) == $row['email'] ) {
      $_SESSION['error'] = "E-Mail existiert bereits in der Datenbank, bitte melden Sie sich an";
      header("Location: index.php");
      return;
  }    
  
  
  else {
      
      $encrypt = hash('md5', $salt.$_POST['regpass']);
      $stmt = $pdo->prepare('INSERT INTO users ( name, email, password) VALUES ( :namereg, :emlreg, :pwreg)');

      $stmt->execute(array(
        
        ':namereg' => $_POST['regname'],
        ':emlreg' => $_POST['regmail'],
        ':pwreg' =>  $encrypt
        )
      );
     
          header("Location: index.php");  
          $_SESSION['success'] = "Registrierung erfolgreich";
          return;
          

  }
}

if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}

// Fall through into the View
}
?>
<?php 
if ( isset($_POST['s1']) )
{

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['name1']) && isset($_POST['email1']) && isset($_POST['cell1']) && isset($_POST['feedback']) && isset($_POST['permission1'])) {
  if ( strlen($_POST['name1']) < 1 || strlen($_POST['email1']) < 1 || strlen($_POST['cell1']) < 1 || strlen($_POST['feedback']) < 1 || strlen($_POST['permission1']) < 1) {
      header("Location: index.php");
      $_SESSION['error'] = "Alle Felder sind erforderlich";
      return;
      
  } 

  if ( strpos(($_POST['email1']),'@' ) === false ) {
    header("Location: index.php");
     $_SESSION['error'] = "E-Mail muss ein at-Zeichen (@) enthalten";
    return;
}   



  
  
  else {
      
      
      $stmt = $pdo->prepare('INSERT INTO contact1 ( name, email, phone, message, permission) VALUES ( :cs1, :cs2, :cs3, :cs4, :cs5 )');

      $stmt->execute(array(
        
        ':cs1' => $_POST['name1'],
        ':cs2' => $_POST['email1'],
        ':cs3' => $_POST['cell1'],
        ':cs4' => $_POST['feedback'],
        ':cs5' => $_POST['permission1'],
        )
      );
     
          header("Location: index.php");  
          $_SESSION['success'] = "Vielen Dank, dass Sie mit mir Kontakt aufgenommen haben!";
          return;
          

  }
}

if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}

// Fall through into the View
}
?>
<?php 
if ( isset($_POST['s2']) )
{



$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['name2']) && isset($_POST['email2']) && isset($_POST['cell2']) && isset($_POST['feedback1']) && isset($_POST['permission2'])) {
  if ( strlen($_POST['name2']) < 1 || strlen($_POST['email2']) < 1 || strlen($_POST['cell2']) < 1 || strlen($_POST['feedback1']) < 1 || strlen($_POST['permission2']) < 1) {
      header("Location: index.php");
      $_SESSION['error'] = "Alle Felder sind erforderlich";
      return;
      
  } 

  if ( strpos(($_POST['email2']),'@' ) === false ) {
    header("Location: index.php");
    $_SESSION['error'] = "E-Mail muss ein at-Zeichen (@) enthalten";
    
    return;
}   



  
  
  else {
      
      
      $stmt = $pdo->prepare('INSERT INTO contact2 ( name, email, phone, message, permission) VALUES ( :cs6, :cs7, :cs8, :cs9, :cs10 )');

      $stmt->execute(array(
        
        ':cs6' => $_POST['name2'],
        ':cs7' => $_POST['email2'],
        ':cs8' => $_POST['cell2'],
        ':cs9' => $_POST['feedback1'],
        ':cs10' => $_POST['permission2'],
        )
      );
           
          header("Location: index.php");  
          $_SESSION['success'] = "Vielen Dank f??r Ihre Kontaktaufnahme!";
          return;
          

  }
}

if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}

// Fall through into the View
}
?>


    <!DOCTYPE html>
    <html lang="de">
    <head>
    <title>Willkommen bei ResumePro</title>
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
            <li class="nav-item"><a class="nav-link active" href="#"><span class="fa fa-home fa-lg"></span > Startseite</a></li>
            <li class="nav-item"><a class="nav-link" href="./add.php"><span class="fa fa-plus fa-lg"></span> Lebenslauf hinzuf??gen</a></li>
            <li class="nav-item"><a class="nav-link" href="./list.php" ><span class="fa fa-list fa-lg"></span>Lebenslauf Datenbank</a></li>
            <li class="nav-item"><a class="nav-link" href="./contactus.php"><span class="fa fa-address-card fa-lg"></span >Kontakt</a></li>
        
        </ul>
        <?php
        if ( !isset($_SESSION['name']) ){
                

                echo '<span class="navbar-text" id="loginButton">
                <a>
                <span class="fa fa-sign-in"></span> Anmeldung</a>
            </span>
            <span class="navbar-text mleft" id="registerButton">
            &nbsp;<a>
                <span class="fa fa-user-plus "></span> Register</a>
            </span>
            <span class="navbar-text mleft" id="languageButton">
            &nbsp;<a>
                <span class="fa fa-language "></span> Sprache</a>
            </span>
            ';
            
                
            
                    }
                    if ( isset($_SESSION['name']) ){
                

                      echo '<span class="ml-10 navbar-text" >
                      <a href="logout.php">
                      <span class="fa fa-sign-out"></span> Abmeldung</a>
                  </span>
                  <span class="navbar-text mleft" id="languageButton">
            &nbsp;<a>
                <span class="fa fa-language "></span> Sprache</a>
            </span>
                  
                  
                  ';
                      
                  
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

<script>
function doRegValidate() {

console.log('Validating Registration...');

try {

    namereg = document.getElementById('regname').value;
    emlreg = document.getElementById('regmail').value;
    pwreg = document.getElementById('regpass').value;
    pw2reg = document.getElementById('regpass2').value;
   

    if (pwreg == null || pwreg == ""|| emlreg==null || emlreg==""||namereg == null || namereg == ""|| pw2reg==null || pw2reg=="" ) {
        alert("Alle Felder m??ssen ausgef??llt werden");
        return false; }
     if  ((emlreg.indexOf('@') == -1)||(emlreg.indexOf('@') == -1))
  { alert("Ung??ltige E-Mail Adresse");
  return false; } 
  if  (pwreg != pw2reg)
  { alert("Passw??rter stimmen nicht ??berein");
  return false; } 
else
   {return true; }

} catch(e) {
    return false;
}
return false;
}
</script>

<script>

function doSendValidate1() {

console.log('Validating...');

try {

    
    cs1 = document.getElementById('name1').value;
    cs2 = document.getElementById('email1').value;
    cs3 = document.getElementById('cell1').value;
    cs4 = document.getElementById('feedback').value;
    
    

    if (cs1 == null || cs1 == ""|| cs2==null || cs2=="" || cs3==null || cs3=="" || cs4==null || cs4=="" ) {
        alert("Alle Felder m??ssen ausgef??llt werden");
        return false; }
   
else
   {return true; }

} catch(e) {
    return false;
}
return false;
}
</script>


<script>

function doSendValidate2() {

console.log('Validating...');

try {

    
    cs1 = document.getElementById('name2').value;
    cs2 = document.getElementById('email2').value;
    cs3 = document.getElementById('cell2').value;
    cs4 = document.getElementById('feedback1').value;
    
    

    if (cs1 == null || cs1 == ""|| cs2==null || cs2=="" || cs3==null || cs3=="" || cs4==null || cs4=="" ) {
        alert("Alle Felder m??ssen ausgef??llt werden");
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


    <div id="registerModal" class="modal fade " role="dialog" >
        <div class="modal-dialog modal-lg" role="content">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Register </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body ">

                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                    <label class="sr-only" for="regname">Name</label>
                                    <input type="text"  name="regname"  class="form-control form-control-sm mr-1" id="regname" placeholder="Name eingeben">
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="sr-only" for="regmail">E-Mail</label>
                                <input type="email" name="regmail" class="form-control form-control-sm mr-1" id="regmail" placeholder="E-Mail eingeben ">
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="sr-only" for="regpass">Passwort</label>
                                <input type="password" name="regpass" class="form-control form-control-sm mr-1" id="regpass" placeholder="Passwort eingeben">
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="sr-only" for="regpass2">Passwort wiederholen</label>
                                <input type="password" name="regpass2" class="form-control form-control-sm mr-1" id="regpass2" placeholder=" Passwort wiederholen">
                            </div>
                            
                          
                        </div>
                        <div class="form-row">
                            
                            <input type="submit" name="register" onclick="doRegValidate();"  class="btn btn-primary btn-sm ml-1" value="Register">
                            <input type="submit" class="btn btn-secondary btn-sm ml-auto"  name="cancel" value="Abbrechen" data-dismiss="modal">    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 

    <div id="reserveModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="content">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kontaktieren Sie mich </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body align-items-center">
                    <form method="POST">
                       
                        
                        <div class="form-group row mt-3 align-items-center">
                            <label for="name1" class="col-12 col-md-5 col-form-label">Name</label>
                            <div class="col-12 col-md-7">
                                <input type="text"  class="form-control" id="name1" name="name1" placeholder="Ihren Namen eingeben">
                            </div>
                       
                            
                        
                        </div>
                        <div class="form-group row mt-3 align-items-center">
                      
                            <label for="email1" class="col-12 col-md-5 col-form-label">E-Mail</label>
                            <div class="col-12 col-md-7">
                                <input type="email" class="form-control" id="email1" name="email1" placeholder="E-Mail eingeben">
                            </div>
                        
                        </div>
                        <div class="form-group row mt-3 align-items-center">
                            <label for="cell1" class="col-12 col-md-5 col-form-label">Rufnummer</label>
                            <div class="col-12 col-md-7">
                                <input type="tel" class="form-control" id="cell1" name="cell1" placeholder="Rufnummer eigeben ">
                            </div>
                       
                        </div>


                        <div class="form-group row">
                                 <label for="feedback" class="col-md-5 col-form-label">Nachricht</label>
                                 <div class="col-md-7">
                                 <textarea class="form-control" id="feedback" name="feedback" rows="3" placeholder="Schreiben Sie Ihre Nachricht"></textarea>
                                 </div>
                                 </div>



                        <div class="form-row align-items-center">
                            <div class="col-12 col-sm-2  "> 
                                ??<p> Kann ich Sie kontaktieren??</p>
                            </div> 

                            <div class="form-group col-12 col-sm "> 
                             
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-success active">
                                                <input type="radio" name="permission1" value="yes" id="perm1" autocomplete="off" checked  > Ja
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="permission1" value="no" id="perm2" autocomplete="off"> Nein
                                            </label>
                                  </div>
                                </div>                  
                        </div>
                        <div class="row offset-2 ">
                             
                            <input type="submit" class="btn btn-secondary btn-md ml-auto"  name="cancel" value="Abbrechen" data-dismiss="modal">  
                            <input type="submit" name="s1"  onclick="doSendValidate1();"  class="btn btn-primary btn-md ml-4 mr-3" value="Senden">
                             
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="languageModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="content">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change language </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        <div class="form-row"> 
                        <a href="./index2.php" class="btn btn-primary btn-lg " role="button" aria-disabled="true">Click here to go to English Site</a>
                        </div>
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
                <div class="col-12 col-sm-2 align-self-center" id="reserveButton">
                    
                    <a class="btn btn-warning btn-md btn-block"
                    
                     role="button">Kontakt</a>
                </div>
            </div>
        </div>
    </header>
   

    <?php

if ( isset($_SESSION['success']) ) {
    echo('<div class="container"> <div  class="col-12 col-sm-6 col-md-6" style="color: green;"><h4>'.htmlentities($_SESSION['success']).'</h4></div></div>');
    unset($_SESSION['success']);
  }
  if ( isset($_SESSION['error']) ) {
    echo('<div class="container"> <div  class="col-12 col-sm-6 col-md-6" style="color: red;"><h4>'.htmlentities($_SESSION['error']).'</h4></div></div>');
    unset($_SESSION['error']);
  }
 

  
  
?>


</div>
    <div class=container>
        <div class="row row-content align-items-center">
            <div class="col">
                <div id="mycarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block img-fluid"
                                src="img/add2.png" alt="Uthappizza">
                            <div class="carousel-caption d-none d-md-block">
                                <h2>Jetzt anfangen! <span class="badge badge-danger">LEBENSLAUF HINZUF??GEN KLICKEN</span> </h2>
                                <p class="d-none d-sm-block">Jetzt k??nnen Sie so viele Lebensl??ufe in dieser Anwendung speichern. Speichern und verwenden Sie sie nach Bedarf. Worauf warten Sie also noch? Starten Sie jetzt!</p>
                            </div>
                        </div>


                        <div class="carousel-item">
                            <img class="d-block img-fluid"
                            src="img/list1.jpg" alt="Weekend_Grand_Buffet">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Verwalten Sie jetzt Ihre Lebensl??ufe! <span class="badge badge-secondary">ANSEHEN, AKTUALISIEREN UND L??SCHEN!</span> </span></h2>
                          <p class="d-none d-sm-block mr-3">Wir unterst??tzen das Einsehen, Bearbeiten und L??schen von Lebensl??ufen zu jeder Zeit. Sie m??ssen sich also keine Sorgen um den Datenschutz machen. Unsere dynamisch gesicherte Webanwendung speichert die Daten sicher in der Datenbank.</p>
                          </div>
                        </div>


                        <div class="carousel-item">
                            <img class="d-block img-fluid"
                            src="img/alberto.png" alt="alberto">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="mt-0">Md Shohanoor Rahman </span></h2>
                            <span class="badge badge-warning"><h4>Full Stack Entwickler</h4></span>
                            <p class="d-none d-sm-block">Hallo zusammen! Ich bin der Designer dieser Webanwendung : ResumePro, wo man Lebensl??ufe speichern, bearbeiten, aktualisieren und l??schen kann. Diese Webanwendung kann Ihnen helfen Sie Lebensl??ufe zu verwalten. Ich freue mich darauf, meine F??higkeiten zu pr??sentieren. Ich danke Ihnen!
                                </p>
                          </div>
                        </div>


                    <ol class="carousel-indicators">
                        <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#mycarousel" data-slide-to="1"></li>
                        <li data-target="#mycarousel" data-slide-to="2"></li>
                    </ol>

                    <a class="carousel-control-prev" href="#mycarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#mycarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>

                   
                        <button class="btn btn-danger btn-sm" id="carouselButton">
                            <span class="fa fa-pause"></span>
                        </button>
                       
                    

                </div>

                
             </div>
        </div>




        <div class="row row-content align-items-center">
            <div class="col-12 col-sm-4 order-sm-last col-md-3">
                <h3>Fangen Sie jetzt an!</h3>
            </div>
            <div class="col col-sm order-sm-first col-md">

                <div class="media">
                    <img class="d-flex mr-3 img-thumbnail align-self-center"
                            src="img/add.png" alt="ADD">
                    <div class="media-body">
                        <h2 class="mt-0">Jetzt einen Lebenslauf hinzuf??gen!<span class="badge badge-danger ml-2">SPEICHERN</span><span class="badge badge-pill badge-secondary ml-2">JETZT!</span></h2>
                        <p class="d-none d-sm-block">Sie k??nnen mit dem Speichern von Lebensl??ufen beginnen, solange Sie eingeloggt sind. Diese Web-App unterst??tzt eine unbegrenzte Anzahl von Lebensl??ufen. Unsere Datenbanken sind gesichert und sicher f??r die Speicherung von Daten.</p>
                    </div>
                </div>
                
            </div>
        </div>
    
       

    


        <div class="row row-content align-items-center">
            <div class="col-12 col-sm-4  col-md-3">
                <h3>Mit Unterst??tzung von Bearbeiten & L??schen</h3>
            </div>
            <div class="col col-sm  col-md">

                <div class="media">
                    <div class="media-body">
                        <h2 class="mt-0">Lebensl??ufe jetzt aktualisieren, bearbeiten und l??schen!<span class="badge badge-danger ml-2">NEU</span></h2>
                        <p class="d-none d-sm-block mr-3">Sie k??nnen jederzeit auf Ihre gespeicherten Lebensl??ufe zugreifen. Auch die L??schung Ihrer Daten und die Aktualisierung von Lebensl??ufen ist 24x7 m??glich. Ihre Datensicherheit ist unser h??chstes Anliegen. </p>
                    </div>
                    <img class="d-flex mr-3 img-thumbnail align-self-center"
                            src="img/list2.jpg" alt="Uthappizza">
                    
                </div>
                
            </div>
        </div>
   

        <div class="row row-content align-items-center">
            <div class="col-12 col-sm-4 order-sm-last col-md-3">
                <h3>Treffen Sie den Entwickler</h3>
            </div>
            <div class="col col-sm order-sm-first col-md">
                <div class="media">
                    <img class="d-flex mr-3 img-thumbnail align-self-center"
                            src="img/nasib.png" alt="Alberto Somayya">
                    <div class="media-body">
                        <h2 class="mt-0">Md Shohanoor Rahman</h2>
                        <h4>Web Entwickler</h4>
                        <p class="d-none d-sm-block">Hallo zusammen! Ich bin der Designer dieser Webanwendung : ResumePro, wo man Lebensl??ufe speichern, bearbeiten, aktualisieren und l??schen kann. Diese Webanwendung kann Ihnen helfen Sie Lebensl??ufe zu verwalten. Ich freue mich darauf, meine F??higkeiten zu pr??sentieren. Ich danke Ihnen!
                            </p>
                    </div>
                </div>
                
            </div>
           
        

        </div>
        <div class="row row-content align-items-center" id="reserve" >
            <div class="col-12 col-sm-12 ">
                <div class="card">
                    <h3 class="card-header bg-yellow text-white">Jetzt kontaktieren</h3>
                    <div class="card-body modal-body">
                            <form method="POST">
                                
                                    
                                <div class="form-group row  align-items-center">
                                    <label for="name2" class="col-12 col-md-4 col-form-label">Name</label>
                                    <div class="col-12 col-md-8">
                                        <input type="text" class="form-control"  id="name2" name="name2" placeholder="Ihren Namen eingeben">
                                    </div>
                                
                                    
                                
                                </div>
                                <div class="form-group row  align-items-center">
                                
                                    <label for="email2" class="col-12 col-md-4 col-form-label">E-Mail</label>
                                    <div class="col-12 col-md-8">
                                        <input type="email" class="form-control" id="email2" name="email2" placeholder="E-Mail eingeben ">
                                    </div>
                                
                                </div>
                                <div class="form-group row  align-items-center">
                                    <label for="cell2" class="col-12 col-md-4 col-form-label">Phone</label>
                                    <div class="col-12 col-md-8">
                                        <input type="phone" class="form-control" id="cell2" name="cell2" placeholder="Rufnummer eingeben ">
                                    </div>
                                
                                    
                                
                                </div>

                                <div class="form-group row">
                                 <label for="feedback1" class="col-md-4 col-form-label">Nachricht</label>
                                 <div class="col-md-8">
                                 <textarea class="form-control" id="feedback1"  name="feedback1" rows="3" placeholder="Schreiben Sie Ihre Nachricht"></textarea>
                                 </div>
                                 </div>


                                <div class="form-group row align-items-center">
                                    
                        
                                    <label for="can" class="col-12 col-md-4 col-form-label">Kann ich Sie kontaktieren?</label>
                                    <div class="form-group col-12 col-sm-8 " id="can" > 
                                        
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-success active">
                                                <input type="radio" name="permission2" value="yes" id="perm3" autocomplete="off" checked  > Ja
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="permission2" value="no" id="perm4" autocomplete="off"> Nein
                                            </label>
                                            
                                        </div>  
                                     </div>                 
                                
                                <div class="row offset-1 mt-3 ">
                                     
                                <input type="submit" class="btn btn-secondary btn-md ml-auto "  name="cancel" value="Abbrechen" data-dismiss="modal">  
                            <input type="submit" name="s2" onclick="doSendValidate2();"    class="btn btn-primary btn-md ml-4 mr-3" value="Senden">
                             
                                </div>
                            
                                    
            
                        
                            </form> 
                      </div>
                      </div>
                      
                    </div>
                </div>
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
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        
        <script>
            $(document).ready(function(){
                $("#mycarousel").carousel( { interval: 2000 } );
                $("#carousel-pause").click(function(){
                    $("#mycarousel").carousel('pause');
                });

                $("#carouselButton").click(function(){
                if ($("#carouselButton").children("span").hasClass('fa-pause')) {
                    $("#mycarousel").carousel('pause');
                    $("#carouselButton").children("span").removeClass('fa-pause');
                    $("#carouselButton").children("span").addClass('fa-play');
                }
                else if ($("#carouselButton").children("span").hasClass('fa-play')){
                    $("#mycarousel").carousel('cycle');
                    $("#carouselButton").children("span").removeClass('fa-play');
                    $("#carouselButton").children("span").addClass('fa-pause');                    
                }
            });
               
            });
        </script>
       

                  <script>
                   $("#reserveButton").click(function(){
                   $('[id="reserveModal"]').modal();
                   });
                  </script>

                  <script>
                 $("#loginButton").click(function(){
                $('[id="loginModal"]').modal();
                });
                 </script>

<script>
                 $("#registerButton").click(function(){
                $('[id="registerModal"]').modal();
                });
                 </script>

<script>
                 $("#languageButton").click(function(){
                $('[id="languageModal"]').modal();
                });
                 </script>


</body>

</html>