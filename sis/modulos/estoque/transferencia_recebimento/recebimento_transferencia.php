<?
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

</script>

<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="195" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=195" class='navegacao_ativo'>
<span></span>    Recebimento de Transfer&ecirc;ncia
</a>
</div>

<div id="barra_info">
	<form method="get" style="float:left" >
        <input type="hidden" name="tela_id" value="195">
    	<select style="margin-top:1px;" name="status" id="status">
        	<option value="99">Status</option>
            <option <? if($_GET['status'] == '1'){echo 'selected="selected"';}?>value="1">Enviado</option>
            <option <? if($_GET['status'] == '2'){echo 'selected="selected"';}?>value="2">Recebido</option>
        </select>
      
         <select style="margin-right:10px; margin-top:2px" name="origem" id="origem">
        	<option value="0">Origem</option>
            <?php 
					$sql_origem = mysql_query(" SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome");
						while($reg_origem = mysql_fetch_object($sql_origem)){
							if($_GET['origem'] == $reg_origem->id){$sel_origem='selected="selected"';}else{$sel_origem='';}
			?>
            <option <?=$sel_origem?> value="<?=$reg_origem->id?>"> <?=$reg_origem->nome?></option>
            <?php
						}
            ?>
        </select>
        <select style="margin-top:2px; margin-right:5px;" name="destino" id="destino">
        	<option value="0">Destino</option>
            <?php 
					$sql_destino = mysql_query(" SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome");
						while($reg_destino = mysql_fetch_object($sql_destino)){
							if($_GET['destino'] == $reg_destino->id){$sel_destino='selected="selected"';} else{$sel_destino='';}
			?>
            <option <?=$sel_destino?>value="<?=$reg_destino->id?>"> <?=$reg_destino->nome?></option>
            <?php
						}
            ?>
        </select>
        
          Data:<input type="text" name="data" id="data" size="10" style="height:12px;" calendario='1'>
          <input type="submit" value="Filtrar">
    	</form> 
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60">Pedido</td>
          <td width="150">Origem</td>
          <td width="150">Destino</td>
          <td width="70">Envio</td>
          <td width="70">Recebido</td>
          <td width="70">Status</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
	
					if(!empty($_GET['busca'])){
								$and_busca = "AND (e.id = '".$_GET['busca']."' or c.nome = '".$_GET['busca']."')";
					}
					if(!empty($_GET['origem']) and !empty($_GET['destino'])){
										$origem_destino = "	AND e.unidade_id_origem = '".$_GET['origem']."' AND e.unidade_id_destino = '".$_GET['destino']."'";
					}
					if(!empty($_GET['status']) or $_GET['status'] == '0'){
						if($_GET['status'] == '99')
							$and_status = '';
						else
							$and_status = "AND e.status = '".$_GET['status']."'";	
					}
					if(!empty($_GET['data'])){
							$and_data = " AND e.data_fim = '".dataBrToUsa($_GET['data'])."'";	
					}

			
		$sql = mysql_query($y="SELECT *,e.id as id_transferencia FROM estoque_transferencia e,cozinha_unidades c 
											WHERE 
												e.status <> '3'
											AND 
												e.unidade_id_origem = c.id
										
										AND e.status <> '0'				
										$and_status
										AND e.vkt_id = '$vkt_id' 
										$origem_destino
										$and_data
										$and_busca
										ORDER BY e.id DESC ");
					//echo $y;
					//echo $_GET['busca'];
			
				while($r=mysql_fetch_object($sql)){
				$origem=mysql_fetch_object(mysql_query($o=" SELECT * FROM cozinha_unidades WHERE id = ".$r->unidade_id_origem." AND vkt_id = '$vkt_id' "));
					//echo $o;
				$destino=mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$r->unidade_id_destino." AND vkt_id = '$vkt_id' "));
				//print_r($destino);
				
	?>      
    	<tr <?=$sel?> onclick="location.href='?tela_id=196&acao=edit_recebimento&id=<?=$r->id_transferencia?>&origem=<?=$origem->id?>&destino=<?=$destino->id?>'" >
          <td width="60"><?=$r->id_transferencia;?></td>
          <td width="150"><?=$origem->nome;?></td>
          <td width="150"><?=$destino->nome;?></td>
          <td width="70"><?=dataUsaToBr($r->data_inicio)?></td>
          <td width="70"><?=dataUsaToBr($r->data_fim)?></td>
          <?
          	if($r->status == '1'){
			 $cor = '#009900';
			} else if($r->status == '2') {
				$cor = '#FF8000';
			}
		  ?>
          <td width="70" style="color:<?=$cor?>; font-weight:bold;"><?=$status_transferencia[$r->status]?></td>
          
          <td></td>
        </tr>
<?php
		}		
?>
    	
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
          <td width="300"></td>
          <td width="70">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>

</div>
