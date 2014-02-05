<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
if($_GET[conta_id]){
$conta_id = $_GET[conta_id];
}else{
$conta_id = $_POST[conta_id];
	
}
if(!isset($_GET[extorno])){$filtro_extorno=" AND extorno=0";}elseif($_GET[extorno]=='1'){ $filtro_extorno='';}
/*if($_GET['mes_i']){
	$mes_i = $_GET['mes_i'];
	$ano_i = $_GET['ano_i'];
	$mes_f = $_GET['mes_f'];
	$ano_f = $_GET['ano_f'];
}else{
	$mes_i = date("m");
	$ano_i =  date("Y");
	$mes_f = date("m");
	$ano_f =  date("Y");
}

$mes_s[$mes_i] 	= 'selected="selected"';
$mes_s2[$mes_f] = 'selected="selected"';
$ano_s[$ano_i] 	= 'selected="selected"';
$ano_s2[$ano_f] = 'selected="selected"';
*/

if($_GET['data_inicio']){
	$data_inicio=DataBrToUsa($_GET['data_inicio']);$data_fim=DataBrToUsa($_GET['data_fim']);
}else{
	$data_inicio=date("Y-m-01");$data_fim=date("Y-m-t");
}

// guarda as informações das contas
$q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
while($r= mysql_fetch_object($q)){
	$x++;
	if($x==1&&$_GET[conta_id]<1){
	  $conta_id= $r->id; $conta_selecionada=$r->nome;
	  }
	if($r->id==$_GET[conta_id]){$sel = "selected='selected'";$conta_selecionada=$r->nome;}else{$sel = "";}
	  $saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
	  $saldo=number_format($saldo,2,',','.');
	  $conta_info[] = "<option value='$r->id' $sel >$r->nome - R$ $saldo</option>";  
  }
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<link href="../fontes/css/select2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../fontes/js/select2.min.js"></script>
<script type="text/javascript" src="../fontes/js/select2_locale_pt-BR.js"></script>
<style>
a{ text-decoration:none;}
.result_val_diferente{ background:#C3C3C3; padding:5px; width:300px; color:#FFF;}
.table-dados tbody tr:nth-child(even) {background: #CCC}
.table-dados tbody tr:nth-child(odd) {background: #FFF}
.wp{ color:#CCC}
.table-dados tr td{border:0;background:#F1F5FA;}
</style>
<script src="modulos/financeiro/financeiro.js"></script>
<span style="display:none">
<?
/*

$vetor = array();
$vetor = exibe_option_sub_plano_ou_centro_3('plano',0,0,0,0,$vetor);
$vetor_ids = $vetor[id];
$vetor_nomes = $vetor[nome];
$vetor_valores = $vetor[valor];
$vetor_clicks = $vetor[clica];


echo "var centro_id = Array(,".implode(',',$vetor_ids).");\n";
echo "var centro_nome = Array(\",".implode("\",\"",$vetor_nomes)."\");\n";
echo "var centro_valo = Array(\",".implode("\",\"",$vetor_valores)."\");\n";
echo "var centro_click = Array(,".implode(',',$vetor_clicks).");\n";
*/
?>
</span>
<script>
var pressedCtrl = false; 
$(document).keyup(function (e) {
	if(e.which == 18)
		pressedCtrl=false; 
})

function abremais(){
			window.open('modulos/financeiro/form_transferencia.php?conta_id=<?=$conta_id?>','carregador')

}
function abreformfi(){
	
	window.open('modulos/financeiro/form_movimentacao.php?conta_id='+document.getElementById('conta_id').value+'&info_pgto=<?=$_POST['tipo']?>','carregador')
}
$(document).keydown(function (e) {
	if(e.which == 18) {pressedCtrl = true; }

	//document.title=e.which;
	if(e.which == 27){
		$("#exibe_formulario").html('');
	}
	// abre a transferencia
	if(e.which == 84 && pressedCtrl == true){
		abremais(); 
	}
	
	if(e.which == 83 && pressedCtrl == true){
		confirma_calculor();
		return false;
	}
	
	// 
	if((e.which == 61 || e.which == 187)  && pressedCtrl == true) { 
		//Aqui vai o código e chamadas de funções para o ctrl++
		abreformfi();	
	}
});
</script>

<script src="modulos/financeiro/form_palno_centro_cliente.js"></script>
<div id='conteudo'>
<?
/*
echo "<pre>";
print_r($mes_s);
print_r($ano_s);
print_r($mes_s2);
print_r($ano_s2);
echo "</pre>";
*/
?><div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    Caixa
</a>
</div>
<div id="barra_info">
<form method="get" action="" id="form_filtro">
<input type="hidden"  name="tela_id" value="54" />
<input type="hidden" name="conta_id" id="conta_id" value="<?=$conta_id?>">

   <a  onclick='abreformfi()' class="mais"></a>
   <input type="button" value="Transferencia" onclick="abremais()" style="float:right; margin:3px 10px 0 0 "> 
Conta
 <select name="conta_id" id="conta_id"  onchange="document.getElementById('form_filtro').submit()">
              <?php
			  
				echo implode("\n",$conta_info);  

			  ?>
			    
    </select>
    <label>Mostrar extornos
    	<input style="margin-left:-2px;" type="checkbox" <? if($_GET['extorno']==1)echo "checked='checked'"; ?> name="extorno" value="1" />
    </label>
    
    Periodo
    <input type="text" calendario="1" name="data_inicio" id="data_inicio" value="<?=DataUsaToBr($data_inicio)?>" style="width:75px;height:10px;"/>
<!--<select name="mes_i">
    	<option value="01"<?=$mes_s['01']?>>Janeiro</option>
    	<option value="02"<?=$mes_s['02']?>>Fevereiro</option>
    	<option value="03"<?=$mes_s['03']?>>Março</option>
    	<option value="04"<?=$mes_s['04']?>>Abril</option>
    	<option value="05"<?=$mes_s['05']?>>Maio</option>
    	<option value="06"<?=$mes_s['06']?>>Junho</option>
    	<option value="07"<?=$mes_s['07']?>>Julho</option>
    	<option value="08"<?=$mes_s['08']?>>Agosto</option>
    	<option value="09"<?=$mes_s['09']?>>Setembro</option>
    	<option value="10"<?=$mes_s['10']?>>Outubro</option>
    	<option value="11"<?=$mes_s['11']?>>Novembro</option>
    	<option value="12"<?=$mes_s['12']?>>Dezembro</option>
    </select>
       <input type="text" name="ano_i" value="<?=$ano_i?>" style="width:35px; height:10px">-->
    a
    <input type="text" calendario="1" name="data_fim" id="data_fim" value="<?=DataUsaToBr($data_fim)?>" style="width:75px;height:10px;"/>
<!--    
<select name="mes_f">
    	<option value="01"<?=$mes_s2['01']?>>Janeiro</option>
    	<option value="02"<?=$mes_s2['02']?>>Fevereiro</option>
    	<option value="03"<?=$mes_s2['03']?>>Março</option>
    	<option value="04"<?=$mes_s2['04']?>>Abril</option>
    	<option value="05"<?=$mes_s2['05']?>>Maio</option>
    	<option value="06"<?=$mes_s2['06']?>>Junho</option>
    	<option value="07"<?=$mes_s2['07']?>>Julho</option>
    	<option value="08"<?=$mes_s2['08']?>>Agosto</option>
    	<option value="09"<?=$mes_s2['09']?>>Setembro</option>
    	<option value="10"<?=$mes_s2['10']?>>Outubro</option>
    	<option value="11"<?=$mes_s2['11']?>>Novembro</option>
    	<option value="12"<?=$mes_s2['12']?>>Dezembro</option>
    </select>
      <input type="text" name="ano_f" value="<?=$ano_f?>" style="width:35px;height:10px">-->
      <input type="submit" value="Ir" />
     
     
     <button type="button" onclick="window.open('modulos/tela_impressao.php?url=<? //$url?>')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" >
	<img src="../fontes/img/imprimir.png" />
	</button>
     
</form>
 </div>
 <table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
    	  <td width="30" style="margin:0;padding:0; text-align:center" title='Consiliado com o Banco' class="wp">C</td>
           	<td width="70" style="margin:0;padding:0; text-align:center">
            <a href="?tela_id=54&conta_id=<?=$_GET["conta_id"]?>&mes_i=<?=$_GET["mes_i"]?>&ano_i=<?=$_GET["ano_i"]?>&mes_f=<?=$_GET["mes_f"]?>&ano_f=<?=$_GET["ano_f"]?>&data=<?=$_GET["data"]?>" id="ordena_data">Data</a>
            
            <!--<?linkOrdem("Data","data_info_movimento",1)?>-->
            </td>
            <td width="240">Cliente/Fornecedor</td>
            <td width="240">Descrição</td>
          	<td width="85" style="margin:0;padding:0; text-align:center">Entradas</td>
          	<td width="85" style="margin:0;padding:0; text-align:center">Saidas</td>
          	<td width="85" style="margin:0;padding:0; text-align:center">Saldo</td>
          	<td width="" class="wp"></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<div id="info_filtro">
<?=$template_cabecalho_impressao?>

<strong>Financeiro - Caixa</strong>
    <div style="clear:both"></div>
    <strong>Conta:</strong> <?=$conta_selecionada?>
    <strong>Período:</strong> <?="<h3><strong>De ".dataUsaToBr($data_inicio)." até ".dataUsaToBr($data_fim)."</strong></h3>"?>
</div>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>



<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?php
	$filter_data = 0;
	$and_data = " ORDER BY  data_movimento";
	
	if(isset($_GET["data"])){
		$filter_data = 1;
		$and_data = "ORDER BY  data_info_movimento,data_movimento";
	}
	
	
	$dataini = " data_movimento >='".$data_inicio." 00:00:00'";
	$datafim = " data_movimento <='".$data_fim." 23:59:59'";
	//$dataini2 = " data_info_movimento >='".$ano_i."-".$mes_i."-01'";
	//$datafim2 = " data_info_movimento <='".$ano_f."-".$mes_f."-31'";
	$dataini2 = " data_info_movimento >='".$data_inicio."'";
	$datafim2 = " data_info_movimento <='".$data_fim."'";
	
	/*
	#	(
	#		$dataini
	#		AND
	#		$datafim
	#	) 
	#	OR
	*/
	$q= mysql_query($trace="
	SELECT 
		*,
		date_format(data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento 
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	AND 
		`status`='1'
		$filtro_extorno
	AND
		conta_id='$conta_id'
	AND
	(
		(
			$dataini2
			AND
			$datafim2
		)
	)
	
	$and_data  ");
	
	if($vkt_id==1){
		//echo "<PRE>".$trace."</PRE>";
	}
	//echo mysql_error();
	$qtd_reg = mysql_num_rows($q);
	
	while($r=mysql_fetch_object($q)){
		$total++;
		  if($total%2){$sel='class="al"';}else{$sel='';}
		if($r->movimentacao =='fisica' || $r->extorno==1){
			$parenteseI="(";
			$parenteseF=")";
		}else{
			$parenteseI="";
			$parenteseF="";
		}
		
		if($r->entrada>0){
			$entrada = $parenteseI.moedaUsaToBr($r->entrada).$parenteseF;
			if($r->extorno!=1){
				$entrada_soma[]= $r->entrada;
			}
			
		}else{
			$entrada = '';
		}
		if($r->saida>0){
			$saida = $parenteseI.'-'.moedaUsaToBr($r->saida).$parenteseF;
			if($r->extorno!=1){
				$saida_soma[]= $r->saida;
			}
		}else{
			$saida = '';
		}
		
		$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$r->internauta_id'"));
		$saldo=$r->saldo;
		if($r->extorno!=1){
			$sel_ext = "";
		}else{
			$sel_ext = "style='color:#999'";
		}
	?>      
    	<tr <?=$sel?><?=$sel_ext?>>
    	  <td id='li<?=$total?>' width="30" style="margin:0;padding:0; text-align:center;" class="wp"><input onclick="co(this,<?=$r->id?>)" type="checkbox"<? if($r->conciliado ==1){echo 'checked="checked"'; }?>></td>
            <td width="70" style="margin:0;padding:0; text-align:center;"><?=dataUsaToBr($r->data_info_movimento)?></td>
        	<td width="240"onclick="opf(<?=$r->id?>)"><?=$cliente->razao_social ?></td>
          	<td width="240"><?=substr($r->descricao,0,40)?></td>
          	<td width="85" style="margin:0;padding:0; text-align:right"><?=$entrada?></td>
          	<td width="85" style="margin:0;padding:0; text-align:right"><?=$saida?></td>
          	<td width="85" style="margin:0;padding:0; text-align:right" >
			<? 
				if($filter_data != 1) { echo moedaUsaToBr($r->saldo); }
				if($total == 1 && $filter_data==1) { echo moedaUsaToBr($r->saldo); }
				if($total == $qtd_reg  && $filter_data==1) {echo moedaUsaToBr($r->saldo);}
			?></td>
          	<td class="wp"><?=$forma_pagamento[$r->forma_pagamento]?></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
<script>
$("#dados").focus();
</script>
</div>
<div id="total">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
    	  <td width="30" class="wp" style="margin:0;padding:0; "></td>
          	<td width="70" style="margin:0;padding:0; "></td>
            <td width="240">&nbsp;</td>
            <td width="240">Total</td>
            <td width="85"align="right"style="margin:0;padding:0; "><?=moedaUsaToBr(@array_sum($entrada_soma))?></td>
            <td width="85"align="right"style="margin:0;padding:0; ">-<?=moedaUsaToBr(@array_sum($saida_soma))?></td>
            <td width="85"align="right"style="margin:0;padding:0; "><?=moedaUsaToBr($saldo)?></td>
          	<td width="" class="wp"></td>
      </tr>
    </thead>
</table>
</div>
</div>
<div id='rodape'>
	<span style="font-size:9px; color:#666; line-height:22px;">Atalhos: <strong>ESC</strong> Fecha Formulário <strong>ALT+(+)</strong> Adiciona Atividade <strong>ALT+ T </strong> Transferencia</span>

</div>
