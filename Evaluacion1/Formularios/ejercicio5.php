<?php
    $num1=$_REQUEST['numero1'];
    $num2=$_REQUEST['numero2'];
    if($num1==null||$num2==null||isset($_REQUEST['operacion'])){
        echo "No se ha podido realizar lo que se pide";
    }else{
        $oper=$_REQUEST['operacion'];
        for ($i=0;$i<count($oper);$i++){
            if($oper[$i]=="suma"){
                $res=$num1+$num2;
                echo "El resultado de realizar la suma de los números $num1 y $num2 es $res<br>";
            }
            if($oper[$i]=="resta"){
                $res=$num1-$num2;
                echo "El resultado de realizar la resta de los números $num1 y $num2 es $res<br>";
            }
            if($oper[$i]=="producto"){
                $res=$num1*$num2;
                echo "El resultado de realizar el producto de los números $num1 y $num2 es $res<br>";
            }
            if($oper[$i]=="cociente"){
                $res=$num1/$num2;
                echo "El resultado de realizar el cociente de los números $num1 y $num2 es $res<br>";
            }
        }
    }
    
    
?>