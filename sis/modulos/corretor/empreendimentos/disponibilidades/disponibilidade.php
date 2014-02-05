

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php"); 

?>


<script src="<?=$caminho?>/negociacao.js"></script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
function buscaNegociacoes(){
	var empreendimento_id=$("#empreendimento_id").val(); 
	var cliente_id= $("#cliente_id").val();
	if(cliente_id>0){
		$("#negociacao_id").load("modulos/administrativo/empreendimentos/disponibilidades/busca_negociacoes.php?cliente_id="+cliente_id+"&empreendimento_id="+empreendimento_id);
	}
	
}
</script>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
	<input type="hidden" name="disponibilidade_tipo_id" value="<?=$_GET['disponibilidade_tipo_id']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>

<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s1'>
  	Imobiliária
</a>

<a href="?tela_id=17" class='s2'>
    <?=$empreendimento->nome?> 
</a>
<a href="" class="navegacao_ativo">
<span></span>Disponibilidades
</a>
</div>
<div id="barra_info">
 Tipo 
   <select name="disponibilidade_tipo_id" onchange="location='?tela_id=60&empreendimento_id=<?=$_GET[empreendimento_id]?>&disponibilidade_tipo_id='+this.value">
     <option value='0' >Todas</option>
     <?
 $qtd = mysql_query("SELECT * FROM disponibilidade_tipo WHERE empreendimento_id='$empreendimento->id' order by nome");
 while($rtd=mysql_fetch_object($qtd)){
	 
	 if($_GET[disponibilidade_tipo_id]== $rtd->id){
		$selected = 'selected="selected"'	 ;
	}else{
		$selected ='';
	}
	 
	echo "<option value='$rtd->id' $selected>".str_pad($rtd->nome,35,' -',STR_PAD_RIGHT).'R$ '.moedaUsaToBr($rtd->valor)."</option>\n";
	$disponibilidade_tipo[$rtd->id] = $rtd->nome;
}
 
 ?>
   </select>
   <select name="select3" onchange="location='?tela_id=60&empreendimento_id=<?=$_GET[empreendimento_id]?>&disponibilidade_tipo_id=<?=$_GET[disponibilidade_tipo_id]?>&situacao='+this.value">
   <?
   $situacao_info[$_GET[situacao]] ='selected="selected"'	 ;
   ?>
     <option value='todos' <?= $situacao_info['todos']?>>Todas</option>
     <option value='0' <?= $situacao_info[0]?>>Disponiveis</option>
     <option value='1' <?= $situacao_info[1]?>>Pre-venda</option>
     <option value='2' <?= $situacao_info[2]?>>Vendidos</option>
   
   </select>
<a href="<?=$caminho?>form.php?empreendimento_id=<?=$empreendimento->id?>" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="240"><?=linkOrdem("Tipo","disponibilidade_tipo_id",1)?></td>
            <td width="240"><?=linkOrdem("Identificação","identificacao",1)?></td>
          	<td width="80"><a href="#" class='tda'>Situação</a></td>
			<td width="100"><a href="#" class='tda'>Opções </a></td>
            <td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    
    
    <?
	if(strlen($_GET[busca])>0){
		$busca_add = "AND nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query($trace="SELECT count(*) FROM disponibilidade WHERE empreendimento_id='$_GET[empreendimento_id]' $busca_add "),0,0);

	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="disponibilidade_tipo_id, identificacao";
	}
	if($_GET[disponibilidade_tipo_id]>0){
		$edmp = " AND disponibilidade_tipo_id='$_GET[disponibilidade_tipo_id]' ";	
	}
	if(isset($_GET[situacao])){
		
		if($_GET[situacao]=='todos'){
			$situacao_sql = "";
		}else{
			$situacao_sql = " AND situacao='$_GET[situacao]' ";
		}
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query("SELECT * FROM disponibilidade WHERE empreendimento_id='$_GET[empreendimento_id]'  $busca_add $edmp $situacao_sql ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		// Falta fazer as disponibilidaes de um tipo
		
		if($r->situacao==0)$situacao="Disponível";
		if($r->situacao==1)$situacao="Pré-Venda";
		if($r->situacao==2)$situacao="Vendido";
		if($r->situacao==3)$situacao="Pago";
		$total++;
		
	?>    	<tr >
            <td width="240"><?=$disponibilidade_tipo[$r->disponibilidade_tipo_id] ?></td>
          <td width="240"><?=$r->identificacao ?></td>
          	<td width="80"><?=$situacao?></td>
			<td width="100" class="options"><a href="<?=$caminho?>form_vendas.php?id=<?=$r->id?>" target="carregador">Pre-Venda</a></td>
           	<td width=""></td>
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
            <td width="250"><a>Total</a></td>
            <td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	356 Registros <select name="select" id="select" style="margin-left:10px">
    <option>15</option>
    <option>30</option>
    <option>50</option>
    <option>100</option>
  </select>
  Por P&aacute;gina 
<div style="float:right; margin:0px 20px 0 0">
	<a href=" " class='bt_left'></a>
	<input name="textfield" class="nPaginacao" type="text" id="textfield" size="2" value="1" />
	<a href=" " class='bt_rigth'></a>
</div>
</div>
