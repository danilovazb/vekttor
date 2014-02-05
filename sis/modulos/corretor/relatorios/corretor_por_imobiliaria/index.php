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
</a>
<a href="" class='s2'>
  	Relat&oacute;rios
</a>
<a href="" class='navegacao_ativo'>
<span></span>    Cliente por Imobili&aacute;ria
</a>
</div>

<div id="barra_info">
	<div style="float:left; margin-top:1.5px;">
    	<form method="get">
        	<input type="hidden" name="tela_id" value="176" />
        	<select name="imo" id="imo">
            <option value="g99">Todos</option>
            	<?php 
					
					$sql = mysql_query($t="SELECT u.nome FROM usuario u WHERE u.usuario_tipo_id = 12 ");
						
								while($r=mysql_fetch_object($sql)){
								
								if($_GET['imo'] == $r->nome){ $sell='selected="selected"'; } else{ $sell=''; }
								
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
          <td width="300">Corretor</td>
          <td width="200">Imobili&aacute;ria</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
	
			if(isset($_GET['imo'])){
					
					if($_GET['imo'] == 'g99'){
						$where = " WHERE  1=1";	
					} else{
						$where = " WHERE u.nome = '".htmlspecialchars($_GET['imo'])."'";
					}
					
			}
			
		$sql = mysql_query($y="SELECT  
									c.id as idc,
									c.nome as nome_corretor,
									u.id as idu,
									u.nome as imobiliaria
								FROM corretor c
									JOIN usuario u on c.imobiliaria_id = u.id $where ");
			
				while($r=mysql_fetch_object($sql)){
						
		
	?>      
    	<tr <?=$sel?>>
          <td width="300"><?=$r->nome_corretor;?></td>
          <td width="200"><?=$r->imobiliaria;?></td>
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
