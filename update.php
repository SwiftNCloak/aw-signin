<?php
    include('config.php');
    $disp = '';

    if (isset($_POST['token'])) {
        $id = $_POST['token'];
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $JobTitle = $_POST['JobTitle'];

        $checkDuplicateRec = "SELECT * FROM employees WHERE EmployeeFN = '$Fname' AND EmployeeID != $id";
        $duplicateRes = $conn->query($checkDuplicateRec);

        if ($duplicateRes->num_rows > 0) {
            echo "Error: An employee with the name '$Fname $Lname' already exists.";
        } 
        else {
            $sql = "UPDATE employees SET EmployeeFN = '$Fname', EmployeeLN = '$Lname', EmployeeEmail = '$Email', EmployeePhone = '$Phone', JobTitle = '$JobTitle'
                    WHERE EmployeeID = $id";
            echo $sql;
            if ($conn->query($sql)) {
                header("location: EmployeeList.php");
            } else {
                echo $conn->error;
            }
        }
    } else {
        echo "Employee ID not provided.";
    }
?>