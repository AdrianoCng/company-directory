<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

include("config.php");

header('Content-Type: application/json; charset=UTF-8');

function test_input($data) {
    $data = trim(preg_replace('/\s+/', ' ', $data));
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;   
};

$conn = new mysqli($cd_host, $cd_user, $cd_password, $cd_dbname, $cd_port, $cd_socket);

if (mysqli_connect_errno()) {

    $output['status']['code'] = "300";
    $output['status']['name'] = "failure";
    $output['status']['description'] = "database unavailable";
    $output['data'] = [];

    mysqli_close($conn);

    echo json_encode($output);

    exit;

};

// Validate Inputs
if (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && !empty($_POST["department"])) {

    $tested_firstName = test_input($_POST["fname"]);
    $tested_lastName = test_input($_POST["lname"]);
    $tested_email = test_input($_POST["email"]);

    $valid_firstName = preg_match("/^[a-zA-Z ]*$/", $tested_firstName);
    $valid_lastName = preg_match("/^[a-zA-Z ]*$/", $tested_lastName);
    $valid_email = filter_var($tested_email, FILTER_VALIDATE_EMAIL);
    $valid_departmentID = is_numeric($_POST["department"]);
    

    if ($valid_firstName && $valid_lastName && $valid_email && $valid_departmentID) {

        $isSanitized_firstName = filter_var($tested_firstName, FILTER_SANITIZE_STRING);
        $isSanitized_lastName = filter_var($tested_lastName, FILTER_SANITIZE_STRING);
        $isSanitized_email = filter_var($valid_email, FILTER_SANITIZE_EMAIL);

        $firstName = ucwords(strtolower($isSanitized_firstName));
        $lastName = ucwords(strtolower($isSanitized_lastName));
        $jobTitle = '';
        $email = strtolower($isSanitized_email);
        $departmentID = $_POST["department"];

        $query = "INSERT INTO personnel (firstName, lastName, jobTitle, email, departmentID) VALUES ('$firstName', '$lastName', '$jobTitle', '$email', '$departmentID')";

        $result = $conn->query($query);

    };
    
};

if (!isset($result) || !$result) {

    $output['status']['code'] = "400";
    $output['status']['name'] = "failed";
    $output['status']['description'] = "query failed";

    echo json_encode($output);

    mysqli_close($conn);

    exit;

};

$output['status']['code'] = "201";
$output['status']['name'] = "created";
$output['status']['description'] = "success";

echo json_encode($output);

mysqli_close($conn);