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
	})
	function checa_cpf(t){
	ultima = t.value.substr(13,1);
	//alert(id);
	if(ultima!='_' && t.value.length=='14' ){
		window.open('modulos/escolar2/cadastros/funcionarios/form.php?cnpj_cpf='+t.value,'carregador')	
		}
	}
	
	$(document).ready(function(){
			$("tr:odd").addClass('al');
});
</script>
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a><a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span>Funcionários
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
   <td width="40">Codigo</td>
   <td width="200">Nome</td>
   <td width="150">Email</td>
   <td width="80">Telefone</td>
   <td width="80">Celular</td>
   <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND u.nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= @mysql_result(mysql_query($t="SELECT p.*,p.id as id,c.*,u.* FROM escolar_professor p 
						INNER JOIN cliente_fornecedor c ON p.cliente_fornecedor_id =c.id
						INNER JOIN usuario u ON p.usuario_id =u.id
						WHERE p.vkt_id='$vkt_id' $busca_add"),0,0);
   //echo $t;
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="p.id DESC";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT p.*,p.id as p_id,c.*,u.* FROM escolar_professor p 
						INNER JOIN cliente_fornecedor c ON p.cliente_fornecedor_id =c.id
						INNER JOIN usuario u ON p.usuario_id =u.id
						WHERE p.vkt_id='$vkt_id' AND p.status='1' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->p_id?>','carregador')">
   <td width="40"><?=$r->p_id?></td>
   <td width="200"><?=$r->nome_contato?></td>
   <td width="150"><?=$r->email?></td>
   <td width="80"><?=$r->telefone1?></td>
   <td width="80"><?=$r->telefone2?></td>
   <td></td>
</tr>
   <?
	}
	?>
    <tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->p_id?>','carregador')">
   		<td width="40">22</td>
   		<td width="200">Marcelo Arroyo De  Lima</td>
        <td width="150">arroyo@br.ibm.com</td>
        <td width="80">(19)2132-7738 </td>
        <td width="80"></td>
        <td></td>
	</tr>
    <!-- -->
    <tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->p_id?>','carregador')">
   		<td width="40">23</td>
   		<td width="200"> Joao Alberto  Lima</td>
        <td width="150">joaolima@br.ibm.com</td>
        <td width="80">(92)2132-6901 </td>
        <td width="80"></td>
        <td></td>
	</tr>
    
    <!-- -->
    <tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->p_id?>','carregador')">
   		<td width="40">24</td>
   		<td width="200"> Luiz Ricardo Diniz Souto  Lima</td>
        <td width="150">ricardo@hotmail.com</td>
        <td width="80">(92)3487-6901</td>
        <td width="80"></td>
        <td></td>
	</tr>	
    
    <!-- -->
    <tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->p_id?>','carregador')">
   		<td width="40">25</td>
   		<td width="200">Augusto de Lima e Lima</td>
        <td width="150">augusto@gmail.com</td>
        <td width="80"></td>
        <td width="80"></td>
        <td></td>
	</tr>	
    
    <!-- -->
    <tr onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->p_id?>','carregador')">
   		<td width="40">26</td>
   		<td width="200">Amanda Lopes da Silva</td>
        <td width="150">amandinha@gmail.com</td>
        <td width="80">(92)3456-7865</td>
        <td width="80"></td>
        <td></td>
	</tr>	
    
    <!-- -->
    <tr>
   		<td width="40">27</td>
   		<td width="200">Bruno Costa Carvalho</td>
        <td width="150">brunosociety@hotmail.com</td>
        <td width="80">(92)4567-9876</td>
        <td width="80"></td>
        <td></td>
	</tr>	
    
    <!-- -->
    <tr >
   		<td width="40">28</td>
   		<td width="200">Caroline Alexandra Favalho</td>
        <td width="150">alexandra@hotmail.com</td>
        <td width="80">(92)3456-5678</td>
        <td width="80"></td>
        <td></td>
	</tr>	
    
    <!-- -->
    <tr>
   		<td width="40">29</td>
   		<td width="200">Diego Monteiro Lopes</td>
        <td width="150">diegomonteiro@gmail.com</td>
        <td width="80">(92)3456-8712</td>
        <td width="80"></td>
        <td></td>
	</tr>			
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
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
