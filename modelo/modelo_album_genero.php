<?php

    require_once('../modelo/modelo_conexion.php');

    function insertAlbumGenero($album_id, $genre_id) {
        $conn = openDB();

        $sql = 'INSERT INTO ALBUMS_GENRES (album_id, genre_id) VALUES (:album_id, :genre_id)';

        $query = $conn->prepare($sql);
        $query->bindParam(':album_id', $album_id);
        $query->bindParam(':genre_id', $genre_id);
        $query->execute();

        $conn = closeDB();
    }
?>