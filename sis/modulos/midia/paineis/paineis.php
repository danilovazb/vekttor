<?
$caminho =$tela->caminho; 
include('_functions.php');
include("_ctrl.php");


if($_GET['ordem'] && $_GET['ordem_tipo']){
	$ordem = " ORDER BY {$_GET['ordem']} {$_GET['ordem_tipo']} ";
}
/* para listagem */
$paineis_q=mq("
SELECT 
	*,
	TIME_FORMAT(seg_ini,'%H:%i') as seg_ini,
	TIME_FORMAT(ter_ini,'%H:%i') as ter_ini,
	TIME_FORMAT(qua_ini,'%H:%i') as qua_ini,
	TIME_FORMAT(qui_ini,'%H:%i') as qui_ini,
	TIME_FORMAT(sex_ini,'%H:%i') as sex_ini,
	TIME_FORMAT(sab_ini,'%H:%i') as sab_ini,
	TIME_FORMAT(dom_ini,'%H:%i') as dom_ini,
	TIME_FORMAT(seg_fim,'%H:%i') as seg_fim,
	TIME_FORMAT(ter_fim,'%H:%i') as ter_fim,
	TIME_FORMAT(qua_fim,'%H:%i') as qua_fim,
	TIME_FORMAT(qui_fim,'%H:%i') as qui_fim,
	TIME_FORMAT(sex_fim,'%H:%i') as sex_fim,
	TIME_FORMAT(sab_fim,'%H:%i') as sab_fim,
	TIME_FORMAT(dom_fim,'%H:%i') as dom_fim
FROM 
	paineis 
WHERE 
	vkt_id='$vkt_id'
$ordem
");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<script>
function trocaBanco(d) {
	$(".dvboletos").hide();
	$('#num_inicio_boleto').show();
	if(d.value == 001) {//Banco do Brasil
		$('#convenio').show();
		$('#contrato').show();
		$('#carteira').show();
		$('#variacao_carteira').show();
		
	}
	
	if(d.value == 237) {//Bradesco
		//$('#convenio').show();
		$('#carteira').show();
		
	}
	
	if (d.value ==104) {//Caixa Econômica
		$('#convenio').show();
	
	} 
	if (d.value ==409) {//Itaú
		$('#carteira').show();
	
	} 
	if (d.value ==399) {//HSBC
		$('#codigo_cedente').show();
		$('#carteira').show();
	
	} 
	
	
	
	
}

</script>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>

<a href="?" class='s2'>
  	Midia
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">    
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    <form method="get">
    
    </form>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="100"><?=linkOrdem("Nome do Painel","nome",1)?></td>
            <td width="180">Descrição</td>
          	<td width="80" >Segunda</td>
            <td width="80" >Terça</td>
            <td width="80" >Quarta</td>
            <td width="80" >Quinta</td>
            <td width="80" >Sexta</td>
            <td width="80" >Sábado</td>
            <td width="80" >Domingo</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
	    <? 
		$i=0;
		while($painel=mf($paineis_q)){ 
		$i++;if($i%2==0){$al='al';}else{$al='';}
		if($ultimo_cadastrado==$painel->id){ $ultimo="background-color:green !important;color:white;";}else{$ultimo="";}
		?>
    	<tr <?="class='$al'  "
		?> 
        onClick="window.open('<?=$caminho?>/form.php?id=<?=$painel->id?>','carregador')">
       		<td <?="style='$ultimo'"?> width="100"><?=$painel->nome?></td>
            <td <?="style='$ultimo'"?> width="180"><?=$painel->descricao?></td>
            <td <?="style='$ultimo'"?> width="80" ><?=$painel->seg_ini?> - <?=$painel->seg_fim?></td>
            <td <?="style='$ultimo'"?> width="80" ><?=$painel->ter_ini?> - <?=$painel->ter_fim?></td>
            <td <?="style='$ultimo'"?> width="80" ><?=$painel->qua_ini?> - <?=$painel->qua_fim?></td>
            <td <?="style='$ultimo'"?> width="80" ><?=$painel->qui_ini?> - <?=$painel->qui_fim?></td>
            <td <?="style='$ultimo'"?> width="80" ><?=$painel->sex_ini?> - <?=$painel->sex_fim?></td>
            <td <?="style='$ultimo'"?> width="80" ><?=$painel->sab_ini?> - <?=$painel->sab_fim?></td>
            <td <?="style='$ultimo'"?> width="80" ><?=$painel->dom_ini?> - <?=$painel->dom_fim?></td>
            <td <?="style='$ultimo'"?> ></td>
        </tr>
        <? } ?>
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>
<script>
$("#tabela_dados tr:odd").addClass('al');
</script>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209" colspan="10"></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
