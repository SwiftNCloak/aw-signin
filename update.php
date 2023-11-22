<?php
    include('config.php');

    // Get the employee ID from the URL parameter

    if (isset($_POST['token'])) {
        $id = $_POST['token'];
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $JobTitle = $_POST['JobTitle'];

        $sql = "UPDATE employees SET EmployeeFN = '$Fname', EmployeeLN = '$Lname', EmployeeEmail = '$Email', EmployeePhone = '$Phone', JobTitle = '$JobTitle'
                WHERE EmployeeID = $id";
        echo $sql;
        if ($conn->query($sql)) {
            header("location: EmployeeList.php");
        } else {
            echo $conn->error;
        }
    } else {
        echo "Employee ID not provided.";
    }
?>
