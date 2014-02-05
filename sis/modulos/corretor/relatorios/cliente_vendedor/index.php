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
        <a href="./" class='s2'>
    Imobili&aacute;ria 
</a><a href="" class='navegacao_ativo'>
<span></span>    Cliente por Vendedor
</a>
</div>

<div id="barra_info">
	<div style="float:left; margin-top:1.5px;">
    	<form method="get">
        	<input type="hidden" name="tela_id" value="175" />
        	<select name="nome" id="nome">
            <option value="">Todos</option>
            	<?php 
					
					$sql = mysql_query($t="SELECT nome FROM corretor");
						
								while($r=mysql_fetch_object($sql)){
								
								if($_GET['nome'] == $r->nome){$sell='selected="selected"';}else{$sell='';}
								
									if($r->nome != null){
				?>
            							<option <?=$sell?> value="<?php echo $r->nome;?>" ><?php echo $r->nome;?> </option>
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
       	  <td width="200">Cliente</td>
          <td width="300">Corretor</td>
          
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
	
			if(isset($_GET['nome']) and $_GET['nome']!=''){
					
						$where = " AND cor.nome= '".$_GET['nome']."'";
			}else{
				$where ='';	
			}
					
			
		/*$sql = mysql_query($y="SELECT cont.cliente_fornecedor_id, cli.nome_contato, cor.nome FROM contrato as cont, cliente_fornecedor as cli, corretor as cor WHERE cont.corretor_id=cor.id AND cont.cliente_fornecedor_id=cli.id AND cliente_vekttor_id = '$vkt_id' AND usuario_id='$login_id' $where ");*/
		$sql= mysql_query("SELECT * FROM corretor as c, cliente_fornecedor as i, contrato as co WHERE c.usuario_id='$login_id' AND ");
		
			//echo $y;
			while($r=mysql_fetch_object($sql)){
					
		
	?>      
    	<tr <?=$sel?>>
        <td width="200"><?=$r->nome;?></td>
          <td width="300"><?=$r->nome_contato;?></td>
          
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
