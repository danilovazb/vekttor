<?
include("_functions.php");
include("_ctrl.php");
$sql=mysql_fetch_object(mysql_query($t="SELECT * FROM os_configuracao WHERE id='$vkt_id'"));
	//echo $t;
	if(empty($sql->img_cabecalho)){
		$img_c=$logo;
	}else{
		$img_c="modulos/ordem_servico/configuracao/img/".$vkt_id."_c.".$sql->img_cabecalho;
	}
	if(empty($sql->img_rodape)){
		$img_r=$logo;
	}else{
		$img_r="modulos/ordem_servico/configuracao/img/".$vkt_id."_r.".$sql->img_rodape;
	}
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
	*{ margin:0px ; padding:0px;}
	table tr td {font-family:Tahoma, Geneva, sans-serif; border:1px solid #333;}
		#pagina{
			border:1px solid #000;
			width:840px;
			height:1010px;
			background:#FFFFFF;
			margin:0px auto;
			box-shadow:2px 1px 2px #333333;
			margin-top:10px;
		}
		#os{font-family:Tahoma, Geneva, sans-serif;font-size:11pt;}
		#cabecalho{
			/*border-bottom:solid 1px;*/
			height:75px;
			font-family:Tahoma, Geneva, sans-serif;
			font-size:14px;
		}
		#cliente{
			/*border-bottom:1px solid #666;*/
			width:880px;
			height:100px;
			font-family: arial, sans-serif;
			font-size:11pt;
			padding:10px;
		}
		#cliente br{
			margin:8px;	
		}
		#produtos{
			border-collapse: collapse;
			padding-left:13px;
			margin-left:18px;
			
		}
		#produtos tr td{ 
			/*border:solid 1px;*/
		}
		#rodape0{
			font-family:Tahoma, Geneva, sans-serif;
			font-size:10pt;
			margin-right:auto;
			vertical-align:text-bottom;
			padding:3px;	
		}
		#rodape1{
			float:left;
			width:40%;
			height:120px;
			border-right:solid 1px;
		
		}
		#rodape2{			
			width:30%;
			height:113px;
		}
		#rodapea,#rodapeb{
			font-weight:500;
			
		}
		#servicos{
			height:305px;
		}
		.titulo_os{ font-family:Arial, Helvetica, sans-serif;font-weight:bold;}
		.titulo_os_info{
				font-family:Arial, Helvetica, sans-serif;font-weight:bold;
				text-align:center; width:95%; border-top:1px solid #999; padding:4px;
				di
		}
	</style>
<script type="text/javascript">

</script>

<div id='conteudo'>
<div id='navegacao'>
<div id='some'>«</div>
<a href="?" class='s1'>
  	Sistema
</a>

<a href="?" class='s2'>
  	OS
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Configuraçao
</a>
</div>

<div id="barra_info">
<a href="modulos/ordem_servico/configuracao/form.php" target="carregador" class="mais"></a>  
</div>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<script>
</script>
<div id="pagina">
	<?php
    	if(empty($sql->img_cabecalho)){
	?>		
   <img id="img_rodape" src="<?=$img_c?>"/>
    <div id="cabecalho" style="padding:10px">
		
        <div style="clear:both"></div>
        <strong style="text-transform:capitalize;"><?=$empresa[nome]?></strong><br>
		CNPJ: <?=$empresa[cnpj]?>
		<?=$empresa[endereco]?><br>
		<?=$empresa[bairro]?><br>
		<br>
        <br>
    </div>
    <?php
		}else{
    ?> 
    	<img id="img_rodape" src="<?=$img_c?>" width="100%"/>
	<?php
		}
	?>
    <div class="titulo_os" style=" margin:0px auto; text-align:center; border-bottom:1px solid #999; padding:3px; width:95%;">
     ORDEM DE SERVIÇO - N&deg; <?=$os->os_id?>
    </div>
    
    <div id="cliente">
    	<div style="float:left;width:300px; padding-left:13px;">
        	Cliente: <?=$os->razao_social?><br>
    		Tel. Comercial: <?=$os->telefone1?><br>
    		Endereço: <?=$os->endereco?><br>
            Bairro: <?=$os->bairro?> 
    		Cidade: <?=$os->cidade?><br>
    		CPF / CNPJ: <?=$os->cnpj_cpf?><br>
    		
        </div>
        
        <div style="float:left;width:450px; padding-left:13px;">
        	Pessoa p/ Contato: <?=$os->nome_contato?><br>
            Tel. Residencial: <?=$os->telefone1?><br>
    		Insc. Estadual/RG: <?=$os->inscricao_estadual." ".$os->rg?><br>
    		E-mail: <?=$os->email?><br>
            N&deg; de S&eacute;rie: <?=$os->os_id?>
        </div>
        
        <div>
        	<br>
    		<br>
    		<br>
    		<br>
    		<br>
			<br>
        </div>
    </div>    
    <div class="titulo_os_info" style="font-size:13pt; margin:0px auto; text-decoration:underline">
        INFORMAÇ&Otilde;ES DA OS
        </div>
   <div id="os" style="height:150px; padding:10px">
   
    	<div style="float:left;width:400px;height:100px; padding-left:15px;">
    		Descriçao: <?=$os->descricao?><br>
            Solicitante: <?=$os->nome_fantasia?><br>
            Data de Cadastro: <?=dataUsaToBr($os->data_cadastro)?><br>
            Nota Fiscal: <?=$os->nota_fiscal_servico?>
            <br>
    	</div>
        
        <div style="height:100px;">
    		N&deg; de série: <?=$os->os_id?><br>
            Tel. Solicitante: <?=$os->telefone1?><br>
            Entrega: <?=dataUsatoBr($os->data_entrega)?><br>
            Data de Emissao: <?=dataUsatoBr($os->data_cadastro)?>
    	</div>
    	<div style="width:95%;float:left; padding-left:13px; ">
    		<strong>Informaçoes do cliente</strong>
        	<p>
        		<?=$os->defeito_reclamado?>
        	</p>
    	</div>
        <div style="width:95%;float:left; padding-left:13px;">
    		<strong>Informaçoes Técnicas</strong>
        	<p>
        		Constatada a causa do problema, o mesmo foi solucionado <?=$os->reparo_manutencao?>.
        		Após o reparo, o funcionamento passou a ser adequado.
        	</p>
    	</div>
    </div>
    
    <div style="clear:both"></div>
    
    <div id="servicos" style=" overflow:auto; padding:10px;" >
    	<?
			$os_item=mysql_query($t="SELECT * FROM os_item WHERE os_id=$os->os_id AND produto_id!=0 AND vkt_id=$vkt_id");
		?>
        <table  width="95%" id="produtos">
        	<tr align="center">
            	<td colspan="6" bgcolor="#CCCCCC" style="font-size:14px"><strong>Serviços Executados</strong></td>
            </tr>
            <tr align="center" bgcolor="#CCCCCC">
            	<td style="font-size:13px"><strong>Código</strong></td>
                <td style="font-size:13px"><strong>Descriçao do Serviço</strong></td>
                <td style="font-size:13px"><strong>Técnico Repons&aacute;vel</strong></td>
                <td style="font-size:13px"><strong>Qtde.</strong></td>
                <td style="font-size:13px"><strong>Valor</strong></td>
                <td style="font-size:13px"><strong>Valor Total</strong></td>
            </tr>
            
            <tr>
            	<td colspan="5" align="right" style="font-size:13px; padding-right:10px;"><strong>Valor Total dos Serviços</strong></td>
                <td style="font-size:13px; padding-left:5px;"><strong><?=moedaUsaToBr($total_servicos)?></strong></td>
            </tr>
       </table>
    	
        <div id="texto adicional" style="margin-top:100px;padding-left:13px;">
        	<p align="justify"><?=$sql->texto_adicional?></p>
        </div>
    </div>
    
<div id="rodape0" style="background:#FFFFFF; vertical-align:bottom; border-top:1px solid #666; margin-top:30px;">
		<div id="rodape1" style="vertical-align:bottom">
   		<center><strong><u>Orçamento</u></strong></center>
        <div style="float:left;width:60%" id="rodapea">
        	<div>Valor das Peças: <?=moedaUsatoBr($total_produtos)?></div>
        	<div>Valor dos Serviços: <?=moedaUsatoBr($total_servicos)?></div>
        	<div>Valor Deslocamento:<?=moedaUsatoBr($valor_deslocamento)?></div>
        </div>
        <div id="rodapeb">
        	Desconto: <?=moedaUsatoBr($desconto)?><br>
            VALOR TOTAL: <?=moedaUsaToBr($total)?>
        </div>
		</div>
		<div id="rodape2" style="float:left;">
    	<div style="border-top:1px solid #333; width:340px; text-align:center; margin-top:40px;  margin-right:10px;">
        	Assinatura do Técnico
        </div>
        <div style="border-top:1px solid #333; width:340px; text-align:center; margin-top:40px; margin-right:10px;">
        	Assinatura do Cliente
        </div>
        </div>
</div>
<?php
    	if(!empty($sql->img_rodape)){
	?>	
		<img id="img_rodape" src="<?=$img_r?>" width="100%"/>
    <?php
		}
	?>
</div>
</div>


<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr <?=$sel?>>
          <td></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
</div>
