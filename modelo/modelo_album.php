<?php
    require_once('../modelo/modelo_conexion.php');
    require_once('../modelo/modelo_album_genero.php');

    # SELECT ALBUMS
    function selectAlbums() {
        $conn = openDB();

        $sql = 'CALL SP_LISTAR_ALBUM()';

        $query = $conn->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $conn = closeDB();

        return $result;
    }

    # INSERT ALBUMS
    function insertAlbum($album_name, $album_image_path, $release_year, $artist_id, $genre_id) {
        try {
            $conn = openDB();

            // Si no se ha elegido una imagen
            $image_path_default = '../media/default.png';
            
            if (file_exists($album_image_path)) {
                $nameImage = '../media/' . basename($album_image_path);
            } else {
                $nameImage = $image_path_default;
            }

            // Inserto nuevo album
            $sql = 'INSERT INTO ALBUMS (album_name, album_image_path, release_year, artist_id) VALUES (:album_name, :nameImage, :release_year, :artist_id)'; # album_image_path

            $query = $conn->prepare($sql);
            $query->bindParam(':album_name', $album_name);
            $query->bindParam(':nameImage', $nameImage);
            $query->bindParam(':release_year', $release_year);
            $query->bindParam(':artist_id', $artist_id);
            $query->execute();

            // Recupero el Id del album por auto_increment (BD)
            $album_id = $conn->lastInsertId();

            // Inserto el genero al album en la tabla album_genero
            insertAlbumGenero($album_id, $genre_id);

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = closeDB();
    }

    /**
     * Primero actualizo el album
     * Inserto Genero
     * Recupero cada id de las tablas anteriores
     * Inserto id's a la tabla album_generoS
     */

    # UPDATE ALBUMS
    function updateAlbum($album_idU, $album_nameU, $album_image_pathU, $release_yearU, $artist_idU, $genre_idU) {
        try {
            $conn = openDB();

            // Primero actualizo el album
            $sql = 'CALL SP_UPDATE_ALBUM(?, ?, ?, ?, ?)';

            $query = $conn->prepare($sql);
            $query->bindParam(1, $album_idU, PDO::PARAM_INT);
            $query->bindParam(2, $album_nameU);
            $query->bindParam(3, $album_image_pathU);
            $query->bindParam(4, $release_yearU);
            $query->bindParam(5, $artist_idU);
            $query->execute();

            // Actualizo 
            // Recupero los id de album y genero

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        $conn = closeDB();
    }

    # DELETE
    function deleteAlbum($album_idD) {
        $conn = openDB();

        $sql = 'CALL SP_DELETE_ALBUM(?)';

        $query = $conn->prepare($sql);
        $query->bindParam(1, $album_idD);
        $query->execute();

        try {
            //code...
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        $conn = closeDB();
    }

    function selectAlbums2() {
        $conn = openDB();

        $sql = 'SELECT * FROM ALBUMS';

        $query = $conn->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $conn = closeDB();

        return $result;
    }
?>