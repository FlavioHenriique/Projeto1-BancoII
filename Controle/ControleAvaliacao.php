<?php   


class ControleAvaliacao{
    
   
    
    
function avaliar($email, $nota, $comentario, $localidade) {

    require_once 'conexao.php';
    $con = getConnection();
    $query = "SELECT codigo FROM avaliacao WHERE emailusuario='$email' "
            . "AND codigolocalidade=$localidade";
    $resultado = pg_query($con,$query);
    if(pg_num_rows($resultado)>0){
        $linha = pg_fetch_array($resultado);
        $sqlnota = "UPDATE  avaliacao SET nota=".$nota." WHERE codigo="
                . "".$linha['codigo'];
        pg_exec($con, $sqlnota);
    }else{
        $sql = "INSERT INTO Avaliacao (emailusuario,codigolocalidade,nota) "
            . "VALUES ('$email',$localidade,$nota)";
        pg_exec($con, $sql);
    }
    $sqlcodigo = "SELECT codigo FROM avaliacao WHERE emailusuario='".$email."'"
            . " AND codigolocalidade=$localidade";
    $result = pg_query($con, $sqlcodigo);
    $row = pg_fetch_array($result);
    $insercao = "INSERT INTO comentario_avaliacao(codigoavaliacao,comentario)"
            . "VALUES (" . $row['codigo'] . ",'" . $comentario . "')";
    pg_exec($con, $insercao);
    header('Location: index.php');
    
    echo "<script>alert('Avaliação realizada!');</script>";
}

function getComentarios($codigo) {

    require_once 'conexao.php';
    $con = getConnection();
    $sql = "SELECT ca.comentario, u.nome FROM avaliacao a,comentario_avaliacao ca,
    usuario u WHERE a.codigolocalidade=".$codigo."AND a.codigo=ca.codigoavaliacao
    AND ca.comentario <> ' '  AND a.emailusuario=u.email ORDER BY ca.codigoavaliacao";
    $result = pg_query($con, $sql);
    if(pg_num_rows($result)>0){
    echo "<h2> &nbsp; Comentários</h2>";
    while($row = pg_fetch_array($result)){
        echo "<b> &nbsp; &nbsp;".$row["nome"]."  </b><br> &nbsp; &nbsp;".$row["comentario"]."<hr>";
    }
    }else {
        echo "Sem comentários para esta localidade!";
    }
}

function verificarUsuario($email,$latitude,$longitude){
    require_once 'conexao.php';
    $con = getConnection();
    $sql = "SELECT a.nota
FROM avaliacao a, comentario_avaliacao ca, localidade l
WHERE a.codigo=ca.codigoavaliacao
AND l.codigo=a.codigolocalidade
AND l.latitude= '".$latitude."'
    AND l.longitude= '".$longitude."'
AND a.emailusuario='$email'";
    $result = pg_query($con,$sql);
    
    if(pg_num_rows($result)>0){
        $row = pg_fetch_array($result);
         echo "<style>#nota {visibility:visible;} #comentario {visibility:visible;}"
        . "#botao {visibility:visible;}  #titulo{visibility: visible;}</style>"
                 . "<script>nota.value=".$row['nota'].";"
                 . "titulo.innerHTML='Editar avaliação';</script>";
    }
    else{
         echo "<style>#nota {visibility:visible;} #comentario {visibility:visible;}"
        . "#botao {visibility:visible;} #titulo{visibility: visible;}</style>";
    }
}

function calculaMedia($localidade){
    
    require_once 'conexao.php';
    $con = getConnection();
    $sql = "SELECT CAST(AVG(nota) as Numeric(10,1)) FROM avaliacao"
            . " WHERE codigolocalidade=".$localidade;
    $result = pg_query($con,$sql);
    
    $resultado = pg_fetch_array($result);
    if ($resultado["avg"]!=""){
        return $resultado["avg"];
    }else{
        return 0;
    }
}
}