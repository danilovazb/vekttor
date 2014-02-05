<?
include("_functions.php");
include("_ctrl.php");
$sql=mysql_fetch_object(mysql_query("SELECT * FROM aluguel_configuracao WHERE id='$vkt_id'"));
	if(empty($sql->img_cabecalho)){
		$img_c=$logo;
	}else{
		$img_c="modulos/aluguel/configuracao/img/".$vkt_id."_c.".$sql->img_cabecalho;
	}
	if(empty($sql->img_rodape)){
		$img_r=$logo;
	}else{
		$img_r="modulos/aluguel/configuracao/img/".$vkt_id."_r.".$sql->img_rodape;
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
			height:9.6cm;
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
<a href="?" class='s2'>
  	OS
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Configuraçao
</a>
</div>

<div id="barra_info">
<a href="modulos/aluguel/configuracao/form.php" target="carregador" class="mais"></a>  
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
	<div id="cabecalho" style="padding:10px">
		<strong style="text-transform:capitalize;"><?=$empresa[nome]?></strong><br>
		<?=$empresa[cnpj]?><br>
		<?=$empresa[endereco]?><br>
		
		<br>
        <br>
      	<div style="background:url('<?=$logo?>') no-repeat; background-position:center;float:right; width:100px;height:50px;margin-top:-70px; padding-right:50px;">&nbsp;</div>
        
	</div>
    <?
		}else{
	?>
    	<img id="img_rodape" src="<?=$img_c?>" width="100%"/>
    <?
		}
	?>
    <div class="titulo_os" style=" margin:0px auto; text-align:center; border-bottom:1px solid #999; padding:3px; width:95%;">
     Locaçao - N&deg; <?=$locacao->al_id?>
    </div>
    
    <div id="cliente">
    	<div style="float:left;width:300px; padding-left:13px;">
        	<div>Cliente: <?=$locacao->razao_social?></div>
    		Tel. Comercial: <?=$locacao->telefone1?><br>
    		Endereço: <?=$locacao->endereco?><br>
            Bairro: <?=$locacao->bairro?> 
    		Cidade: <?=$locacao->cidade?><br>
    		CPF / CNPJ: <?=$locacao->cnpj_cpf?><br>
    		
        </div>
        
        <div style="float:left;width:450px; padding-left:13px;">
        	Pessoa p/ Contato: <?=$locacao->nome_contato?><br>
            Tel. Residencial: <?=$locacao->telefone1?><br>
    		Insc. Estadual/RG: <?=$locacao->inscricao_estadual." ".$locacao->rg?><br>
    		E-mail: <?=$locacao->email?><br>
            
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
        INFORMAÇ&Otilde;ES DA LOCAÇ&Atilde;O
        </div>
   <div id="os" style="height:70px; padding:10px">
   
    	<div style="float:left;width:400px;height:100px; padding-left:15px;">
    		Descriçao: <?=$locacao->descricao?><br>
            Cliente: <?=$locacao->nome_fantasia?><br>
            Data da Locaçao: <?=dataUsaToBr($locacao->data_locacao)?><br>
            Data da Devoluç&atilde;o: <?=dataUsaToBr($locacao->data_devolucao)?><br>
            <br>
    	</div>
        
        <div style="height:100px;">
    		N&deg; da Locacao: <?=$locacao->id?><br>
            Tel. Cliente: <?=$locacao->telefone1?><br>
            Data da Reserva: <?=dataUsatoBr($os->data_cadastro)?><br>
            Entregue em: <?=dataUsatoBr($locacao->data_entrega)?>            
    	</div>
    	<div style="width:95%;float:left; padding-left:13px; ">
    		
    	</div>
        <div style="width:95%;float:left; padding-left:13px;">
    		
    	</div>
    </div>
    
    <div style="clear:both"></div>
    
    <div id="servicos" style=" overflow:auto; padding:10px;">
    	
        <table  width="95%" id="produtos">
        	<tr>
            	<td colspan="7" style="font-size:14px" bgcolor="#999999" align="center"><strong>Itens da Locaçao</strong></td>
            </tr>
            <tr align="center" >
            	<td style="font-size:13px" colspan="2"><strong>Descriçao</strong></td>
                <td width="14%" style="font-size:13px;"><strong>QTD</strong></td>
                <td width="12%" style="font-size:13px;"><strong>Dias</strong></td>
                <td width="12%" style="font-size:13px;"><strong>Vlr. Unit.</strong></td>
                
                <td width="19%" style="font-size:13px;"><strong>Valor</strong></td>
            </tr>
			
            <tr>
            	<td style="font-size:13px" colspan="2"></td>
                <td style="font-size:13px"></td>
                <td style="font-size:13px"></td>
                <td style="font-size:13px"></td>
                <td style="font-size:13px"></td>
                
         
            
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
