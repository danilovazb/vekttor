<?
$salamateria = mysql_fetch_object(mysql_query("SELECT * FROM escolar_sala_materia_professor WHERE vkt_id='$vkt_id' AND id='".$_GET[salamateria_id]."'"));

$materia = mysql_fetch_object(mysql_query("SELECT * FROM escolar_materias WHERE id='$salamateria->materia_id' "));


$professor = mysql_fetch_object(mysql_query("SELECT p.* FROM escolar_professor as ep,cliente_fornecedor as p WHERE ep.cliente_fornecedor_id = p.id AND  ep.id='$salamateria->professor_id' "));
//print_r($professor);

?>
<script>
$('.ops').live('click',function(){
	aula_id=$(this).attr('id');
	
	location = '?tela_id=288&aula_id='+aula_id;
});
</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a><a href="?tela_id=231" class="navegacao_ativo">
<span></span>Tradução
</a>
</div>
<div id="barra_info">
De:
<select id="origem">
	<option value="en">Inglês</option>
    <option value="pt">Português</option>
</select>
Para:
<select id="destino">
	<option value="pt">Português</option>
    <option value="en">Inglês</option>
</select>
<input type="button" onClick="traduzir();" value="Traduzir" />
</div>

<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table width="100%" cellpadding="0" cellspacing="0">
	<thead>
    	<tr><td>Tradução</td></tr>
    </thead>
</table>
<label style="float:left; margin-left:30px; margin-top:10px;">
Texto a ser traduzido:
	<textarea style="display:block; width:320px; height:200px; border-radius:5px;" id="texto"></textarea>
</label>
    <div id="retorno_traducao" style="float:left; margin-left:40px; margin-top:10px;">
		<span>Texto Traduzido</span>
        <div id="texto_traduzido" style="display:block; padding:5px; height:200px; width:320px; border:solid 1px black; border-radius:5px;">
        
        </div>    
    </div>
</div>

</div>
<script>
	function traduzir(){
		origem=$("#origem option:selected").val();
		destino=$("#destino option:selected").val();
		
		texto=escape($("#texto").val());
		
		$.get('<?=$tela->caminho?>/retorna_traducao.php?origem='+origem+'&destino='+destino+'&texto=' + texto, function(data){
   			retorno= data;
			$('#texto_traduzido').html(unescape(retorno));
		});
		
	}
	
	/*
	function traduzir2(){
		origem=$("#origem option:selected").val();
		destino=$("#destino option:selected").val();
		texto=escape($("#texto").val());
		
		$.ajax({
			url:'<?=$tela->caminho?>/retorna_traducao.php?origem='+origem+'&destino='+destino+'&texto=' + texto,
			
		}).done(function(data){
			retorno= data;
			$('#texto_traduzido').html(unescape(retorno));
		})
	}*/
</script>
<div id='rodape'>
  <div style="float:right; margin:0px 20px 0 0"></div>
</div>
