/*- script para notificacao -*/
 $(function(){
		$(".vkt_notificacao").live("click",function(){		
			var x = $(this).attr('id');
				if(x==1){
					$("#notification").hide();
					$(this).attr('id', '0'); 
				}
				else{
					$("#notification").show();
					$(this).attr('id', '1');
				}
		});
		/*--*/
		$("#notification").mouseup(function(){
			return false
		});
		$(".vkt_notificacao").mouseup(function(){
			return false
		});
		//Document Click
		$(document).mouseup(function(){
			$("#notification").hide();
			$(".vkt_notificacao").attr('id', '');
		});
		
		/* - click notificacao - */
		$(".item-notification").live('click',function(){
			var tela_id = $(this).prev('input').val();
			location.href="?"+tela_id;
		}); 
		
		

  /*
  * script para balão
  * data-placement  top | bottom | left | right
  */
	$("a,input,button,img,select").each(function(){
		var title = $(this).attr('title');
		var id = $(this).attr('id');
		  if(title != null){
			  $("#"+id).tooltip();
		  }
	});		
});

/* rel="tip" */
$("a,input,button,img,select,td").live('hover',function(){
	$(this).each(function(){
		$("[rel=tip]").tooltip();
	});
});

 var j = 0;
 var chamaNotificacao = function(){
	$.ajax({
		url:'modulos/notificacao/notificacao.php',
		dataType:"json",
		success: function(data){
		var htmlnotificacao = ""; var modal = "";
			 
			$.each(data.result,function(i,item){
				j = item.totalreg;
				if(item.titulo != "contagem" && item.qtd != 0){
					
					htmlnotificacao += '<input type="hidden" name="tela" id="tela" value="'+item.tela_id+'">'+
				   '<div class="item-notification"><blockquote>'+
						'<div style="padding:1px;" class="lista_item">'+
							'<div id="qtd"><span class="badge badge-important">'+item.qtd+'</span></div>'+
							'<div style="font-weight: 300;margin-bottom: 0;padding:0px 0px 0px 0;font-size: 14px;line-height: 23px;"> '+item.titulo+'</div>'+
						'</div>'+
						'<small>'+item.descricao+' <cite title="Source Title"> click aqui para ver</cite></small>'+
				   '</blockquote></div>';
				
				} else{
							  
				 if(j > 0)
					$(".vkt_notificacao").show();
							
				 }
			});
			
				modal = "<div class='vkt_notificacao btn' style='float:right; margin-top:3px; margin-right:5px;' >"+
				 "<img src='../fontes/img/bell.png'><span class='label-notificacao badge-important'>"+j+"</span>"+
				"</div>"+
				"<div id='notification' style='display:none'>"+
				 "<div class='modal' style='right:3%; top:4%; width:320px'>"+
				   "<div class='modal-header'><h4>Notifica&ccedil;&otilde;es</h4>  </div>"+
				   "<div class='modal-body'>"+htmlnotificacao+"</div>"+
				   "<div class='modal-footer'><div style='padding:8px;'></div></div>"+
				   "</div>"+
				 "</div>";
				 $("#navegacao").append(modal);
				  
		}//-success
	});//-ajax
}
 
/*- fim script para notificacao -*/
$(".modal_close").live("click",function(){
	var modal = $(this).parent().parent();
	
	modal.hide('slow');
});