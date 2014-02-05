<?
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");

$tipo_cobranca= array(
				"1"=>"Mensal",
				"2"=>"Semestral",
				"3"=>"Anual",
);

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
	.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}
</style>
<script src="<?=$caminho?>/cobranca_mensal_configuracao.js"></script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id='some'>«</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    Administrativo 
</a>
<a href="?tela_id=<?=$tela->id?>" class="navegacao_ativo">
<span></span>    <?=$tela->nome?> 
</a>
</div>
<div id="barra_info">
    <select name="grupo_id" id="grupo_id" style="float:left; margin-top:3px;" title="Adicionar Grupo de Clientes" data-placement="right">
    	<option value="">Grupos</option>
        <option value="novo">Adicionar</option>
		<?php
			$grupos = mysql_query("SELECT * FROM cliente_fornecedor_grupo WHERE tipo = 'C' AND vkt_id='$vkt_id'");
			while($grupo = mysql_fetch_object($grupos)){
		?>
        	<option value="<?=$grupo->id?>" <?php if($grupo->id==$_GET['grupo_id']){ echo "selected='selected'";}?>><?=$grupo->nome?></option>
        <?php
			}
		?>
    </select>
    <div id="botoes" style="float:left;margin-top:3px;">
    	<?php
			if($_GET['grupo_id']>0){
				echo "<input type='button' value='Editar' id='edt_grupo'><input type='button' value='filtrar' id='filtrar'>";
			}
		?>
     
    </div>
     <!--<button type="button" name="exportar" id="exportar" title="Exportar Clientes" data-placement="right" style="float:left; margin-top:3px;"> Exportar </button>
     <button type="button" name="aniversariante" id="aniversariante" title="Lista os aniversariandes de hoje" data-placement="right" style="float:left; margin-top:3px;">Aniversariante de Hoje</button>-->  
    <a href="<?=$caminho?>form_cliente.php" target="carregador" class="mais"></a>
    <input type="button" name="btn_configuracao_id" id="btn_configuracao_id" value="Configuraçao" style="float:right;margin-right:3px;margin-top:2px;"/>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
       
            <td width="230"><?=linkOrdem("Nome","cf.nome_fantasia",1)?></td>
            <td width="80"><?=linkOrdem("Tipo","m.tipo_mensalidade",1)?></td>
          	<td width="80"><?=linkOrdem("Valor","m.valor",1)?></td>
          
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['filtro']=="filtrar"&&$_GET['grupo_id']>0){
		$filtro = "AND grupo_id='".$_GET['grupo_id']."'";
	}
	if($_GET['aniversariantes']=='sim'){
	// necessario para paginacao
   		$filtro = "AND DAY(nascimento)='".date('d')."' AND MONTH(nascimento)='".date('m')."'";
	}
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome_fantasia";
	}
	$registros= mysql_result(mysql_query("SELECT count(*) FROM cliente_fornecedor WHERE tipo='Cliente' AND cliente_vekttor_id ='$vkt_id' $busca_add ORDER BY nome_fantasia"),0,0);
	// colocar a funcao da paginaçao no limite
	
	if(strlen($_GET[busca])>0){
		$q= mysql_query($t="SELECT * FROM cliente_fornecedor  WHERE tipo='Cliente' AND cliente_vekttor_id ='{$_SESSION['usuario']->cliente_vekttor_id}' $busca_add $filtro ORDER BY ".$ordem." ".$_GET['ordem_tipo']);
	}else{
		$q= mysql_query($t="SELECT cf.* FROM cliente_fornecedor as cf, cobranca_mensal_clientes as m WHERE m.cliente_fornecedor_id = cf.id AND cf.tipo='Cliente' AND cf.cliente_vekttor_id ='{$_SESSION['usuario']->cliente_vekttor_id}' $busca_add $filtro ORDER BY ".$ordem." ".$_GET['ordem_tipo']);
	
	}
	//echo $t;
	
	
	$valor_total = '0';
	while($r=mysql_fetch_object($q)){
		$total++;
		$valor_cobranca = mysql_fetch_object(mysql_query("SELECT * FROM cobranca_mensal_clientes WHERE cliente_fornecedor_id ='$r->id' AND vkt_id='$vkt_id'"));
		
		if($total%2){$sel='class="al"';}else{$sel='';}
		if($valor_cobranca->tipo_mensalidade==1){
			$valor=$valor_cobranca->valor;
		}
		if($valor_cobranca->tipo_mensalidade==2){
			$valor=$valor_cobranca->valor/6;
		}
		if($valor_cobranca->tipo_mensalidade==3){
			$valor=$valor_cobranca->valor/12;
		}
		$valor_total += $valor; 

	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form_cliente.php?id=<?=$r->id?>','carregador')">
<td width="230"><?=$r->nome_fantasia?></td>
<td width="80" style="text-align:right"><?=$tipo_cobranca[$valor_cobranca->tipo_mensalidade]?></td>
<td width="80" style="text-align:right"><?php echo MoedaUsaToBr($valor);?></td>
<td></td>
</tr>
<?
	$valor="";
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
       
            <td width="230"><a>Total: <?=$total?></a></td>
            <td width="80" style="text-align:right">&nbsp;</td>
          	<td width="80" style="text-align:right"><?php if($valor_total>0){ echo MoedaUsaToBr($valor_total);}else{ echo "0,00";}?></td>
          	
            <td></td>
        </tr>
</table>

</div>
<div id='rodape'></div>
