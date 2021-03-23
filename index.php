<?php
require_once("php/functions.php");
ver_errores();
/*imprime_bonito_post();*/


$es_xml = false;
$es_json = false;
$msj_error = "";
$archivo = "";
$archivo_convertido = "";
$fichero_convertido_con_exito = false;
$mostrar_boton_descarga = false;


if (isset($_POST['submit']) && ($_POST['submit'] == "Convertir")) {

    if (isset($_FILES['fileToConvert']) && ($_FILES['fileToConvert']["size"] > 0)) {

        $archivo = $_FILES['fileToConvert'];
        $nombre = obtener_informacion_archivo($archivo);

        $formato_valido = comprobar_formato_valido($nombre);
        if ($formato_valido == true) {
            $formato_base = get_extension($nombre);

            if ($formato_base == "xml") {
                $es_xml = true;
                $archivo_convertido = convert_to_xml($archivo);
                if ($archivo_convertido != "") {
                    $fichero_convertido_con_exito = true;
                    $mostrar_boton_descarga = true;
                }
            }

        }
    } else {
        $msj_error = "No se ha seleccionado ningún archivo para convertir";
    }

}
if (isset($_POST['submit']) && ($_POST['submit'] == "Descargar")) {
    download();
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!--icon-->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <title>Mi Conversor</title>
</head>
<header>
    <h1><img src="images/favicon.ico" style="width: 20px;height: 20px;">Conversor de Isa</h1>
</header>
<body>
<div class="container">

    <div class="container-fluid jumbotron">
        <div class="row">
            <div class="col-md-12" id="formulario_and_info_box">
                <h3>Conversor Personalizado de .xml a .json y viceversa</h3>
                <p>Seleccione el fichero y el tipo de conversión a realizar, por favor.</p>
                <p class="help-block">Sólo se aceptan archivos con formato .xml o .json</p>

                <fieldset id="formulario_box">
                    <legend>Archivo a convertir</legend>
                    <form role="form" class="form-inline" action="index.php" method="post"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" class="form-control-file" name="fileToConvert" id="fileToConvert"
                                   accept=".xml,.json"  <!--onchange="return cambiarFile();-->"/>
                        </div>
                        <div id="botonera">
                            <input type="submit" name="submit" value="Convertir" class="btn btn-dark">
                            <?php if ($mostrar_boton_descarga == true) {
                                echo '<input type="submit" name="submit"  value="Descargar" class="btn btn-info">';
                            } ?>
                        </div>
                        <br/>

                        <?php if ($archivo != "") { ?>
                            <div class="row" id="information_boxes">

                                <div class="col-md-6" id="actual_box">
                                    <h3>Previsualización del archivo
                                        <?php if (isset($nombre)) {
                                            echo "<span class='variable'>$nombre</span>";
                                        } ?></h3>
                                    <div><?php if (isset($archivo)) {
                                            echo "<div class='jumbotron' id='informacion_archivo'>";
                                            echo "<h4>Contenido del archivo</h4>";
                                            if ($es_xml == true) {
                                                imprimir_fichero_xml($archivo);
                                            } elseif ($es_json == true) {
                                                imprimir_fichero_json($archivo);
                                            }
                                            echo "</div>";
                                        }
                                        ?></div>
                                </div>
                                <div class="col-md-6" id="converted_box">

                                    <h3>Previsualización del archivo convertido</h3>
                                    <div><?php if (isset($archivo_convertido)) {
                                            echo "<div class='jumbotron' id='informacion_convertido'>";
                                            echo "<h4>Contenido del archivo a descargar</h4>";
                                            if ($es_xml == true) {
                                                //imprimir_fichero_json($archivo_convertido);
                                                echo $archivo_convertido;
                                            } else {
                                                imprime_bonito_array($archivo_convertido);
                                            }
                                            echo "</div>";
                                            print_hidden($archivo_convertido);

                                        }

                                        ?>
                                    </div>
                                </div>

                            </div> <!--information_boxes-->

                        <?php   } ?>

                    </form>
                    <?php if ($msj_error != "") {
                        echo '<div class="error_messages alert alert-danger" role="alert">' . $msj_error . '</div>';
                    } ?>

                </fieldset>

            </div> <!--body-->
        </div> <!--row-->
    </div> <!--jumbotron-->
</div> <!--container-->
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
</body>
<!-- Footer -->
<footer class="page-footer font-small">
    <div class="footer-copyright text-center py-3">© 2021 Copyright
        Isabel González Anzano
    </div>
</footer>
<!-- Footer -->
