<?php 
session_start();
require_once "pdo.php";
if ( isset($_POST['cancel'] ) ) {
  // Redirect the browser to game.php
  header("Location: index.php");
  return;
}
if ( !isset($_SESSION['name']))
{$_SESSION['success'] = "Bitte anmelden";
header("Location:index.php");
return; 
}
?>
<?php
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is meow123

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
  if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
      $_SESSION['error'] = "E-Mail und Passwort sind erforderlich";
      header("Location: list.php");
      return;
      
  } 
  else if ( strpos(($_POST['email']),'@' ) === false ) {
      $_SESSION['error'] = "E-Mail muss ein at-Zeichen (@) enthalten";
      header("Location: list.php");
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
          
          header("Location: list.php");  
          $_SESSION['success'] = "Anmeldung erfolgreich";
          return;
          error_log("Login success ".$_row['user_id']);
          return; }

      else {
              $_SESSION['error'] = "Falsches Passwort";
              header("Location: list.php");
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

<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<title>ResumePro Datenbank-Betrachter</title>
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
          <li class="nav-item"><a class="nav-link active" href="./index.php"><span class="fa fa-home fa-lg"></span > Startseite</a></li>
            <li class="nav-item"><a class="nav-link" href="./add.php"><span class="fa fa-plus fa-lg"></span> Lebenslauf hinzuf??gen</a></li>
            <li class="nav-item"><a class="nav-link active" href="./list.php" ><span class="fa fa-list fa-lg"></span>Lebenslauf Datenbank</a></li>
            <li class="nav-item"><a class="nav-link" href="./contactus.php"><span class="fa fa-address-card fa-lg"></span >Kontakt</a></li>
        
        </ul>
        <?php
        if ( !isset($_SESSION['name']) ){
                

                echo '<span class="navbar-text" id="loginButton">
                <a>
                <span class="fa fa-sign-in"></span> Login</a>
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
            <div class=container>
                <div class="row">
                     <ol class="col-12 breadcrumb">
                            <li class="breadcrumb-item"><a  href="./index.php" >Startseite</a></li>
                            <li class="breadcrumb-item active" >Lebenslauf Liste</li>
                    </ol>
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

<?php 
                            if ( !isset($_SESSION['name']) ){
                
                               
                
                echo '<div class=container>';
              
                   echo '<div class="row row-content align-items-center">';
                   
                   
                   echo '<table  class="col-12 col-md-12 table table-bordered table-striped">';
                   echo '<colgroup>';
                   echo '<col class="col-xs-5">';
                   echo '<col class="col-xs-5">';
                   echo '</colgroup>';
                   echo '<thead>';
                   echo '<tr>';
                   echo '<th>Name</th>';
                   echo '<th>Beschreibung</th>';
                   echo '</tr>';
                   echo '</thead>';
                   echo '<tbody>';
                   $d=  $_SESSION['user_id'] ;
                   $pro2= $pdo->query("SELECT first_name, last_name, profile_id ,headline FROM profile where user_id=$d");
                    while  ($row =$pro2->fetch(PDO::FETCH_ASSOC)) {
                   echo '<tr>';
               
                   $e=  ((htmlentities($row['first_name']))." ".htmlentities($row['last_name']));
                   echo('<td> <a href="view.php?profile_id='.$row['profile_id'].'">'.$e.'</a></td>');
                   echo '<td>'.htmlentities($row['headline']).'</td>';
                   
                   echo '</tr>';
                    }
                   echo '</tbody>';
                   echo '</table>';
                  
                   echo '</div>';
                   echo '</div>';
                   echo '</div>';
                   
                    }
            
                
            ?>






<?php 
                            if ( isset($_SESSION['name']) ){
                
                               
                
                echo '<div class=container>';
              
                   echo '<div class="row row-content align-items-center">';
                   
                   
                   echo '<table  class="col-12 col-md-12 table table-bordered table-striped">';
                   echo '<colgroup>';
                   echo '<col class="col-xs-5">';
                   echo '<col class="col-xs-5">';
                   echo '<col class="col-xs-5">';
                   echo '</colgroup>';
                   echo '<thead>';
                   echo '<tr class="modal-body">';
                   echo '<th>Name</th>';
                   echo '<th>Beschreibung</th>';
                   echo '<th>Aktion</th>';
                   echo '</tr>';
                   echo '</thead>';
                   echo '<tbody>';
                   $g=  $_SESSION['user_id'] ;
                   $pro= $pdo->query("SELECT first_name, last_name, profile_id ,headline FROM profile WHERE user_id=$g");
                    while  ($row2 =$pro->fetch(PDO::FETCH_ASSOC)) {
                   echo '<tr>';
               
                   $f=  ((htmlentities($row2['first_name']))." ".htmlentities($row2['last_name']));
                   echo('<td> <a href="view.php?profile_id='.$row2['profile_id'].'">'.$f.'</a></td>');
                   echo '<td>'.htmlentities($row2['headline']).'</td>';
                   echo '<td>'.'<a href="edit.php?profile_id='.$row2['profile_id'].'">Bearbeiten</a> / <a href="delete.php?profile_id='.$row2['profile_id'].'">L??schen</a> '.'</td>';
                   
                   echo '</tr>';
                    }
                   echo '</tbody>';
                   echo '</table>';
                  
                   echo '</div>';
                   echo '</div>';
                   echo '</div>';
                   
                    }
            
                
            ?>


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







</body>
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



<script src="node_modules/jquery/dist/jquery.slim.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
                 $("#loginButton").click(function(){
                $('[id="loginModal"]').modal();
                });
                 </script>
 

</html>