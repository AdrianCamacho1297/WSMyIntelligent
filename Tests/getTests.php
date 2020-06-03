<?php

$response = array();
$Cn = mysqli_connect("localhost","root","","intelligent")or die ("Servidor no Encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = mysqli_query($Cn,"SELECT * FROM tests ORDER BY id_test ASC");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) { 
            $response["success"] = 200;
            $response["message"] = "Test Encontrado";
            $response["tests"] = array();
            while ($res = mysqli_fetch_array($result)){
                $test = array();
                $test["id_test"] = $res["id_test"];
                $test["name_test"] = $res["name_test"];
                $test["time_test"] = $res["time_test"];
                $test["desc_test"]=$res["desc_test"];
                array_push($response["tests"], $test);
            }
           echo json_encode($response);
        } else {
            $response["success"] = 404;
            $response["message"] = "No se encontro información el Test";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;
        $response["message"] = "No se encontro el Test";
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 400;
    $response["message"] = "Faltan Datos de Entrada";
    echo json_encode($response);
}
mysqli_close($Cn);
?>