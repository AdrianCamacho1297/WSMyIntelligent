<?php

$response = array();
$Cn = mysqli_connect("localhost","root","","intelligent")or die ("Servidor no Encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"), true);
    $id_test = $objArray['id_test'];
    $id_question = $objArray['id_question'];
    $result = mysqli_query($Cn,"SELECT answers.id_answer, answers.answer, answers.status_answer, answers.id_question FROM answers INNER JOIN questions ON answers.id_question = questions.id_question INNER JOIN tests ON questions.id_test = tests.id_test WHERE tests.id_test = $id_test AND questions.id_question = $id_question");
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) { 
            $response["success"] = 200;
            $response["message"] = "Preguntas Encontrado";
            $response["answers"] = array();
            while ($res = mysqli_fetch_array($result)){
                $answer = array();
                $answer["id_answer"] = $res["id_answer"];
                $answer["answer"] = $res["answer"]; 
                $answer["status_answer"] = $res["status_answer"];
                $answer["id_question"] = $res["id_question"];
                array_push($response["answers"], $answer);
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