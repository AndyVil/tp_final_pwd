<?php
#Requiero todas las dependencias de la libreria
use PHPImageWorkshop\ImageWorkshop;

$ruta = $GLOBALS['ROOT'];

require_once($ruta . '/controller/imageworkshop/ImageWorkshop.php');
require_once($ruta . '/controller/imageworkshop/Core/ImageWorkshopLayer.php');
require_once($ruta . '/controller/imageworkshop/Core/ImageWorkshopLib.php');
require_once($ruta . '/controller/imageworkshop/Exception/ImageWorkshopBaseException.php');
require_once($ruta . '/controller/imageworkshop/Exception/ImageWorkshopException.php');

/**
 * Clase formularios, para comprobacion de formularios, subida de archivos etc.
 */
class Formulario
{

    /**
     * Formulario de carga de productos
     */
    public function cargarArchivos($nombre, $datos)
    {
        $retorno = [];
        $retorno['imagen']['link'] = "";
        $retorno['imagen']['error'] = "";

        /**
         * Reescalamos la imagen, creamos un txt con la descripcion como contenido
         */
        $dir = $GLOBALS['ROOT'] . 'uploads/';
        $todoOK = true;
        if ($todoOK && !copy($_FILES['productoImagen']['tmp_name'], $dir . $nombre)) {
            $error = "ERROR: No se pudo copiar la imagen.";
            $todoOK = false;
        }
        if ($todoOK) {
            $this->rezise($nombre);
        }


        if ($todoOK) {
            $retorno['imagen']['link'] = $dir . $nombre;
        } else {
            $retorno['imagen']['error'] = $error;
        }
        $pos = mb_strripos($nombre, ".");


        $txtName = substr($nombre, 0, $pos) . ".txt";
        $txtName = $dir . $txtName;
        $texto = $this->verInformacion($datos, $nombre);
        /* fopen crea un nuevo archivo con nombre $name y con "w" reemplaza la información si ya existia */
        $ar = fopen($txtName, "w") or die("error al crear");
        fwrite($ar, $texto);
        fclose($ar);

        return $retorno;
    }


    /**
     * @param string $nombre (Nombre del archivo)
     */
    public function rezise($name)
    {
        // Variable que almacena el directorio del proyecto
        $layerBase = new PHPImageWorkshop\ImageWorkshop;
        #Image Path
        $pathInicial = $GLOBALS['ROOT'] . 'uploads/' . $name; //tmp
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

    public function obtenerArchivos()
    {
        $directorio = $GLOBALS['ROOT'] . "/uploads";

        if (is_dir($directorio)) {
            //Escaneamos el directorio
            $carpeta = scandir($directorio);
            //Miramos si existen archivos
            if (count($carpeta) > 2) {
                $archivos = scandir($directorio, 1);
                //var_dump($archivos);
                //Miramos si existe el archivo pasado como parámetro
                // if (file_exists('folder/index.php'))
                // echo 'El archivo existe';
                // else
                //     echo 'El archivo no existe';
            } else {
                echo 'No hay productos cargados';
                $archivos =  false;
            }
        } else {
            echo 'El directorio no existe.';
            $archivos =  false;
        }

        return $archivos;
    }

    public function verInformacion($datos, $nombre)
    {
        $pos = mb_strripos($nombre, ".");

        $id = substr($nombre, 0, $pos);
        $protipo = $datos['tipoProducto'];
        $descripcion = $datos["descripcion"];
        $procantstock = $datos["procantstock"];
        $protalle = implode(", ", $datos['talle']);
        $proprecio = $datos['proprecio'];
        $nombre = $protipo . $id;

        $texto = "<h3>Información de el producto</h3>
                          <b>Nombre:</b> $id" . "$protipo <br/>
                          <b>Descripcion:</b> $descripcion <br/>
                          <b>Cantstock:</b> $procantstock <br/>
                          <b>Talles disponibles:</b> $protalle <br />
                          <b>Precio:</b> $proprecio <br />";
        return $texto;
    }

    public function obtenerArchivosPorId($id)
    {
        $directorio = "../../uploads/";
        $return = array();
        $archivos = scandir($directorio, 1);
        var_dump($archivos);
        //Miramos si existe el archivo pasado como parámetro
        $i = 0;
        $loencontre = false;
        // while (!$loencontre) {
        //     $dot = mb_strripos($archivos[0], ".");
        //     $nombre = substr($archivos[0], 0, $dot);
        //     if ($nombre == $id) {
        //         array_push($return, $archivos);
        //     }
        //     if (count($return) > 1) {
        //         $noloencontre = true;
        //     }
        //     $i++;
        // }

        foreach ($archivos as $archivo) {
            $dot = mb_strripos($archivo, ".");
            $nombre = substr($archivo, 0, $dot);  
            if($nombre==$id){                        
                array_push($return,$archivo);
            }                    
        }


        return $return;
    }


    #Llama al archivo txt desde su ruta y la carga 
    public function obtenerInfoDeArchivo($datos)
    {
        $directorio = "../../uploads/";
        foreach ($datos as $clave => $valor) {
            $nombreArchivo = str_replace("Seleccion:", '', $clave);
        }

        /* pos y ultPos lo usamos para reemplazar el tipo de arhivo sea cual sea su longitud (.png o .jpeg) */
        $pos = mb_strripos($nombreArchivo, "_");
        //echo $pos;
        $ultPos = substr($nombreArchivo, $pos);
        //print_r(($ultPos));
        $ultPos = str_replace("_", '.', $ultPos);
        // echo " ";
        // print_r(($ultPos));
        $nombreArchivo = substr($nombreArchivo, 0, $pos) . $ultPos;
        $nombreImagen = $directorio . $nombreArchivo;
        $nombreArchivodescripcion = substr($nombreArchivo, 0, $pos) . ".txt";

        $descripcion = "";
        if (file_exists($directorio . $nombreArchivodescripcion)) {
            $fArchivoOBS = fopen($directorio . $nombreArchivodescripcion, "r");
            $descripcion = fread($fArchivoOBS, filesize($directorio . $nombreArchivodescripcion));
            fclose($fArchivoOBS);
        }
        //var_dump($nombreImagen); 
        $datosArch = [
            "link" => $nombreImagen,
            "NombreArchivo" => $nombreArchivo,
            "Descripcion" => $descripcion

        ];
        //finfo_close($finfo);

        return $datosArch;
    }
}
