<?
$caminho =$tela->caminho; 
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
<a href="?tela_id=49" class='navegacao_ativo'>
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
            <td width="120">Descrição</td>
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
	    
    	<tr>
       		<td width="100">Painel Recife</td>
            <td width="120">painel atrás do golden goal </td>
            <td width="80" >06:00 - 18:00</td>
            <td width="80" >06:00 - 18:00</td>
            <td width="80" >06:00 - 18:00</td>
            <td width="80" >06:00 - 18:00</td>
            <td width="80" >06:00 - 18:00</td>
            <td width="80" >06:00 - 18:00</td>
            <td width="80" >06:00 - 18:00</td>
            <td  ></td>
        </tr>
        
        <tr>
       		<td width="100">Painel Paraíba</td>
            <td width="120">painel perto do Carrefour</td>
            <td width="80" >06:00 - 17:00</td>
            <td width="80" >06:00 - 17:00</td>
            <td width="80" >06:00 - 17:00</td>
            <td width="80" >06:00 - 17:00</td>
            <td width="80" >06:00 - 17:30</td>
            <td width="80" >06:00 - 18:00</td>
            <td width="80" >06:00 - 19:00</td>
            <td  ></td>
        </tr>
	
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
