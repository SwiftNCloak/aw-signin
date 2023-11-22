<?php
    include('config.php');
    $current = date('d-M-y');

    $Fname = $_POST['Fname'];
    $Lname = $_POST['Lname'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $JobTitle = $_POST['JobTitle'];

    // Finding duplicates
    $sql = "SELECT EmployeeID FROM employees WHERE EmployeeFN = '$Fname' AND EmployeeLN = '$Lname'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Checks current EmployeeID
        $sql = "SELECT MAX(EmployeeID) AS MaxID FROM employees";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $newEmployeeID = $row['MaxID'] + 1;

        $sql = "INSERT INTO employees (EmployeeID, EmployeeFN, EmployeeLN, EmployeeEmail, EmployeePhone, HireDate, ManagerID, JobTitle)
                VALUES ($newEmployeeID, '$Fname', '$Lname', '$Email', '$Phone', '$current', 50, '$JobTitle')";

        if ($conn->query($sql)) {
            header("location:EmployeeList.php");
        } else {
            echo $conn->error;
        }
    } else {
        $error = "The name already exists. Please input another one, or edit the information.";
        header("location:EmployeeList.php?error=" . urlencode($error));
    }
?>
