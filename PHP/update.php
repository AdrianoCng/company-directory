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

}

if (!empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["email"]) && !empty($_POST["department"]) &&!empty($_POST["id"])) {

    $tested_firstName = test_input($_POST["fname"]);
    $tested_lastName = test_input($_POST["lname"]);
    $tested_email = test_input($_POST["email"]);

    $isValid_firstName = preg_match("/^[a-zA-Z ]*$/", $tested_firstName);
    $isValid_lastName = preg_match("/^[a-zA-Z ]*$/", $tested_lastName);
    $isValid_email = filter_var($tested_email, FILTER_VALIDATE_EMAIL);
    $isValid_departmentID = is_numeric($_POST["department"]);

    $isSanitized_email = filter_var($isValid_email, FILTER_SANITIZE_EMAIL);

    if ($isValid_firstName && $isValid_lastName && $isValid_email && $isValid_departmentID) {

        $firstName = ucwords(strtolower($tested_firstName));
        $lastName = ucwords(strtolower($tested_lastName));
        $email = strtolower($isSanitized_email);
        $departmentID = $_POST["department"];
        $id = $_POST["id"];

        $query = "UPDATE personnel SET `firstName` = '$firstName', `lastName` = '$lastName', `email` = '$email', `departmentID` = '$departmentID' WHERE `id` = '$id';";

        $result = $conn->query($query);

    };

}

if (!isset($result) || !$result) {

    $output['status']['code'] = "400";
    $output['status']['name'] = "failed";
    $output['status']['description'] = "query failed";

    echo json_encode($output);

    mysqli_close($conn);

    exit;

};

$output['status']['code'] = "200";
$output['status']['name'] = "updated";
$output['status']['description'] = "success";

echo json_encode($output);

mysqli_close($conn);