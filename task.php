<?php

//include_once 'application/helpers/sendemail_helper.php';

//recordatorioCursoTresDiasAntes();
//despedidaDelCurso();
updateBitacoraNivel();
//cumpleAnios();

function recordatorioCursoTresDiasAntes() {//Correo de recordatorio cuando falten 3 días para iniciar el curso
    $result = sql("SELECT a.nombre,u.nombres,u.correo 
                  FROM curso c 
                  JOIN asignatura a ON c.id_asignatura=a.id_asignatura
                  JOIN usuario_x_curso uc ON c.id_curso=uc.id_curso
                  JOIN usuario u ON uc.id_usuario=u.id_usuario AND u.rol='estudiante'
                  WHERE DATE(c.fecha_inicio)=DATE_ADD(CURDATE(),INTERVAL 3 DAY)");
    while ($row = mysqli_fetch_array($result)) {
        $msj = "Cordial saludo {$row['nombres']}, le informamos que el curso {$row['nombre']} comienza en 3 días <br>";
        enviarEmail($row['correo'], "Inicio del curso", $msj);
    }
}

function despedidaDelCurso() {//Correo de despedida al finalizar un curso
    $result = sql("SELECT a.nombre,u.nombres,u.correo 
                  FROM curso c 
                  JOIN asignatura a ON c.id_asignatura=a.id_asignatura
                  JOIN usuario_x_curso uc ON c.id_curso=uc.id_curso
                  JOIN usuario u ON uc.id_usuario=u.id_usuario AND u.rol='estudiante'
                  WHERE DATE(c.fecha_fin)=CURDATE()");
    while ($row = mysqli_fetch_array($result)) {
        $msj = "Cordial saludo {$row['nombres']}, le informamos que el curso {$row['nombre']} ha finalizado <br>";
        enviarEmail($row['correo'], "Fin del curso", $msj);
    }
}

function updateBitacoraNivel() {//Correo de despedida al finalizar un curso
    $result = sql("select id_usuario,id_curso,MAX(id_nivel) nivel
                   FROM bitacora_nivel
                   GROUP BY id_curso,id_usuario");
    while ($row = mysqli_fetch_array($result)) {
        sql("INSERT INTO bitacora_nivel(id_usuario,id_curso,id_nivel) VALUES('{$row['id_usuario']}','{$row['id_curso']}','{$row['nivel']}')");
    }
}

function cumpleAnios() {//Correo de despedida al finalizar un curso
    $result = sql("Select u.nombres,u.correo FROM usuario u
                  WHERE DATE(u.fecha_nacimiento)=CURDATE()");
    while ($row = mysqli_fetch_array($result)) {
        $msj = "Cordial saludo {$row['nombres']}, Ticademia te desea un muy feliz cumpleaños!";
        enviarEmail($row['correo'], "Feliz cumpleaños", $msj);
    }
}

function sql($query) {
    $link = mysqli_connect("localhost", "root", "1Minerva.Unal", "ticademia");
    $r = mysqli_query($link, $query);
    mysqli_close($link);
    return $r;
}
