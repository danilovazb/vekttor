// JavaScript Document
var dataBanco = "modulos/agendamento/agenda_diaria/dataBanco.php";
	function isNumeric(str){
  		var er = /^[0-9]+$/;
  		return (er.test(str));
	}	
	$("#sel_agenda").live("change",function(){
		var valOption = $(this).val();
			if(valOption == 'novo'){
				$("#editagenda").hide();
				console.log(valOption);
				window.open('modulos/agendamento/agenda_diaria/form_agenda.php','carregador');
			}
			else if(isNumeric(valOption) == true){
				console.log(valOption);
			 	$("#form_agenda").submit();
			}
	});
	$("#editagenda").live('click',function(){
				var id = $("select#sel_agenda").val();
				console.log(id);
				if(id != 0){
					window.open('modulos/agendamento/agenda_diaria/form_agenda.php?editAgenda='+id,'carregador');
				} else{ alert('Selecione uma agenda!'); return false;}
	})
	$("#filtar").live('click',function(){
			$("#form_agenda").submit();		
	})
	
	
	$(document).ready(function() {
		var calendar = $('#calendar').fullCalendar({
			header: {
				left: '',
				center: 'month,agendaWeek,agendaDay, title',
				right: 'prev,today,next'
			},
			eventClick: function(event) {
				event.url = "modulos/agendamento/agenda_diaria/form.php";
					
				  if (event.url) {
					  window.open(event.url+'?id='+event.id,'carregador');
					  return false;
				  }
			},
			
			
			
			selectable: true,
			selectHelper: true,
			select: function(start, end, allDay) {	
				  
				  var inicial = new Date(start);
				  var final   = new Date(end);
				  var dataInicial  = $.fullCalendar.formatDate(start, "dd/MM/yyyy");
				  var dataFim      = $.fullCalendar.formatDate(end, "dd/MM/yyyy");
				  var agenda_id = $("select#sel_agenda").val();
				  var agenda = $("select#sel_agenda option:selected").text();
				
				 	
				  /* Pegar data e hora Inicial */
				      var mes = (inicial.getMonth())+1;
				  /*-Pegar Hora Inicial-*/
					  var hora_inicial = inicial.getHours()+":"+inicial.getMinutes();
				  /* Pegar data e hora Final */ 
					  var mes_fim = (final.getMonth())+1;
				  /*-Pegar Hora Final -*/
					  var hora_final = final.getHours()+":"+final.getMinutes();
							
					window.open("modulos/agendamento/agenda_diaria/form.php?dataInicial="+dataInicial+'&horaInicial='+hora_inicial+'&dataFinal='+dataFim+'&horaFinal='+hora_final+'&agenda_id='+agenda_id,'carregador');
					
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
			events: 'modulos/agendamento/agenda_diaria/listaEventos.php?agenda_id='+$("#agenda_id").val(), 		
			eventDrop: function(event, delta) {
				var dataStartUpdate  = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd");
				var horaStartUpdate  = $.fullCalendar.formatDate(event.start, "HH:mm");
				
				var dataEndUpdate  = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd");
				var horaEndUpdate  = $.fullCalendar.formatDate(event.end, "HH:mm");
				$.post("modulos/agendamento/agenda_diaria/dataBanco.php",{acao:'update',id:event.id,dataInicio:dataStartUpdate,horaInicio:horaStartUpdate,dataFim:dataEndUpdate,horaFim:horaEndUpdate});
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
				$.post("modulos/agendamento/agenda_diaria/dataBanco.php",{acao:"updateResize",id:event.id,dataFim:dataEndUpdate,horaFim:horaEndUpdate});

    		},
			
			droppable: true, // this allows things to be dropped onto the calendar !!!

			drop: function(date, allDay) { // this function is called when something is dropped

				// retrieve the dropped element's stored Event Object

				var originalEventObject = $(this).data('eventObject');
				console.log(originalEventObject);
				// we need to copy it, so that multiple events don't have a reference to the same object

				var copiedEventObject = $.extend({}, originalEventObject);			

				// assign it the date that was reported

				copiedEventObject.start = date;

				copiedEventObject.allDay = allDay;
				
				var HoraInicio  = $.fullCalendar.formatDate(copiedEventObject.start, "HH:mm");
				
				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)

				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
				
				$(this).remove();

			}

			  
		});
		//calendar.fullCalendar('refetchEvents',{ title: "New title", start: "2012-11-29 12:00:00", end: "2012-11-29 13:00:00", allDay: false},true);
		//calendar.fullCalendar( 'refetchEvents', { id: '72'});
		//var event = calendar.fullCalendar('clientEvents',{id:72});
		//alert(event.title);
}); /*-fim script calendario-*/
