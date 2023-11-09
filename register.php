<?php 
include 'header.php';
include 'config.php';
session_start();

  if(isset($_POST['submit'])){

    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $cpass=$_POST['cpass'];

    if(empty($name)){
        $message[]='fill  name';
    }
    else if(empty($email)){
        $message[]='fill email';
    }
    else if(empty($pass)){
        $message[]='fill pass'; 
    }
    else if(empty($cpass)){
        $message[]='fill cpass'; 
    }
    else if($pass!=$cpass){
        $message[]='confirm pass  not match'; 
    }
     
    else{
        $check=mysqli_query($conn,"SELECT *FROM friends WHERE femail='$email' and fpassword='$pass'");
        if(mysqli_num_rows($check)>0){
            $message[]='user exsits  already'; 
             
        }
        else{
            $insert=mysqli_query($conn,"INSERT INTO friends(fname,femail,fpassword) VALUES('$name','$email','$pass')");
            if($insert){
                $message[]='register succssesful';
                header('Location:index.php'); 
            }
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
   <h1>login Page</h1>

   
    <form action=""  method="POST" class="fom">
        <div class="sp"><span >profile name</span></div>
        
        <input type="text" class="box" name="name" placeholder="profile name">
        <div class="sp"><span >email</span></div>
        <input type="mail" class="box" name="email" placeholder="mail">
        <div class="sp"><span > password </span></div>
         
        <input type="password" class="box" name="pass" placeholder="passwords">
        <div class="sp"><span >confirm password</span></div>
        <input type="password" class="box" name="cpass" placeholder="confirm passwords">
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