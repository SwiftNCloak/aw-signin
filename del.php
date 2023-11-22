<?php
  include('config.php');

  if(isset($_GET['token'])){
    $id =$_GET['token'];
    $sql="DELETE FROM employees WHERE EmployeeID=$id";

    if($conn->query($sql)){
      header("location:EmployeeList.php");// redirect in php
    }
    else{
      echo $conn->error;
    }
  }
?>
