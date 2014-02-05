<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s1'>
    Imobili&aacute;ria 
</a><a href="?" class='s2'>
  	Relat&oacute;rios
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span>    Comissão por Corretor
</a>
</div>
<?php
			if(isset($_GET['ano'])){
					$ano = 	$_GET['ano'];
			} else {
					$ano = date('Y');	
			}
?>
<div id="barra_info">
	<div style="float:left;">
    	<form method="get">
        	<input type="hidden" name="tela_id" value="268" />
        	<input type="text" name="ano" value="<?php echo $ano;?>" size="5">
            <label>Empreendimentos
            <select name="empreendimento_id">
            	<option value="0">Todos</option>
                <? $empreendimentos_q=mysql_query("SELECT * FROM empreendimento WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
				while($empreendimento=mysql_fetch_object($empreendimentos_q)){
					if($_GET[empreendimento_id]==$empreendimento->id){ $sel='selected="selected"';}else{$sel='';}
					?>
                    <option <?=$sel?> value="<?=$empreendimento->id?>"><?=$empreendimento->nome?></option>
                    <?
				}
				?>
                
            </select>
            </label>
            <input type="submit" name="filtrar" value="Filtar">
        </form>
    </div>
  <strong style="margin-left:10px;">ANO: 
    <?=$ano?></strong>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/corretor/corretor/form.php?id='+id,'carregador');
	});
});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="150">Corretor</td>
          <td width="55">Jan</td>
          <td width="55">Fev</td>
          <td width="55">Mar</td>
          <td width="55">Abr</td>
          <td width="55">Mai</td>
          <td width="55">Jun</td>
          <td width="55">Jul</td>
          <td width="55">Agos</td>
          <td width="55">Set</td>
          <td width="55">Out</td>
          <td width="55">Nov</td>
          <td width="55">Dez</td>
          <td width="55">Ano</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
	
	//filtro por empreendimento
	if($_GET[empreendimento_id]>0){
		$filtro_empreendimento=" AND c.empreendimento_id='{$_GET[empreendimento_id]}' ";}else{$filtro_empreendimento='';
	}
		$sql = mysql_query("SELECT * FROM corretor WHERE vkt_id='$vkt_id' ORDER BY nome ASC");
			
				while($r=mysql_fetch_object($sql)){
					$total_ano=0;
						$id_corretor[] = $r->id; 
		
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" onclick="location.href='?tela_id=180&id_total=<?=$r->id?>&nome=<?=$r->nome?>'" >
          <td width="150"><?=$r->nome;?></td>
          <?php 
		 $contrato=mysql_fetch_object(mysql_query("
		 SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '01' "));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php 
		  $contrato=mysql_fetch_object(mysql_query("SELECT  SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '02'"));$total_ano+=$contrato->total_comissao; 
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
           $contrato=mysql_fetch_object(mysql_query("SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '03'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
           $contrato=mysql_fetch_object(mysql_query("SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '04'"));$total_ano+=$contrato->total_comissao; 
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php 
		 $contrato=mysql_fetch_object(mysql_query("SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '05'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
          $contrato=mysql_fetch_object(mysql_query($a="SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '06'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
           $contrato=mysql_fetch_object(mysql_query("SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '07'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
           $contrato=mysql_fetch_object(mysql_query("SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '08'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
           $contrato=mysql_fetch_object(mysql_query("SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '09'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
           $contrato=mysql_fetch_object(mysql_query("SELECT SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '10'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
           $contrato=mysql_fetch_object(mysql_query("SELECT  SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '11'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <?php
           $contrato=mysql_fetch_object(mysql_query("SELECT  SUM(valor_comissao) as total_comissao FROM contrato AS c WHERE YEAR(c.data_fechamento) = '".$ano."' AND c.situacao = '2' AND corretor_id = '".$r->id."' $filtro_empreendimento AND MONTH(c.data_fechamento)= '12'"));$total_ano+=$contrato->total_comissao;
		  ?>
          <td width="55"><?=moedaUsaToBr($contrato->total_comissao);?></td>
          <td width="55"><?=moedaUsaToBr($total_ano)?></td>
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
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="55"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
