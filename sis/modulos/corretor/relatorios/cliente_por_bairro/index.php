<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

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
<span></span>    Cliente por Bairro
</a>
</div>

<div id="barra_info">
	<div style="float:left; margin-top:1.5px;">
    	<form method="get">
        	<input type="hidden" name="tela_id" value="174" />
        	<select name="bairro" id="bairro">
            <option value="g99">Todos</option>
            	<?php 
					
					$sql = mysql_query($t="SELECT DISTINCT(bairro) FROM cliente_fornecedor WHERE bairro <> '' AND cliente_vekttor_id = '$vkt_id' AND usuario_id='$login_id' GROUP BY bairro");
						
								while($r=mysql_fetch_object($sql)){
								
								if($_GET['bairro'] == $r->bairro){$sell='selected="selected"';}else{$sell='';}
								
									if($r->bairro != null){
				?>
            							<option <?=$sell?> value="<?php echo $r->bairro;?>" ><?php echo $r->bairro;?> </option>
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
          <td width="300">Bairro</td>
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
	
			if(isset($_GET['bairro'])){
					
					if($_GET['bairro'] == 'g99'){
						$and = " ";	
					} else{
						$and = "and bairro = '".htmlspecialchars($_GET['bairro'])."'";
					}
					
			}
			
		$sql = mysql_query($y="SELECT DISTINCT(bairro) FROM cliente_fornecedor WHERE bairro != '' AND cliente_vekttor_id = '$vkt_id' AND usuario_id='$login_id'");
				while($r=mysql_fetch_object($sql)){
				$qtd_bairro = mysql_fetch_object(mysql_query("SELECT COUNT(bairro) as cont from cliente_fornecedor where bairro  = '".$r->bairro."' AND cliente_vekttor_id='$vkt_id' GROUP BY bairro"));
		
	?>      
    	<tr <?=$sel?> onclick="window.open('modulos/corretor/cadastro_clientes/form.php?id=<?=$r->id?>','carregador')">
          <td width="300"><?=$r->bairro;?></td>
          <td width="70"><?=$qtd_bairro->cont;?></td>
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
