<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");



?>

Hor&aacute;rios
<select name="horario_id[]" class='horario_id' valida_valor='1,99999999' retorno='focus|Selecione um Horario'>
<option value="0">Selecione 1 M&oacute;dulo Antes</option>
<?

$q = mq($t="SELECT h.* FROM escolar_horarios as h WHERE h.periodo_id = '{$_GET[periodo_id]}' AND h.escola_id='{$_GET[escola_id]}' AND h.curso_id='{$_GET[curso_id]}' AND h.modulo_id ='{$_GET[modulo_id]}' ");
echo $t;
while($r=mf($q)){
    if(strlen($r->nome)>0){
		 $nome = $r->nome; 
	}else{
	  	$nome = converte_numeros_comvirgula_em_dias_semanas($r->dias_semana ,$semana_abreviado)." ".substr($r->horario_inicio,0,5)." às ".substr($r->horario_fim ,0,5); 
	}

    echo utf8_encode("<option value='$r->id' valor='$r->valor' valor_bolsista='$r->valor_bolsista' $s>$nome</option>");
}

?>
</select> 
<?
//pr($_GET);
//echo $t; 
//echo mysql_error();
?>
