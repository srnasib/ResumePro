<?php

session_start();
require_once "pdo.php";
require_once "head.php";

if ( ! isset($_SESSION['name'])   ) {
  $_SESSION['success'] = "Please log in";
  header("Location: index.php");
  return;
   
}

 
if ( isset($_POST['cancel'] ) ) {
  // Redirect the browser to login.php
  header("Location: index.php");
  return;
}


if (  isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['user_id']) )  
{

    if ( strlen($_POST['first_name']) <1  || strlen($_POST['last_name']) <1 || strlen($_POST['email']) <1  || strlen($_POST['headline'])<1 || strlen($_POST['summary']) <1 )
 { $_SESSION['error'] = "All fields are required";
    header("Location: edit.php?profile_id=".$_GET['profile_id']);
    return;
 }

    else if ( strpos(($_POST['email']),'@' ) === false )
     {   $_SESSION['error'] = "Email address must contain @"; 
        header("Location: edit.php?profile_id=".$_GET['profile_id']);
        return;
    }
    else if ( (validatePos()!==true)  )
     {
        $_SESSION['error'] = validatePos();
        header("Location: edit.php?profile_id=".$_GET['profile_id']);
        return;
     }
     else if ( (validateEdu() ) !== true )
     {
        $_SESSION['error'] = validateEdu();
        header("Location: edit.php?profile_id=".$_GET['profile_id']);
        return;
     } 

    else {

        $sql= "UPDATE profile SET   first_name = :fn, last_name = :ln, email = :em, headline = :he, summary= :su
        WHERE profile_id = :profile_id";
        $stmt = $pdo->prepare($sql);      
        $stmt->execute(array(
              
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'],
                ':profile_id' => $_GET['profile_id'] )
                
            );
            

        $stmt = $pdo->prepare('DELETE FROM position WHERE profile_id=:pid');
        $stmt->execute(array( ':pid' => $_REQUEST['profile_id']));
      
        $rank=1;
        

        for($i=1; $i<=9; $i++) {
          if ( ! isset($_POST['year'.$i]) ) continue;
          if ( ! isset($_POST['desc'.$i]) ) continue;
      
          $year = $_POST['year'.$i];
          $desc = $_POST['desc'.$i];

          $stmt = $pdo->prepare('INSERT INTO position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :desc)');

          $stmt->execute(array(
          ':pid' => $_REQUEST['profile_id'],
          ':rank' => $rank,
          ':year' => $year,
          ':desc' => $desc)
        );
        
        $rank++;}




        $stmt = $pdo->prepare('DELETE FROM education WHERE profile_id=:pid');
        $stmt->execute(array( ':pid' => $_REQUEST['profile_id']));

        for($i=1; $i<=9; $i++) {
        
            if ( ! isset($_POST['year1'.$i]) ) continue;
            if ( ! isset($_POST['school'.$i]) )  continue;
        
            $year1 = $_POST['year1'.$i];
            $school = $_POST['school'.$i];
          
            $stmt2 = $pdo->prepare('SELECT institution_id FROM institution WHERE name= :school'); 
            
            $stmt2->execute(array(':school' => $school ));
            $rowinsid =$stmt2->fetch(PDO::FETCH_ASSOC);
            if ($rowinsid!==false)
           { $insid= ($rowinsid['institution_id']);}
           
           if ($rowinsid===false)
           {
            $stmt = $pdo->prepare('INSERT INTO institution (name) VALUES ( :name)');
            $stmt->execute(array(':name' => $school));
            $insid= $pdo->lastInsertId();
          
           }
    
    
            $stmt = $pdo->prepare('INSERT INTO education (profile_id,institution_id, rank, year) VALUES ( :pid1, :eid, :rank, :year1)');
            $stmt->execute(array(
            ':pid1' => $_REQUEST['profile_id'],
            ':rank' => $rank,
            ':year1' => $year1,
            ':eid' => $insid)
          );
          
          $rank++;}
 
        $_SESSION['success'] = "Record Updated";
        header("Location: index.php");
        return;
  
      }
    
}

if ( ! isset($_GET['profile_id']) ) {
    $_SESSION['error'] = "Missing profile_id";
    header("Location: index.php");
    return;
  }

  
  if ( isset($_SESSION['error']) ) {
   echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
     unset($_SESSION['error']);}
 
     function validatePos() {
         for($i=1; $i<=9; $i++) {
           if ( ! isset($_POST['year'.$i]) ) continue;
           if ( ! isset($_POST['desc'.$i]) ) continue;
       
           $year = $_POST['year'.$i];
           $desc = $_POST['desc'.$i];
       
           if ( strlen($year) == 0 || strlen($desc) == 0 ) {
             return "All fields are required";
           }
       
           if ( ! is_numeric($year) ) {
             return "Position year must be numeric";
           }
         }
         return true;
       }    
 
       function validateEdu() {
         for($i=1; $i<=9; $i++) {
           if ( ! isset($_POST['year1'.$i]) ) continue;
           if ( ! isset($_POST['school'.$i]) ) continue;
       
           $year1 = $_POST['year1'.$i];
           $school = $_POST['school'.$i];
       
           if ( strlen($year1) == 0 || strlen($school) == 0 ) {
             return "All fields are required";
           }
       
           if ( ! is_numeric($year1) ) {
             return "Education year must be numeric";
           }
         }
         return true;
       }   
 
  
 
  


  $stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['profile_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $stmt1 = $pdo->prepare("SELECT * FROM position where profile_id = :xyz");
  $stmt1->execute(array(":xyz" => $_GET['profile_id']));
  $row1 = $stmt1->fetchAll();

  $stmt2= $pdo->prepare("SELECT name ,year  FROM education JOIN institution ON education.institution_id=institution.institution_id WHERE profile_id=:hello");
  $stmt2->execute(array(":hello" => $_GET['profile_id']));
  $row2 = $stmt2->fetchAll();


  if ( $row === false ) {
      $_SESSION['error'] = 'Bad value for profile_id';
      header( 'Location: index.php' ) ;
      return;
  } 


$a = htmlentities($row['first_name']);
$b = htmlentities($row['last_name']);
$c = htmlentities($row['email']);
$d = htmlentities($row['headline']);
$e = htmlentities($row['summary']);
$f = htmlentities($row['user_id']);
//$profile_id = $row['profile_id'];
//$user_id = $row['user_id'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Edit a Resume in ResumePro</title>
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
            <li class="nav-item"><a class="nav-link active" href="./add.php"><span class="fa fa-plus fa-lg"></span> Add Resume</a></li>
            <li class="nav-item"><a class="nav-link  " href="./list.php" ><span class="fa fa-list fa-lg"></span>Resume Database</a></li>
            <li class="nav-item"><a class="nav-link" href="./contactus.php"><span class="fa fa-address-card fa-lg"></span >Contact</a></li>
        
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
                            <li class="breadcrumb-item active" >Edit Resume</li>
                    </ol>
            </div>



     <div class="container">
<div class="row row-content align-items-center" id="reserve" >
            <div class="col-12  offset-sm-1 col-sm-10">
                <div class="card">
                    <h3 class="card-header modal-header text-black">Edit Resume</h3>
                    <div class="card-body modal-body">
                        
                 
                            <form method="post" class="form-row">

<input type="hidden" name="user_id" id="nam" value="<?=$f ?>" size ="40" ><br/>
<div class="form-group col-sm-4">
<label for="fn"> <b>First Name :</b>   </label>
</div>
<div class="form-group col-sm-6">
<input type="text" name="first_name" id="fn" size ="40" value="<?=$a ?>" class="form-control form-control-sm mr-1"><br/>
</div>
<div class="form-group col-sm-4">
<label for="ln"><b>Last Name :</b>   </label>
</div>
<div class="form-group col-sm-6">
<input type="text" name="last_name" id="ln" size ="40" value="<?=$b ?>" class="form-control form-control-sm mr-1"><br/>
</div>
<div class="form-group col-sm-4">
<label for="em"><b>E-Mail :</b> :   </label>
</div>
<div class="form-group col-sm-6">
<input type="text" name="email" id="em" size ="30" value="<?=$c ?>" class="form-control form-control-sm mr-1" placeholder="Enter email"><br/>
</div>
<div class="form-group col-sm-4">
<label for="hl"><b>Headline :</b>   </label>
</div>
<div class="form-group col-sm-6">
<input type="text" name="headline" id="hl" size ="45" value="<?=$d ?>" class="form-control form-control-sm mr-1" ><br/>
</div>
<div class="form-group col-sm-4">
<p> <strong>  Summary : </strong> </p>
</div>
<div class="form-group col-sm-6">
<textarea name="summary"  rows="10" cols="40"  class="form-control form-control-sm mr-1" ><?= $e ?> </textarea> <br/>
</div>

<div class="form-group col-sm-4">
<b>Education:</b>
</div>
<div class="form-group col-sm-4">
<input type="submit" id="addEdu" value="+" class="form-control form-control-sm mr-1"> 
</div>
      
       <div id="education_fields" class="form-group col-sm-12">

       <?php
            $rank = 1;
            foreach ($row2 as $rows) {
                echo "<div class=row id= education" . $rank . "> 
                <div class='form-group col-sm-4'> <b>Year:</b> </div>
                <div class='form-group col-sm-6'><input type=text class='form-control form-control-sm mr-1' name=year1 value=".$rows['year']."> </div>
                <div class='form-group col-sm-2'><input type=button value='-'  onclick= $('#education". $rank ."').remove();return false;> </div>
                <div class='form-group col-sm-4'> <b>School:</b> </div>
                <div class='form-group col-sm-6'> <input type=text class='form-control form-control-sm mr-1'  name=school". $rank ."'). size=50 value=".$rows['name']." class=school ></div>
</div>";
                $rank++;
            } ?>

     </div>
     <div class="form-group col-sm-4">
     <b>Position:</b>
     </div>
     <div class="form-group col-sm-4">
     <input type="submit" id="addPos" value="+" class="form-control form-control-sm mr-1"> 
     </div>

      
<div id="position_fields" class="form-group col-sm-12">
<?php
            $rank = 1;
            foreach ($row1 as $rown) {
                echo "<div class=row id= position" . $rank . ">
                <div class='form-group col-sm-4'> <b>Year:</b> </div>
                <div class='form-group col-sm-6'> <input type=text  class='form-control form-control-sm mr-1' name=year value=".$rown['year']."> </div>
                <div class='form-group col-sm-2'> <input type=button value='-'  onclick= $('#position". $rank ."').remove();return false;></div>
                <div class='form-group col-sm-4'> <b>Description:</b> </div>
                <div class='form-group col-sm-6'><textarea name=desc". $rank ."'). class='form-control form-control-sm mr-1' rows=8 cols=80>".$rown['description']."</textarea></div>
                </div>";
                $rank++;
            } ?>
</div>


<div class="form-group col-sm-6">
<input type="submit"  value="Save" onclick="return doValidate();" class="btn btn-warning btn-sm ml-1">
<input type="submit" name="cancel" value="Cancel" class="btn btn-warning btn-sm ml-1">
</div>
</p>
</form>



<script>
        countPos = 0;
        countEdu = 0;
        // http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript 
        
        $(document).ready(function () {
            window.console && console.log('Document ready called');
            $('#addEdu').click(function (event) {
                // http://api.jquery.com/event.preventdefault/
                event.preventDefault();
                if (countEdu >= 9) {
                    alert("Maximum of nine education entries exceeded");
                    return;
                }
                countEdu++;
                window.console && console.log("Adding position " + countEdu);
                
                $('#education_fields').append(
                    '<div class=row id="education' + countEdu + '"> \
                    <div class="form-group col-sm-4"> <b>Year:</b> </div> <div class="form-group col-sm-6"> <input type="text" class="form-control form-control-sm mr-1" name="year1' + countEdu + '" value="" /> </div> \
                    <div class="form-group col-sm-2"> <input type="button" value="-" \
                onclick="$(\'#education' + countEdu + '\').remove();return false;"> </div> \
                <div class="form-group col-sm-4"><b>School:</b> </div> <div class="form-group col-sm-6"> <input type="text" class="form-control form-control-sm mr-1" name="school' + countEdu + '" value="" size="50" class="school" /></div> \
            </div>');
            $('.school').autocomplete({ source: "school.php" });
            });
        });



        // http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript
        $(document).ready(function () {
            window.console && console.log('Document ready called');
            $('#addPos').click(function (event) {
                // http://api.jquery.com/event.preventdefault/
                event.preventDefault();
                if (countPos >= 9) {
                    alert("Maximum of nine position entries exceeded");
                    return;
                }
                countPos++;
                window.console && console.log("Adding position " + countPos);
                $('#position_fields').append(
                    '<div class=row id="position' + countPos + '"> \
                    <div class="form-group col-sm-4"><b>Year:</b></div> <div class="form-group col-sm-6">  <input type="text" class="form-control form-control-sm mr-1" name="year' + countPos + '" value="" /></div> \
                    <div class="form-group col-sm-2"> <input type="button" value="-" \
                onclick="$(\'#position' + countPos + '\').remove();return false;"></div> \
                <div class="form-group col-sm-4"><b>Description:</b> </div> <div class="form-group col-sm-6"> <textarea class="form-control form-control-sm mr-1" name="desc' + countPos + '" rows="8" cols="80"></textarea></div>\
            </div>');
            });
        });
    </script>


</p>

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
</body>

<script src="node_modules/jquery/dist/jquery.slim.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</html>


