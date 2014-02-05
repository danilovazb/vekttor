<?php

if($_POST[action]=='Salvar'){
	include("modulos/financeiro/_functions_financeiro.php");
	include("modulos/financeiro/_ctrl_financeiro.php");
}
include ("_functions.php");
include ("_ctrl.php");

$caminho = $tela->caminho; 



/* 
faltando
	centro de custo
	plano de conta
	cliente
*/
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<style>
tbody tr:nth-child(even) td{ background:#F1F4F7}
tbody tr:hover td{ background:#8AA6CA; color:#FFF}
#dados tbody .act td{ background:#8AA6CA;color:#FFF}
#dados tbody .act2 td{color:#CCC}
.select2-results li.select2-result-with-children > .select2-result-label { font-size:11px;}
.select2-results ul.select2-result-sub  li .select2-result-label{ padding-left:25px;}
.select2-results ul.select2-result-sub  li .select2-result-label {font-size:10px} 
</style>
<script src="modulos/financeiro/form_palno_centro_cliente.js"></script>
<script src="modulos/financeiro/financeiro.js"></script>
<link href="../fontes/css/select2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../fontes/js/select2.min.js"></script>
<script type="text/javascript" src="../fontes/js/select2_locale_pt-BR.js"></script>
<script>
	
	$("#dados tbody tr").live('click',function(){
		$("#dados tbody tr").removeClass('act');
		
		vencimento = $(this).find("td:eq(1)").html();
		descricao = $(this).find("td:eq(2)").html();
		valor = $(this).find("td:eq(3)").html();
		origem_id = $(this).attr('i')
		tipo = $(this).attr('tp');
		if(tipo=="1"){
			tipo ='receber';	
		}else{
			tipo ='pagar';	
		}
		url = 'modulos/financeiro/form_movimentacao.php?conciliacao=1&vencimento='+vencimento+'&descricao='+descricao+'&valor='+valor+'&origem_id='+origem_id+'&conta_id='+$(this).attr('conta_id')+'&info_pgto='+tipo;
		window.open(url,'carregador');
		$(this).addClass('act');
	});
/*
	$descricao=$_GET[descricao];
	$vencimento=$_GET[vencimento];
	$ano_mes_referencia=$_GET[ano_mes_referencia];
	$valor=$_GET[valor];
	$data_info_movimento=$_GET[data_info_movimento];
	$pagar_receber=$_GET[pagar_receber];

*/


$(".opm").live('click',function(){
	//retorno_id =$(this).attr('id')
	//window.location= '?tela_id=263&retorno_id='+retorno_id;
	
});
function of(){
	window.open('<?php echo $caminho; ?>/form.php','carregador');
}
$(document).keydown(function (e) {
	if(e.which == 18) {pressedCtrl = true; }

	if(e.which == 27){
		$("#exibe_formulario").fadeOut(300);
	}
	// abre a transferencia
	if(e.which == 84 && pressedCtrl == true){
		
	}
	
	if(e.which == 83 && pressedCtrl == true){
		//confirma_calculor();
		return false;
	}
	
	// 
	if((e.which == 61 || e.which == 187)  && pressedCtrl == true) { 
		//Aqui vai o código e chamadas de funções para o ctrl++
		of()
	}
});


</script>
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
        
        <div id="some">«</div>
        <a href="#" class='s2'>Financeiro</a>
        <a href="?tela_id=<?=$tela->id?>" class="navegacao_ativo"><span></span><?=$tela->nome?></a>
    </div>
    
    
  <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info"><a onClick="of()" target="carregador" class="mais"></a>	
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<td width="30"><input type="checkbox" onClick="if(this.checked){$('[type=checkbox]').attr('checked','checked')}else{ $('[type=checkbox]').removeAttr('checked')}" ></td>
                <td width="80">Data</td>
                <td width="350">Descri&ccedil;&atilde;o</td>
                <td width="60">Valor</td>                
                <td></td>                
            </tr>
        </thead>
    </table>
    
    <script>
    </script>
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
    <div id="dados">
    
	  <script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
            <?php
		  $q=mq("SELECT *,date_format(data,'%d/%m/%Y') as dt FROM $tb WHERE vkt_id='$vkt_id'  ORDER BY data, id");
		  while($r=mf($q)){
			  $conta= mf(mq("SELECT * FROM financeiro_contas WHERE id='$r->conta_id'"));
			//	pr($r);
			$info = mf(mq($t="SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND valor_cadastro=$r->valor AND (data_info_movimento ='".dataBrToUsa($r->dt)."' OR data_vencimento ='".dataBrToUsa($r->dt)."')"));
			if($info->id>0){
				$acti = 'class="act2"';
				$check = '';
			}else{
				$acti = '';
				$check = '<input type="checkbox" name="conciliacao_id[]" value="'.$r->id.'">';
			}
			if($r->tipo==0){
				$valor = -$r->valor;
			}else{
				$valor = $r->valor;
			}
            ?>
            
              <tr <?=$acti?> i="<?=$r->item_arquivo_id?>" conta_id='<?=$r->conta_id?>' tp='<?=$r->tipo?>' >
                    <td width="30"><?=$check?></td>
                    <td width="80"><?=$r->dt?></td>
                    <td width="350" class="opm" title='<?=$r->descricao?>' ><?=substr($r->descricao,0,45)?></td>
                    <td width="60" align="right"><?=moedaUsaToBr($valor);?></td>
                    <td><?
					if($info->id>0){
						echo 'já conciliado';
					}
					?> <?=$conta->nome?></td>
                </tr>
            <?php
            }
            ?>	
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
               <td width="100%">&nbsp;</td>
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
<select>
	<option>O que fazer com os Selecioados ?</option>
	<option>Remover</option>
	<option>Enviar para Caixa</option>
</select>

</div>