<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
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
</a><a href="" class='s2'>
  	Relat&oacute;rios
</a>
<a href="" class='navegacao_ativo'>
<span></span>    Cliente Ramo Atividade
</a>
</div>

<div id="barra_info">
	<div style="float:left; margin-top:1.5px;">
    	<form method="get">
        	<input type="hidden" name="tela_id" value="173" />
        	<select name="ramo" id="ramo">
            <option value="0">Todos</option>
            	<?php 
					
					$sql = mysql_query($t="SELECT distinct ramo_atividade,id FROM cliente_fornecedor WHERE ramo_atividade <> '' AND cliente_vekttor_id = '$vkt_id' AND usuario_id='$login_id' GROUP BY ramo_atividade");
						
							while($r=mysql_fetch_object($sql)){
								if($_GET['ramo'] == $r->ramo_atividade){$sell='selected="selected"';}else{$sell='';}
									if($r->ramo_atividade != null){
				?>
            							<option <?=$sell?> value="<?php echo $r->ramo_atividade;?>" ><?php echo $r->ramo_atividade; ?> </option>
                <?php 				}
						}
				?>
            </select>
            <input type="submit" value="Filtrar">
        </form>
    </div>
  
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="300">Ramo Atividade</td>
          <td width="70">Qtd Cliente</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
	
			if(isset($_GET['ramo'])){
					if(isset($_GET['ramo']) && $_GET['ramo']!='' && $_GET['ramo']!='0'){
						$and = " AND ramo_atividade = '".htmlspecialchars($_GET['ramo'])."'";
					}
			}
			
		$sql = mysql_query($y="SELECT DISTINCT(ramo_atividade) FROM cliente_fornecedor WHERE ramo_atividade <> '' AND cliente_vekttor_id = '$vkt_id' AND usuario_id='$login_id' $and GROUP BY ramo_atividade ORDER BY ramo_atividade
");
			//echo $y;
				while($r=mysql_fetch_object($sql)){
					
					$qtd_cliente = mysql_fetch_object(mysql_query("SELECT COUNT(ramo_atividade) AS cont FROM cliente_fornecedor WHERE ramo_atividade  = '".$r->ramo_atividade."' AND cliente_vekttor_id = '$vkt_id' AND usuario_id='$login_id' GROUP BY ramo_atividade"));
						
		
	?>      
    	<tr <?=$sel?> onclick="window.open('modulos/corretor/cadastro_clientes/form.php?id=<?=$r->id?>','carregador')">
          <td width="300"><?=$r->ramo_atividade;?></td>
          <td width="70"><?=$qtd_cliente->cont;?></td>
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
