<?

include("../../../_config.php");

if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

$compra=mysql_fetch_object(mysql_query("SELECT status FROM compra WHERE id='".$id."' LIMIT 1"));

if($compra->status=="Efetivado")echo "<script>location='form.php?id=".$id."';</script>";
else echo "<script>location='form_disabled.php?id=".$id."';</script>";

/*
if($compra->status=="Cancelado")echo "<script>location='form_cancelado.php?id=".$id."';</script>";
if($compra->status=="Aguardo")echo "<script>location='form_aguardo.php?id=".$id."';</script>";
if($compra->status=="Autorizado")echo "<script>location='form_autorizado.php?id=".$id."';</script>";
*/
?>