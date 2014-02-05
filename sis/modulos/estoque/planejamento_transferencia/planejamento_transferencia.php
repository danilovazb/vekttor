<?
//session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
$("a.mais").live("click",function(){
			var msg = "";
			var erro = 0;
			
		var id_origem  = $("select#origem_id").val();
		var id_destino = $("select#destino_id").val();
		
			if(id_origem == "0"){
				erro++;
				msg = "Informe Origem\n";	
			}
			if(id_destino == "0"){
				erro++;
				msg += "\nInforme Destino\n";
			}
			if(id_origem == id_destino){
				erro++;
				msg += "\nSelecione Unidades diferentes\n";
			}
			if(erro > 0){
				alert(msg);	
			} else{
				location.href=('?tela_id=479&id_origem='+id_origem+'&id_destino='+id_destino+'&acao=cadastra');
			}
			
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="192" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca"  onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="" class='navegacao_ativo'>
<span></span>Transfer&ecirc;ncia de Mercadoria
</a>
</div>

<div id="barra_info">
	
    	<form method="get" style="float:left" >
        <input type="hidden" name="tela_id" value="192">
    	<select style="margin-top:1px;" name="status" id="status">
        	<option value="99">Status</option>
        	<option <? if($_GET['status'] == '0'){echo 'selected="selected"';}?> value="0">Aberto</option>
            <option <? if($_GET['status'] == '3'){echo 'selected="selected"';}?>value="3">Cancelado</option>
            <option <? if($_GET['status'] == '1'){echo 'selected="selected"';}?>value="1">Enviado</option>
            <option <? if($_GET['status'] == '2'){echo 'selected="selected"';}?>value="2">Recebido</option>
        </select>
         <select style="margin-right:10px; width:100px" name="origem" id="origem">
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
        <select style="width:100px" name="destino" id="destino">
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
          <input type="submit" value="Filtrar" id="Filtrar">
    	</form>
   
    	
   
        
        <!-- CADASTRO DE TRANSFERENCIA -->
        <a href="#" target="carregador" class="mais"></a>
         <select style="float:right; margin-top:3px; margin-right:5px;width:100px;" name="destino_id" id="destino_id">
        	<option value="0">Destino</option>
            <?php 
					$sql_destino = mysql_query(" SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome");
						while($reg_destino = mysql_fetch_object($sql_destino)){
			?>
            <option value="<?=$reg_destino->id?>"> <?=$reg_destino->nome?></option>
            <?php
						}
            ?>
        </select>
        
       
        <select style="float:right;margin-top:3px; margin-right:10px;width:100px;" name="origem_id" id="origem_id">
        	<option value="0">Origem</option>
            <?php 
					$sql_origem = mysql_query(" SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome");
						while($reg_origem = mysql_fetch_object($sql_origem)){
			?>
            <option value="<?=$reg_origem->id?>"> <?=$reg_origem->nome?></option>
            <?php
						}
            ?>
        </select>		
    		
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
										$origem_destino = "
											AND 
												e.unidade_id_origem = '".$_GET['origem']."'
											AND 
												e.unidade_id_destino = '".$_GET['destino']."'";
					}
					if(!empty($_GET['status']) or $_GET['status'] == '0'){
						if($_GET['status'] == '99')
							$and_status = '';
						else
							$and_status = "AND e.status = '".$_GET['status']."'";	
					}
					if(!empty($_GET['data'])){
							$and_data = "AND e.data_inicio = '".dataBrToUsa($_GET['data'])."'";	
					}
			
		$sql = mysql_query($y="SELECT *,e.id as transferencia_id FROM estoque_transferencia as  e, cozinha_unidades as c  
								
								WHERE 	
									e.vkt_id = '$vkt_id'
								
								AND e.unidade_id_origem=c.id
								$and_busca
								$origem_destino
								$and_status
								$and_data	 
								ORDER BY e.id DESC");
						//echo $y;
			
				while($r=mysql_fetch_object($sql)){
				$origem=mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$r->unidade_id_origem));
				$destino=mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$r->unidade_id_destino));
				
	?>      
    	<tr <?=$sel?> onclick="location.href='?tela_id=518&acao=edit&id=<?=$r->transferencia_id?>&id_origem=<?=$origem->id?>&id_destino=<?=$destino->id?>&status=<?=$r->status?>'" >
          <td width="60"><?=$r->transferencia_id;?></td>
          <td width="150"><?=$origem->nome;?></td>
          <td width="150"><?=$destino->nome;?></td>
          <td width="70"><?=dataUsaToBr($r->data_inicio)?></td>
          <td width="70"><?=dataUsaToBr($r->data_fim)?></td>
          <?
          	if($r->status == '0'){
				 $cor = '#333';
			}if($r->status == '1'){
				 $cor = '#09F';
			}if($r->status == '2'){
				 $cor = '#009900';
			}if($r->status == '3'){
				 $cor = '#FF8000';
			}
		  ?>
          <td width="70" style="color:<?=$cor?> ;"><?=$status_transferencia[$r->status]?></td>
          
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
