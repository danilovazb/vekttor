<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_functions.php");
include("_ctrl.php");

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
	$("#dados tr.aplicavel:nth-child(2n+1)").addClass('al');
})

var tabAtual = 1
 
mudarTab = function(numeroTab) {
	$("#tab_"+tabAtual).toggle()
	$("#tab_"+numeroTab).toggle()
	tabAtual = numeroTab
}
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <!--<input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>-->
    <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_GET[busca]?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/politicos/busca_politico.php,@r0,0'/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s1'>
    Eleitoral 
</a>
<a href="./" class='s2'>
    Cadastros 
</a>
<a href="" class="navegacao_ativo">
<span></span>  Politicos</a></div>
<div id="barra_info">
<form>
<label>
    	<select name="pesquisa_cargo" onchange="this.form.submit();" method="post">
        	<option value="">TODOS OS CARGOS</option>
            <option value="vereador" <? if($_GET['pesquisa_cargo']=="vereador"){echo "selected";}?>>Vereador</option>
            <option value="prefeito" <? if($_GET['pesquisa_cargo']=="prefeito"){echo "selected";}?>>Prefeito</option>
            <option value="Deputado Estadual" <? if($_GET['pesquisa_cargo']=="Deputado Estadual"){echo "selected";}?>>Deputado Estadual</option>
            <option value="Deputado Federal" <? if($_GET['pesquisa_cargo']=="Deputado Federal"){echo "selected";}?>>Deputado Federal</option>
            <option value="governador" <? if($_GET['pesquisa_cargo']=="governador"){echo "selected";}?>>Governador</option>
            <option value="senador" <? if($_GET['pesquisa_cargo']=="senador"){echo "selected";}?>>Senador</option>
            <option value="presidente" <? if($_GET['pesquisa_cargo']=="presidente"){echo "selected";}?>>Presidente</option>
        </select>
  <!--<input type="submit" name="filtrar" value="Filtrar" />-->
  <input type="hidden" name="tela_id" value="141" />
 </label>
<a href="<?=$caminho?>/form_vereador.php" target="carregador" class="mais"></a>
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="120"><?=linkOrdem("Nome","nome",0)?></td>
             <td width="100"><?=linkOrdem("Cargo Pretendido","Cargo Pretendido",0)?></td>
            <td width="50"><?=linkOrdem("Partido","partido",0)?></td>
          	<td width="200"><?=linkOrdem("Coligacao","Coligacao",0)?></td>
            <td width="80">Votos</td>
            <td width="40">%</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="dados">
	<?
	function ordena($a,$b){
					if($a['votos']<$b['votos']){
						return -1;
					}elseif($a['votos']>$a['votos']){
						return 1;
					}
				}
		$cargos = array("vereador","prefeito","Deputado Estadual","Deputado Federal","governador","senador","presidente");
		if(empty($_GET['pesquisa_cargo']) and empty($_GET['busca'])){
			foreach($cargos as $cargo){
				//echo $cargo."<br>";
				$total_votos=0;
				$vereadores_q=mysql_query($trace="SELECT * FROM eleitoral_politicos WHERE cargo='".$cargo."' AND vkt_id=$vkt_id");
				
				$total_eleitores=mysql_fetch_object(mysql_query($trace="SELECT COUNT(i.id) as qtd 
				FROM eleitoral_intencoes_voto as i, eleitoral_politicos as p
				WHERE
				p.id = i.politico_id
				AND i.status='1'
				AND (i.eleitor_id!='0' OR i.colaborador_id!='0')
				AND i.status_voto='sim'
				AND p.cargo='$cargo'
				AND i.vkt_id='$vkt_id' 
				"));
				//echo $trace."<br>";
				$total_votos=$total_eleitores->qtd;
				//echo $total_votos."<br><br>";
				$cont=0;
				unset($porc);
				while($vereador=mysql_fetch_object($vereadores_q)){
					//porc[][0]=$vereador->id;
					
					$qtd_votos = mysql_fetch_object(mysql_query($trace="SELECT COUNT(*) as soma FROM eleitoral_intencoes_voto WHERE politico_id='".$vereador->id."' and status='1'"));
					//$porc[$qtd_votos->soma]['id']=$vereador->id;
					$porc[$cont]['votos']= $qtd_votos->soma;
					$porc[$cont]['id']= $vereador->id;
					$porc[$cont]['nome']= $vereador->nome;
					$cont++;		
				}
				
			if(isset($porc)){
				array_multisort($porc,SORT_DESC);
				
			foreach($porc as $porcentagem){
		?>
        	<tr class="aplicavel" onclick="window.open('<?=$caminho?>/form_vereador.php?idvereador=<?=$porcentagem['id']?>','carregador')">
            	<td width="120"><?=$porcentagem['nome']?></td>
            	<td width="100"><?=$cargo?></td>
            	<?
            		$nomepartido = mysql_fetch_object(mysql_query($trace="SELECT p.sigla as sigla FROM eleitoral_partidos as p, eleitoral_politicos as pol WHERE p.id=pol.partido_id AND pol.id='".$porcentagem['id']."'"));
					//echo $trace."<br>";
				?>
            	<td width="50"><?=$nomepartido->sigla?></td>
            	<?
            		$nomecoligacao = mysql_fetch_object(mysql_query($trace="SELECT c.nome as nome FROM eleitoral_coligacoes as c, eleitoral_politicos as pol WHERE c.id=pol.coligacao_id AND pol.id='".$porcentagem['id']."'"));
					//echo $trace."<br>";
				?>
          		<td width="200"><?=$nomecoligacao->nome?></td>
            	<?
            		
					//echo $trace."<br>";
				?>
                <td width="80"><?=$porcentagem['votos']?></td>
            	<td width="40"><? if($total_votos!=0){echo number_format(($porcentagem['votos']/$total_votos)*100,'2','.',',');}else{echo "0.00";}?></td>
               	<td></td>
        		</tr>
		<?
				}
			}
				//}
			}
		}else if($_GET['pesquisa_cargo']){
				
				$vereadores_q=mysql_query($trace="SELECT * FROM eleitoral_politicos WHERE cargo='".$_GET['pesquisa_cargo']."' AND vkt_id=$vkt_id");
				//echo $trace;
				$total_eleitores=mysql_fetch_object(mysql_query($trace="SELECT COUNT(i.id) as qtd 
				FROM eleitoral_intencoes_voto as i, eleitoral_politicos as p
				WHERE
				p.id = i.politico_id
				AND i.status='1'
				AND (i.eleitor_id!='0' OR i.colaborador_id!='0')
				AND i.status_voto='sim'
				AND p.cargo='".$_GET['pesquisa_cargo']."'
				AND i.vkt_id='$vkt_id' 
				"));
				//echo $trace."<br>";
				$total_votos=$total_eleitores->qtd;
				//echo $total_votos."<br><br>";
				$cont=0;
				unset($porc);
				while($vereador=mysql_fetch_object($vereadores_q)){
					//porc[][0]=$vereador->id;
					
					$qtd_votos = mysql_fetch_object(mysql_query($trace="SELECT COUNT(*) as soma FROM eleitoral_intencoes_voto WHERE politico_id='".$vereador->id."' and status='1'"));
					//$porc[$qtd_votos->soma]['id']=$vereador->id;
					$porc[$cont]['votos']= $qtd_votos->soma;
					$porc[$cont]['id']= $vereador->id;
					$porc[$cont]['nome']= $vereador->nome;
					$cont++;		
				}
				
			if(isset($porc)){
				array_multisort($porc,SORT_DESC);
				
			foreach($porc as $porcentagem){
		?>
        	<tr class="aplicavel" onclick="window.open('<?=$caminho?>/form_vereador.php?idvereador=<?=$porcentagem['id']?>','carregador')">
            	<td width="120"><?=$porcentagem['nome']?></td>
            	<td width="100"><?=$_GET['pesquisa_cargo']?></td>
            	<?
            		$nomepartido = mysql_fetch_object(mysql_query($trace="SELECT p.sigla as sigla FROM eleitoral_partidos as p, eleitoral_politicos as pol WHERE p.id=pol.partido_id AND pol.id='".$porcentagem['id']."'"));
					//echo $trace."<br>";
				?>
            	<td width="50"><?=$nomepartido->sigla?></td>
            	<?
            		$nomecoligacao = mysql_fetch_object(mysql_query($trace="SELECT c.nome as nome FROM eleitoral_coligacoes as c, eleitoral_politicos as pol WHERE c.id=pol.coligacao_id AND pol.id='".$porcentagem['id']."'"));
					//echo $trace."<br>";
				?>
          		<td width="200"><?=$nomecoligacao->nome?></td>
            	<?
            		
					//echo $trace."<br>";
				?>
                <td width="80"><?=$porcentagem['votos']?></td>
            	<td width="40"><? if($total_votos!=0){echo number_format(($porcentagem['votos']/$total_votos)*100,'2','.',',');}else{echo "0.00";}?></td>
               	<td></td>
        		</tr>
		<?
				}
			}
				//}
			//}
		}else{
			
				$vereadores_q=mysql_query($trace="SELECT * FROM eleitoral_politicos WHERE nome LIKE '%".$_GET['busca']."%' AND vkt_id=$vkt_id");
				//echo $trace;
				while($vereador=mysql_fetch_object($vereadores_q)){
					//echo $trace;
					$total_eleitores=mysql_fetch_object(mysql_query($trace="SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto INNER JOIN eleitoral_politicos WHERE eleitoral_intencoes_voto.politico_id = 
					eleitoral_politicos.id AND status='1' and eleitoral_intencoes_voto.status_voto='sim' and eleitoral_politicos.cargo='".$vereador->cargo."' and eleitoral_intencoes_voto.eleitor_id!='0' AND
					eleitoral_intencoes_voto.vkt_id=$vkt_id"));
					//echo $trace;
					$total_colaboradores=mysql_fetch_object(mysql_query($trace="SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto INNER JOIN eleitoral_politicos WHERE eleitoral_intencoes_voto.politico_id = 
					eleitoral_politicos.id AND status='1' and eleitoral_intencoes_voto.status_voto='sim' and eleitoral_politicos.cargo='".$vereador->cargo."' and eleitoral_intencoes_voto.colaborador_id!='0'
					AND	eleitoral_intencoes_voto.vkt_id=$vkt_id"));
					
					$total_votos=$total_colaboradores->qtd+$total_eleitores->qtd;
		?>	
				        	<tr class="aplicavel" onclick="window.open('<?=$caminho?>/form_vereador.php?idvereador=<?=$vereador->id?>','carregador')">
            	<td width="120"><?=$vereador->nome?></td>
            	<td width="100"><?=$vereador->cargo?></td>
            	<?
            		$nomepartido = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_partidos WHERE id='".$vereador->partido_id."'"));
				?>
            	<td width="50"><?=$nomepartido->sigla?></td>
            	<?
            		$nomecoligacao = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_coligacoes WHERE id='".$vereador->coligacao_id."'"));
				?>
          		<td width="200"><?=$nomecoligacao->nome?></td>
            	<?
            		$qtd_votos = mysql_fetch_object(mysql_query($trace="SELECT COUNT(*) as soma FROM eleitoral_intencoes_voto WHERE politico_id='".$vereador->id."' and status='1'"));
					//echo $trace."<br>";
				?>
                <td width="80"><?=$qtd_votos->soma?></td>
            	<td width="40"><? if($total_votos!=0){echo number_format(($qtd_votos->soma/$total_votos)*100,'2','.',',');}else{echo "0.00";}?></td>
               	<td></td>
        		</tr>						
		<?
				}
		}
	?>
    </tbody>
</table>
</div>
</div>
<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>