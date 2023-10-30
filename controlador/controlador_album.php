<?php
    session_start();

    require_once('../modelo/modelo_album.php');
    require_once('../modelo/modelo_album_genero.php');

    // Recupero los datos de los inputs del modal en los parametros de la funcion insertAlbum()

    $image_path_default = '../media/default.png';

    # INSERT
    if (isset($_POST['insert'])) {
        // Compruebo si se ha insertado una imagen
        if (isset($_FILES['album_image']) && $_FILES['album_image']['error'] == 0) {
            $ruta = '../media/';
            $nameImage = $ruta . $_FILES['album_image']['name'];
            move_uploaded_file($_FILES['album_image']['tmp_name'], $nameImage);
            insertAlbum($_POST['album_name'], $nameImage, $_POST['release_year'], $_POST['album_artist'], $_POST['album_genero']);
        } else {
            // Insertamos una imagen por default
            insertAlbum($_POST['album_name'], $image_path_default, $_POST['release_year'], $_POST['album_artist'], $_POST['album_genero']);
        }

        header('location: ../vista/index.php');
        exit();
    }

    # Update
    # compruebo si se ha presionado el button con name 'update'
    if (isset($_POST['update'])) { 
        # recupero valores enviados desde el formulario
        $album_idU = $_POST['album-idU']; # name de imput
        $album_nameU = $_POST['album_nameU'];
        $album_coverU = $_FILES['album_imageU'];
        $album_release_yearU = $_POST['release_yearU'];
        $album_artistU = $_POST['album_artistU'];
        $album_genreU = $_POST['album_generoU'];

        $portadaOld = $_POST['album_imageOld'];
        
        # Comprobamos si se ha subido una imagen
        if (isset($album_coverU) && $album_coverU['error'] == 0) {
            // Movemos la nueva imagen a la carpeta de destino
            $ruta = '../media/';
            $nameImageU = $ruta . $album_coverU['name'];
            move_uploaded_file($album_coverU['tmp_name'], $nameImageU);
            // Actualizamos la imagen en la bd
            updateAlbum($album_idU, $album_nameU, $nameImageU, $album_release_yearU, $album_artistU, $album_genreU);
        } else {
            // Si no se ha subido ninguna imagen, usamos la antigua
            // Actualizamos la imagen en la bd con la imagen antigua
            updateAlbum($album_idU, $album_nameU, $portadaOld, $album_release_yearU, $album_artistU, $album_genreU);
        }

        header('location: ../vista/index.php');
        exit();
    }

    # DELETE
    if (isset($_POST['delete'])) {
        $album_idD = $_POST['album_idD'];

        deleteAlbum($album_idD);

        header('location: ../vista/index.php');
        exit();
    }
?>