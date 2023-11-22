<?php

include('config.php');
$disp='';


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
      //  case 0 : header("location:EmployeeList.php"); break;
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
}else{
    header("location:logout.php");
}





$sql ="SELECT EmployeeID, EmployeeFN, EmployeeLN,JobTitle FROM employees";
//execute query
if($rs=$conn->query($sql)){
	if($rs->num_rows>0){
		while($row=$rs->fetch_assoc()){
			$disp.='<tr>';
				$disp.='<td>'.$row['EmployeeID'].'</td>';
				$disp.='<td>'.$row['EmployeeFN'].' '.$row['EmployeeLN'].'</td>';
				$disp.='<td>'.$row['JobTitle'].'</td>';
					$disp.='<td>
					<a class="btn btn-warning" href="EmployeeList.php?token='.$row['EmployeeID'].'"> Edit</a>
					<a class="btn btn-danger" href="del.php?token='.$row['EmployeeID'].'"> Delete</a>

					</td>';
			$disp.='</tr>';
		}
	}
	else{
	  $disp="No record(s) Found!";
	}
}
else{
	echo $conn->error;
}

$Fname='';$Lname='';$Email=''; $Phone='';
if(isset($_GET['token'])){
	$id=$_GET['token'];
	$sql="SELECT * FROM employees WHERE EmployeeID=$id";
	if($rs=$conn->query($sql)){
		if($rs->num_rows>0){
			$row=$rs->fetch_assoc();
			$Fname=$row['EmployeeFN'];
			$Lname=$row['EmployeeLN'];
			$Email=$row['EmployeeEmail'];
			$Phone=$row['EmployeePhone'];
		}
	}else{
		echo $conn->error;
	}
	$btn='<input class="btn btn-warning" type="submit" name="btnUpdate" value="UPDATE INFORMATION">';
}
else{
	$btn='<input class="btn btn-primary" type="submit" name="btnSubmit" value="SAVE INFORMATION">';
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>EMPLOYEE LIST</title>
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
  </head>
  <body>
	<center>
		<a href="logout.php">Logout</a>
		<form  action="save_employee.php" method="post">
					<input type="text" name="Fname" placeholder="Enter First Name" value="<?php echo $Fname?>">
					<input type="text" name="Lname" placeholder="Enter Last Name" value="<?php echo $Lname?>">
					<input type="email" name="Email" placeholder="Enter Email" value="<?php echo $Email?>">
					<input type="text" name="Phone" placeholder="Enter Contact No" value="<?php echo $Phone?>"><br/>
					<select  name="JobTitle">
<?php
	$sql="SELECT DISTINCT(JobTitle) FROM employees";
		if($rs=$conn->query($sql)){
				while($row=$rs->fetch_assoc()){
				echo '<option value="'.$row['JobTitle'].'">'.$row['JobTitle'].'</option>';
			}
		}else{

			echo $conn->error;
		}

 ?>
					</select>

					<?php
						echo $btn;
					?>

		</form>







		<table class="table table-bordered table-hover" id="myTable">
			<thead>
				<tr>
					<th>EmpNo</th>
					<th>Name</th>
					<th>Job Title</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
				echo $disp;
			?>
			</tbody>
		</table>
	</center>
  </body>
  <script>
	$(document).ready( function () {
		$('#myTable').DataTable();
	} );
  </script>
</html>
