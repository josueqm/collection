<?php
    require_once('../modelo/modelo_album.php');
    require_once('../modelo/modelo_genero.php');
    require_once('../modelo/modelo_artista.php');

    $albums = selectAlbums();
    $genres = selectGenres();
    $artists = selectArtist();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!--- Icon FontAwesome -->
    <script src="https://kit.fontawesome.com/4cb17968f0.js" crossorigin="anonymous"></script>
    <!-- style css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>.:: Mi Colleccion | josueqm</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="text-info">.:: Colecction</h3>
                
                <!-- MODAL BUTTON NEW CARD -->
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalInsert">
                    <i class="fa-solid fa-plus"></i>New Card
                </button>

                <!-- START NEW CARD MODAL -->
                <div class="modal fade" id="modalInsert" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="miModalLabel">Add New Card</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <!-- NEW CARD FORM MODAL -->
                                <form action="../controlador/controlador_album.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <!-- <label for="album_id" class="form-label">Identificador</label> -->
                                        <!-- <input type="number" class="form-control" id="album_id" name="album_id"  required> -->
                                    </div>
                                    <div class="mb-3">
                                        <label for="album_name" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="album_name" name="album_name" placeholder="Nombre del Album" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="album_image" class="form-label">Portada</label>
                                        <input type="file" class="form-control" id="album_image" name="album_image">
                                    </div>
                                    <div class="mb-3">
                                        <label for="release_year" class="form-label">Año Lanzamiento</label>
                                        <input name="release_year" type="number" class="form-control" id="release_year" placeholder="YYYY" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="album_artist" class="form-label">Artista</label>
                                        <select class="form-select" name="album_artist" id="album_artist">
                                            <option value="">Seleccione un Artista</option>
                                            <?php
                                                foreach ($artists as $artist) {
                                                    echo "<option value='" . $artist["artist_id"]. "'>" . $artist["artist_name"]. "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="album_genero" class="form-label">Genero(s)</label>
                                        <select class="form-select" name="album_genero" id="album_genero">
                                            <option value="">Seleccione un Genero</option>
                                            <?php
                                                foreach ($genres as $genero) {
                                                    echo "<option value='" . $genero["genre_id"]. "'>" . $genero["genre_name"]. "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary" name="insert">Guardar cambios</button>
                                    </div>
                                </form>
                            </div>
                            <!-- MODAL FOOTER -->
                        </div>
                    </div>
                </div>
                <!-- END NEW CARD MODAL -->
            </div>
            
            <!-- MOSTRAR CARTAS -->
            <div class="card-body">
                <div class="row d-grid">
                    <!-- FOREACH PARA MOSTRAR CARTAS -->
                    <?php foreach ($albums as $album) { ?>
                        <div class="col">
                            <div class="album-card">
                                <img src="<?php echo $album['album_portada'] ?>" alt="Cover Album" class="album-image"> 
                                <div class="info-card">
                                    <h2 class="album-name text-center text-line-clamp"><?php echo $album['album_name']; ?></h2>
                                    <p class="album-artist text-center"><?php echo $album['artista_nombre'] ?></p>
                                    <span class="text-center"><?php echo $album['release_year']; ?></span>
                                    <small class="text-center"><?php echo $album['genero_nombre'] ?></small>
                                    <!-- CARD ACTION (UPDATE | DELETE) -->
                                    <div class="my-3 action-card">
                                        <!-- MODAL BUTTON UPDATE CARD | *** data-bs-target = #editModal -->
                                        <button class="btn btn-edit btn-success" id="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $album['album_id'] ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <!-- START UPDATE CARD MODAL | id -> data-bs-target = editModal --> 
                                        <div class="modal fade" id="editModal<?php echo $album['album_id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content modal-edit">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-dark" id="editModalLabel">Editar elemento</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Aquí irá el formulario para editar los datos del elemento -->
                                                        <form action="../controlador/controlador_album.php" method="POST" enctype="multipart/form-data">
                                                            <!-- Recupero el id del elemento -->
                                                            <input type="hidden" class="form-control" name="album-idU" id="album-idU" value="<?php echo $album['album_id'] ?>">
                                                            <div class="mb-3">
                                                                <label for="album_nameU" class="form-label">Nombre</label>
                                                                <input type="text" class="form-control" id="album_nameU" name="album_nameU" value="<?php echo $album['album_name'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="album_imageU" class="form-label">Portada</label>
                                                                <!-- OLd IMAGE COVER -->
                                                                <input type="hidden" name="album_imageOld" value="<?php echo $album['album_portada'] ?>">
                                                                <img class="img-update" src="<?php echo $album['album_portada'] ?>" width="80px">
                                                                <input type="file" class="form-control" id="album_imageU" name="album_imageU">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="release_yearU" class="form-label">Año Lanzamiento</label>
                                                                <input type="number" class="form-control" name="release_yearU" id="release_yearU" value="<?php echo $album['release_year'] ?>" placeholder="YYYY" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="album_artistU" class="form-label">Artista</label>
                                                                <select class="form-select" name="album_artistU" id="album_artistU">
                                                                    <?php 
                                                                        # artista recuperado
                                                                        $selected_artist = $album['artista_nombre'];

                                                                        foreach ($artists as $artist) {
                                                                            # comparo artista recuperado con el de artistas $artist para mostarlo como seleccionado
                                                                            $selectedA = ($artist['artist_name'] == $selected_artist) ? 'selected' : '';
                                                                            # muestro opciones
                                                                            echo "<option value='" . $artist['artist_id']."' ".$selectedA.">" . $artist['artist_name']."</option>";
                                                                        } 
                                                                    ?>   
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="album_generoU" class="form-label">Genero(s)</label>
                                                                <select class="form-select" name="album_generoU" id="album_generoU">
                                                                    <?php
                                                                        # genero recuperado
                                                                        $selected_genre = $album['genero_nombre'];

                                                                        foreach ($genres as $genero) {
                                                                            # Comparo genero recuperado con lista de generos y marcarlo como selected
                                                                            $selected = ($genero['genre_name'] == $selected_genre) ? 'selected' : '';
                                                                            # muestro opciones
                                                                            echo "<option value='" . $genero["genre_id"]. "' ".$selected.">" . $genero["genre_name"]. "</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary" name="update" id="saveChangesBtn">Guardar cambios</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END UPDATE CARD MODAL -->
                                        <!-- MODAL BUTTON DELETE CARD -->
                                        <button class="btn btn-delete btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete<?php echo $album['album_id'] ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <!-- START DELETE CARD MODAL -->
                                        <div class="modal fade" id="modalDelete<?php echo $album['album_id'] ?>" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-dark" id="modalDeleteLabel">Delete Card</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-dark">
                                                        <form action="../controlador/controlador_album.php" method="POST">
                                                            <div class="mb-3">
                                                                <label>¿Estás seguro(a) que quieres eliminar esta card?</label>
                                                                <input type="hidden" name="album_idD" value="<?php echo $album['album_id'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-danger" name="delete">Eliminar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php } ?>
                    <!-- END FOREACH -->
                </div>
            </div>
            <div class="card-footer">#</div>
        </div>
    </div>

    <!-- Script JS -->
    <script src="./../assets/js/index.js"></script>
</body>
</html>