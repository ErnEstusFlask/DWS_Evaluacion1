<?php ob_start(); 
if(isset($_SESSION["id_user"])){
?>

<form name="formBusqueda" action="index.php?ctl=buscarMensajesSend" method="POST">

<table>

<td><input type="submit" value="Mostrar Mensajes"></td>
</tr>
</table>

</table>

</form>

<table>
<tr>
<th>Para</th>
<th>Asunto</th>
<th>Mensaje</th>
</tr>
<?php foreach ($params['resultado'] as $mensaje) : ?>
<tr>
<td><?php print_r($params['mensaje']); echo $params['mensaje'][0]['id_rec']['name'] ?></td>
<td><a href="index.php?ctl=verM&id_men=<?php echo $mensaje['id_men'] ?>">
<?php echo $mensaje['subject'] ?></a></td>
<td><?php echo $mensaje['mensaje'] ?></td>
</tr>
<?php endforeach; ?>

</table>
<?php }else{
	echo "Debes ser un usuario registrado para ver el contenido de esta pagina. Porfavor inicie sesion o registrese.";
}?>
<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>
