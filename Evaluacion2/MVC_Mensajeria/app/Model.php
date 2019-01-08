<?php


class Model extends PDO
{

    protected $conexion;

    public function __construct()
    {
        try {
            
            $this->conexion = new PDO('mysql:host=' . Config::$mvc_bd_hostname . ';dbname=' . Config::$mvc_bd_nombre . '', Config::$mvc_bd_usuario, Config::$mvc_bd_clave);
            // Realiza el enlace con la BD en utf-8
            $this->conexion->exec("set names utf8");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<p>Error: No puede conectarse con la base de datos.</p>\n";
            echo "<p>Error: " . $e->getMessage();
        }
    }

   

    public function dameUsuarios()
    {
        try {
            
            $consulta = "select * from usuario order by id_us desc";
            $result = $this->conexion->query($consulta);
            return $result->fetchAll();
           
        } catch (PDOException $e) {
            
            echo "<p>Error: " . $e->getMessage();
        }
    }

    public function buscarUsuariosPorNombre($nombre)
    {
        try {
        $consulta = "select * from usuario where name like :nombre order by id_us desc";
        
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':nombre', $nombre);
        $result->execute();
           
        return $result->fetchAll();
        } catch (PDOException $e) {
            
            echo "<p>Error: " . $e->getMessage();
        }
    }
    
    public function buscarMensaje($energia)
    {
        try {
            $consulta = "select * from mesnaje where energia like :energia order by energia desc";
            
            $result = $this->conexion->prepare($consulta);
            $result->bindParam(':energia', $energia);
            $result->execute();
            
            return $result->fetchAll();
        } catch (PDOException $e) {
            
            echo "<p>Error: " . $e->getMessage();
        }
    }
    
    public function dameUsuario($id)
    {
        try {
            $consulta = "select * from usuario where id_us=:id";
            
            $result = $this->conexion->prepare($consulta);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->fetch();
            
        } catch (PDOException $e) {
            
            echo "<p>Error: " . $e->getMessage();
        }
    }
    
    public function dameMensajeR($id)
    {
        try {
            $consulta = "select * from mensaje where id_rec=:id";
            
            $result = $this->conexion->prepare($consulta);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->fetch();
            
        } catch (PDOException $e) {
            
            echo "<p>Error: " . $e->getMessage();
        }
    }
    
    public function dameMensajeS($id)
    {
        try {
            $consulta = "select * from mensaje where id_send=:id";
            
            $result = $this->conexion->prepare($consulta);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->fetch();
            
        } catch (PDOException $e) {
            
            echo "<p>Error: " . $e->getMessage();
        }
    }
    
    //añadir validador para no repetir usuario/correo
    public function insertarUsuario($name, $pass, $mail)
    {
        $consulta = "insert into usuario (name, password, mail) values (?, ?, ?)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(1, $name);
        $result->bindParam(2, $pass);
        $result->bindParam(3, $mail);
        $result->execute();
                
        return $result;
    }

    public function enviarMensaje($send, $rec, $subj, $mensaje)
    {
        $consulta = "insert into mensaje (id_send, id_rec, subject, mensaje) values (?, ?, ?, ?)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(1, $send);
        $result->bindParam(2, $rec);
        $result->bindParam(3, $subj);
        $result->bindParam(4, $mensaje);
        $result->execute();
        
        return $result;
    }
    
}
?>