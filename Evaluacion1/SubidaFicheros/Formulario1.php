<?php
include ('bGeneral.php');
cabecera($_SERVER['PHP_SELF']);
$error = false;
if (! isset($_REQUEST['bAceptar'])) {
    ?>

<form method="post" action="Formulario1.php"
	enctype="multipart/form-data">
NOMBRE:<input type="text" name="nombre" size="10"><br>
EDAD:<input type="text" name="edad" size="10"><br>
EMAIL:<input type="text" name="correo" size="10"><br>
<input type="file" name="imagen" id="imagen" />
<input type="submit" name="bAceptar" value="Subir fichero" />
</form>
</body>
</html>
<?php
} // En esta parte comprobamos los datos recibidos
else {
    $name=$_REQUEST['nombre'];
    $age=$_REQUEST['edad'];
    $mail=$_REQUEST['correo'];
    $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
    $dir = "imagenes/";
    $max_file_size = "200000";
    $extensionesValidas = array(
        "jpeg",
        "gif"
    );
    echo "<pre>";
    print_r($_REQUEST);
    print_r($_FILES);
    echo "</pre>";
    
    if ((cTexto($name) == 0)) {
        $error = true;
    }
    if ((cNum($age) == 0)) {
        $error = true;
    }
    
    if (! $error) {
        if ($_FILES['imagen']['error'] != 0) {
            echo 'Error: ';
            switch ($_FILES['imagen']['error']) {
                case 1:
                    echo "UPLOAD_ERR_INI_SIZE <br>";
                    echo "Fichero demasiado grande<br>";
                    break;
                case 2:
                    echo "UPLOAD_ERR_FORM_SIZE<br>";
                    echo 'El fichero es demasiado grande<br>';
                    break;
                case 3:
                    echo "UPLOAD_ERR_PARTIAL<br>";
                    echo 'El fichero no se ha podido subir entero<br>';
                    break;
                case 4:
                    echo "UPLOAD_ERR_NO_FILE<br>";
                    echo 'No se ha podido subir el fichero<br>';
                    break;
                case 6:
                    echo "UPLOAD_ERR_NO_TMP_DIR<br>";
                    echo "Falta carpeta temporal<br>";
                case 7:
                    echo "UPLOAD_ERR_CANT_WRITE<br>";
                    echo "No se ha podido escribir en el disco<br>";
                    
                default:
                    echo 'Error indeterminado.';
            }
        } else {
            // Guardamos el nombre original del fichero
            $nombreArchivo = $_FILES['imagen']['name'];
            // Guardamos tamaño fichero
            $filesize = $_FILES['imagen']['size'];
            // Guardamos nombre del fichero en el servidor
            $directorioTemp = $_FILES['imagen']['tmp_name'];
            // Guardamos la información del archivo en un array
            $arrayArchivo = pathinfo($nombreArchivo);
            $errores=array();
            /*
             * Extraemos la extensión del fichero, desde el último punto. Si hubiese doble extensión, no lo
             * tendría en cuenta.
             */
            $extension = $arrayArchivo['extension'];
            // Comprobamos la extensión del archivo dentro de la lista que hemos definido al principio
            if ((in_array($extension, $extensionesValidas))==False) {
                $errores[] = "La extensión del archivo no es válida o no se ha subido ningún archivo";
            }
            // Comprobamos el tamaño del archivo
            if ($filesize > $max_file_size) {
                $errores[] = "La imagen debe de tener un tamaño inferior a 200 kb";
            }
            // Almacenamos el archivo en ubicación definitiva si no hay errores
            if (empty($errores)==True) {
                // Añadimos time() al nombre del fichero, así lo haremos único y si tuviera doble extensión
                // Haríamos inservible la segunda.
                $nombreArchivo = $arrayArchivo['filename'] . time();
                $nombreCompleto = $dir . $nombreArchivo . "." . $extension;
                // Movemos el fichero a la ubicación definitiva
                if (move_uploaded_file($directorioTemp, $nombreCompleto)) {
                    echo "<b>NOMBRE: </b>".$name."<br>";
                    echo "<b>EDAD: </b>".$age."<br>";
                    echo "<b>EMAIL: </b>".$mail."<br>";
                    echo "<br> El fichero \"$nombreArchivo\" ha sido guardado";
                } else {
                    echo "Error: No se puede mover el fichero a su destino";
                }
            }else{
                echo $errores[0];
            }
        }
    } else {
        
        ?>
<form ACTION="<?=$_SERVER ['PHP_SELF'] //el archivo actual?>"
	METHOD='post'>
	<p>Los datos que has introducido no están en el formato correcto</p>
	NOMBRE:<input type="text" name="nombre" size="10" VALUE="<?php
		echo $name;
        ?>"> <br> EDAD:<input type="text" name="edad" size="10" VALUE="<?php
		echo $age;
        ?>"> <br> EMAIL:<input type="text" name="correo" size="10" VALUE="<?php
		echo $mail;
        ?>">
		<?php
        echo '<input TYPE="submit" name="bAceptar" VALUE="aceptar">';
    }
}
?>
		  
</form>
<?php

pie();
?>