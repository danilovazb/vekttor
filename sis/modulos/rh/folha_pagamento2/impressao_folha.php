<?php
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
$mesExtenso = array(1=>"Janeiro",2=>"Fevereiro",3=>"Março",4=>"Abril",5=>"Maio",6=>"Junho",7=>"Julho",8=>"Agosto",9=>"Setembro",10=>"Outubro",11=>"Novembro",12=>"Dezembro");
include"../../../_config.php";
include"../../../_functions_base.php";
	
	$folha_id = $_GET['folha_id'];
	
	$ResumoEvento["evento"]["vencimento"] = array();
	$ResumoEvento["evento"]["desconto"] = array();
	$options = array(
		"tipo_evento_vencimento" => "vencimento",
		"tipo_evento_desconto" => "desconto", 
	    "soma_salario_liquido" => 0,
		"soma_salario_base" => 0,
	    "soma_base_irrf" => 0,
	    "soma_base_inss" => 0,
	    "soma_base_fgts" => 0,
	    "soma_total_fgts" => 0,
	    "numero_func_listados" => 0,
	    "aviso_previo_indenizado" => 0,
		"funcionario_por_pagina" => 5,
		"qtd_funcionario" => 0
	);

	
					
    $sqlFOLHA = "  SELECT *, cf.razao_social AS nome_empresa, folha.mes AS mes_folha, folha.ano AS ano_folha, folha.empresa_id AS folha_empresa_id, folha.id AS folhaID
	FROM rh_folha AS folha 
		JOIN rh_empresas AS empresa ON empresa.cliente_fornecedor_id = folha.empresa_id
		JOIN cliente_fornecedor AS cf ON cf.id = empresa.cliente_fornecedor_id
		WHERE folha.id = '$folha_id' ";
		#AND folha.mes = '11' AND folha.ano = '2013'
	
	$folha = mysql_fetch_object(mysql_query($sqlFOLHA));

	$sql_funcionario = mysql_query($r=" SELECT *,
	 func.id AS func_id 
	 FROM rh_funcionario AS func 
		JOIN rh_folha_funcionario AS folha_func ON folha_func.funcionario_id = func.id 
		WHERE func.empresa_id = '".$folha->folha_empresa_id."' AND folha_func.folha_id = '".$folha->folhaID."' ORDER BY nome ASC  ");
	
		while($reg_func=mysql_fetch_array($sql_funcionario)){
			$funcionario[] = $reg_func;
		}	
		
?>
<style>
*{ box-sizing: border-box;-moz-box-sizing: border-box; }
body{ margin:0;padding:0;background-color:#FAFAFA;  font:11pt "Tahoma"}
.page{ width:20cm;  padding:0.5cm;  margin:1cm auto;  height:277mm; /*height:auto;*/  border:1px #D3D3D3 solid; background:white;  box-shadow:0 0 5px rgba(0,0,0,0.1);page-break-before:auto;}
.quebrapagina{page-break-after: always;}
hr{margin: 15px 0;border: 0;border-top: 1px solid #000;border-bottom: 1px solid #000;}
.title-funcionario{ text-transform:uppercase;}
.row{clear: both; width:100%;}
.row:before,
.row:after{display: table;line-height: 0;content: "";}
.row:after {clear: both;}
.row div{ padding:2px;}
.tableSemborda{ border:0}
.tableSemborda tr th{ border-bottom:0; font-size:9pt;}
.tableSemborda tr td{ font-size:9pt;}
.tableSemborda tbody tr td {border-left:0; padding:6px 5px;}
.tableSemborda tr:nth-child(even){background:#f3f3f3;}
table{ border-collapse:collapse;border-bottom:0;}
table tbody tr td {border-left:1px solid #000; padding:2px 5px;}
table tr th{ border-bottom:1px solid #000; font-size:9pt; padding:2px 5px;}
table tr td{ font-size:9pt;}
table tfoot tr th{ padding:-2px 8px;}
.tdSemBordaLeft{ border-left:0;}
.trSemBordaLeft td:first-child{ border-left:0;}
.trThSemBordaLeft th:first-child{ border-left:0;}
.footer-titulo{font-size:12px; padding-bottom:6px;}
.negrito{ font-weight:bold;}
.header{margin-bottom:30px;width:100%;}
.span{width:4%;}
.span1{ width:6%;}
.span1-5{width:20%;}
.span2{width:30%;}
.span3{width:40%;}
.span12{width:100%;clear:both;}
.clearboth{clear:both;}
.pull-left{float:left;}
.pull-right{float:right;}
.text-center{text-align:center;}
.text-right{text-align:right;}
.text-left{text-align:left;}
.Font10px{font-size:10px;}
.Font8pt{font-size:8pt;}
.Font9pt{font-size:9pt;}
.Font10pt{font-size:10pt;}
.Font12pt{font-size:12pt;}
.Font13pt{font-size:13pt;}
.backgroundTitulo{background:#f0f0f0;}
@page{ size: A4; margin:0; padding:0;}
@media print{
	.page{margin:0; border:initial; border-radius:initial; width:initial; min-height:initial; box-shadow:initial; background:initial; page-break-after:always}
	.backgroundTitulo{background:#f0f0f0;}
}
</style>
<?  $continua = 0;
    $options["qtd_funcionario"] = count($funcionario);
	
	$num_page =  ceil(count($funcionario)/$options["funcionario_por_pagina"]);
	for( $j= 0; $j < $num_page; $j++){
		
?>

<div class="page">
  <div class="header">
      <div class="row">
          <div class="backgroundTitulo" style="height:43px; clear:both;">
              <div class="pull-left span2" >Nasajon Sistemas</div> 
              <div class="pull-left span2 text-center ">Persona</div> 
              <div class="pull-right"> ANDRAY GUSTAVO BARBOSA DOS SANTOS</div> 
              <div class="pull-left span2 Font10px" ><? echo date("d/m/Y H:i:s")?></div> 
              <div class="pull-left span3 text-center"><?=$folha->nome_empresa?></div> 
              <div class="pull-right Font10px"> Página <?=($j+1)." de ".($num_page+2);?> </div> 
          </div>
          <div class="span12 text-center negrito Font13pt"> Folha de Pagamento de <?=$mesExtenso[$folha->mes_folha + 1];?>/<?=$folha->ano_folha?> <span class="pull-right">Mensal</span> </div>
          <div class="span12 text-center Font12pt" style="border-bottom:2px solid #000;"> Inclui: Folha, Férias, Rescisão, 13º, Salário, Fol. Comp., Resc. Comp., Dif, de Férias, 13º Complem </div>  
      </div>
  </div><!--/.header-->

  <div class="container" >
      <?php 
	  $cont = 0;
	  
	  for($i=$continua; $i < count($funcionario); $i++){ 
	    $cont++;
		$continua++;
		$options["numero_func_listados"]++;
		
	  ?>
      <div class="row" >
          <div class="pull-left span1 negrito"><?=$funcionario[$i]['numero_sequencial_empresa']?></div> 
          <div class="pull-left span3 text-left negrito title-funcionario"> <?=$funcionario[$i]["nome"]?> </div> 
          <div class="pull-right negrito Font10pt"> <? 
		  	$cargo = mysql_fetch_object( mysql_query($t=" SELECT * FROM cargo_salario WHERE vkt_id = '$vkt_id' AND id = '".$funcionario[$i]["cargo_id"]."' "));
			echo $cargo->cargo ?> 
          </div> 
          <div class="clearboth"></div>
          <div class="pull-left span2 Font10pt"> Data Adm. : &nbsp;&nbsp; <span><?=dataUsaToBr($funcionario[$i]["data_admissao"])?></span> </div> 
          <div class="pull-left span2 Font10pt"> Salário Contr. :  <span class="pull-right"><?=moedaUsaToBr($funcionario[$i]["salario_base"])?></span>  </div>
          <div class="pull-right span2 Font10pt" style="border-bottom:1px solid #000"> &nbsp;  </div> 
          <div class="pull-right span1 Font10pt" > Assin.: </div> 
      </div><br/>
      
      <div class="row" style="border-bottom:1px solid #000">
        
       <!--TOTAL-->
       <table style="width:23%;float:left" class="table">
          <thead>
              <tr class="trThSemBordaLeft backgroundTitulo">
                  <th class="span1-5 text-left" colspan="2">Totais</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                <td class="negrito tdSemBordaLeft">Salário Liq.:</td>
                <td class="text-right tdSemBordaLeft"><?
                $options["soma_salario_liquido"] += $funcionario[$i]["salario_liquido"];
				echo moedaUsaToBr($funcionario[$i]["salario_liquido"])
				?></td>
              </tr>
              <tr>
                <td class="negrito tdSemBordaLeft">Base IRRF: </td>
                <td class="text-right tdSemBordaLeft"><?
                $options["soma_base_irrf"] += $funcionario[$i]["base_irrf"];
				echo moedaUsaToBr($funcionario[$i]["base_irrf"])?></td>
              </tr>
              <tr>
                <td class="negrito tdSemBordaLeft">Base INSS</td>
                <td class="text-right tdSemBordaLeft"><?
                $options["soma_base_inss"] += $funcionario[$i]["base_inss"]; 
				echo moedaUsaToBr($funcionario[$i]["base_inss"]);
				?></td>
              </tr>
              <tr>
                <td class="negrito tdSemBordaLeft">Base FGTS:</td>
                <td class="text-right tdSemBordaLeft"><?
				$options["soma_base_fgts"] += $funcionario[$i]["base_fgts"];
                echo moedaUsaToBr($funcionario[$i]["base_fgts"])?></td>
              </tr>
              <tr>
                <td class="negrito tdSemBordaLeft">Valor FGTS:</td>
                <td class="text-right tdSemBordaLeft"><?
				$options["soma_total_fgts"] += $funcionario[$i]["total_fgts"];
                echo moedaUsaToBr($funcionario[$i]["total_fgts"])?></td>
               </tr>
              </tr>
          </tbody>
       </table>
           
       <!--RENDIMENTO-->
         <table style="width:40%; float:left;" class="table"> <? $TotalRendimentos = 0; ?>
          <thead>
              <tr class="trThSemBordaLeft backgroundTitulo">
                  <th class="span1-5 text-left">Rendimentos</th>
                  <th class="span1 text-left">Valor</th>
                  <th class="text-left" style="width:3%;">Ref.</th>
              </tr>
          </thead>
          <tbody>
            <? ?>
              <tr>
                <td class="tdSemBordaLeft">Salário Base</td>
                <td class="tdSemBordaLeft"><?
				    $options["soma_salario_base"] += $funcionario[$i]["salario_base"];
					$TotalRendimentos = ($funcionario[$i]["salario_base"]);
					
					echo moedaUsaToBr($funcionario[$i]["salario_base"]); 
				 ?></td>
                <td class="tdSemBordaLeft"></td>
              </tr>
              <? $sqlEventoVencimento =  mysql_query($t1=" 
                 SELECT * FROM rh_folha_funcionarios_eventos AS evento 
                    WHERE evento.funcionario_id = '".$funcionario[$i]['func_id']."' 
                    AND evento.vencimento_ou_desconto = '".$options["tipo_evento_vencimento"]."'   
                    AND evento.folha_id = '".$folha->folhaID."' AND
					evento.valor_real > 0 AND
					tributaveis='sim'"); 
                    
                    while($eventoVencimento=mysql_fetch_array($sqlEventoVencimento)){
                        $TotalRendimentos += $eventoVencimento[valor_real];
						
						if($eventoVencimento["evento_id"] == 0){
							$eventoDefault["evento"]["vencimento"][] = $eventoVencimento["nome"];	 
					 	}
						
						$ResumoEvento["evento"]["vencimento"][] = $eventoVencimento["evento_id"];
						
              ?>
              <tr>
                <td class="tdSemBordaLeft"><?=$eventoVencimento[nome];?></td>
                <td class="tdSemBordaLeft"><?=moedaUsaToBr($eventoVencimento[valor_real])?></td>
                <td class="tdSemBordaLeft"><?=moedaUsaToBr($eventoVencimento[referencia])?></td>
              </tr>
            <? } ?>
          </tbody>
           <tfoot>
              <tr>
                <th style="border-bottom:0;" class="negrito text-left ">Total Rendimentos</th>
                <th style="border-bottom:0;" class="text-left"><?=number_format($TotalRendimentos,2,",",".");?></th>
                <th style="border-bottom:0;" class="text-left" style="width:3%;"></th>
              </tr>
          </tfoot>
       </table>
           
       <!--DESCONTO -->
       <table style="width:37%;" class="table"> <? $TotalDesconto = 0;?>
          <thead>
              <tr class="trThSemBordaLeft backgroundTitulo">
                  <th class="text-left" style="width:70%">Desconto</th>
                  <th class="text-left" style="width:30%">Valor</th>
                  <th class="text-left" style="width:3%;">Ref.</th>
              </tr>
          </thead>
          <tbody>
              <? $sqlEventoDesconto =  mysql_query($t1=" 
                 SELECT * FROM rh_folha_funcionarios_eventos AS evento 
                    WHERE evento.funcionario_id = '".$funcionario[$i]['func_id']."' 
                    AND evento.vencimento_ou_desconto = '".$options["tipo_evento_desconto"]."'   
                    AND evento.folha_id = '".$folha->folhaID."' "); 
                
                 while($eventoDesconto=mysql_fetch_array($sqlEventoDesconto)){
					 if($eventoDesconto["evento_id"] == 0){
						$eventoDefault["evento"]["desconto"][] = $eventoDesconto["nome"];	 
					 }
					 
					 $TotalDesconto += $eventoDesconto[valor_real];
					 $ResumoEvento["evento"]["desconto"][] = $eventoDesconto["evento_id"];
              ?>
              <tr>
                <td class="tdSemBordaLeft"><?=$eventoDesconto[nome]?></td>
                <td class="tdSemBordaLeft"><?=moedaUsaToBr($eventoDesconto[valor_real])?></td>
                <td class="tdSemBordaLeft"><?=moedaUsaToBr($eventoDesconto[referencia])?></td>
              </tr>
              <? }?>
          </tbody>
           <tfoot>
              <tr >
                <th style="border-bottom:0;" class="negrito text-left">Total Descontos:</th>
                <th style="border-bottom:0;" class="text-left"><?=number_format($TotalDesconto,2,",",".");?></th>
                <th style="border-bottom:0;" class="text-left" style="width:3%;"></th>
              </tr>
          </tfoot>
       </table>
             
      </div>
      <br>
      <? if($cont == 4){break;} } ?>
  </div><!--/.container-->

</div><!--/.page-->

<? } ?>


<?php
  function SomaEventoRendimentos($evento_id, $folha_id){
	  $soma =  mysql_fetch_object(mysql_query(" 
		  SELECT SUM(valor_real) AS soma_evento FROM rh_folha_funcionarios_eventos 
		  WHERE evento_id = '".trim($evento_id)."' 
		  AND folha_id = '".$folha_id."' 
		  AND vencimento_ou_desconto = 'vencimento' "));
	  if($soma->soma_evento > 0)
		  return $soma->soma_evento;
	  else
		  return  0;
  }
  
  function SomaEventoDescontos($evento_id, $folha_id){
	  $soma =  mysql_fetch_object(mysql_query(" 
		  SELECT SUM(valor_real) AS soma_evento FROM rh_folha_funcionarios_eventos 
		  WHERE evento_id = '".trim($evento_id)."' 
		  AND folha_id = '".$folha_id."' 
		  AND vencimento_ou_desconto = 'desconto' "));
	  if($soma->soma_evento > 0)
		  return $soma->soma_evento;
	  else
		  return  0;
  }
  
  //Soma de Eventos Default
  function SomaEventoDefaultVencimento($EventoNome, $folha_id){
	 $soma =  mysql_fetch_object(mysql_query($t=" 
		  SELECT SUM(valor_real) AS soma_evento FROM rh_folha_funcionarios_eventos 
		  WHERE nome = '".trim($EventoNome)."' 
		  AND folha_id = '".$folha_id."' 
		  AND vencimento_ou_desconto = 'vencimento' "));
	  
	  if($soma->soma_evento > 0)
		 return $soma->soma_evento;
	  else
		  return  0;
	    
  }
  
  function SomaEventoDefaultDesconto($EventoNome, $folha_id){
	 $soma =  mysql_fetch_object(mysql_query($t=" 
		  SELECT SUM(valor_real) AS soma_evento FROM rh_folha_funcionarios_eventos 
		  WHERE nome = '".trim($EventoNome)."' 
		  AND folha_id = '".$folha_id."' 
		  AND vencimento_ou_desconto = 'desconto' "));
	  
	  if($soma->soma_evento > 0)
		 return $soma->soma_evento;
	  else
		  return  0;
	    
  }
  
?>

<div class="page"> <!-- Página de Resumo -->
  <? $num_ultima = $num_page + 2; ?>
  <div class="header">
      <div class="row">
          <div class="backgroundTitulo" style="height:43px; clear:both;">
              <div class="pull-left span2" >Nasajon Sistemas</div> 
              <div class="pull-left span2 text-center ">Persona</div> 
              <div class="pull-right"> ANDRAY GUSTAVO BARBOSA DOS SANTOS</div> 
              <div class="pull-left span2 Font10px" ><? echo date("d/m/Y H:i:s")?></div> 
              <div class="pull-left span3 text-center"><?=$folha->nome_empresa?></div> 
              <div class="pull-right Font10px">Página <?=($num_ultima-1)." de ".$num_ultima?></div> 
          </div>
          <div class="span12 text-center negrito Font13pt"> Folha de Pagamento de <?=$mesExtenso[$folha->mes_folha + 1];?>/<?=$folha->ano_folha?> <span class="pull-right">Mensal</span> </div>
          <div class="span12 text-center Font12pt" style="border-bottom:2px solid #000;"> Inclui: Folha, Férias, Rescisão, 13º, Salário, Fol. Comp., Resc. Comp., Dif, de Férias, 13º Complem </div>  
      </div>
  </div><!--/.header-->
    
    <div class="footer">
  	  <h4 class="text-center">Resumo por Evento</h4>
      <div class="row">
          <? 
		  	//print_r($ResumoEvento["evento"]["vencimento"]);
		    //print_r($ResumoEvento["evento"]["desconto"]);
			if(!sizeof($ResumoEvento["evento"]["vencimento"])>0){
				$ResumoEventoGeral = array_unique(array_merge($ResumoEvento["evento"]["vencimento"], $ResumoEvento["evento"]["desconto"]));
			}
			
			$ResumoEventoGeral = array_unique(array_merge($ResumoEvento["evento"]["vencimento"], $ResumoEvento["evento"]["desconto"]));
		  	
			if(!sizeof($eventoDefault["evento"]["vencimento"])>0){
				$ResumoEventoDefault = array_unique($eventoDefault["evento"]["desconto"]);
			}else if(!sizeof($eventoDefault["evento"]["desconto"])>0){
				$ResumoEventoDefault = array_unique($eventoDefault["evento"]["vencimento"]);
			}else{
				$ResumoEventoDefault = array_unique(array_merge($eventoDefault["evento"]["vencimento"], $eventoDefault["evento"]["desconto"]));
			}
			
			//pr($eventoDefault["evento"]["vencimento"]);
			//pr($ResumoEventoDefault);
		  ?>
          <table style="width:75%; margin:auto;" class="tableSemborda">
              <thead>
                  <tr class="backgroundTitulo">
                  	<!--<th class="text-left">Evento</th>-->
                    <th class="text-left">Descrição</th>
                    <th class="text-left">Rendimentos</th>
                    <th class="text-left">Descontos</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                	<!--<td class="text-left"><?=$valor["evento_id"]?></td>-->
                    <td>Salário Base</td>
                    <td><?=moedaUsaToBr($options["soma_salario_base"])?></td>
                    <td><?=$SomaDescontos?></td>	
                </tr>
              	<? 
				  $SomaRendimentos = 0; $SomaDescontos = 0;
				  foreach($ResumoEventoGeral as $chave => $valor){
					if( !empty($valor["evento_id"]) ){
					  $SomaRendimentos = moedaUsaToBr(SomaEventoRendimentos($valor["evento_id"],$folha->folhaID));
					  $SomaDescontos = moedaUsaToBr(SomaEventoDescontos($valor["evento_id"],$folha->folhaID));
					  $evento_nome = mysql_fetch_object(mysql_query(" SELECT * FROM rh_eventos WHERE id = '".trim($valor["evento_id"])."' "));
				?>
                <tr>
                	<!--<td class="text-left"><?=$valor["evento_id"]?></td>-->
                    <td><?=$evento_nome->nome;?></td>
                    <td><?=$SomaRendimentos?></td>
                    <td><?=$SomaDescontos?></td>	
                </tr>
               <? 
				    }
				}
				foreach($ResumoEventoDefault as $chave => $valor){
					$SomaRendimentos = moedaUsaToBr(SomaEventoDefaultVencimento($valor,$folha->folhaID));
					$SomaDescontos = moedaUsaToBr(SomaEventoDefaultDesconto($valor,$folha->folhaID));
			   ?>
               
                <tr>
                	<!--<td></td>-->
                    <td><?=$valor?></td>
                    <td><?=$SomaRendimentos?></td>
                    <td><?=$SomaDescontos?></td>	
                </tr>
                <?php
				}
				?>
              </tbody>
          </table>
      </div>
  </div><!--/.footer-->
</div>

<div class="page"> <!--/.Última página -->
	<div class="header">
      <div class="row">
          <div class="backgroundTitulo" style="height:43px; clear:both;">
              <div class="pull-left span2" >Nasajon Sistemas</div> 
              <div class="pull-left span2 text-center ">Persona</div> 
              <div class="pull-right"> ANDRAY GUSTAVO BARBOSA DOS SANTOS</div> 
              <div class="pull-left span2 Font10px" ><? echo date("d/m/Y H:i:s")?></div> 
              <div class="pull-left span3 text-center"><?=$folha->nome_empresa?></div> 
              <div class="pull-right Font10px">Página <?=($num_ultima)." de ".$num_ultima?></div> 
          </div>
          <div class="span12 text-center negrito Font13pt"> Folha de Pagamento de <?=$mesExtenso[$folha->mes_folha + 1];?>/<?=$folha->ano_folha?> <span class="pull-right">Mensal</span> </div>
          <div class="span12 text-center Font12pt" style="border-bottom:2px solid #000;"> Inclui: Folha, Férias, Rescisão, 13º, Salário, Fol. Comp., Resc. Comp., Dif, de Férias, 13º Complem </div>  
      </div>
  </div><!--/.header-->
  
  <div class="container">
    
          <table style="width:75%; margin:auto;" class="tableSemborda">
              <tbody>
                <tr>
                	<td>40R1</td>
                    <td>Aviso Prévio Indenizado</td>
                    <td>(-)</td>
                    <td></td>	
                </tr>
                <tr>
                	<td>40V1</td>
                    <td>Valor pago na Rescisão</td>
                    <td></td>
                    <td>(-)</td>	
                </tr>
                <tr>
                	<td>9R14</td>
                    <td>Serviços Diversos</td>
                    <td>(-)</td>
                    <td></td>	
                </tr>
                <tr>
                	<td></td>
                    <td></td>
                    <td>(-)</td>
                    <td>(-)</td>	
                </tr>
              </tbody>
          </table><br/>
          
          <div class="row">
            
            <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left  Font9pt negrito" style="width:53%;" >Salário Líquido</div> 
              <div class="pull-left span1 text-center Font9pt ">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_salario_liquido"],2,",",".")?></div> 
            </div> 
            
            <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left  Font9pt negrito" style="width:53%;" >Base de INSS</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_base_inss"],2,",",".")?></div> 
            </div> 
            
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" > Base de IRRF </div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_base_irrf"],2,",",".")?></div> 
             </div>
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >Base de FGTS</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_base_fgts"],2,",",".")?></div> 
             </div>
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >Total de FGTS</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_total_fgts"],2,",",".")?></div> 
             </div> 
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >FGTS a Recolher (Sefip)</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"></div> 
             </div> 
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >Multa do FGTS</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"></div> 
             </div> 
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >No. de Funcionários listados</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=$options["numero_func_listados"]?></div> 
             </div>  
            
          </div> <!--/.row-->
          
          <hr>
          
          <div class="row">
            
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left  Font9pt negrito" style="width:53%;" >Salário Líquido</div> 
              <div class="pull-left span1 text-center Font9pt ">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_salario_liquido"],2,",",".")?></div> 
            </div> 
            
            <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left  Font9pt negrito" style="width:53%;" >Base de INSS</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_base_inss"],2,",",".")?></div> 
            </div> 
            
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" > Base de IRRF </div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_base_irrf"],2,",",".")?></div> 
             </div>
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >Base de FGTS</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_base_fgts"],2,",",".")?></div> 
             </div>
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >Total de FGTS</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=number_format($options["soma_total_fgts"],2,",",".")?></div> 
             </div> 
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >FGTS a Recolher (Sefip)</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"></div> 
             </div> 
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >Multa do FGTS</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"></div> 
             </div> 
             
             <div style="clear:both; width:48%; margin:auto;">
              <div class="pull-left Font9pt negrito" style="width:53%;" >No. de Funcionários listados</div> 
              <div class="pull-left span1 text-center Font9pt">:</div> 
              <div class="pull-left span2 text-right Font9pt"><?=$options["numero_func_listados"]?></div> 
             </div>
            
          </div> <!--/.row-->
     
    </div><!--/.container-->	
  
</div><!--/.Última Página-->