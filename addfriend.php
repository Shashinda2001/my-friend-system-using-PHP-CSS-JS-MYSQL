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
if(isset($_SESSION['countc'])){
    $count=$_SESSION['countc'];
}
else{
    $count=0; 
}
 if(isset($_GET['prev'])){
    $count=$count-5;
    $_SESSION['countc'] =$count;
    header('Location:addfriend.php');
}
else if(isset($_GET['next'])){
    $count=$count+5;
    $_SESSION['countc'] =$count;
    header('Location:addfriend.php');
}

if(isset($_GET['setfriend'])){

    $unid=$_GET['setfriend'];
    

   $del= mysqli_query($conn," INSERT INTO `friendlist`(`uId`, `fId`) VALUES ('$fid','$unid')");
   $upfriend= mysqli_query($conn,"UPDATE friends
   SET num_friends = num_friends + 1
   WHERE fId='$fid'");
   if($del and $upfriend){
    header('Location:addfriend.php');
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
        echo '<h1>'.$c['fname'].' add Friend list page</h1>
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
    $checkfcount=mysqli_query($conn,"SELECT *FROM friends where fId!='$fid'");
    if(mysqli_num_rows($checkfcount)>0){

        $select=mysqli_query($conn," SELECT *
        FROM friends f WHERE f.fId !='$fid' and f.fId not in(SELECT fId FROM friendlist u where u.uId='$fid') limit $count,5");

        if(mysqli_num_rows($select)>0){
            while($row=mysqli_fetch_assoc($select)){

                echo '<tr>

                <td>'.$row['fname'].'</td>
                <td><a href="addfriend.php?setfriend='.$row['fId'].'">add friend</a></td>
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
// $_SESSION['countc'] =$count;
if($count>0){
    echo '<a href="addfriend.php?prev"  class="boxr">prev</a>';
}

$allusers=mysqli_query($conn,"SELECT count(f.fId) as counts
FROM friends f WHERE f.fId !='$fid' and f.fId not in(SELECT fId FROM friendlist u where u.uId='$fid') ");

$showcount=mysqli_fetch_assoc($allusers);


if(($count+5)<($showcount['counts'])){
echo '<a href="addfriend.php?next" class="boxr">next</a>';
}
?>
</div>

<a href="friends.php" class="boxr">friend list</a>
<a href="addfriend.php?logout" class="boxr">logout</a>


</section>


<?php include 'footer.php' ?>  
    
</body>
</html>