<?php 
include 'header.php';
include 'config.php';
session_start();

  if(isset($_POST['submit'])){

   
     
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    
 
    if(empty($email)){
        $message[]='fill email';
    }
    else if(empty($pass)){
        $message[]='fill pass'; 
    }
    else{
        $check=mysqli_query($conn,"SELECT *FROM friends WHERE femail='$email' and fpassword='$pass'");
        if(mysqli_num_rows($check)>0){
            $row=mysqli_fetch_assoc($check);
            $_SESSION['fid']=$row['fId'];
            header('Location:friends.php');
          
        }
        else{
            
                 $message[]='user not exsit';
            
        }
    }


  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


  <section class="loginsec">
    
   <div  class="fullform">
   <h1>registation Page</h1>

   
    <form action=""  method="POST" class="fom">
        
        
       
        <div class="sp"><span >email</span></div>
        <input type="mail" class="box" name="email" placeholder="mail">
        <div class="sp"><span > password </span></div>
         
        <input type="password" class="box" name="pass" placeholder="passwords">
      
        <input type="reset" class="boxr">
        <input type="submit" class="boxr" name="submit" >

    </form>

    <div class="mesdiv">

    <?php 
    if(isset($message)) {
        
        foreach($message as  $message){
            echo'<p>'.$message.'</p>';
        }
        
    }
    
    ?>


    </div>

   </div>
 

  </section>
    

  <?php include 'footer.php' ?>  
</body>
</html>