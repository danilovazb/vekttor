<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");



?>

Salas
<select name="sala_id[]" class='sala_id'>
<option value="0">Selecione 1 Curso Antes</option>
<?

$q = mq($t="SELECT * FROM escolar_salas WHERE horario_id='{$_GET[horario_id]}'");
while($r=mf($q)){
   // echo iconv('ISO-8859-1','UTF-8',"<option value='$r->id'>$r->nome</option>");
    echo utf8_encode("<option value='$r->id'>$r->nome</option>");
}

?>
</select>

<?
//pr($_GET);
//echo $t; 
//echo mysql_error();
?>