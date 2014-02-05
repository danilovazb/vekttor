// JavaScript Document



var dataBanco = "modulos/escolar2/calendario_escolar/dataBanco.php";
	function isNumeric(str){
  		var er = /^[0-9]+$/;
  		return (er.test(str));
	}	
	$("#sel_agenda").live("change",function(){
		var valOption = $(this).val();
			if(valOption == 'novo'){
				$("#editagenda").hide();
				window.open('modulos/escolar2/calendario_escolar/form_agenda.php','carregador');
			}
			else if(isNumeric(valOption) == true){
			 	$("#form_agenda").submit();
			}
	});
	$("#editagenda").live('click',function(){
				var id = $("select#sel_agenda").val();
				if(id != 0){
					window.open('modulos/escolar2/calendario_escolar/form_agenda.php?editAgenda='+id,'carregador');
				} else{ alert('Selecione uma agenda!'); return false;}
	})
	$("#filtar").live('click',function(){
			$("#form_agenda").submit();		
	})
	
	/*============================*/
	
	$(document).ready(function() {
		var calendar = $('#calendar').fullCalendar({
			header: {
				left: '',
				center: 'month,agendaWeek,agendaDay, title',
				right: 'prev,today,next'
			},
			eventClick: function(event) {
				 	event.url = "modulos/escolar2/calendario_escolar/form.php";
						if (event.url) {
							window.open(event.url+'?id='+event.id,'carregador');
							return false;
						}
			},
			selectable: true,
			selectHelper: true,
			select: function(start, end, allDay,startDate,endDate) {	
						var inicial = new Date(start);
						var final   = new Date(end);
						var dataInicial  = $.fullCalendar.formatDate(start, "dd/MM/yyyy");
						var dataFim      = $.fullCalendar.formatDate(end, "dd/MM/yyyy");
						var agenda_id = $("select#sel_agenda").val();
						
						console.log(start);
					/* Pegar data e hora Inicial */
						var mes = (inicial.getMonth())+1;
						
						  /*-Pegar Hora Inicial-*/
						  var hora_inicial = inicial.getHours()+":"+inicial.getMinutes();
					/* Pegar data e hora Final */ 
						var mes_fim = (final.getMonth())+1;
						
						  /*-Pegar Hora Final -*/
							var hora_final = final.getHours()+":"+final.getMinutes();
							window.open("modulos/escolar2/calendario_escolar/form.php?dataInicial="+dataInicial+'&horaInicial='+hora_inicial+'&dataFinal='+dataFim+'&horaFinal='+hora_final+'&agenda_id='+agenda_id,'carregador');
					
					/*Aqui a seleçao fica marcado na agenda*/
					if (title) {
						calendar.fullCalendar('renderEvent',
							{
								title: title,
								start: start,
								end: end,
								allDay: allDay
							},
							true // make the event "stick"
						);
					}
					calendar.fullCalendar('unselect');
			},
			editable: true, 
			events: 'modulos/escolar2/calendario_escolar/listaEventos.php?agenda_id='+$("#agenda_id").val(), 		
			eventDrop: function(event, delta) {
				var dataStartUpdate  = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd");
				var horaStartUpdate  = $.fullCalendar.formatDate(event.start, "HH:mm");
				
				var dataEndUpdate  = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd");
				var horaEndUpdate  = $.fullCalendar.formatDate(event.end, "HH:mm");
				$.post("modulos/escolar2/calendario_escolar/dataBanco.php",{acao:'update',id:event.id,dataInicio:dataStartUpdate,horaInicio:horaStartUpdate,dataFim:dataEndUpdate,horaFim:horaEndUpdate});
			},
			loading: function(bool) {
				if (bool) 
					$('#loading').show();
				else 
					$('#loading').hide();
			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
				var dataEndUpdate  = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd");
				var horaEndUpdate  = $.fullCalendar.formatDate(event.end, "HH:mm");
				$.post("modulos/escolar2/calendario_escolar/dataBanco.php",{acao:"updateResize",id:event.id,dataFim:dataEndUpdate,horaFim:horaEndUpdate});

    		},
			  
			/*eventMouseover: function(calEvent, jsEvent) {
					//var tooltip = '<div class="tooltipevetn" style="width:100px;height:100px;background:#ccc;position:absolute;z-index:10001;"><a>x<a/>' + calEvent.title + '</div>';
					var tooltip = '<div style="position:relative;background:#ccc; padding-top:3px;" class="tooltipevetn">\
					<div  style="text-align:center;width:100px;z-index:30001;"><span style="text-align:right;"><a href="#" style="color:#000;"> x </a></span></div></div>';
					$(this).append(tooltip);
					$(this).mouseover(function(e) {
						$(this).css('z-index', 10000);
						//$('.tooltipevetn').css('top', e.pageY + 10);
						//$('.tooltipevetn').fadeIn('500');
						//$('.tooltipevetn').fadeTo('10', 1.9);
					});
					$(this).mousemove(function(e) {
						//$('.tooltipevetn').css('top', e.pageY + 10);
						//$('.tooltipevetn').css('left', e.pageX + 20);
						//$('.tooltipevetn').css('top', e.pageY + 10);
						//$('.tooltipevetn').css('left', e.pageX + 20);
					});
			},
			eventMouseout: function(calEvent, jsEvent) {
				$(this).css('z-index', 8);
				$('.tooltipevetn').remove();
			},*/
			/*--*/
		});
		//calendar.fullCalendar('refetchEvents',{ title: "New title", start: "2012-11-29 12:00:00", end: "2012-11-29 13:00:00", allDay: false},true);
		//calendar.fullCalendar( 'refetchEvents', { id: '72'});
		//var event = calendar.fullCalendar('clientEvents',{id:72});
		//alert(event.title);
}); /*-fim script calendario-*/
