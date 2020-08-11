<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

include("config.php");

header('Content-Type: application/json; charset=UTF-8');

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

if (!empty($_POST["id"])) {

    $id = $_POST["id"];

    if (is_numeric($id)) {

        $query = "DELETE FROM personnel WHERE `id` = '$id';";

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

$output['status']['code'] = "200";
$output['status']['name'] = "deleted";
$output['status']['description'] = "success";

echo json_encode($output);

mysqli_close($conn);