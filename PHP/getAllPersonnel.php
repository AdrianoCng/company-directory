<?php

include("./config.php");

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

// Find number of rows in the database and set number of pages needed

$limit = 6;
$query = 'SELECT p.id, firstName, lastName, email, d.name AS departmentName, d.id AS departmentId, loc.name As locationName FROM personnel AS p INNER JOIN department AS d ON d.id = p.departmentID INNER JOIN location as loc ON d.locationID = loc.id';
$sqlresult = $conn->query($query);
$sqlrowcount = mysqli_num_rows($sqlresult);
$sqlpages = $sqlrowcount / $limit;
$numpages = ceil($sqlpages);

// -->


$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query .= ' ORDER BY p.firstName ASC LIMIT '.$offset.', '.$limit;

$result = $conn->query($query);

if (!$result) {

    $output['status']['code'] = "400";
    $output['status']['name'] = "executed";
    $output['status']['description'] = "query failed";	
    $output['data'] = [];

    echo json_encode($output); 

    mysqli_close($conn);
    exit;

}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {

    array_push($data, $row);

}

$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "success";
$output['metadata']['pages'] = $numpages;
$output['metadata']['itemsPerPage'] = $limit;
$output['metadata']['results'] = $sqlrowcount;
$output['data'] = $data;

echo json_encode($output); 

mysqli_close($conn);