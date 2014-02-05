<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");

$forma_pagamento = array('0'=>"Dinheiro", '1'=>"Cheque", '2'=>"Cartao Crédito Visa", '3'=>"Boleto", '4'=>"Permuta", '5'=>"Outros", '6'=>"Transferecnia", '7'=>"Depósito",'8'=>"Cartao Crédito Mastar",'9'=>"Débito Mastar",'10'=>"Débito Visa");

$venda_config = mysql_fetch_object(mysql_query("SELECT * FROM `estoque_config` WHERE vkt_id = '$vkt_id'  "));

?>
<script src="../../../../modulos/financeiro/financeiro.js"></script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#container_grafico{
position:absolute;float:right; right:5%; display:none; border:1px solid #999; background:#FFF; margin-top:4px;-moz-box-shadow: 10px 10px 5px #888;
-webkit-box-shadow: 7px 7px 5px #888;
box-shadow: 7px 7px 5px #888; 	
}
.g{background:url(../fontes/img/bb.jpg); font-weight:bold; }
.escondido{  position:absolute; display:none; color:black !important;left:29%;}
.modal-body table tr td{ background:white !important;color:black !important;}
.modal-body table tr td:hover{ background:white !important; color:black !important;}
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">&laquo;</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s1'>
  	Financeiro
</a>
<a href="?" class='s2'>
  	Relat&oacute;rios
</a>
<a href="?tela_id=82" class='navegacao_ativo'>
<span></span>    Demonstrativo 
</a>
</div>
<div id="barra_info">
    
<form style=" margin:0; padding:0; " method="get"> 
   
      <select name="conta_id" id="conta_id">
      	<option value="0">Conta</option>
      	<?
        	$sql = mysql_query(" SELECT * FROM `financeiro_contas` WHERE cliente_vekttor_id = '$vkt_id' ");
			while($contas = mysql_fetch_object($sql)){
				if($_GET["conta_id"] == $contas->id ) {$sel = 'selected="selected"';$conta_escolhida=$contas->nome;} else {$sel = '';}
		?>	
        <option <?=$sel?>  value="<?=$contas->id?>"><?=$contas->nome?></option> 
      	<?php
			}
		?>
      </select> 
      
      
      <label> De
      	
        <input type="text" name="dta_inicio" id="dta_inicio" style="width:80px; height:11px;" calendario="1" value="<? 
		if(!empty($_GET["dta_inicio"])){echo $_GET["dta_inicio"];}else{echo "01/".date("m")."/".date("Y");} ?>"> à
        
        <input type="text" name="dta_fim" id="dta_fim" style="width:80px;height:11px" calendario="1" value="<?
        if(!empty($_GET["dta_fim"])){echo $_GET["dta_fim"]; }else{echo date("t")."/".date("m")."/".date("Y");}?>">
      </label>
 
    
<input type="hidden" name="tela_id" value="516" />
<input type="submit" name="button" id="button" value="Filtrar" />

<button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('modulos/tela_impressao.php?url=')" type="button">
	<img src="../fontes/img/imprimir.png">
</button>
</form>
</div>

<div id="dados">
<div id="info_filtro">
<?=$template_cabecalho_impressao?>
Fechamento de Caixa.<br />
<? 
	if(empty($conta_escolhida)){
		$conta_escolhida="Todas as Contas";
	}
	echo "<strong>Contas:</strong> $conta_escolhida <br /><b>Dias:</b> ";
	if(!empty($_GET["dta_inicio"])){echo $_GET["dta_inicio"];}else{echo "01/".date("m")."/".date("Y");};
	echo " ao dia ";
	 if(!empty($_GET["dta_fim"])){echo $_GET["dta_fim"]; }else{echo date("t")."/".date("m")."/".date("Y");}
?>
</div>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
$(".cel_pagamento").live('click',function(){
	
	forma_pagamento = $(this).attr('id');
	tipo       = $(this).attr('tipo');
	conta      = $("#conta_id").val();
	dta_inicio = $("#dta_inicio").val();
	dta_fim    = $("#dta_fim").val();
	//$(".escondido").css('display','block');
	$(".escondido").show('slow');
	$(".janela").show('slow');
	$(".modal-body").load('modulos/financeiro/relatorios/venda/_ctrl.php',{acao:'movimentacoes',forma_pagamento:forma_pagamento,tipo:tipo,
	conta:conta,dta_inicio:dta_inicio,dta_fim:dta_fim});
});

/*$(".cel_pagamento").live('mouseout',function(){
	
});*/
$(".modal_close2").live("click",function(){
	var modal = $(this).parent().parent();
	modal.hide('slow');
});

</script>
<div  id="modal1" class="escondido"  style="z-index:10">
                   <div class="janela" style="width:550px;">
                   <div class="modal-header-2">
                      <a href="#" style="color:#CCC; font-weight:bold;float:right;" class="modal_close2">x</a>
                     <span><?=$nome?>&nbsp;</span>
                   </div>
                   <div class="modal-body" >
                   
                   </div><!-- fim modal-body -->
                   <div class="modal-footer">
                   </div>
               </div>
            </div>
	<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>
    	  <td width="200">Descrição</td>
		  <td width="90">Entrada</td>
          <td width="90">Saída</td>
          <td width="90">Saldo</td>
          <td></td>
        </tr>
    </thead>
</table>

    <table cellpadding="0" cellspacing="0" width="100%"  >
        <tbody>
        <?
			$conta_id = $venda_config->conta_id;
			//$filter_conta = "AND conta_id = '".$conta_id."'";
			
			if(empty($_GET["dta_inicio"])){
				$data_inicio = date("Y")."-".date("m")."-01";
				$data_fim    = date("Y")."-".date("m")."-".date("t");
			}else{
				$data_inicio = DataBrToUsa($_GET["dta_inicio"]);
				$data_fim    = DataBrToUsa($_GET["dta_fim"]); 
			}
			
			$filterData =  " AND ((data_movimento BETWEEN '$data_inicio 00:00:0000' AND '$data_fim 23:59:59') OR (data_info_movimento BETWEEN '$data_inicio' AND '$data_fim'))";
			
				
			if(!empty($_GET["conta_id"])){
				$conta_id = $_GET["conta_id"];
				$filter_conta = "AND conta_id = '".$conta_id."'";
			}
			
			$sql = mysql_query($t=" SELECT cliente_id, forma_pagamento,data_registro, SUM(valor_cadastro) AS total_recebido 
				FROM financeiro_movimento WHERE 1 $filterData  $filter_conta  AND cliente_id = '$vkt_id' AND status = '1' AND tipo='receber' AND extorno!='1'
				GROUP BY forma_pagamento ");
						
			$forma_entrada_pg = array();
			
			//Contas a pagar
			while($dados=mysql_fetch_object($sql)){
				  
				  $pg_entrada["forma"] = $dados->forma_pagamento;
				  $pg_entrada["total"] = $dados->total_recebido;
				  $forma_entrada_pg[] = $pg_entrada;
			}
			//print_r($forma_entrada_pg);
			$sql = mysql_query($t=" SELECT cliente_id, forma_pagamento,data_registro, SUM(valor_cadastro) AS total_recebido 
				FROM financeiro_movimento WHERE 1 $filterData  $filter_conta  AND cliente_id = '$vkt_id' AND status = '1' AND tipo='pagar'  AND extorno!='1'
				GROUP BY forma_pagamento");
			$forma_saida_pg = array();
			while($dados=mysql_fetch_object($sql)){
				 
				  $pg_saida["forma"] = $dados->forma_pagamento;
				  $pg_saida["total"] = $dados->total_recebido;
				  $forma_saida_pg[] = $pg_saida;
				  
			}
			
			//Contas a receber
			
		?>
            <tr align="right"> 
              <td width="200" align="left">Dinheiro</td>
              <!--Atributo ID refere-se a forma de pagamento.Ex: Dinheiro(1)-->
              <td width="90" class="cel_pagamento" id="1" tipo='receber'>
              <?
			  $total_entrada = 0;
			  $total_saida = 0;
			  $c=0;
			  $saldo=0;
			  for($i=0; $i < count($forma_entrada_pg);$i++ ){
                  // echo "Forma entrada de $i de forma=".$forma_entrada_pg[$i]["forma"]."<br>";
				  if($forma_entrada_pg[$i]["forma"] == 1){
					  echo moedaUsaToBr($forma_entrada_pg[$i]["total"]);
					  if(!$forma_entrada_pg[$i]["total"]>0){echo "0,00";}
					  $total_entrada+=$forma_entrada_pg[$i]["total"]; 
					  $saldo = $forma_entrada_pg[$i]["total"];
                 	  $c++; 
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
              ?>
        
              </td>
              <td width="90" class="cel_pagamento" id="1" tipo='pagar'>
              <?
			  $c=0;
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 1){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
					  $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	  $c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
              <td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Cheque</td>
            	<td width="90" class="cel_pagamento" id="2" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 2){
						
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	if(!$forma_entrada_pg[$i]["total"]>0){echo "0,00";}
						$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                 
					 	$c++;
					 }
				 }
				 if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="2" tipo='pagar'>
              <?
              $c=0;
			  for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 2){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                  	
					 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Boleto</td>
            	<td width="90" class="cel_pagamento" id="4" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 4){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	if(!$forma_entrada_pg[$i]["total"]>0){echo "0,00";}
						$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				 if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="4" tipo='pagar'>
              <?
			  $c=0;
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 4){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                  	  if(!$forma_saida_pg[$i]["total"]>0){echo "0,00";}
					 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	 $c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Permuta</td>
            	<td width="90" class="cel_pagamento" id="5" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 5){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	if(!$forma_entrada_pg[$i]["total"]>0){echo "0,00";}
						$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="5" tipo='pagar'>
              <?
			  $c=0;
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 5){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                  	  if(!$forma_saida_pg[$i]["total"]>0){echo "0,00";}
					 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				      $c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Outros</td>
            	<td width="90" class="cel_pagamento" id="6" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 6){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  
						$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="6" tipo='pagar'>
              <?
              $c=0;
			  for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 6){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                  	  
					 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Transferência</td>
            	<td width="90" class="cel_pagamento" id="7" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 7){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="7" tipo='pagar'>
              <?
              $c=0;
			  for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 7){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                 	 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Depósito</td>
            	<td width="90" class="cel_pagamento" id="8" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 8){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="8" tipo='pagar'>
              <?
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 8){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                	 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Cartao Crédito Visa</td>
            	<td width="90" class="cel_pagamento" id="3" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 3){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				 if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="3" tipo='pagar'>
              <?
			  $c=0;
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 3){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                  	  $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  		$c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Cartao Crédito Master</td>
            	<td width="90" class="cel_pagamento" id="9" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 9){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="9" tipo='pagar'>
              <?
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 9){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                  	  if(!$forma_saida_pg[$i]["total"]>0){echo "0,00";}
					 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  if(!$c>0){
			  		echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Débito Master</td>
            	<td width="90" class="cel_pagamento" id="10" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 10){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
						$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				 if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="10" tipo='pagar'>
              <?
			  $c=0;
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 10){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                	 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <!-- -->
            <tr align="right"> 
				<td width="200" align="left">Débito Visa</td>
            	<td width="90" class="cel_pagamento" id="11" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 11){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="11" tipo='pagar'>
              <?
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 11){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                	 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <tr align="right"> 
				<td width="200" align="left">Cielo Débito</td>
            	<td width="90" class="cel_pagamento" id="12" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 12){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="12" tipo='pagar'>
              <?
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 12){
                      echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                	 $total_saida+=$forma_saida_pg[$i]["total"];
					  $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  if(!$c>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
            <tr align="right"> 
				<td width="200" align="left">Cielo Crédito</td>
            	<td width="90" class="cel_pagamento" id="13" tipo='receber'>
				<?
				 $saldo=0;
				 $c=0;
				 for($i=0; $i < count($forma_entrada_pg);$i++ ){
                 	 if($forma_entrada_pg[$i]["forma"] == 13){
                      	echo moedaUsaToBr($forma_entrada_pg[$i]["total"]); 
					  	$total_entrada+=$forma_entrada_pg[$i]["total"];
						$saldo = $forma_entrada_pg[$i]["total"];                  
					 	$c++;
					 }
				 }
				if(!$c>0){
			  		echo "0,00";
			  	}
				?>
                </td>
                 <td width="90" class="cel_pagamento" id="13" tipo='pagar'>
              <?
              for($i=0; $i < count($forma_saida_pg);$i++ ){
                  if($forma_saida_pg[$i]["forma"] == 13){
                     echo moedaUsaToBr($forma_saida_pg[$i]["total"]);
                	 $saida = $forma_saida_pg[$i]["total"];
					 $total_saida+=$forma_saida_pg[$i]["total"];
					 $saldo-=$forma_saida_pg[$i]["total"];
				  	$c++;
				  }
              }
			  
			  if(!$saida>0){
			  	echo "0,00";
			  }
			  
              ?>
              </td>
              <td width="90">
              	<?=moedaUsaToBr($saldo)?>
              </td>
            	<td></td>
            </tr>
        <!-- -->
        </tbody>
    </table>
</div>
<div id="total">
<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="200">Total </td>
          <td width="85" style="text-align:right; padding-right:5px;">R$ <?=moedaUsaToBr($total_entrada)?></td>
          <td width="85" style="text-align:right; padding-right:5px;">R$ <?=moedaUsaToBr($total_saida)?></td>
          <td width="85" style="text-align:right; padding-right:5px;">R$ <?=moedaUsaToBr($total_entrada-$total_saida)?></td>
            <td></td>
        </tr>
    </thead>
</table>
</div>
</div>
<div id='rodape'>
	<script>
	$("#centro_escolha").click(function(){
		$("#centro").show();$("#plano").hide();$("#cliente").hide();
	})
	
	$("#plano_escolha").click(function(){
		$("#centro").hide();$("#plano").show();$("#cliente").hide();
	})
		
	
		
	$("#cliente_escolha").click(function(){
		$("#centro").hide();$("#plano").hide();$("#cliente").show();
	})
		
</script>
</div>
