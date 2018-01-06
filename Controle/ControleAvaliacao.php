<?php   

function avaliar($email, $nota, $comentario, $localidade) {

    require_once 'conexao.php';
    $con = getConnection();
    $query = "SELECT codigo FROM avaliacao WHERE emailusuario='$email' "
            . "and codigolocalidade=$localidade";
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
            . " and codigolocalidade=$localidade";
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
    $sql = "SELECT ca.comentario, u.nome FROM avaliacao a,comentario_avaliacao ca,
    usuario u WHERE a.codigolocalidade=".$codigo."AND a.codigo=ca.codigoavaliacao
    AND ca.comentario<>''  and a.emailusuario=u.email";
    $result = pg_query($con, $sql);
    if(pg_num_rows($result)>0){
    echo "Comentários <br> <br><table width='50%' border=1><tr><td>";
    while($row = pg_fetch_array($result)){
        echo "<b> ".$row["nome"]."-</b><br> "." ".$row["comentario"]."<hr>";
    }
    echo "</td></tr></table>";
    }else {
        echo "Sem comentários para esta localidade!";
    }
}

function verificarUsuario($email,$latitude,$longitude){
    require_once 'conexao.php';
    $con = getConnection();
    $sql = "select a.nota
from avaliacao a, comentario_avaliacao ca, localidade l
where a.codigo=ca.codigoavaliacao
and l.codigo=a.codigolocalidade
and l.latitude= '".$latitude."'
    and l.longitude= '".$longitude."'
and a.emailusuario='$email'";
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
    $sql = "SELECT CAST(AVG(nota) as Numeric(10,1)) FROM avaliacao WHERE codigolocalidade=".$localidade;
    $result = pg_query($con,$sql);
    
    $resultado = pg_fetch_array($result);
    if ($resultado["avg"]!=""){
        return $resultado["avg"];
    }else{
        return 0;
    }
}