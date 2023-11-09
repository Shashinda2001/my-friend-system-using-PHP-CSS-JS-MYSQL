<?php 
include 'header.php';
include 'config.php';
session_start();

if(isset($_SESSION['fid'])){
  $fid=$_SESSION['fid'];
}

if(isset($_GET['logout'])){
    session_destroy();
    header('Location:index.php');
}

// if(!(isset($_GET['prev'])  or isset($_GET['next'])) ){
//     $count=0;
// }
if(isset($_SESSION['count'])){
    $count=$_SESSION['count'];
}
else{
    $count=0; 
}
if(isset($_GET['prev'])){
    $count=$count-5;
    $_SESSION['count'] =$count;
    header('Location:friends.php');
}
else if(isset($_GET['next'])){
    $count=$count+5;
    $_SESSION['count'] =$count;
    header('Location:friends.php');
}
 

if(isset($_GET['unfriend'])){

    $unid=$_GET['unfriend'];
    

   $del= mysqli_query($conn,"DELETE FROM friendlist WHERE uId='$fid' and fId='$unid'");
   $downfriend= mysqli_query($conn,"UPDATE friends
   SET num_friends = num_friends - 1
   WHERE fId='$fid'");
   if($del and $downfriend){
    header('Location:friends.php');
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

<section class="sect">
    
    <?php 
     
    $checkfcount=mysqli_query($conn,"SELECT *FROM friends WHERE fId='$fid' ");
    if(mysqli_num_rows($checkfcount)>0){
        $c=mysqli_fetch_assoc($checkfcount);
           echo '<h1>'.$c['fname'].' add Friend page</h1>
           <p>total number of friends is '.$c['num_friends'].'</p>'; 
        
    }  
    ?>
    
<table>

<thead>
    
<th>name</th>
<th>action</th>


</thead>
<tbody>
    <?php 
    $checkfcount=mysqli_query($conn,"SELECT *FROM friends WHERE fId='$fid' and num_friends>'0'");
    if(mysqli_num_rows($checkfcount)>0){

        $select=mysqli_query($conn," SELECT f.uId, f.fId, u.fname
        FROM friendlist f
        INNER JOIN friends u ON f.fId = u.fId
        WHERE f.uId = '$fid' limit $count,5;
        ");
        if(mysqli_num_rows($select)>0){
            while($row=mysqli_fetch_assoc($select)){

                echo '<tr>

                <td>'.$row['fname'].'</td>
                <td><a href="friends.php?unfriend='.$row['fId'].'">unfriend</a></td>
                </tr>';

            }
        }



    }
    else{
        echo'no  friends yet';
    }
    
    ?>
  
    </tbody>



</table>

<div class="next">

<?php
// $_SESSION['count'] =$count;
if($count>0){
    echo '<a href="friends.php?prev" class="boxr">prev</a>';
}

if(($count+5)<$c['num_friends']){
echo '<a href="friends.php?next" class="boxr">next</a>';
}
?>



</div>

<a href="addfriend.php" class="boxr">add friends</a>
<a href="friends.php?logout" class="boxr">logout</a>


</section>


<?php include 'footer.php' ?>  
    
</body>
</html>