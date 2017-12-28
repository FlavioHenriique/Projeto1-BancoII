<?php

function avaliar($email, $nota, $comentario, $localidade) {

    require_once 'conexao.php';
    $con = getConnection();
    $sql = "INSERT INTO Avaliacao (emailusuario,codigolocalidade,nota) "
            . "VALUES ('$email',$localidade,$nota)";
    pg_exec($con, $sql);

    $sqlcodigo = "SELECT codigo FROM avaliacao ORDER BY codigo DESC LIMIT 1";
    $result = pg_query($con, $sqlcodigo);
    $row = pg_fetch_array($result);
    $insercao = "INSERT INTO comentario_avaliacao(codigoavaliacao,comentario)"
            . "VALUES (" . $row['codigo'] . ",'" . $comentario . "')";
    pg_exec($con, $insercao);
    echo "<script>alert('Avaliação realizada!');</script>";
}
