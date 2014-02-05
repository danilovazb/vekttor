<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");



?>

Cursos
<select name="curso_id[]" class='curso_id' valida_valor='1,99999999' retorno='focus|Selecione um Curso'>
<option value="0">Selecione 1 Escola Antes</option>
<?

$q = mq($t="SELECT c.* FROM escolar_horarios as h, escolar_cursos as c WHERE h.curso_id=c.id AND h.periodo_id = '{$_GET[periodo_id]}' AND h.escola_id='{$_GET[escola_id]}' group by c.id");
while($r=mf($q)){
    echo utf8_encode("<option value='$r->id'>$r->nome</option>");
}

?>
</select>

<?
//pr($_GET);
//echo $t; 
//echo mysql_error();
?>