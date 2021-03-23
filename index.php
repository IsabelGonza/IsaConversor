<?php
require_once ("php/functions.php");
ver_errores();
/*imprime_bonito_post();*/

$es_xml = false;
$es_json = false;
$fichero_convertido_con_exito = false;

if(isset($_POST['submit']) && ($_POST['submit'] == "Convertir")){

    $archivo = $_FILES['fileToConvert'];
    $nombre = obtener_informacion_archivo($archivo);

    $formato_valido = comprobar_formato_valido($nombre);
    if ($formato_valido == true){
        $formato_base = get_extension($nombre);

        if($formato_valido == "xml"){
            $es_xml = true;
           $archivo_convertido = convert_to_xml($archivo);

        }
        /*if($formato_valido == "json"){
            $es_json = true;
            $archivo_convertido = convert_to_json($archivo);
        }*/
        /*descargar_archivo_convertido($archivo_convertido);*/
    }
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
    <!--js y librerías-->
    <!--<script src="js/MyConversor.js"></script>
    <script src="libs/json2xml.js"></script>
    <script src="libs/xml2json.js"></script>-->
    <!--icon-->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <title>Mi Conversor</title>
</head>
<header>
    <h1>Conversor de Isa</h1>
</header>
<body>
<div class="container">


    <div class="container-fluid jumbotron">
        <div class="row">
            <div class="col-md-12">
                <h3>
                    Conversor Personalizado
                </h3>
                <p>Seleccione el fichero y el tipo de conversión a realizar, por favor.</p>

                <form role="form" class="form-inline" action="." method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputFile">
                           Seleccione el archivo
                        </label>
                        <input type="file" class="form-control-file" name="fileToConvert" id="fileToConvert" accept=".xml,.json" required <!--onchange="return cambiarFile();-->"/>
                        <p class="help-block">
                            Sólo se aceptan archivos con formato .xml o .json
                        </p>
                    </div>
                    <input type="submit" name="submit" value="Convertir" class="btn btn-dark">
                    <?php if($fichero_convertido_con_exito == true){
                        echo '<input type="submit" name="submit" value="Descargar" class="btn btn-info">';
                    }  ?>
                </form>

                <div class="row">
                    <div class="col-md-6">
                        <h3>Previsualización del archivo
                            <?php if(isset($nombre)){echo "<span class='variable'>$nombre</span>";}?></h3>
                        <div><?php if(isset($archivo)){
                            echo "<div class='jumbotron' id='informacion_archivo'>";
                            echo "<h4>Contenido del archivo</h4>";
                                if($es_xml == true){
                                    imprimir_fichero_xml($archivo);
                                }elseif($es_json==true){
                                    imprimir_fichero_json($archivo);
                                }
                            echo "</div>";
                            }
                            ?></div>
                    </div>
                    <div class="col-md-6">
                        <h3>Previsualización del archivo convertido</h3>
                        <div><?php if(isset($archivo_convertido)){
                                echo "<div class='jumbotron' id='informacion_convertido'>";
                                echo "<h4>Contenido del archivo a descargar</h4>";
                                if($es_xml == true){
                                    imprimir_fichero_json($archivo_convertido);
                                    $fichero_convertido_con_exito = true;
                                }else{
                                    imprime_bonito_array($archivo_convertido);
                                }
                                /*elseif($es_xml == true){
                                    imprimir_fichero_xml($archivo_convertido);
                                }*/
                                echo "</div>";
                                }

                            ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
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
