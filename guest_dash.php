<?php
include('config.php');
if(isset($_COOKIE['token'])){
  $id=$_COOKIE['token'];
  $sql ="SELECT * FROM users WHERE user_id=$id";
  if($rs=$conn->query($sql)){
    if($rs->num_rows>0){
      $row=$rs->fetch_assoc();
      $usertype=$row['user_type'];
      $userid=$row['user_id'];
      switch($usertype){
        case 0 : header("location:EmployeeList.php"); break;
        case 1 : header("location:staff_dash.php"); break;
      //  case 2 : header("location:guest_dash.php"); break;
      }
    }else{
        //token not exist
        header("location:logout.php");
    }
  }
  else{
    	echo $conn->error;
  }
}else{
    header("location:logout.php");
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>WELCOME GUEST</h1>
      	<a href="logout.php">Logout</a>
  </body>
</html>
