<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho;
include("_functions.php");
include("_ctrl.php");
?>
<div id='form_socio'></div>
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
<script>

</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id='some'><<</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    RH 
</a>
<a href="#" class="navegacao_ativo">
<span></span>    Folhas de Pagamento 
</a>
</div>
<div id="barra_info">
	<? if($_GET['empresa_id']>0){ ?>
    <span style="float:left; font-weight:bold;"><?=$empresa->razao_social?> | </span> 
    <form method="GET" style="float:left; margin-left:10px;">
    <label>Mês:<select name="mes">
    <option value="0">todos</option>
                <? 
				foreach($mes_abreviado as $i=>$v){
					if($_GET['mes']==$i){$sel='selected="selected"';}else{$sel='';}
					?>
                    <option <?=$sel?> value="<?=$i?>"><?=$v?></option>
                    <?
				}
				?>
            </select>
    </label>
    <label>
    	Ano:<input name="ano" style="width:50px; height:11px;" type="text" value="<?=$_GET['ano']?>"/>
    </label>
    <input type="submit" name="action" value="Filtrar">
    <input type="hidden" name="empresa_id" value="<?=$_GET['empresa_id']?>">
    <input type="hidden" name="tela_id" value="<?=$tela->id?>">
    </form>
    
    <a href="<?=$caminho?>/form_nova_folha.php?empresa_id=<?=$empresa_id?>" target="carregador" class="mais"></a>
    <? }else{
		 ?>
         Selecione uma empresa para ver suas folhas de pagamento.
    <? } ?>
    
	
</div>

<? if(!$_GET['empresa_id']){ ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
          	<td width="120">Última Folha</td>
          	<td width="120">Última Alteração</td>
          	<td width="200">Usuário última alteração</td>
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
		$busca_add = "AND cf.nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="cf.nome_fantasia";
	}
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1'"),0,0);
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="
	SELECT 
		*, cf.id as cliente_forencedor_id, re.id as empresa_id 
	FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1' 
		$busca_add 
		$filtro 
		ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$ultimo_acesso_q=mysql_query("SELECT re.*, DATE_FORMAT(re.ultima_alteracao,'%d/%m/%Y %H:%i') as ultima_alteracao, u.nome as nome FROM rh_folha_empresa as re, usuario as u WHERE re.vkt_id='".$vkt_id."' AND re.empresa_id='".$r->cliente_forencedor_id."' AND u.id=re.ultima_alteracao_login_id ORDER BY id DESC");
		$ultimo_acesso=mysql_fetch_object($ultimo_acesso_q);

	?>
<tr <?=$sel?> onclick="location.href='?tela_id=<?=$tela->id?>&empresa_id=<?=$r->cliente_forencedor_id?>'">
    <td width="200"><?=$r->nome_fantasia?></td>
    <td width="120"><?=$mes_extenso[$ultimo_acesso->mes].' '.$ultimo_acesso->ano?></td>
    <td width="120"><?=$ultimo_acesso->ultima_alteracao?></td>
    <td width="200"><?=$ultimo_acesso->nome?></td>
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
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>
<? }else{ ?>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">Mês/Ano</td>
           <td width="80">Situação</td>
           <td>&nbsp;</td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
<? 
if($_GET['action']=='Filtrar'){
	if($_GET['mes']>0){$filtro_mes=" AND mes='".$_GET['mes']."'";}
	if($_GET['ano']!=''){$filtro_ano=" AND ano='".$_GET['ano']."'";}
}
$folhas_q=mysql_query($a="SELECT * FROM rh_folha_empresa WHERE vkt_id='".$vkt_id."' AND empresa_id='".$empresa_id."' $filtro_ano $filtro_mes ORDER BY id DESC"); 
while($folha=mysql_fetch_object($folhas_q)){
	$total++;
	if($total%2){$sel='class="al"';}else{$sel='';}
?>
<tr <?=$sel?> onClick="location.href='?tela_id=441&folha_id=<?=$folha->id?>'">
    <td width="200" ><?=$mes_extenso[$folha->mes]?> <?=$folha->ano?></td>
    <td width="80" ><?=ucwords($folha->status)?></td>
    <td>&nbsp;</td>
</tr>
<? } ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">&nbsp;</td>
           <td width="80"><a>Total: <?=$total?></a></td>
           <td>&nbsp;</td>
      </tr>
    </thead>
</table>

<? } ?>
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
