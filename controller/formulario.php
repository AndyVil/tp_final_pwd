<?php
#Requiero todas las dependencias de la libreria
use PHPImageWorkshop\ImageWorkshop;

$ruta = $GLOBALS['ROOT'];

require_once($ruta.'/controller/imageworkshop/ImageWorkshop.php');
require_once($ruta.'/controller/imageworkshop/Core/ImageWorkshopLayer.php');
require_once($ruta.'/controller/imageworkshop/Core/ImageWorkshopLib.php');
require_once($ruta.'/controller/imageworkshop/Exception/ImageWorkshopBaseException.php');
require_once($ruta.'/controller/imageworkshop/Exception/ImageWorkshopException.php');

/**
 * Clase formularios, para comprobacion de formularios, subida de archivos etc.
 */
class Formulario {

    /**
     * Formulario de carga de productos
     */
    public function cargarArchivos($nombre,$datos){   

        /**
         * Reescalamos la imagen, creamos un txt con la descripcion como contenido
         */

        $this->rezise($nombre);
        $dir = $GLOBALS['ROOT'] . 'uploads/';
        $pos = mb_strripos($nombre, ".");
        $texto = $this->verInformacion($datos,$nombre);
        //$ext = pathinfo($_FILES['productoImagen']['name'], PATHINFO_EXTENSION);
        //$numExt = "-".strlen($ext);
        $txtName = substr($nombre, 0,$pos).".txt";
        $txtName = $dir . $txtName;
        var_dump($txtName);
        /* fopen crea un nuevo archivo con nombre $name y con "w" reemplaza la información si ya existia */
        $ar = fopen($txtName, "w") or die("error al crear");
        fwrite($ar, $texto);
        fclose($ar);
        
    }


    /**
     * @param string $nombre (Nombre del archivo)
     */
    public function rezise ($name){
        // Variable que almacena el directorio del proyecto
        $layerBase = new PHPImageWorkshop\ImageWorkshop;
        #Image Path
        $pathInicial = $GLOBALS['ROOT'] . 'uploads/' . $name;//tmp
        #Traemos la imagen a la capa inicializada
        $layerBase = ImageWorkshop::initFromPath($pathInicial);

        $layerBase->resizeInPixel(600, null, true);
        $resultadoDir = $GLOBALS['ROOT'] . 'uploads/';
        //$nameresultado= 'editado' . $name ;
        //$filename = "img-".$name;
        $crearCarpeta = false; #Si la carpeta no existe, se creara automaticamente
        $backgroundColor = null; #transparente, solo para PNG (De lo contrario sera blanco si se establece nulo)
        $imageQuality = 70; #No sirve para GIF, pero es util para PNG y JPEG (0 to 100);

        $layerBase->save($resultadoDir, $name, $crearCarpeta, $backgroundColor, $imageQuality);
    }


    public function verInformacion($datos, $nombre)
    {
        $nombre;
        $protipo = $datos['tipoProducto'];
        $descripcion = $datos["descripcion"];
        $procantstock = $datos["procantstock"];    
        $protalle = implode(", ", $datos['talle']);  
        $proprecio = $datos['proprecio'];

        $texto = "<h3>Información de el producto</h3>
                          <p><b>Nombre:</b> $nombre <br />
                          <b>Tipo:</b> $protipo <br />;
                          <b>Descripcion:</b> $descripcion <br />
                          <b>Cantstock:</b> $procantstock <br />;
                          <b>Talles disponibles:</b> $protalle <br />;
                          <b>Precio:</b> $proprecio <br />";

        return $texto;
    }

}

?>