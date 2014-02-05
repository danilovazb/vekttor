<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 
//include("_functions.php");
//include("_ctrl.php");
?>
<script>
$(document).ready(function(){
	window.open('modulos/eleitoral/relatorios/eleitores_form.php','carregador');
});	

$(function(){
	window.open('<?=$caminho?>/eleitores_form.php','carregador');
})
;

$(".link_etiqueta").live('click',function(){
	
	var mes_aniversariante = $("#aniversariante").val();
	var cep_inicio         = $("#cep_inicio").val();
	var cep_fim            = $("#cep_fim").val();
	var grupo_social_id    = $("#grupo_social_id").val();
	var regiao_id          = $("#regiao_id").val();
	var estado             = $("#estado").val();
	var cidade             = $("#cidade").val();
	var bairro             = $("#bairro").val();
	var profissao_id       = $("#profissao_id").val();
	var sexo               = $("#sexo").val();
	var acao               = 'conta_eleitores';
	
	$.ajax({
	url:'modulos/eleitoral/eleitores/_ctrl.php?mes_aniversariante='+mes_aniversariante+'&cep_inicio='+cep_inicio+'&cep_fim='+cep_fim+'&grupo_social_id='+grupo_social_id+'&regiao_id='+regiao_id+'&estado='+estado+'&cidade='+cidade+'&bairro='+bairro+'&profissao_id='+profissao_id+'&sexo='+sexo+'&acao='+acao,	
	cache:false,
			success: function(data){
				
				$("#total_cadastros").html(data);
				
				total_paginas = data/30;
				total_paginas = total_paginas.toFixed(0);
				
				if(total_paginas<1){
					total_paginas=1;				
				}
				
				$("#total_paginas").html(total_paginas);
				$("#ate").val(total_paginas);
			}
		});		
});
$("#botao_etiqueta").live('click',function(){
	
	var mes_aniversariante = $("#aniversariante").val();
	var cep_inicio         = $("#cep_inicio").val();
	var cep_fim            = $("#cep_fim").val();
	var grupo_social_id    = $("#grupo_social_id").val();
	var regiao_id          = $("#regiao_id").val();
	var estado             = $("#estado").val();
	var cidade             = $("#cidade").val();
	var bairro             = $("#bairro").val();
	var profissao_id       = $("#profissao_id").val();
	var sexo               = $("#sexo").val();
	var acao               = 'imprimir_etiqueta';
	var max_paginas        = $("#ate").val();
	
	url='modulos/eleitoral/relatorios/impressao_etiqueta.php?mes_aniversariante='+mes_aniversariante+'&cep_inicio='+cep_inicio+'&cep_fim='+cep_fim+'&grupo_social_id='+grupo_social_id+'&regiao_id='+regiao_id+'&estado='+estado+'&cidade='+cidade+'&bairro='+bairro+'&profissao_id='+profissao_id+'&sexo='+sexo+'&acao='+acao+'&max_paginas='+max_paginas;
	
	window.open(url);
	
});
</script>