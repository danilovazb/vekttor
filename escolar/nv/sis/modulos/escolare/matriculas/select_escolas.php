<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");



?>

Unidades
<select name="escola_id[]" class='escola_id' valida_valor='1,99999999' retorno='focus|Selecione uma escolas'>
    <option value="0">Selecione 1 Unidade ANtes</option>
    <?
    
    $q = mq($t="SELECT e.* FROM escolar_horarios as h, escolar_escolas as e WHERE h.escola_id=e.id AND h.periodo_id = '{$_GET[periodo_id]}' group by e.id");
    while($r=mf($q)){
        echo utf8_encode("<option value='$r->id'>$r->nome</option>");
    }
    
    ?>
</select>

<?
//pr($_GET);
//echo $t; 
?>