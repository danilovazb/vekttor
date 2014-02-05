<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
if($_GET[conta_id]){
$conta_id = $_GET[conta_id];
}else{
$conta_id = $_POST[conta_id];
	
}
if(!isset($_GET[extorno])){$filtro_extorno=" AND extorno=0";}elseif($_GET[extorno]=='1'){ $filtro_extorno='';}
if($_GET['mes_i']){
	$mes_i = $_GET['mes_i'];
	$ano_i = $_GET['ano_i'];
	$mes_f = $_GET['mes_f'];
	$ano_f = $_GET['ano_f'];
}else{
	$mes_i = date("m");
	$ano_i =  date("Y");
	$mes_f = date("m");
	$ano_f =  date("Y");
}

$mes_s[$mes_i] 	= 'selected="selected"';
$mes_s2[$mes_f] = 'selected="selected"';
$ano_s[$ano_i] 	= 'selected="selected"';
$ano_s2[$ano_f] = 'selected="selected"';


// guarda as informações das contas
$q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
while($r= mysql_fetch_object($q)){
	$x++;
	if($x==1&&$_GET[conta_id]<1){
	  $conta_id= $r->id; 
	  }
	if($r->id==$_GET[conta_id]){$sel = "selected='selected'";}else{$sel = "";}
	  $saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
	  $saldo=number_format($saldo,2,',','.');
	  $conta_info[] = "<option value='$r->id' $sel >$r->nome - R$ $saldo</option>";  
  }
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
a{ text-decoration:none;}
</style>
<script src="modulos/financeiro/financeiro.js"></script>
<script>
/* script para atalho de clientes */
$(".atl_natureza input:radio").live('click',function(){
	$("#atl_nome").val("");
	$("#atl_cnpf_cpf").val("");
	$("#atl_nome").attr("disabled","disabled");
	$("#atl_cnpf_cpf").attr("disabled","disabled");
	$("#atl_cadastrar").attr("disabled","disabled");
	
	for( i=0; i < $(this).length; i++ ){
			if($(this).is(":checked")){
				var liberado = true;
			}
	}
	if(liberado == true){
		$("#atl_nome").removeAttr("disabled");
		$("#atl_cnpf_cpf").removeAttr("disabled");
		$("#atl_cadastrar").removeAttr("disabled");
		$("#tipo").removeAttr("disabled");
	}
	if($(this).val() == '1'){
		$("#atl_cnpf_cpf").val('');
		$("#atl_cnpf_cpf").attr('mascara','___.___.___-__');
	}else{
		$("#atl_cnpf_cpf").val('');
		$("#atl_cnpf_cpf").attr('mascara','__.___.___/____-__'); // 05.535.221/0001-88
	}
});
$("div").on("click","#cad_cliente",function(){
	$("#janela_cliente").toggle();
});
$("div").on('click','#atl_cadastrar',function(){
		//Físico - Jurídico
		var natureza = $(".atl_natureza").find(":radio");
			for(i=0; i < natureza.length; i++){
				if($(natureza[i]).is(":checked")){
					var tipo_cadastro = $(natureza[i]).val();
				}
			}
	 
		  var nome = $("#atl_nome").val();
		  var cnpj_cpf = $("#atl_cnpf_cpf").val();
		  var tipo = $("select#tipo").val();
		//alert(tipo_cliente);
		$.post('modulos/ordem_servico/ordem_servico/tabela_item.php?acao=atl_cliente',{tipo_cadastro:tipo_cadastro,tipo:tipo,nome:nome,cnpjCpf:cnpj_cpf},function(data){
				$("#internauta_id").val(data);
				$("#cliente").val(nome);
				$("#atl_nome").attr("disabled","disabled");
				$("#atl_cnpf_cpf").attr("disabled","disabled");
				$("#atl_cadastrar").attr("disabled","disabled");
				$(".modal").hide("slow");	
		})
		
})
/**/
/*Plano de contas*/
$("div").on("click","#busca_plano_conta",function(){
	$("#janela_plano_contas").toggle();
	
});//
$("#click_plano_contas").live("click",function(){
	var plano_id = ($(this).attr("class"));
	var descricao = $(this).find("#descplano").text();
	$("#plano_conta").val(descricao);
	$("#plano_de_conta_id").val(plano_id);
	$("#janela_plano_contas").hide("slow");
});//

$("#busca_plano").live("keyup",function(){
	
	var filter = $(this).val(), count = 0;
	
	$(".table-dados tr td").each(function() {
		
		if ($(this).text().search(new RegExp(filter, "i")) < 0) {
			$(this).parent().fadeOut();
		} else {
			$(this).parent().parent().find("tr #desc").css("text-decoration","underline");
			$(this).parent().show();
			
		}	
		
    });
});

/*Centro de custo*/
$("div").on("click","#busca_centro_custo",function(){
	$("#janela_centro_custo").toggle();
	
});//
$("#click_centro_custo").live("click",function(){
	var centro_id = ($(this).attr("class"));
	var descricao = $(this).find("#descentro").text();
	
	$("#centro_custo").val(descricao);
	$("#centro_custo_id").val(centro_id);
	$("#janela_centro_custo").hide("slow");
	
});//

$("#busca_plano").live("keyup",function(){
	
	var filter = $(this).val(), count = 0;
	
	$(".table-dados tr td").each(function() {
		
		if ($(this).text().search(new RegExp(filter, "i")) < 0) {
			$(this).parent().fadeOut();
		} else {
			$(this).parent().parent().find("tr #desc").css("text-decoration","underline");
			$(this).parent().show();
			
		}	
		
    });
});
</script>
<div id='conteudo'>
<?
/*
echo "<pre>";
print_r($mes_s);
print_r($ano_s);
print_r($mes_s2);
print_r($ano_s2);
echo "</pre>";
*/
?><div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=49" class='navegacao_ativo'>
<span></span>    Caixa
</a>
</div>
<div id="barra_info">
<form method="get" action="">
<input type="hidden"  name="tela_id" value="54" />
   <a  href="modulos/financeiro/form_movimentacao.php?conta_id=<?=$conta_id?>" target="carregador" class="mais"></a>
    <input type="button" value="Transferencia" onclick="window.open('modulos/financeiro/form_transferencia.php?conta_id='+document.getElementById('conta_id').value,'carregador')" style="float:right; margin:3px 10px 0 0 "> 
Conta
 <select name="conta_id" id="conta_id"  onchange="location='?tela_id=54&conta_id='+this.value">
              <?
			  
				echo implode("\n",$conta_info);  

			  ?>
			    
    </select>
    <label>Mostrar extornos
    	<input style="margin-left:-2px;" type="checkbox" <? if($_GET['extorno']==1)echo "checked='checked'"; ?> name="extorno" value="1" />
    </label>
    
    Periodo
<select name="mes_i">
    	<option value="01"<?=$mes_s['01']?>>Janeiro</option>
    	<option value="02"<?=$mes_s['02']?>>Fevereiro</option>
    	<option value="03"<?=$mes_s['03']?>>Março</option>
    	<option value="04"<?=$mes_s['04']?>>Abril</option>
    	<option value="05"<?=$mes_s['05']?>>Maio</option>
    	<option value="06"<?=$mes_s['06']?>>Junho</option>
    	<option value="07"<?=$mes_s['07']?>>Julho</option>
    	<option value="08"<?=$mes_s['08']?>>Agosto</option>
    	<option value="09"<?=$mes_s['09']?>>Setembro</option>
    	<option value="10"<?=$mes_s['10']?>>Outubro</option>
    	<option value="11"<?=$mes_s['11']?>>Novembro</option>
    	<option value="12"<?=$mes_s['12']?>>Dezembro</option>
    </select>
       <input type="text" name="ano_i" value="<?=$ano_i?>" style="width:35px; height:10px">
    a
<select name="mes_f">
    	<option value="01"<?=$mes_s2['01']?>>Janeiro</option>
    	<option value="02"<?=$mes_s2['02']?>>Fevereiro</option>
    	<option value="03"<?=$mes_s2['03']?>>Março</option>
    	<option value="04"<?=$mes_s2['04']?>>Abril</option>
    	<option value="05"<?=$mes_s2['05']?>>Maio</option>
    	<option value="06"<?=$mes_s2['06']?>>Junho</option>
    	<option value="07"<?=$mes_s2['07']?>>Julho</option>
    	<option value="08"<?=$mes_s2['08']?>>Agosto</option>
    	<option value="09"<?=$mes_s2['09']?>>Setembro</option>
    	<option value="10"<?=$mes_s2['10']?>>Outubro</option>
    	<option value="11"<?=$mes_s2['11']?>>Novembro</option>
    	<option value="12"<?=$mes_s2['12']?>>Dezembro</option>
    </select>
      <input type="text" name="ano_f" value="<?=$ano_f?>" style="width:35px;height:10px">
	    <input type="submit" value="Ir" />
     
     
     <button type="button" onclick="window.open('modulos/tela_impressao.php?url=<? //$url?>')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" >
	<img src="../fontes/img/imprimir.png" />
	</button>
     
</form>
 </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
    	  <td width="30" style="margin:0;padding:0; text-align:center" title='Consiliado com o Banco'>C</td>
           	<td width="70" style="margin:0;padding:0; text-align:center">
            <a href="?tela_id=54&conta_id=<?=$_GET["conta_id"]?>&mes_i=<?=$_GET["mes_i"]?>&ano_i=<?=$_GET["ano_i"]?>&mes_f=<?=$_GET["mes_f"]?>&ano_f=<?=$_GET["ano_f"]?>&data=<?=$_GET["data"]?>" id="ordena_data">Data</a>
            
            <!--<?linkOrdem("Data","data_info_movimento",1)?>-->
            </td>
            <td width="200">Cliente/Fornecedor</td>
            <td width="200">Descrição</td>
          	<td width="85" style="margin:0;padding:0; text-align:center">Entradas</td>
          	<td width="85" style="margin:0;padding:0; text-align:center">Saidas</td>
          	<td width="85" style="margin:0;padding:0; text-align:center">Saldo</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>

<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	$filter_data = 0;
	$and_data = " ORDER BY  data_movimento";
	
	if(isset($_GET["data"])){
		$filter_data = 1;
		$and_data = "ORDER BY  data_info_movimento";
	}
	
	
	$dataini = " data_info_movimento >='".$ano_i."-".$mes_i."-01'";
	$datafim = " data_info_movimento <='".$ano_f."-".$mes_f."-31' ";
	
	
	$q= mysql_query($trace="
	SELECT 
		*,
		date_format(data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento 
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	AND 
		`status`='1'
		$filtro_extorno
	AND
		conta_id='$conta_id'
	AND
	$dataini
	AND
	$datafim
	
	$and_data  ");
	//echo $trace;
	//echo mysql_error();
	$qtd_reg = mysql_num_rows($q);
	
	while($r=mysql_fetch_object($q)){
		$total++;
		  if($total%2){$sel='class="al"';}else{$sel='';}
		if($r->movimentacao =='fisica' || $r->extorno==1){
			$parenteseI="(";
			$parenteseF=")";
		}else{
			$parenteseI="";
			$parenteseF="";
		}
		
		if($r->entrada>0){
			$entrada = $parenteseI.moedaUsaToBr($r->entrada).$parenteseF;
			if($r->extorno!=1){
				$entrada_soma[]= $r->entrada;
			}
			
		}else{
			$entrada = '';
		}
		if($r->saida>0){
			$saida = $parenteseI.'-'.moedaUsaToBr($r->saida).$parenteseF;
			if($r->extorno!=1){
				$saida_soma[]= $r->saida;
			}
		}else{
			$saida = '';
		}
		
		$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$r->internauta_id'"));
		$saldo=$r->saldo;
		if($r->extorno!=1){
			$sel_ext = "";
		}else{
			$sel_ext = "style='color:#999'";
		}
	?>      
    	<tr <?=$sel?><?=$sel_ext?>>
    	  <td width="30" style="margin:0;padding:0; text-align:center;"><input onclick="co(this,<?=$r->id?>)" type="checkbox"<? if($r->conciliado ==1){echo 'checked="checked"'; }?>></td>
            <td width="70" style="margin:0;padding:0; text-align:center;"><?=dataUsaToBr($r->data_info_movimento)?></td>
        	<td width="200"onclick="opf(<?=$r->id?>)"><?=$cliente->razao_social ?></td>
          	<td width="200"><?=substr($r->descricao,0,40)?></td>
          	<td width="85" style="margin:0;padding:0; text-align:right"><?=$entrada?></td>
          	<td width="85" style="margin:0;padding:0; text-align:right"><?=$saida?></td>
          	<td width="85" style="margin:0;padding:0; text-align:right" >
			<? 
				if($filter_data != 1) { echo moedaUsaToBr($r->saldo); }
				if($total == 1 && $filter_data==1) { echo moedaUsaToBr($r->saldo); }
				if($total == $qtd_reg  && $filter_data==1) {echo moedaUsaToBr($r->saldo);}
			?></td>
          	<td width=""></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
    	  <td width="30"></td>
          	<td width="70"></td>
            <td width="200">&nbsp;</td>
            <td width="200">Total</td>
            <td width="85"align="right"><?=moedaUsaToBr(@array_sum($entrada_soma))?></td>
            <td width="85"align="right">-<?=moedaUsaToBr(@array_sum($saida_soma))?></td>
            <td width="85"align="right"><?=moedaUsaToBr($saldo)?></td>
          	<td width=""></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
