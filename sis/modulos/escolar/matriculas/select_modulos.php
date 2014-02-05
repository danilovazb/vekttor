<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");



?>

M&oacute;dulos
<select name="modulo_id[]" class='modulo_id' valida_valor='1,99999999' retorno='focus|Selecione um Módulo'>
<option value="0">Selecione 1 Curso Antes</option>
<?

$q = mq($t="SELECT m.* FROM escolar_horarios as h, escolar_modulos as m WHERE h.modulo_id=m.id AND h.periodo_id = '{$_GET[periodo_id]}' AND h.escola_id='{$_GET[escola_id]}' AND h.curso_id='{$_GET[curso_id]}' group by m.id");
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