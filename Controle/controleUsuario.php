<?php

require_once 'conexao.php';

function autenticar($email, $senha) {

    $con = getConnection();
    $sql = "SELECT * FROM USUARIO WHERE email='$email' AND senha='$senha'";
    $result = pg_query($con, $sql);
    $row = pg_fetch_array($result);
    if ($row > 0) {
        echo "<script>nomeUsuario.innerHTML='" . $row["nome"] . "';</script>";
        echo "<style>#btCadastrar{visibility: visible;}</style>";
    } else {
        echo"<script>autenticacao.innerHTML='Usuário não encontrado!';</script>"
        . "<style>#autenticacao{color:red;}</style>";
    }
}

function cadastrarUsuario($cadEmail, $cadNome, $cadSenha) {

    if ($cadEmail === "" || $cadNome === "" || $cadSenha === "") {
       return "Preencha todos os campos! <style>#cadastro{color:red;}</style>";
    }
    $con = getConnection();
    $sql = "SELECT email FROM Usuario WHERE email='" . $cadEmail . "'";
    $result = pg_query($con, $sql);
    if (pg_num_rows($result) > 0) {
        return "Este email já está sendo utilizado <style>#cadastro{color:red;}</style>";
    } else {
        $cadastro = "INSERT INTO Usuario (nome,email,senha) VALUES('"
                . $cadNome . "','" . $cadEmail . "','" . $cadSenha . "')";
        pg_exec($con, $cadastro);
        return "Usuário cadastrado com sucesso! ";
    }
}