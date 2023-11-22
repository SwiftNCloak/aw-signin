<?php
include('config.php');$disp='';
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
        case 2 : header("location:guest_dash.php"); break;
      }
    }else{
        //token not exist
        header("location:logout.php");
    }
  }
  else{
    	echo $conn->error;
  }
}





if(isset($_POST['txtUname'])){
  $U=$_POST['txtUname'];
  $P=md5($_POST['txtUpass']);
  $sql ="SELECT * FROM users WHERE user_name='$U' and user_pass='$P'";
  if($rs=$conn->query($sql)){
  	if($rs->num_rows>0){
  		$row=$rs->fetch_assoc();
      $usertype=$row['user_type'];
      $userid=$row['user_id'];
      setcookie('token',$userid);
      switch($usertype){
        case 0 : header("location:EmployeeList.php"); break;
        case 1 : header("location:staff_dash.php"); break;
        case 2 : header("location:guest_dash.php"); break;
      }
    }else{
      // invalid credential
      $disp='Invalid Credentials';
    }
  }else{
    	echo $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Log In</title>
  </head>
  <body>
    <div style="width:250px; margin:auto;">
      <fieldset>
        <legend>LOGIN ACCOUNT</legend>
        <form  method="post">
            <label>USERNAME</label><br/>
            <input type="text" required="true" name="txtUname" placeholder="Enter Username"/> <br/>
            <label>PASSWORD</label><br/>
            <input type="password" required="true" name="txtUpass" placeholder="Enter Password"/> <br/><br/>
            <input type="submit" name="btnLogin" value="Login"/><br/>
            <?php echo $disp; ?>
        </form>
      </fieldset>

      <form action="signup.php" method="get">
        <input type="submit" value="Sign Up"/>
      </form>
    <div>
  </body>
</html>
