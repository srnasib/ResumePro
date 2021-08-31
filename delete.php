<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}


if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Delete Resume from ResumePro Database</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
     
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="css/styles.css">
   
</head>

<body><div class="container">
<div class="row row-content align-items-center" id="reserve" >
            <div class="col-12  offset-sm-1 col-sm-10">
                <div class="card">
                    <h3 class="card-header modal-header text-black">Delete Resume</h3>
                    <div class="card-body modal-body">
                        
                 
                            <form method="post" class="form-row">
                            <div class="form-group col-sm-12">Confirm: Deleting <?= htmlentities((htmlentities($row['first_name']))." ".htmlentities($row['last_name'])) ?></div>
                            <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
                            <div class="form-group col-sm-12">
                            <input type="submit" value="Delete" class="btn btn-danger btn-sm ml-1" name="delete">
                            <a class="btn btn-success btn-sm  ml-1" href="index.php" role="button">Cancel</a>
                            
                            </div>
                             </form>
                            </div>
                           
   
            
                        </div>

                    </div>
                </div>
            </div>




</body>

<script src="node_modules/jquery/dist/jquery.slim.min.js"></script>
        <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</html>