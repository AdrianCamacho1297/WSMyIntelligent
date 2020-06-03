<?php

$response = array();
$Cn = mysqli_connect("localhost","root","","intelligent")or die ("Servidor no Encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"), true);
    $id_test = $objArray['id_test'];
    $result = mysqli_query($Cn,"SELECT questions.id_question, questions.question, questions.id_test FROM questions INNER JOIN tests ON questions.id_test = tests.id_test WHERE tests.id_test = $id_test");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) { 
            $response["success"] = 200;
            $response["message"] = "Preguntas Encontrado";
            $response["questions"] = array();
            while ($res = mysqli_fetch_array($result)){
                $question = array();
                $question["id_question"] = $res["id_question"];
                $question["question"] = $res["question"]; 
                $question["id_test"] = $res["id_test"];
                array_push($response["questions"], $question);
            }
           echo json_encode($response);
        } else {
            $response["success"] = 404;
            $response["message"] = "No se encontro información de las Preguntas";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;
        $response["message"] = "No se encontro de las Preguntas";
        echo json_encode($response);
    }
} else {
    $response["success"] = 400;
    $response["message"] = "Faltan Datos de Entrada";
    echo json_encode($response);
}
mysqli_close($Cn);

?>