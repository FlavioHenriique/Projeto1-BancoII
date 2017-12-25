<?php

function getConnection() {
    $con = pg_connect("host=localhost port=5432 user=postgres password='flavio22'"
            . "dbname=projetoI-BancoII") or die("erro na conexão com banco!");
    return $con;
}
