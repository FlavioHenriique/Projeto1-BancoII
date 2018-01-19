<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tela Inicial</title>
        <link rel="stylesheet" href="Css/app.css">
    </head>
    <body>
        <table width="100%" height="100%" class="tabela"><tr bgcolor="#B22222" class="topo">
                <td width="50%"><h1>Tela Inicial</h1>
                    <b> <label id="nomeUsuario"></label></b>
                </td>
                <td>
                    <div id="login"><form method="post" tex-align="right">
                            <table>
                                <tr>
                                    <td><b><label class="topo">Email</label></b></td>     
                                    <td><b><label class="topo">Senha</label></b></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email"></td>
                                    <td><input type="password" name="senha"></td>
                                    <td> <input type="submit" value="Entrar"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="autenticacao"></label>
                                    </td>
                                </tr>
                            </table>           
                        </form></div>
                </td>
            </tr>
            <tr height="90%" bgcolor="#F5F5F5">
                <td>
                    <table>
                        <tr>
                            <td>
                                <form method="post">
                                    <input type="text" name="buscaNome" 
                                           placeholder="Nome da localidade">
                                    <input type="submit" value="Buscar">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="text" name="buscaEndereco" 
                                           placeholder="Endereço">
                                    <input type="submit" value="Buscar">
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form method="post" name="avaliacao" id="avaliacao"
                                      action="Avaliacao.php">
                                    <input type="hidden" name="latMarker" id="latMarker">
                                    <input type="hidden" name="lngMarker" id="lngMarker">
                                    <input type="hidden" name="avaliador" id="avaliador">
                                </form>
                            </td>
                        </tr>
                    </table>


                    <label id="resultadoBusca"></label>
                    <div id="map"></div><br><br>
            <center>
                <form method="post" action="Localidade.php">
                    <input type="hidden" name="user" id="user">
                    <input type="hidden" name="userPass" id="userPass"><br>
                    <button id="btCadastrar">CADASTRAR LOCALIDADE</button>
                </form>
            </center>
        </td>
        <td>
            <form method="post"><center>
                    <h2>Cadastro de Usuário</h2>
                    <input type="text" name="cadNome" class="palavras" placeholder="Nome"><br><br>
                    <input type="text" name="cadEmail" class="palavras" placeholder="Email"><br><br>
                    <input type="password" name="cadSenha" class="palavras" placeholder="Senha"><br><br>
                    <label id="cadastro"></label><br><br>
                    <input type="submit" value="Cadastrar">
                </center>
            </form>
        </td>
    </tr>
</table>
<br>
<br><br>
</body>
</html>
<?php

require_once 'Controle/controleUsuario.php';
require_once 'Controle/mapa.php';
require_once 'Modelo/Usuario.php';

$controladorUsuario = new controleUsuario();

if (isset($_SESSION["usuario"])) {
     $obj = unserialize($_SESSION["usuario"]);
     $controladorUsuario->autenticar($obj->getEmail(), $obj->getSenha());
}

if (isset($_POST["buscaEndereco"])) {
    require_once 'Controle/ControleLocalidade.php';
    buscarEndereco($_POST["buscaEndereco"]);
} else if (isset($_POST["buscaNome"])) {

    require_once 'Controle/ControleLocalidade.php';
    buscarNome($_POST["buscaNome"]);
} else if (isset($_POST["email"]) && isset($_POST["senha"])) {

    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $controladorUsuario->autenticar($email, $senha);
    initMap();
} else if (isset($_POST["cadEmail"]) && isset($_POST["cadNome"]) &&
        isset($_POST["cadSenha"])) {

    /*
      $cadEmail = $_POST["cadEmail"];
      $cadNome = $_POST["cadNome"];
      $cadSenha = $_POST["cadSenha"];

      echo "<script>cadastro.innerHTML='" .
      cadastrarUsuario($cadEmail, $cadNome, $cadSenha) . "';</script>";
     */
    
    echo "<script>cadastro.innerHTML='" . $controladorUsuario->cadastrarUsuario
            ($_POST["cadEmail"], $_POST["cadNome"], $_POST["cadSenha"]) . "';</script>";
    initMap();
} else {
    initMap();
}
