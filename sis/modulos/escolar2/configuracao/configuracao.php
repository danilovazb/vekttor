<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

$sql_config = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_config WHERE vkt_id = '$vkt_id' "));

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	var config_id = $("#config_id").val();
	$("tr:odd").addClass('al');
	/*===== ABRE FORM AO CLICAR NO ICONE DE MAIS =====*/
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/escolar2/configuracao/form.php?id='+id,'carregador');
	});
	
	/*==== ABRE FORM NO INICIO DA PAGINA ===*/
	window.open('modulos/escolar2/configuracao/form.php?id='+config_id,'carregador');
	
	
	/*= scripts das paginas =*/
	
$("#cobrar").live("click",function(){
  
  if($(this).is(":checked")){
	
	if($(this).val() == "sim"){
		$("#conta_id").removeAttr("disabled");
		$("#centro_custo_id").removeAttr("disabled");
		$("#plano_de_conta_id").removeAttr("disabled");	
	} else if($(this).val() == "nao"){
		$("#conta_id").attr("disabled","disabled");
		$("#centro_custo_id").attr("disabled","disabled");
		$("#plano_de_conta_id").attr("disabled","disabled");	
	}
	
  }
  
});
	
});
</script>

<style>
.adiciona{ margin-top:0px; float:right}
.remove{ margin-top:0px; float:right}
</style>
<div id="conteudo">
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <?
  //  pr($_POST);
	?>
    <div id="navegacao">
        <form class='form_busca' action="" method="get">
             <a></a>
            <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
            <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
            <input type="text" value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
        </form>
         <div id="some">&laquo;</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span>Ensino</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        <!--<a href="modulos/escolar2/ensino/form.php" target="carregador" class="mais"></a>-->	
    </div>
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="220">Configura&ccedil;&atilde;o Conta</td>
                <td width="220">Plano de Contas</td>
                <td width="220">Centro de Custo</td>
                <td>&nbsp;</td>
            </tr>
        </thead>
    </table>
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
<div id="dados">
<input type="hidden" name="config_id" id="config_id" value="<?=$sql_config->id?>">
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
             
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   <?php
   		$sql = mysql_query("SELECT * FROM escolar2_config  WHERE vkt_id = '$vkt_id' ");
		while($escola_config = mysql_fetch_object($sql)){
			
			$conta = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_contas WHERE id = '$escola_config->conta_id' "));
			$plano_contas = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_centro_custo WHERE id = '$escola_config->plano_conta_id' "));
			$centro_custo = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_centro_custo WHERE id = '$escola_config->centro_custo_id' "));
   ?>
    <tr id="<?=$escola_config->id?>">
        <td width="220"><?=$conta->nome?></td> 
        <td width="220"><?=$plano_contas->nome?></td> 
        <td width="220"><?=$centro_custo->nome?></td> 
        <td>&nbsp;</td>
    </tr>     
     <? } ?>
    </tbody>
</table>
        
</div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
               <td width="260">&nbsp;</td>
               <td width="260">&nbsp;</td>
               <td >&nbsp;</td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	<?php echo $registros; ?> Registros 
    <?php
	
		if( $_GET[limitador] < 1 ){
			$limitador = 30;
		} else {
			$limitador = $_GET[limitador];
		}
		$qtd_selecionado[$limitador] = 'selected="selected"';
	
	?>
    
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?php echo $qtd_selecionado[15]; ?>>15</option>
        <option <?php echo $qtd_selecionado[30]; ?>>30</option>
        <option <?php echo $qtd_selecionado[50]; ?>>50</option>
        <option <?php echo $qtd_selecionado[100]; ?>>100</option>
    </select>
    Por P&aacute;gina 
  
    <div style="float:right; margin:0px 20px 0 0">
        <?php echo paginacao_links( $_GET[pagina], $registros, $_GET[limitador] ); ?>
    </div>
    
</div>