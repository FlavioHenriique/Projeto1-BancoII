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

function getComentarios($codigo) {

    require_once 'conexao.php';
    $con = getConnection();
    $sql = "SELECT ca.comentario, a.emailusuario FROM avaliacao a,comentario_avaliacao ca
    WHERE a.codigolocalidade=".$codigo."AND a.codigo=ca.codigoavaliacao
    AND ca.comentario<>''";
    $result = pg_query($con, $sql);
    while($row = pg_fetch_array($result)){
        echo "<hr><b color='blue'>".$row["emailusuario"]."</b> "." ".$row["comentario"]."<br>";
        echo "<hr>";
    }
}
