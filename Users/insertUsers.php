<?php

$response = array();

$Cn = mysqli_connect("localhost", "root", "", "intelligent") or die("Servidor no Encontrado");
mysqli_set_charset($Cn, "utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"), true);

    if (empty($objArray)) {
        $response["success"] = 400;
        $response["message"] = "Faltan Datos Entrada";
        echo json_encode($response);
    } else {
        $numUser = $objArray['num_user'];
        $pasUser = $objArray['pas_user'];
        $nameUser = $objArray['name_user'];
        $espUser = $objArray['esp_user'];
        $semUser = $objArray['sem_user'];
        $ageUser = $objArray['age_user'];
        $sexUser = $objArray['sex_user'];
        $result = mysqli_query($Cn, "INSERT INTO users(num_user, pas_user, name_user, esp_user, sem_user, age_user, sex_user) VALUES ($numUser, '$pasUser', '$nameUser','$espUser', $semUser, $ageUser, '$sexUser')");
        if ($result) {
            $response["success"] = 200;   
            $response["message"] = "Usuario Insertado";
            echo json_encode($response);
        } else {
            $response["success"] = 406;
            $response["message"] = "Usuario no Insertado";
            echo json_encode($response);
        }
    }
} else {
    $response["success"] = 400;
    $response["message"] = "Faltan Datos de entrada";
    echo json_encode($response);
}
mysqli_close($Cn);

?>