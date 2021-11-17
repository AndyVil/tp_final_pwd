<?php
#Requiero todas las dependencias de la libreria
use PHPImageWorkshop\ImageWorkshop;

require_once('../src/ImageWorkshop.php');
require_once('../src/Core/ImageWorkshopLayer.php');
require_once('../src/Core/ImageWorkshopLib.php');
require_once('../src/Exception/ImageWorkshopBaseException.php');
require_once('../src/Exception/ImageWorkshopException.php');

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
        $name = substr($nombre, 0, $pos) . ".txt";
        $name = $dir . $nombre;
        /* fopen crea un nuevo archivo con nombre $name y con "w" reemplaza la información si ya existia */

        $ar = fopen($name, "w") or die("error al crear");
        fwrite($ar, $texto);
        fclose($ar);
        
    }


    /**
     * @param string $nombre (Nombre del archivo)
     */
    public function rezise ($name){
        $PROYECTO = 'cine_imageworkshop';

        // Variable que almacena el directorio del proyecto
        $layerBase = new PHPImageWorkshop\ImageWorkshop;
        #Image Path
        $pathInicial = $GLOBALS['ROOT'] . 'uploads/' . $name;
        #Traemos la imagen a la capa inicializada
        $layerBase = ImageWorkshop::initFromPath($pathInicial);

        $layerBase->resizeInPixel(400, 600, true);
        $resultadoDir = $GLOBALS['ROOT'] . 'uploads/';
        //$nameresultado= 'editado' . $name ;
        //$filename = "resultado" . "1" . ".png";
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
        $procantstock = $datos["stock"];    
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