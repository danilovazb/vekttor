// JavaScript Document


function atualizaAtendimento(){
	$("#action_aba").val('Salvar');
	$('#formulario_atendimento').submit();
	$("#action_aba").val('');
}

function atualizaProcedimentos(){
	d = new Date();
	atendimento_id=$("#atendimento_id").val();
	if(atendimento_id>0){
		$.ajax({
			cache:false,
			data:{atendimento_id:atendimento_id},
			url:"modulos/odonto/atendimento/carrega_procedimentos.php",
			success: function(data){
				$("#procedimentos_container").html(data);
				dentes=$("#footer").attr('dentes').split('|');
				$("#arcada .dente").each(function(index, element) {
					dente_id=$(this).attr('dente_id')
					$(this).removeClass('dente'+dente_id+'hover');
					if($.inArray(dente_id,dentes)>-1){
						$(this).addClass('dente'+dente_id+'hover');
					}
                });
			}
		})
	}
}

function atualizaProcedimentosAprovados(){
	d = new Date();
	atendimento_id=$("#atendimento_id").val();
	consulta_id=$("#consulta_id").val();
	$("#procedimentos_aprovados_container").load('modulos/odonto/atendimento/carrega_procedimentos_aprovados.php?atendimento_id='+atendimento_id+'&consulta_id='+consulta_id+'&d='+d.getMilliseconds())
}
function atualizaHistoricoConsultas(){
	d = new Date();
	atendimento_id=$("#atendimento_id").val();
	if(atendimento_id>0){
		$.ajax({
			cache:false,
			data:{atendimento_id:atendimento_id},
			url:"modulos/odonto/atendimento/carrega_historico_consultas.php",
			success: function(data){
				$("#historico_consultas").html(data);
			}
		})
	}
	//$("#historico_consultas").load('modulos/odonto/atendimento/carrega_historico_consultas.php?atendimento_id='+atendimento_id+'&d='+d.getMilliseconds())
}

function abreConsultasProcedimento(procedimento_id,servico,dente_id){
	d = new Date();
	atendimento_id=$("#atendimento_id").val();
	$("#status_item_consulta").attr('checked', false);
	$("#historico_obs").show();
	img=$("<img src='../fontes/img/carregando.gif'  height='100' />");
	$("#lista_obs").html('');
	$("#lista_obs").append(img);
	$.ajax({
		  cache:false,
		  data:{atendimento_id:atendimento_id,procedimento_id:procedimento_id,servico:encodeURI(servico),dente_id:dente_id},
		  url:"modulos/odonto/atendimento/carrega_historico_obs.php?d="+d.getMilliseconds(),
		  success: function(data){
			$("#procedimento_aprovado_id").val(procedimento_id);
			$("#lista_obs").html(data);
		}
	})
}

function incluirConsultaProcedimento(){
	$("#action_aba").val('Incluir Consulta');
	$("#formulario_atendimento").submit();
	$("#action_aba").val('');
	$("#obs_procedimento_consulta").val('');
	$("#historico_obs").hide();
	$("#lista_obs").html('');
	//atualizaHistoricoConsultas();
}

function excluirConsultaProcedimento(id,t){
	window.open('modulos/odonto/atendimento/recebe_acao.php?action=Excluir Consulta&consulta_id='+id,'carregador');
	$(t.parentNode.parentNode).remove();
}

function manipulaAprovacao(t){
	tr = $(t.parentNode.parentNode);
	inputs = tr.find('.preco_procedimento');
	procedimento_id=$(t).val();
	if($(t).is(':checked')){
		window.open('modulos/odonto/atendimento/recebe_acao.php?action=aprova&procedimento_id='+procedimento_id,'carregador');
		console.log('aprovou');
		inputs.attr('disabled','disabled');
	}else{
		window.open('modulos/odonto/atendimento/recebe_acao.php?action=desaprova&procedimento_id='+procedimento_id,'carregador')
		console.log('desaprovou');
		inputs.attr('disabled',false);
	}
}

function manipulaPreco(t){
	valor=moedaBrToUsa($(t).val());procedimento_id=$(t).attr('id');
	window.open('modulos/odonto/atendimento/recebe_acao.php?action=alterapreco&procedimento_id='+procedimento_id+'&valor_procedimento_item='+valor,'carregador');
	total=0
	$('.preco_procedimento').each(function(index, element) {
        total+=parseFloat(moedaBrToUsa($(this).val()));
    });
	
	$("#total_preco_procedimentos").text(moedaUsaToBR(total));
}

function abreDente(dente_id,nome_dente){
	if(dente_id>48){
		$(".faces_dente").hide();
	}else{
		$(".faces_dente").show()
	}
	$("#procedimento_novo_form").show();
	$("#dente_id").val(dente_id);
	$("#nome_dente").text('('+dente_id+')'+nome_dente);
}

function abreAnalise(procedimento_id,tipo,dente_id){
	$.ajax({
		url: 'modulos/odonto/atendimento/recebe_acao.php?action=abreprocedimento&procedimento_id='+procedimento_id+'&tipo_procedimento='+tipo,
		success: function(data){
			dados=data.split('|');
			$("#nome_dente_editado").text(dente_id);
			$("#procedimento_editavel_item_id").val(dados[0]);
			$("#procedimento_editavel_id").val(dados[1]);
			$("#procedimento_editavel").val(dados[2]);
			$("#dente_id_editavel").val(dados[3]);
			$("#obs_procedimento_editavel").val(dados[4]);
			$("#tipo_procedimento").val(dados[5]);
			$("#edita_procedimento_form").show();
		}
	});
}

function incluirAnalise(){
	$("#action_aba").val('Incluir Análise');
	$("#formulario_atendimento").submit();
	$("#action_aba").val('');
	fechaDente();
	//atualizaProcedimentos();
	
}
function editarAnalise(){
	$("#action_aba").val('Editar Análise');
	$("#formulario_atendimento").submit();
	$("#action_aba").val('');
	fechaDente();
	atualizaProcedimentos();
}
function excluirAnalise(){
	$("#action_aba").val('Excluir Análise');
	$("#formulario_atendimento").submit();
	$("#action_aba").val('');
	fechaDente();
	//atualizaProcedimentos();
}

function fechaDente(){
	$("#dente_id").val('');
	$("#action_aba").val('');
	$("#procedimento_id").val('')
	$("#procedimento").val('')
	$("#obs_procedimento").val('')
	$("#procedimento_passado_id").val('')
	$("#procedimento_passado").val('')
	$("#obs_procedimento_passado").val('')
	$(".face_dente").attr('checked',false);
	$("#procedimento_editavel").val('')
	$("#procedimento_editavel_id").val('')
	$("#obs_procedimento_editavel").val('')
	$("#procedimento_editavel_item_id").val('')
	$("#tipo_procedimento").val('')
	$("#dente_id_editavel").val('')
	$("#procedimento_novo_form").hide();
	$("#edita_procedimento_form").hide();
}
