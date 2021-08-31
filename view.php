<?php 
session_start();
require_once "pdo.php";
if ( isset($_POST['cancel'] ) ) {
  // Redirect the browser to game.php
  header("Location: index.php");
  return;
}
?>

 <!DOCTYPE html>
<html lang="en">
<head>
<title>View Resume from Database</title>
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
            <li class="nav-item"><a class="nav-link" href="./index.php"><span class="fa fa-home fa-lg"></span > Home</a></li>
            <li class="nav-item"><a class="nav-link" href="./add.php"><span class="fa fa-plus fa-lg"></span> Add Resume</a></li>
            <li class="nav-item"><a class="nav-link  active" href="./list.php" ><span class="fa fa-list fa-lg"></span>Resume Database</a></li>
            <li class="nav-item"><a class="nav-link" href="./contactus.php"><span class="fa fa-address-card fa-lg"></span >Contact Us</a></li>
        
        </ul>
        <?php
    
                    if ( isset($_SESSION['name']) ){
                

                      echo '<span class="navbar-text" >
                      <a href="logout.php">
                      <span class="fa fa-sign-out"></span> Logout</a>
                  </span>';
                      
                  
                          }
            
                
            ?>
        
        </div>
     
     </nav>
     <div class=container>
                <div class="row">
                     <ol class="col-12 breadcrumb">
                            <li class="breadcrumb-item"><a  href="./index.php" >Home</a></li>
                            <li class="breadcrumb-item active" >View Resume</li>
                    </ol>
            </div>

    <?php
     $c=  $_GET['profile_id'] ;

     $pro1= $pdo->query("SELECT first_name, last_name, headline,email,summary FROM profile WHERE profile_id=$c");
     while  ($row1 =$pro1->fetch(PDO::FETCH_ASSOC))  
    
    { 
        echo  ( "<div class='container'><div class='row row-content align-items-center' id='reserve' ><div class='col-12  offset-sm-1 col-sm-10'><div class='card'><h3 class='card-header modal-header text-black'>View Resume</h3><div class='card-body modal-body'><div class='container mt5'><div class='container mt5'><p> <strong>   First Name : </strong>".htmlentities($row1['first_name'])."</p>");
        echo  ( "<p> <strong>   Last Name : </strong>".htmlentities($row1['last_name'])."</p>");
        echo  ( "<p> <strong>   Email : </strong>".htmlentities($row1['email'])."</p>");
        echo  ( "<p> <strong>   Headline : </p>  </strong>".htmlentities($row1['headline'])."<p> </p>");
        echo  ( "<p> <strong>   Summary : </p>  </strong>".htmlentities($row1['summary'])."<p> </p> </div>");
    
    
    
    
    
    }
    
                        
                 
                            


                            
    echo '<div class="container"><p> <strong>  Positions : </strong> </p>';
    $stmt = $pdo->prepare("SELECT * FROM position where profile_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['profile_id']));
    $row1 = $stmt->fetchAll();
     
    $rank=1;
    foreach ($row1 as $row)
    {echo  ( " <ul> <li> <strong>   year : </strong>".htmlentities($row['year'])."<strong>  
         Description : </strong>".htmlentities($row['description'])." </li> </ul></div>" );
        $rank++;
    }
    
    echo "<div class='container mt5'><p> <strong>  Education : </strong> </p>";
    $stmt2= $pdo->prepare("SELECT name ,year  FROM education JOIN institution ON education.institution_id=institution.institution_id WHERE profile_id=:hello");
    $stmt2->execute(array(":hello" => $_GET['profile_id']));
    $row2 = $stmt2->fetchAll();
    
    foreach ($row2 as $rows)
    {echo  ( " <ul> <li> <strong>   year : </strong>".htmlentities($rows['year'])."<strong>  
         School : </strong>".htmlentities($rows['name'])." </li> </ul><div class='container mt5'><a role='button' class='btn btn-primary btn-md' href='index.php'>Done</a> </div></div></div></div></div></div></div>" );
        $rank++;
    }
    
    ?>



  
<footer class="footer mt10" >
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























</body>


<script src="node_modules/jquery/dist/jquery.slim.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
                 $("#loginButton").click(function(){
                $('[id="loginModal"]').modal();
                });
                 </script>
 

</html>