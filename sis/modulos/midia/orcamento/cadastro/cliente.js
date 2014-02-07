// JavaScript Document
$(function(){
	
  $.fn.serializeObject = function(){
	  var o = {};
	  var a = this.serializeArray();
	  $.each(a, function() {
		  if (o[this.name] !== undefined) {
			  if (!o[this.name].push) {
				  o[this.name] = [o[this.name]];
			  }
			  o[this.name].push(this.value || '');
		  } else {
			  o[this.name] = this.value || '';
		  }
	  });
	  return o;
  };
	
	var ClassAjax = "modulos/midia/class/Ajax.class.php";
	
	
	$(document).on('click',"#cadastra_cliente",function(){
		
		var dados = $("#add_form_cliente").serialize();
		console.log(dados);
		$.ajax({
			url:"modulos/midia/orcamento/cadastro/cadastro_cliente.php",
			type:"POST",
			data:dados,
			success: function(ret){
			}
		});
		
	})
});