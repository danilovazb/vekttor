<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");

//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
$sql_config = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_config WHERE vkt_id = '$vkt_id' "));
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
	var config_id = $("#config_id").val();
	$("tr:odd").addClass('al');
	/*===== ABRE FORM AO CLICAR NO ICONE DE MAIS =====*/
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/estoque/configuracao/form.php?id='+id,'carregador');
	});
	
	/*==== ABRE FORM NO INICIO DA PAGINA ===*/
	window.open('modulos/estoque/configuracao/form.php?id='+config_id,'carregador');
});
</script>

<div id='conteudo'>
<div id='navegacao'>
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="" class='s2'>
  	Estoque
</a>
<a href="" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
</div>

<div id="barra_info">
  <!--<a href="modulos/estoque/configuracao/form.php" target="carregador" class="mais"></a>-->
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/estoque/configuracao/form.php?id='+id,'carregador');
	});
});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="200">Configura&ccedil;&atilde;o Conta</td>
                <td width="200">Plano de Contas</td>
                <td width="200">Centro de Custo</td>
                <td width="200">Almoxarifado</td>
                <td>&nbsp;</td>
            </tr>
        </thead>
    </table>
<div id='dados' >
<input type="hidden" name="config_id" id="config_id" value="<?=$sql_config->id?>">
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   <?php
   		$sql = mysql_query("SELECT * FROM estoque_config  WHERE vkt_id = '$vkt_id' ");
		while($escola_config = mysql_fetch_object($sql)){
			
			$conta = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_contas WHERE id = '$escola_config->conta_id' "));
			$plano_contas = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_centro_custo WHERE id = '$escola_config->plano_conta_id' "));
			$centro_custo = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_centro_custo WHERE id = '$escola_config->centro_custo_id' "));
			$almoxarifado = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = '$escola_config->almoxarifado_id'"));
   ?>
    <tr id="<?=$escola_config->id?>">
        <td width="200"><?=$conta->nome?></td> 
        <td width="200"><?=$plano_contas->nome?></td> 
        <td width="200"><?=$centro_custo->nome?></td>
        <td width="200"><?=$almoxarifado->nome?></td> 
        <td>&nbsp;</td>
    </tr>     
     <? } ?>
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>