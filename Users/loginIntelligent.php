<?php

$response = array();

$Cn = mysqli_connect("localhost", "root", "", "intelligent") or die("Servidor no Encontrado");
mysqli_set_charset($Cn, "utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"), true);
    $numUser = $objArray['num_user'];
    $pasUser = $objArray['pas_user'];
    $result = mysqli_query($Cn, "SELECT * from users WHERE num_user = $numUser AND pas_user = $pasUser");

    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {

            $result = mysqli_fetch_array($result);
            $user = array();

            $user["num_user"] = $result["num_user"];
            $user["pas_user"] = $result["pas_user"];
            
            $response["success"] = 200;
            $response["message"] = "Usuario Encontrado";
            $response["user"] = array();

            array_push($response["user"], $user);

            echo json_encode($response);
        } else {
            $response["success"] = 404;
            $response["message"] = "No se encontro información del Usuario";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;
        $response["message"] = "No se encontro el Usuario";
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