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
      $_SESSION['error'] = "Email and password are required";
      header("Location: index.php");
      return;
      
  } 
  else if ( strpos(($_POST['email']),'@' ) === false ) {
      $_SESSION['error'] = "Email must have an at-sign (@)";
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
          $_SESSION['success'] = "Login Successful";
          return;
          error_log("Login success ".$_row['user_id']);
          return; }

      else {
              $_SESSION['error'] = "Incorrect password";
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
      $_SESSION['error'] = "All fields are required";
      header("Location: index.php");
      return;
      
  } 
  if (  strlen($_POST['regpass']) < 6 || strlen($_POST['regpass2']) < 6) {
    $_SESSION['error'] = "Password must be more than 6 characters";
    header("Location: index.php");
    return;
    
} 

if (  ($_POST['regpass'])  != ($_POST['regpass2'])  ) {
    $_SESSION['error'] = "Passwords do not match";
    header("Location: index.php");
    return;
    
} 

if (  ($_POST['regpass'])  != ($_POST['regpass2'])  ) {
    $_SESSION['error'] = "Passwords do not match";
    header("Location: index.php");
    return;
    
} 

$stmt = $pdo->prepare('SELECT email FROM users WHERE email = :emle ');
$stmt->execute(array( ':emle' => $_POST['regmail']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ( ($_POST['regmail']) == $row['email'] ) {
      $_SESSION['error'] = "Email already exists in database, please log in";
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
          $_SESSION['success'] = "Registration Successful";
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
    <html lang="en">
    <head>
    <title>Welcome to ResumePro</title>
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
            <li class="nav-item"><a class="nav-link active" href="#"><span class="fa fa-home fa-lg"></span > Home</a></li>
            <li class="nav-item"><a class="nav-link" href="./add.php"><span class="fa fa-plus fa-lg"></span> Add Resume</a></li>
            <li class="nav-item"><a class="nav-link" href="./list.php" ><span class="fa fa-list fa-lg"></span>Resume Database</a></li>
            <li class="nav-item"><a class="nav-link" href="./contactus.php"><span class="fa fa-address-card fa-lg"></span >Contact</a></li>
        
        </ul>
        <?php
        if ( !isset($_SESSION['name']) ){
                

                echo '<span class="navbar-text" id="loginButton">
                <a>
                <span class="fa fa-sign-in"></span> Login</a>
            </span>
            <span class="navbar-text mleft" id="registerButton">
            &nbsp;<a>
                <span class="fa fa-user-plus "></span> Register</a>
            </span>';
            
                
            
                    }
                    if ( isset($_SESSION['name']) ){
                

                      echo '<span class="ml-10 navbar-text" >
                      <a href="logout.php">
                      <span class="fa fa-sign-out"></span> Logout</a>
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
        alert("Both fields must be filled out");
        return false; }
     if  (eml.indexOf('@') == -1)
  { alert("invalid email address");
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
        alert("All fields must be filled out");
        return false; }
     if  ((emlreg.indexOf('@') == -1)||(emlreg.indexOf('@') == -1))
  { alert("invalid email address");
  return false; } 
  if  (pwreg != pw2reg)
  { alert("Passwords do not match");
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
                    <h4 class="modal-title">Login </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group col-sm-4">
                                    <label class="sr-only" for="nam">Email address</label>
                                    <input type="text"  name="email"  class="form-control form-control-sm mr-1" id="nam" placeholder="Enter email">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="sr-only" for="id_1723">Password</label>
                                <input type="password" name="pass" class="form-control form-control-sm mr-1" id="id_1723" placeholder="Password">
                            </div>
                            <div class="col-sm-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label"> Remember me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            
                            <input type="submit" name="login"  onclick="doValidate();"  class="btn btn-primary btn-sm ml-1" value="Log In">
                            <input type="submit" class="btn btn-secondary btn-sm ml-auto" name="cancel" value="Cancel" data-dismiss="modal">    
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
                                    <input type="text"  name="regname"  class="form-control form-control-sm mr-1" id="regname" placeholder="Enter name">
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="sr-only" for="regmail">E-Mail</label>
                                <input type="email" name="regmail" class="form-control form-control-sm mr-1" id="regmail" placeholder="Enter E-Mail">
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="sr-only" for="regpass">Password</label>
                                <input type="password" name="regpass" class="form-control form-control-sm mr-1" id="regpass" placeholder="Enter Password">
                            </div>
                            <div class="form-group col-sm-12">
                                <label class="sr-only" for="regpass2">Repeat Password</label>
                                <input type="password" name="regpass2" class="form-control form-control-sm mr-1" id="regpass2" placeholder=" Repeat Password">
                            </div>
                            
                          
                        </div>
                        <div class="form-row">
                            
                            <input type="submit" name="register" onclick="doRegValidate();"  class="btn btn-primary btn-sm ml-1" value="Register">
                            <input type="submit" class="btn btn-secondary btn-sm ml-auto"  name="cancel" value="Cancel" data-dismiss="modal">    
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
                    <h4 class="modal-title">Contact me </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body align-items-center">
                    <form>
                       
                        
                        <div class="form-group row mt-3 align-items-center">
                            <label for="date" class="col-12 col-md-2 col-form-label">Name</label>
                            <div class="col-12 col-md-5">
                                <input type="text" class="form-control" id="date" name="date" placeholder="Name">
                            </div>
                       
                            
                        
                        </div>
                        <div class="form-group row mt-3 align-items-center">
                      
                            <label for="email" class="col-12 col-md-2 col-form-label">E-Mail</label>
                            <div class="col-12 col-md-5">
                                <input type="email" class="form-control" id="date" name="email" placeholder="e-mail">
                            </div>
                        
                        </div>
                        <div class="form-group row mt-3 align-items-center">
                            <label for="cell" class="col-12 col-md-2 col-form-label">Phone</label>
                            <div class="col-12 col-md-5">
                                <input type="phone" class="form-control" id="date" name="cell" placeholder="Phone No.">
                            </div>
                       
                            
                        
                        </div>
                        <div class="form-row align-items-center">
                            <div class="col-12 col-sm-2  "> 
                                 <p> Can I contact?</p>
                            </div> 

                            <div class="form-group col-12 col-sm "> 
                             
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-success active">
                                      <input type="radio" name="nsmoking" id="nsmoking" autocomplete="off" checked> Yes
                                    </label>
                                    <label class="btn btn-danger">
                                      <input type="radio" name="smoking" id="smoking" autocomplete="off"> No
                                    </label>
                                  </div>
                                </div>                  
                        </div>
                        <div class="row offset-2 ">
                            <button type="button" class="btn btn-secondary btn-md mr-1 " data-dismiss="modal">Cancel</button>
                            
                            <a role="button" class="btn btn-primary btn-md " href="mailto:srnasib@gmail.com">Send</a>       
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    
    <header class="jumbotron">
        <div class=container>
            <div class="row row-header">
                <div class="col-12 col-sm-6">
                    <h1>ResumePro : Your solution to manage resumes!</h1>
                    <p>ResumePro is a web application for resume management. You can now now store, edit, update unlimited number of resumes in this app!</p>
                </div>
                <div class="col-12 col-sm-3 align-self-center">
                    <img src="img/logo.png" class="img-fluid">  
                </div>
                <div class="col-12 col-sm-3 align-self-center" id="reserveButton">
                    
                    <a class="btn btn-warning btn-md btn-block"
                    
                     role="button">Contact me</a>
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
                                <h2>Start Now! <span class="badge badge-danger">CLICK ADD  RESUME</span> </h2>
                                <p class="d-none d-sm-block">Now you can store as much Resume in this application. Store and use them as required. So what are you waiting for? Start now!</p>
                            </div>
                        </div>


                        <div class="carousel-item">
                            <img class="d-block img-fluid"
                            src="img/list1.jpg" alt="Weekend_Grand_Buffet">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Manage your Resumes instantly! <span class="badge badge-secondary">VIEW, UPDATE & DELETE!</span> </span></h2>
                          <p class="d-none d-sm-block mr-3">We support viewing, editing and deleting the Resumes any time. So nothing to be worried about data privacy. Our dynamic secured web application stores data safely into the database.</p>
                          </div>
                        </div>


                        <div class="carousel-item">
                            <img class="d-block img-fluid"
                            src="img/alberto.png" alt="alberto">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="mt-0">Md Shohanoor Rahman </span></h2>
                            <span class="badge badge-warning"><h4>Full Stack Developer</h4></span>
                            <p class="d-none d-sm-block">Hello there! I am the designer of this web application : ResumePro, where you can store, edit, update and delete resumes. This web app can help 
                            you to manage resumes. Looking forward to showcase my skills. Thank You!
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
                <h3>Start adding now!</h3>
            </div>
            <div class="col col-sm order-sm-first col-md">

                <div class="media">
                    <img class="d-flex mr-3 img-thumbnail align-self-center"
                            src="img/add.png" alt="Uthappizza">
                    <div class="media-body">
                        <h2 class="mt-0">Add a resume now!<span class="badge badge-danger ml-2">STORE</span><span class="badge badge-pill badge-secondary ml-2">NOW!</span></h2>
                        <p class="d-none d-sm-block">You can start storing Resumes as long as you are logged in. Unlimited number of resume storing is supported by this web app. Our databases are secured and safe for storing data.</p>
                    </div>
                </div>
                
            </div>
        </div>
    
       

    


        <div class="row row-content align-items-center">
            <div class="col-12 col-sm-4  col-md-3">
                <h3>With Support of Modify & Delete</h3>
            </div>
            <div class="col col-sm  col-md">

                <div class="media">
                    <div class="media-body">
                        <h2 class="mt-0">Update, edit & delete resumes now!<span class="badge badge-danger ml-2">NEW</span></h2>
                        <p class="d-none d-sm-block mr-3">You can access your stored resumes anytime. Also removal of your data and updating resumes is available 24x7. Your privacy is our utmost conern. </p>
                    </div>
                    <img class="d-flex mr-3 img-thumbnail align-self-center"
                            src="img/list2.jpg" alt="Uthappizza">
                    
                </div>
                
            </div>
        </div>
   

        <div class="row row-content align-items-center">
            <div class="col-12 col-sm-4 order-sm-last col-md-3">
                <h3>Meet the developer</h3>
            </div>
            <div class="col col-sm order-sm-first col-md">
                <div class="media">
                    <img class="d-flex mr-3 img-thumbnail align-self-center"
                            src="img/nasib.png" alt="Alberto Somayya">
                    <div class="media-body">
                        <h2 class="mt-0">Md Shohanoor Rahman</h2>
                        <h4>Web Developer</h4>
                        <p class="d-none d-sm-block">Hello there! I am the designer of this web application : ResumePro, where you can store, edit, update and delete resumes. This web app can help 
                            you to manage resumes. Looking forward to showcase my skills. Thank You!
                            </p>
                    </div>
                </div>
                
            </div>
        </div>


        <div class="row row-content align-items-center" id="reserve" >
            <div class="col-12   col-sm-12">
                <div class="card">
                    <h3 class="card-header bg-yellow text-white">Contact Now</h3>
                    <div class="card-body modal-body">
                    <form>
                       
                        
                       <div class="form-group row  align-items-center">
                           <label for="date" class="col-12 col-md-6 col-form-label">Name</label>
                           <div class="col-12 col-md-6">
                               <input type="text" class="form-control" id="date" name="date" placeholder="Name">
                           </div>
                      
                           
                       
                       </div>
                       <div class="form-group row  align-items-center">
                     
                           <label for="email" class="col-12 col-md-6 col-form-label">E-Mail</label>
                           <div class="col-12 col-md-6">
                               <input type="email" class="form-control" id="date" name="email" placeholder="e-mail">
                           </div>
                       
                       </div>
                       <div class="form-group row  align-items-center">
                           <label for="cell" class="col-12 col-md-6 col-form-label">Phone</label>
                           <div class="col-12 col-md-6">
                               <input type="phone" class="form-control" id="date" name="cell" placeholder="Phone No.">
                           </div>
                      
                           
                       
                       </div>
                       <div class="form-row align-items-center">
                           <div class="col-12 col-sm-6  "> 
                                <p> Can I contact?</p>
                           </div> 

                           <div class="form-group col-12 col-sm-6 "> 
                            
                               <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                   <label class="btn btn-success active">
                                     <input type="radio" name="nsmoking" id="nsmoking" autocomplete="off" checked> Yes
                                   </label>
                                   <label class="btn btn-danger">
                                     <input type="radio" name="smoking" id="smoking" autocomplete="off"> No
                                   </label>
                                 </div>
                               </div>                  
                       </div>
                       <div class="row offset-2 ">
                           <button type="button" class="btn btn-secondary btn-md mr-1 " data-dismiss="modal">Cancel</button>
                           
                           <a role="button" class="btn btn-primary btn-md " href="mailto:srnasib@gmail.com">Send</a>       
                       </div>
                   </form> 
                           
   
            
                       
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
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./add.php">Add Resume</a></li>
                        <li><a href="./list.php">Resume Database</a></li>
                        <li><a href="./contactus.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-7 col-sm-5">
                    <h5>Our Address</h5>
                    <address style="font-size: 100%">
		             J.-G.-Nathusius-Ring 7<br>
		              39106, Magdeburg<br>
		              Germany<br>
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
                    <p>© Copyright 2021 Md Shohanoor Rahman</p>
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


</body>

</html>