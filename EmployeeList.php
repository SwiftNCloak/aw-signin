<?php
	include('config.php');
	$disp='';
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
	else {
		echo $conn->error;
	}

	// Initialize the important variables
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
				$JobTitle = $row['JobTitle'];
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

<!-- HTML FILE -->
<!DOCTYPE html>
	<html lang="en" dir="ltr">
		<head>
			<meta charset="utf-8">
			<title>EMPLOYEE LIST</title>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
		<style>
			.error-border {
					border: 2px solid #f56158;
				background: #deaca9;
				}
		</style>
  </head>
  <body>
		<center>
			<!-- SETS THE ACTION OF THE FORM DEPENDING IF THE ID IS SET -->
			<!-- IF ID IS SET, WE'RE ON UPDATE PAGE, SO REDIRECT ALL ACTIONS TO UPDATE.PHP -->
			<!-- AND IF NOT, WE'RE ON SAVE_EMPLOYEE PAGE, SO REDIRECT ALL ACTIONS TO SAVE_EMPLOYEE.PHP -->
			<?php
				if (isset($id)) { 
					$action = 'update.php';
				} else {
					$action = 'save_employee.php';
				}
			?>

			<!-- THE FORM -->
			<form action="<?php echo $action; ?>" method="POST">
				<input type="text" name="Fname" placeholder="Enter First Name" value="<?php echo $Fname ?>" required<?php if (isset($_GET['error']) && $_GET['id'] == $id) echo ' class="error-border"'; ?>>
				<input type="text" name="Lname" placeholder="Enter Last Name" value="<?php echo $Lname ?>" required<?php if (isset($_GET['error']) && $_GET['id'] == $id) echo ' class="error-border"'; ?>>
				<input type="email" name="Email" placeholder="Enter Email" value="<?php echo $Email ?>" required>
				<input type="text" name="Phone" placeholder="Enter Contact No" value="<?php echo $Phone ?>" required><br/>
				<input class="d-none" name="token" value="<?php echo $id ?>" />
				<select name="JobTitle">
					<?php
					$sql = "SELECT DISTINCT JobTitle FROM employees";
					$jobRes= $conn->query($sql);

					while ($row = $jobRes->fetch_assoc()) {
						$currPos = ($row['JobTitle'] == $JobTitle) ? 'selected' : '';
						echo '<option value="' . $row['JobTitle'] . '" ' . $currPos . '>' . $row['JobTitle'] . '</option>';
					}
					?>
				</select>
				<?php echo $btn; ?>

				<a href="logout.php" class="btn btn-danger">Logout</a>
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
				<?php echo $disp; ?>
				</tbody>
			</table>
		</center>

		<script>
			$("#sessionSelect").change(function() {
				var selectedSession = $(this).val();
				$("#myTable tbody tr").each(function() {
					var session = $(this).find("td:nth-child(6)").text(); // Assuming Session is in the 6th column
					if (selectedSession === "All" || session === selectedSession) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			});
		</script>
  </body>
  <script>
		$(document).ready( function () {
			$('#myTable').DataTable();
		} );
  </script>
</html>
