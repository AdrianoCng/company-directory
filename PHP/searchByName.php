<?php

include("config.php");

header('Content-Type: application/json; charset=UTF-8');

function test_input($data) {
    $data = trim($data);
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

if (isset($_POST["q"])) {

    $tested_q = test_input($_POST["q"]);

    if ($tested_q) {

        $q = $tested_q;

        $query = "SELECT p.id, firstName, lastName, email, d.name AS departmentName, d.id AS departmentId, loc.name As locationName FROM personnel AS p INNER JOIN department AS d ON d.id = p.departmentID INNER JOIN location as loc ON d.locationID = loc.id WHERE `firstName` LIKE '$q%' OR `lastName` LIKE '$q%'";
        
        $limit = 6;
        $sqlresult = $conn->query($query);
        $sqlrowscount = mysqli_num_rows($sqlresult);
        $sqlpages = $sqlrowscount / $limit;
        $numpages = ceil($sqlpages);

        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $offset = ($page - 1) * $limit;

        $query .= " LIMIT $offset, $limit";

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

$data = array();

while ($row = mysqli_fetch_assoc($result)) {

    array_push($data, $row);

}

$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "success";
$output['metadata']['pages'] = $numpages;
$output['metadata']['itemsPerPage'] = $limit;
$output['metadata']['results'] = $sqlrowscount;
$output['data'] = $data;

echo json_encode($output);

mysqli_close($conn);