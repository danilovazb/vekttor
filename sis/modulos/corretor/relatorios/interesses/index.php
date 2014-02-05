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
    Imobiliária 
</a><a href="?" class='s2'>
  	Relat&oacute;rios
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span>   Interesses
</a>
</div>

<div id="barra_info">
	<div style="float:left; margin-top:1.5px;">
    	<form method="get">
        	<input type="hidden" name="tela_id" value="177" />
        	<select name="corretor_id" id="corretor_id">
            <option value="0">-Corretores-</option>
            <optgroup>
            	<?php 
					
					$sql = mysql_query($t="SELECT id,nome FROM corretor WHERE vkt_id='$vkt_id' ");
						
								while($r=mysql_fetch_object($sql)){
								
								if($_GET['corretor_id'] == $r->id){$sell='selected="selected"';}else{$sell='';}
								
									if($r->id != null){
				?>
            							<option <?=$sell?> value="<?php echo $r->id;?>" ><?php echo $r->nome;?> </option>
                <?php 				}
							}
				?>
                </optgroup>
            </select>
            <select name="usuario_id" id="usuario_id">
            <option value="0">-Imobiliárias-</option>
            <optgroup>
            	<?php 
					
					$sql = mysql_query($t="SELECT id,nome FROM usuario WHERE cliente_vekttor_id='$vkt_id' ");
						
								while($r=mysql_fetch_object($sql)){
								
								if($_GET['usuario_id'] == $r->id){$sell='selected="selected"';}else{$sell='';}
								
									if($r->id != null){
				?>
            							<option <?=$sell?> value="<?php echo $r->id;?>" ><?php echo $r->nome;?> </option>
                <?php 				}
							}
				?>
                </optgroup>
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
          <td width="200">Nome</td>
          <td width="100">Telefone</td>
          <td width="200">Email</td>
          <td width="100">Renda Familiar</td>
          <td width="100">Corretor</td>
          <td width="100">Imobiliária</td>
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
			if(isset($_GET['corretor_id']) && $_GET['corretor_id']>0){
				$filtro_corretor = " AND i.corretor_id = '{$_GET['corretor_id']}'";
			}
			if(isset($_GET['usuario_id']) && $_GET['usuario_id']>0){
				$filtro_imobiliaria = " AND i.usuario_id = '{$_GET['usuario_id']}'";
			}
					
			
		$sql = mysql_query($y="SELECT i.nome interessado,i.email, i.renda_familiar, i.telefone_residencial, c.nome as corretor, u.nome as imobiliaria
		FROM interesse as i, corretor as c, usuario as u
		WHERE 
			i.vkt_id='$vkt_id' AND
			i.corretor_id = c.id
			AND i.usuario_id = u.id
			$filtro_corretor
			$filtro_imobiliaria
		
		");
			//echo $y.mysql_error();
			while($r=mysql_fetch_object($sql)){
					
		
	?>      
    	<tr <?=$sel?>>
          <td width="200"><?=$r->interessado;?></td>
          <td width="100"><?=$r->telefone_residencial;?></td>
          <td width="200"><?=$r->email;?></td>
          <td width="100"><?=$r->renda_familiar;?></td>
          <td width="100"><?=$r->corretor?></td>
          <td width="100"><?= $r->imobiliaria ?></td>
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

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black;">
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
