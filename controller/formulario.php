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

        return $retorno;
    }

    public function borrarArchivos($nombre, $datos)
    {
        $retorno = false;
        /**
         * Reescalamos la imagen, creamos un txt con la descripcion como contenido
         */
        $dir = $GLOBALS['ROOT'] . 'uploads/';
        $todoOK = true;
        if ($todoOK && !unlink($_FILES['productoImagen']['tmp_name'], $dir . $nombre)) {
            $error = "ERROR: No se pudo copiar la imagen.";
            $todoOK = false;
            $retorno = true;
        }

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
            } else {
                $archivos =  false;
            }
        } else {
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
        //var_dump($archivos);
        //Miramos si existe el archivo pasado como parámetro
        $i = 0;
        $loencontre = false;
        $descripcion = "";
        $imagen = "";
        foreach ($archivos as $archivo) {
            $dot = mb_strripos($archivo, ".");
            $nombre = substr($archivo, 0, $dot);
            $ext = substr($archivo, $dot + 1);

            if ($nombre == $id) {

                if ($ext == "txt") {
                    $fArchivoOBS = fopen($directorio . $archivo, "r");
                    $descripcion = fread($fArchivoOBS, filesize($directorio . $archivo));
                } else {
                    $imagen = $directorio . $archivo;
                }
            }
        }
        $return = [
            "link" => $imagen,
            "Descripcion" => $descripcion

        ];

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
        $ultPos = substr($nombreArchivo, $pos);
        $ultPos = str_replace("_", '.', $ultPos);
        $nombreArchivo = substr($nombreArchivo, 0, $pos) . $ultPos;
        $nombreImagen = $directorio . $nombreArchivo;
        $nombreArchivodescripcion = substr($nombreArchivo, 0, $pos) . ".txt";

        $descripcion = "";
        if (file_exists($directorio . $nombreArchivodescripcion)) {
            $fArchivoOBS = fopen($directorio . $nombreArchivodescripcion, "r");
            $descripcion = fread($fArchivoOBS, filesize($directorio . $nombreArchivodescripcion));
            fclose($fArchivoOBS);
        }
        $datosArch = [
            "link" => $nombreImagen,
            "NombreArchivo" => $nombreArchivo,
            "Descripcion" => $descripcion

        ];
        return $datosArch;
    }


    public function registro($datos)
    {

        $ambrol = new AbmUsuarioRol();
        $object = new AbmUsuario();
        $datos["usnombre"] = md5($datos["usnombre"]);
        $datos["uspass"] = md5($datos["uspass"]);
        $datos["idrol"] = 3;

        //Impresion de respuestas	    
        list($alta, $id) = $object->alta($datos);
        #Asignar rol cliente al usuario nuevo	
        if ($alta) {
            $respuesta = "Se creo el usuario exitosamente.";
            #asignamos el rol de cliente siempre que se cree una cuenta
            $datos["idusuario"] = $id;
            if ($ambrol->alta($datos)) {
                $respuesta = "Se creo el usuario exitosamente.";
            }
        } else {
            $respuesta = "Error al cargar los datos.";
        }
        return $respuesta;
    }


    public function verificarLogin($datos)
    {
        $sesion = new Session();
        $name = md5($datos['usnombre']);
        $pass = md5($datos['uspass']);
        $sesion->iniciar($name, $pass);

        list($valido, $error) = $sesion->validar();
        if ($datos["idproducto"] != "") {
            $idProducto = $datos["idproducto"];
        }

        if ($valido) {
            $return = "Location:paginaSegura.php?mensaje=" . $idProducto;
        } else {
            $sesion->cerrar();
            $return = "Location:index.php?error=" . $idProducto;
        }
        return $return;
    }

    public function detallesProducto($datos)
    {
        $resultado = [];
        $Abmproducto = new AbmProducto();
        if (array_key_exists('mensaje', $datos)) {
            $infoArchivo = $this->obtenerArchivosPorId($datos["mensaje"]);
            //var_dump($datos);
            $respuesta = $infoArchivo["Descripcion"];
            $link = $infoArchivo["link"];
            $id = $datos["mensaje"];
            $where = ['idproducto' => $id];
            $productos = $Abmproducto->buscar($where);
            $precio = $productos[0]->getproprecio();
            $nombre = $productos[0]->getpronombre();
            $stock = $productos[0]->getprocantstock();
            $detalle = $productos[0]->getprodetalle();
            $deshabilitado = $productos[0]->getprodeshabilitado();
        } elseif (array_key_exists('idcompra', $datos)) {
            if (!array_key_exists('stock', $datos)) {
                foreach ($datos as $clave => $valor) {
                    $datos["idproducto"] = str_replace("idproducto:", '', $clave);
                }
            }
            //var_dum($datos);
            $infoArchivo = $this->obtenerArchivosPorId($datos["idproducto"]);
            $respuesta = $infoArchivo["Descripcion"];
            $link = $infoArchivo["link"];
            $id = $datos["idproducto"];
            $where = ['idproducto' => $id];
            $productos = $Abmproducto->buscar($where);
            $precio = $productos[0]->getproprecio();
            $nombre = $productos[0]->getpronombre();
            $stock = $productos[0]->getprocantstock();
            $detalle = $productos[0]->getprodetalle();
            $deshabilitado = $productos[0]->getprodeshabilitado();
        } else {
            $infoArchivo = $this->obtenerInfoDeArchivo($datos);
            $respuesta = $infoArchivo["Descripcion"];
            $link = $infoArchivo["link"];
            $dot = mb_strripos($link, ".");
            $id = substr($link, 0, $dot);
            $slash = mb_strripos($link, "/");
            $id = substr($id, $slash + 1);
            $where = ['idproducto' => $id];
            $productos = $Abmproducto->buscar($where);
            $precio = $productos[0]->getproprecio();
            $nombre = $productos[0]->getpronombre();
            $stock = $productos[0]->getprocantstock();
            $detalle = $productos[0]->getprodetalle();
            $deshabilitado = $productos[0]->getprodeshabilitado();
        }
        $resultado = [
            'link' => $link,
            'id' => $id,
            'precio' => $precio,
            'nombre' => $nombre,
            'stock' => $stock,
            'detalle' => $detalle,
            'deshabilitado' => $deshabilitado
        ];
        return $resultado;
    }

    public function permisoCompra()
    {
        $sesion = new Session();
        $actionCarrito = "redireccion.php";
        $actionComprar = "redireccion.php";
        if (array_key_exists('usnombre', $_SESSION) and array_key_exists('uspass', $_SESSION)) {
            list($sesionValidar, $error) = $sesion->validar();
            if ($sesionValidar) {
                $roles = $sesion->obtenerRol();
                $escliente = $sesion->arrayRolesUser($roles);
                $comprar = false;
                if ($escliente['Cliente'] == true) {
                    $actionCarrito = "../carrito/añadirCarrito.php";
                    $actionComprar = "../carrito/comprarCarrito.php";
                    $comprar = true;
                }
            } else {
                $comprar = false;
            }
        }
        $resultado = ['comprar' => $comprar, 'actionCarrito' => $actionCarrito, 'actionComprar' => $actionComprar];
        return $resultado;
    }


    public function actionProducto($datos)
    {
        $ruta = $GLOBALS['ROOT'];
        $productos = new AbmProducto;
        $idproducto = $datos['idproducto'];
        if ($datos["accion"] == "borrar") {
            $filtro['idproducto'] = $datos['idproducto'];
            $colproducto = $productos->buscar($filtro);
            $objproducto = $colproducto[0];
            $datos['pronombre'] = $objproducto->getpronombre();
            $datos['prodetalle'] = $objproducto->getprodetalle();
            $datos['procantstock'] = $objproducto->getprocantstock();
            $datos['proprecio'] = $objproducto->getproprecio();
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            #Si la fecha y hora seteada la convierte en 0000-00-00 00:00:00, si no es seteada coloca un timestamp
            if ($objproducto->getprodeshabilitado() != '0000-00-00 00:00:00' && $objproducto->getprodeshabilitado() != NULL) {
                $datos['prodeshabilitado'] = '0000-00-00 00:00:00';
            } else {
                $datos['prodeshabilitado'] = date('Y-m-d h:i:s'); #Timestamp
            }
            $productos->modificacion($datos);
            $respuesta = "Location: index.php?mensaje=Se habilito/deshabilito exitosamente el producto: " . $idproducto;
        } else {

            $tipoProducto = $datos['tipoProducto'];
            $stock = $datos['procantstock'];
            $descripcion = $datos['descripcion'];
            $talle = $datos['talle'];
            $arraytostring = implode(', ', $talle);
            $datos['prodetalle'] = $descripcion . " " . $arraytostring;
            $datos['pronombre'] = $tipoProducto;
            $precio = $datos['proprecio'];

            if ($datos["accion"] == "cargar") {
                list($valido, $id) = $productos->alta($datos);
                if ($valido) {
                    /**
                     * Cargo los prodcutos de la base de datos en una variable para hacer un conteo de los mismos
                     * Esto me permite asignarle un nuevo nombre al archivo para identificarlo
                     */
                    $dirUpload = $ruta . "uploads";
                    $ext = pathinfo($_FILES['productoImagen']['name'], PATHINFO_EXTENSION);
                    $nombre = $id . "." . $ext;

                    $formularioCargarProducto = new Formulario();
                    $array = $formularioCargarProducto->cargarArchivos($nombre, $datos);
                    $respuesta = "Location: index.php?mensaje=Se cargo exitosamente el producto. " . $idproducto;
                }
            }
            if ($datos["accion"] == "editar") {
                if ($productos->modificacion($datos)) {
                    $respuesta = "Location: index.php?mensaje=Se edito exitosamente el producto. " . $idproducto;
                }
            }
        }
        return $respuesta;
    }

    public function misCompras($datos)
    {

        $sesion = new Session();
        $arreglo = array();
        $abmCompra = new AbmCompra();
        $ambCompraEstado = new AbmCompraEstado();
        $ambitems = new AbmCompraItem();
        $div = '';
        if (!$sesion->activa()) {
            header('Location: ../login/index.php');
        } else {
            list($sesionValidar, $error) = $sesion->validar();
            if ($sesionValidar) {
                $roles = $sesion->obtenerRol();
                $escliente = $sesion->arrayRolesUser($roles);
                if ($escliente['Cliente'] == true) {
                    $f = array();
                    $f['idusuario'] = $sesion->getIdUser();
                    $compras = $abmCompra->buscar($f);
                    $aceptadas = array();
                    if (count($compras) > 0) {
                        foreach ($compras as $compra) {
                            $where['idcompra'] = $compra->getidcompra();
                            $where['idcompraestadotipo'] = 2;
                            $estado = $ambCompraEstado->buscar($where);
                            if (count($estado) > 0) {
                                array_push($aceptadas, $estado[0]);
                            } else {
                            }
                        }
                    }
                    if (count($aceptadas) == 0) {
                        $div = "
                        <div class='alert alert-warning' role='alert' align=center>
                        No tienes compras aún.
                        </div>";
                        $arreglo = false;
                    } else {
                        $i = 0;
                        foreach ($aceptadas as $compraestado) {
                            $idcompra = $compraestado->getidcompra();
                            $filtro = array();
                            $filtro['idcompra'] = $idcompra;
                            $items = $ambitems->buscar($filtro);
                            foreach ($items as $item) {
                                $idproducto = $item->getidproducto()->getidproducto();
                                $archivos = $this->obtenerArchivosPorId($idproducto);
                                $arreglo[$i]["link"] = $archivos["link"];
                                $arreglo[$i]["idproducto"] = $idproducto;
                                $arreglo[$i]["nombre"] = $item->getidproducto()->getpronombre();
                                $arreglo[$i]["proprecio"] = $item->getidproducto()->getproprecio();
                                $arreglo[$i]["ciprecio"] = $item->getciprecio();
                                $arreglo[$i]["idcompraitem"] = $item->getidcompraitem();
                                $arreglo[$i]["cicantidad"] = $item->getcicantidad();
                                $arreglo[$i]["iditem"] = $item->getidcompraitem();
                                $arreglo[$i]["fecha"] = $compraestado->getcefechafin();
                                $arreglo[$i]["idcompra"] = $idcompra;
                                $i++;
                            }
                        }
                    }
                } else {
                    $arreglo = false;
                    header('Location: ../inicio_cliente/index.php');
                }
            } else {
                header('Location: ../inicio_cliente/index.php');
            }
        }
        $return = [$arreglo, $div];
        return $return;
    }


    public function detalleCompra($datos)
    {
        $resultado = [];
        $abmCompra = new AbmCompra();
        $abmitem = new AbmCompraItem();
        $ambCompraEstado = new AbmCompraEstado();
        $arreglo = array();

        foreach ($datos as $clave => $valor) {
            $idcompraitem = str_replace("idcompraitem:", '', $clave);
        }
        $idcompra = $datos["idcompra"];
        $where = ["idcompra" => $idcompra];

        $arreglo = $abmitem->buscar($where);
        $colcompras = $abmCompra->buscar($where);
        $compra = $colcompras[0];
        $fecha = $compra->getcofecha();
        $coprecio = $compra->getcompraprecio();

        $resultado = [
            'idcompraitem' => $idcompraitem,
            'idcompra' => $idcompra,
            'arreglo' => $arreglo,
            'colcompras' => $colcompras,
            'compra' => $compra,
            'fecha' => $fecha,
            'coprecio' => $coprecio
        ];
        return $resultado;
    }



    public function controlUsuario($datos)
    {
        if ($datos['accion'] == 'noAccion') {
            header('Location: listarUsuarios.php');
        }

        $resp = false;
        $abmUser = new AbmUsuario();
        $ambuserRol = new AbmUsuarioRol();
        $userDelete = new AbmUsuario();
        $filtro = array();
        $filtro['idusuario'] = $datos['idusuario'];
        $user = $userDelete->buscar($filtro);
        $objUsuario = $user[0];

        /* Accion que permite: cargar una nueva usuario, borrar y editar */
        if (isset($datos['accion'])) {
            $mensaje = "";
            if ($datos['accion'] == 'editar') {

                $nuevosRoles = $datos['colrol'];
                $filtrorol = array(); #Rol actual de la coleccion de arreglos y el id de usuario
                $filtrorol['idusuario'] = $datos['idusuario'];
                $roles = $ambuserRol->buscar($filtro);
                if (count($nuevosRoles) > count($roles)) {
                    foreach ($nuevosRoles as $idrol) {

                        $filtrorol['idrol'] = $idrol;
                        $existerol = $ambuserRol->buscar($filtrorol);
                        #compruebo que el usuario no tenga el rol con el id actual de la iteracion para agregarlo
                        if ($existerol == null)
                            $ambuserRol->alta($filtrorol);
                    }
                }
                #Si el count del array es menor a la cantidad de roles que corresponda entonces SI quita un rol
                elseif (count($nuevosRoles) < count($roles)) {
                    foreach ($nuevosRoles as $idrol) {
                        $filtrorol['idrol'] = $idrol;
                        $existerol = $ambuserRol->buscar($filtrorol);
                        #compruebo que el usuario si tenga el rol con el id actual de la iteracion para eliminarlo
                        if ($existerol != null)
                            $ambuserRol->baja($filtrorol);
                    }
                }
                if ($abmUser->modificacion($datos)) {
                    $resp = true;
                } else {
                    $mensaje = "<b>ERROR: </b>";
                }
            }
            if ($datos['accion'] == 'deshabilitar') {
                $datos['usnombre'] = $objUsuario->getusnombre();
                $datos['uspass'] = $objUsuario->getuspass();
                $datos['usmail'] = $objUsuario->getusmail();
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                #Si la fecha y hora seteada la convierte en 0000-00-00 00:00:00, si no es seteada coloca un timestamp
                if ($objUsuario->getusdeshabilitado() != '0000-00-00 00:00:00' && $objUsuario->getusdeshabilitado() != NULL) {
                    $datos['usdeshabilitado'] = '0000-00-00 00:00:00';
                } else {
                    $datos['usdeshabilitado'] = date('Y-m-d h:i:s'); #Timestamp
                }
                if ($userDelete->modificacion($datos)) {
                    $resp = true;
                } else {
                    $mensaje = "<b>ERROR: </b>";
                }
            }
            if ($datos['accion'] == 'nuevo') {
                if ($objUsuario->alta($datos)) {
                    $resp = true;
                } else {
                    $mensaje = "<b>ERROR:</b> No pudo completarse la accion.<br>";
                }
            }
            if ($datos['accion'] == 'nuevo') {
                if ($objUsuario->alta($datos)) {
                    $resp = true;
                } else {
                    $mensaje = "<b>ERROR:</b> No pudo completarse la accion.<br>";
                }
            }


            if ($resp) {
                $mensaje = "La acción <b>" . $datos['accion'] . " usuario</b>Se realizo correctamente.";
                header('Location: listarUsuarios.php?mensaje=' . urldecode('edicion_exitosa'));
            } else {
                $mensaje .= "La acción <b>" . $datos['accion'] . " usuario</b>No pudo concretarse.";
                header('Location: listarUsuarios.php?mensaje=' . urldecode('edicion_fallida'));
            }
        }
        $encuentraError = strpos(strtoupper($mensaje), 'ERROR');
    }


    public function controlMenuRol($datos)
    {
        if ($datos['accion'] == 'noAccion') {
            header('Location: listarRols.php');
        }

        $resp = false;
        $abmUser = new AbmRol();
        $abmmenurol = new AbmMenuRol();
        $userDelete = new AbmRol();
        $filtro = array();
        $filtro['idRol'] = $datos['idRol'];
        $user = $userDelete->buscar($filtro);
        $objRol = $user[0];

        /* Accion que permite: cargar una nueva Rol, borrar y editar */
        if (isset($datos['accion'])) {
            $mensaje = "";
            if ($datos['accion'] == 'editar') {

                $nuevosRoles = $datos['colrol'];
                $filtrorol = array(); #Rol actual de la coleccion de arreglos y el id de Rol
                $filtrorol['idRol'] = $datos['idRol'];
                $roles = $abmmenurol->buscar($filtro);
                if (count($nuevosRoles) > count($roles)) {
                    foreach ($nuevosRoles as $idrol) {

                        $filtrorol['idrol'] = $idrol;
                        $existerol = $abmmenurol->buscar($filtrorol);
                        #compruebo que el Rol no tenga el rol con el id actual de la iteracion para agregarlo
                        if ($existerol == null)
                            $abmmenurol->alta($filtrorol);
                    }
                }
                #Si el count del array es menor a la cantidad de roles que corresponda entonces SI quita un rol
                elseif (count($nuevosRoles) < count($roles)) {
                    foreach ($nuevosRoles as $idrol) {
                        $filtrorol['idrol'] = $idrol;
                        $existerol = $abmmenurol->buscar($filtrorol);
                        #compruebo que el Rol si tenga el rol con el id actual de la iteracion para eliminarlo
                        if ($existerol != null)
                            $abmmenurol->baja($filtrorol);
                    }
                }
                if ($abmUser->modificacion($datos)) {
                    $resp = true;
                } else {
                    $mensaje = "<b>ERROR: </b>";
                }
            }
            if ($datos['accion'] == 'deshabilitar') {
                $datos['usnombre'] = $objRol->getusnombre();
                $datos['uspass'] = $objRol->getuspass();
                $datos['usmail'] = $objRol->getusmail();
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                #Si la fecha y hora seteada la convierte en 0000-00-00 00:00:00, si no es seteada coloca un timestamp
                if ($objRol->getusdeshabilitado() != '0000-00-00 00:00:00' && $objRol->getusdeshabilitado() != NULL) {
                    $datos['usdeshabilitado'] = '0000-00-00 00:00:00';
                } else {
                    $datos['usdeshabilitado'] = date('Y-m-d h:i:s'); #Timestamp
                }
                if ($userDelete->modificacion($datos)) {
                    $resp = true;
                } else {
                    $mensaje = "<b>ERROR: </b>";
                }
            }
            if ($datos['accion'] == 'nuevo') {
                if ($objRol->alta($datos)) {
                    $resp = true;
                } else {
                    $mensaje = "<b>ERROR:</b> No pudo completarse la accion.<br>";
                }
            }
            if ($datos['accion'] == 'nuevo') {
                if ($objRol->alta($datos)) {
                    $resp = true;
                } else {
                    $mensaje = "<b>ERROR:</b> No pudo completarse la accion.<br>";
                }
            }


            if ($resp) {
                $mensaje = "La acción <b>" . $datos['accion'] . " Rol</b>Se realizo correctamente.";
                header('Location: listarRols.php?mensaje=' . urldecode('edicion_exitosa'));
            } else {
                $mensaje .= "La acción <b>" . $datos['accion'] . " Rol</b>No pudo concretarse.";
                header('Location: listarRols.php?mensaje=' . urldecode('edicion_fallida'));
            }
        }
        $encuentraError = strpos(strtoupper($mensaje), 'ERROR');
    }


    /**
     * @return array
     */
    public function actualizarLogin($datos)
    {
        $respuesta = [];
        $filtro = array();
        $filtro['idusuario'] = $datos['roledit'];
        $rol = new AbmRol();
        $usuariorol = new AbmUsuarioRol();
        $objAbmUsuario = new AbmUsuario();
        $allrol = $rol->buscar(null);
        $unUsuario = $objAbmUsuario->buscar($filtro);
        $colrol = $usuariorol->buscar($filtro);

        $respuesta = ['allrol' => $allrol, 'unUsuario' => $unUsuario, 'colrol' => $colrol];
        return $respuesta;
    }


    public function actualizarProducto($datos){
        $respuesta = [];
        $objAbmProducto = new AbmProducto();
        $filtro = array();
        $filtro['idproducto'] = $datos['proEdit'];
        $unProducto = $objAbmProducto->buscar($filtro);
        $producto = $unProducto[0];
        $id = $producto->getidproducto();
        $precio = $producto->getproprecio();
        $stock = $producto->getprocantstock();
        $detalles = $producto->getprodetalle();
        $respuesta = ['id'=>$id, 'precio'=>$precio, 'stock'=>$stock, 'detalles'=>$detalles];
        return $respuesta;
    }






    public function cambiarMail($nuevoMail)
    {
    }

    // /**
    //  * @param array arreglo de items
    //  * @return string div de recultados de compras
    //  */
    // public function arregloDetalleCompra($arreglo){
    //     foreach ($arreglo as $item) {
    //         //$idcompra = $item->getidcompra();
    //         $idproducto = $item->getidproducto()->getidproducto();
    //         $proprecio = $item->getidproducto()->getidproducto();
    //         //$ciprecio = $item->getciprecio();
    //         //$idcompraitem = $item->getidcompraitem();
    //         $cicantidad = $item->getcicantidad();
    //         //$procantstock = $item->getidproducto()->getprocantstock();
    //         //$detalle = $item->getidproducto()->getprodetalle();
    //         $nombre = $item->getidproducto()->getpronombre();
    //         $archivos = $obj->obtenerArchivosPorId($idproducto);
    //         $link = $archivos["link"];
    //         $detallesResultado = 
    //         "<div class='d-grid col-lg-2 col-sm-4 mb-4'><img class='img-fluid' alt='Portada' src='" . $link . "' style= 'margin-bottom: 10px';>
    //         </div>".
    //         "<div>$nombre</div>".
    //         "<div>c/u: $$proprecio</div>".
    //         "<div>Productos: x$cicantidad</div>".
    //         "<div>Precio: $$proprecio</div>".
    //         "<input type='submit' formaction='../inicio_cliente/detallesProducto.php' name='idproducto:$idproducto' id='idproducto:$idproducto' class='btn btn-danger' value='Comprar de nuevo'>";
    //     return $detallesResultado;
    //     }
    // }
}
