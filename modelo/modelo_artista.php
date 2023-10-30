<?php
    require_once('../modelo/modelo_conexion.php');

    # LISTAR ARTISTAS

    function selectArtist() {
        $conn = openDB();

        $sql = 'SELECT * FROM ARTIST ORDER BY (artist_name) ASC';

        $query = $conn->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $conn = closeDB();

        return $result;
    }
?>