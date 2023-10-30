<?php

    require_once('../modelo/modelo_conexion.php');

    # SELECTS GENEROS
    function selectGenres() {
        $conn = openDB();

        $sql = 'SELECT * FROM GENRES ORDER BY (genre_name) ASC';

        $query = $conn->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $conn = closeDB();

        return $result;
    }

?>