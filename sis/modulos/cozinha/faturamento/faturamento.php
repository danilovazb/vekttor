<?
session_start();
//include("../../../_config.php");
include("_function.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#contrato_sombra{
	box-shadow: 1px 1px 1px #888;
	padding:5px;border:1px solid #C8C8C8;
	margin:3px; height:20px;	
}
table#dados_filtro1 tr td{
	/*padding:0px;*/	
}
</style>
<script>
$(document).ready(function(){
	$('table#tabela_dados tbody tr:odd').addClass('al');	
})
$("#data_fim").live('blur',function(){
			var data_ini    = $("#data_inicio").val();
			var data_fim    = $("#data_fim").val();
			var contrato_id = $("select#contrato_id").val();
			//alert(data_ini+data_fim);
			var data = 'data_ini='+data_ini+'&data_fim='+data_fim+'&contrato='+contrato_id;
			$("#valor_contrato").load('modulos/cozinha/faturamento/valor_contrato.php',data);
});
$("select#contrato_id").live("change",function(){
			var data_ini    = $("#data_inicio").val();
			var data_fim    = $("#data_fim").val();
			var contrato_id = $("select#contrato_id").val();
			//alert(data_ini+data_fim);
			var data = 'data_ini='+data_ini+'&data_fim='+data_fim+'&contrato='+contrato_id;
			$("#valor_contrato").load('modulos/cozinha/faturamento/valor_contrato.php',data);
		});
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="116" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a><a href="./" class='s2'>
    Cozinha 
</a><a href="?tela_id=116" class='navegacao_ativo'>
<span></span> Faturamento
</a>
</div>

<div id="barra_info">
<form method="get">
<input type="hidden" name="tela_id" value="116" />

<!-- select na tabela projetos -->
<div style="float:left">
<select name="contrato_id" id="contrato_id">

<option value="0">Todos Contrato</option>
		<?
        		$sql=mysql_query("SELECT 
											distinct cc.cliente_id,cf.razao_social,cc.id
										FROM 
											cozinha_contratos cc
										JOIN cliente_fornecedor cf
										  
										  ON cf.id=cc.cliente_id
										
										WHERE vkt_id = '$vkt_id'
							
				");
				while($r=mysql_fetch_object($sql)){
					if($_GET['contrato_id'] == $r->id){$sel='selected="selected"';} else{$sel = '';}
        ?>
	<option <?=$sel?> value="<?=$r->id?>"><?=$r->id?> - <?=$r->razao_social?></option>
    	<?
				}
		?>

</select>
Data:<input type="text" name="data" id="data" style="height:14px;" size="10" calendario='1'>
<label><input type="submit" value="Filtar"></label>

</div>
<a href="modulos/cozinha/faturamento/form.php" target="carregador" class="mais"></a>
</form>

</div>

<script>

$("#tabela_dados tr").live("click",function(){
	var faturamento_id = $(this).attr('id');	
	//alert(faturamento_id);
	window.open('<?=$tela->caminho?>/form.php?id='+faturamento_id,'carregador');
});

</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="50">ID</td>
          <td width="300"><?=linkOrdem("Contrato","nome",1)?></td>
          <td width="90">Nota Fiscal</td>
          <td width="80">Vencimento</td>
          <td width="150">Periodo</td>
          <td width="75">Valor</td>
          <td>&nbsp;</td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
       <tbody>
       <?
       			if(!empty($_GET['contrato_id'])){
					$contrato_id = $_GET['contrato_id'];
					$and_contrato = "AND cc.id = ".$contrato_id;
				}
				if(!empty($_GET['busca'])){
					$and_busca = "AND f.id = '".$_GET['busca']."'";	
				}
				if(!empty($_GET['data'])){
						$and_data = "AND f.data_inicio = '".dataBrToUsa($_GET['data'])."'";	
				}
				
				$sql_contrato=mysql_query($rdata="SELECT 
											*,  
											cf.id as cf_id, 
											cc.id as cc_id,
											f.id as f_id  
										FROM 
											cozinha_contratos cc
										
										JOIN cliente_fornecedor cf
										  
										  ON cf.id=cc.cliente_id
										  
										JOIN cozinha_faturamento f
										  ON f.contrato_id=cc.id
										
										WHERE f.vkt_id = '$vkt_id' 
										$and_contrato
										$and_busca
										$and_data
				");
				//echo $rdata; 
				while($reg_contrato=mysql_fetch_object($sql_contrato)){
						
	   ?>
        <tr id="<?=$reg_contrato->f_id?>">
          <td width="50"><?=$reg_contrato->f_id?></td>
          <td width="300"><?=$reg_contrato->razao_social?></td>
          <td width="90"><?=$reg_contrato->nota_fiscal?></td>
          <td width="80"><?=$reg_contrato->vencimento?></td>
          <td width="150"><?=dataUsaToBr($reg_contrato->data_inicio)?> - <?=dataUsaToBr($reg_contrato->data_fim)?></td>
          <td width="75"><?=moedaUsaToBr($reg_contrato->valor)?></td>
          <td>&nbsp;</td>
        </tr>
        	<?
				}
			?>
      </tbody>
</table>

</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
           <td width="350">Total</td>
          <td width="80">&nbsp;</td>
          <td width="150">&nbsp;</td>
          <td width="75">15.550,00</td>
          <td>&nbsp;</td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
