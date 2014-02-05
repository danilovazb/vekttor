<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho;
include("_functions.php");
include("_ctrl.php");
?>
<div id='form_socio'></div>
<style>
.btf{ display:block; float:left; width:15px; height:15px; background-image:url(....//fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
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
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s1'>
  	RH 
</a>
<a href="./" class='s2'>
    Folhas de Pagamento 
</a>
<a href="#" class="navegacao_ativo">
<span></span>    Configuração da Folha de pagamento
</a>
</div>
<div id="barra_info">
         Clique em uma empresa para configurar sua folha de pagamento
</div>

<? if(!$_GET['empresa_id']){ ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
            <td width="120">CNPJ</td>
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
	if($_GET[limitador]<1){
		$limitador= 100;
	}else{

		$limitador= $_GET[limitador];
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
		ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$limitador));
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$ultimo_acesso_q=mysql_query("SELECT re.*, DATE_FORMAT(re.ultima_alteracao,'%d/%m/%Y %H:%i') as ultima_alteracao, u.nome as nome FROM rh_folha_empresa as re, usuario as u WHERE re.vkt_id='".$vkt_id."' AND re.empresa_id='".$r->cliente_forencedor_id."' AND u.id=re.ultima_alteracao_login_id ORDER BY id DESC");
		$ultimo_acesso=mysql_fetch_object($ultimo_acesso_q);
		$mes = $mes_extenso[$ultimo_acesso->mes];
		if($ultimo_acesso->mes==12){
			$mes="13º Integral";
		}
		if($ultimo_acesso->mes==13){
			$mes="13º Parcela 1";
		}
		if($ultimo_acesso->mes==14){
			$mes="13º Parcela 2";
		}
		//echo "Mes: ".$folha->mes." ".$mes."<br>";
	?>
<tr <?=$sel?> onclick="window.open('<?=$caminho?>/form.php?empresa_id=<?=$r->empresa_id?>','carregador')">
    <td width="200"><?=$r->nome_fantasia?></td>
    <td width="120"><?=$r->cnpj_cpf?></td>
    <td width="120"><?=$mes.' '.$ultimo_acesso->ano?></td>
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
<? 
}
?>
</div>
<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 100;	
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