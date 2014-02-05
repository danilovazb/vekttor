<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>

<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<script>
	
	$(document).ready(function(){
		$("#dados tr:nth-child(2n+1)").addClass('al');
	});
	
	$(document).ready(function(){
		$("tr:odd").addClass('al');		
	});
	
	$("#cargo_id").live("change",function(){
		$("#form_filter").submit();	
	});
</script>
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a><a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span><?=ucwords($tela->nome)?>
</a>
</div>
<div id="barra_info">
	
    <form action="" method="get" autocomplete='off' id="form_filter" style="float:left" >
    	
	<select name="cargo_id" id="cargo_id" style="margin-top:5px;"> 
    	<option value="0">Cargo</option>
    <?php
    	$sql = mysql_query (" SELECT * FROM cargo_salario WHERE vkt_id = '$vkt_id' "); 
		while($cargos=mysql_fetch_object($sql)){
			if( $_GET["cargo_id"] == $cargos->id ) { $sel='selected="selected"'; } else { $sel=''; }
	?>
    	<option <?=$sel?> value="<?php echo $cargos->id?>"> <?php echo $cargos->cargo?> </option>
    <?php
		}
	?>
    </select>
    <input type="hidden" name="tela_id" value="469" />
    </form>
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
   <tr>
       <td width="40">N&deg; </td>
       <td width="200">Nome</td>
       <td width="200">Cargo</td>
       <td></td>
   </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	$and = "";
	if(strlen($_GET[busca])>0){
		$busca_add = "AND u.nome like '%{$_GET[busca]}%'";
	}
	
	if( !empty($_GET["cargo_id"]) ){
    	$and = " AND r.cargo_id = '".$_GET["cargo_id"]." ' ";	
	}
	
	// necessario para paginacao
    $registros= @mysql_result(mysql_query($t="SELECT count(*) FROM rh_funcionario WHERE vkt_id='$vkt_id'"),0,0);
   //echo $t;
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="p.id DESC";
	}
				
	$q=mysql_query($a="SELECT * FROM rh_funcionario as r WHERE 1  AND  vkt_id='$vkt_id' $and ORDER BY nome ASC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $a;
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		$cargo = mysql_fetch_object(mysql_query(" SELECT * FROM cargo_salario WHERE id = '$r->cargo_id' "));
		
		if( empty($cargo->id) ){
			$cargo->cargo = " Professor ";
		}

	?>
    <tr <?=$sel?>onclick="window.open('<?=$caminho?>/form.php?funcionario_id=<?=$r->id?>','carregador')">
       <td width="40"><?=$total?></td>
       <td width="200"><?=$r->nome?></td>
       <td width="200"><?=$cargo->cargo?></td>
       <td></td>
    </tr>
   <?
	}
	?>  		
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	Registros 
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
  <script>
  /*
	   function validaescolas(t){
		   val=$(t).val();
		   id=$(t).attr('id');
		   if($(t).val()!=''){
			   s=$(".escolas_horarios[id!="+id+"]");
			   s.each(function() {
				  $(this).find('option[value='+val+']').hide();
				  $(this).find('option[value!='+val+']').show();
			   });
		   }
	   }
	   */
	   function exibeTurnos(t){	
				if($(t).attr('checked')){
					$("#dados_professor").show();
					$("#cargo_id").hide()
					$("#escola_id").hide()
					$("#cargo_id option").removeAttr('selected')
					$("#escola_id option").removeAttr('selected')
				}else{
					$("#cargo_id").show()
					$("#escola_id").show()
					$("#dados_professor").hide();
				}
			}
       </script>
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
