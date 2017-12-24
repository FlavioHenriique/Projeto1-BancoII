
<html>
    <head>
        <meta charset="UTF-8">
        <title>Projeto 1</title>
        <link rel="stylesheet" href="app.css">
    </head>
    <body>
        <table width="100%" height="80%" class="tabela"><tr bgcolor="#B0E0E6">
                <td width="50%"> <h1>Tela Inicial</h1></td>
                <td>
                    <div id="login"><form method="post" tex-align="right">
                            <table>
                                <tr>
                                    <td>Email</td>     
                                    <td>Senha</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email"></td>
                                    <td><input type="password" name="senha"></td>
                                    <td> <input type="submit" value="Entrar"></td>
                                </tr>
                                <tr><td><label id="autenticacao"></label></td></tr>
                            </table>           
                        </form></div>
                </td>
            </tr>
            <tr height="90%">
                <td>  <div id="map"></div></td>
                <td>
                    <form method="post"><center>
                            <h2>Cadastro de Usuário</h2>
                            Nome <input type="text" name="cadNome"><br><br>
                            Email <input type="text" name="cadEmail"><br><br>
                            Senha <input type="password" name="cadSenha"><br><br>
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
require_once 'funcoes.php';


if (isset($_POST["email"]) && isset($_POST["senha"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    autenticar($email, $senha);
}

if (isset($_POST["cadEmail"]) && isset($_POST["cadNome"]) &&
        isset($_POST["cadSenha"])) {

    $cadEmail = $_POST["cadEmail"];
    $cadNome = $_POST["cadNome"];
    $cadSenha = $_POST["cadSenha"];
    if (cadastrarUsuario($cadEmail, $cadNome, $cadSenha)) {
        echo "<script>cadastro.innerHTML='Usuário cadastrado com sucesso!';</script>"
        . " <style>#cadastro{color:green;}</style>";
    } else {
        echo "<script> cadastro.innerHTML='Este email já está sendo"
        . " utilizado!';</script> <style>#cadastro{color:red;}</style>";
    }
}
    initMap();
?>  
