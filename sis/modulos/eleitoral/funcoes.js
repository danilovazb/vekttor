
function formatatelefone(campo){
	var telefone=campo.value;
	var traco="-";
	var parenteses="(";
	var parenteses2=")";
	var expr = /[0123456789()-]/;
	for(i=0;i<telefone.length;i++){
		var lchar = campo.value.charAt(i);
		var nchar = campo.value.charAt(i+1);
		if((lchar.search(expr) != 0)){
			campo.value=campo.value.substring(0,(i));
			break;
		}		
		if(telefone.length==1){
			campo.value=parenteses+telefone;
		}
		if(telefone.length==3){
			campo.value=telefone+parenteses2;
		}
		if(telefone.length==8){
			campo.value=telefone+traco;
		}
		if(telefone.length>13){
			campo.value = campo.value.substring(0,13);
 		}
	}
	return true;
}

function formatacpf(campo){
	var cpf=campo.value;
	var expr = /[0123456789]/;
	for(i=0;i<cpf.length;i++){
		var lchar = campo.value.charAt(i);
		var nchar = campo.value.charAt(i+1);
		if((lchar.search(expr) != 0)){
			campo.value=campo.value.substring(0,(i));
			break;
		}		
		if(cpf.length>11){
			campo.value = campo.value.substring(0,11);
 		}
	}
	return true;
}

function formataplaca(campo){
	var placa=campo.value;
	var traco="-";
	var expr1= /[0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-]/;
	for(i=0;i<placa.length;i++){
		var lchar = campo.value.charAt(i);
		var nchar = campo.value.charAt(i+1);
		if((lchar.search(expr1) != 0)){
			campo.value=campo.value.substring(0,(i));
			break;
		}
		if(placa.length==3){
			campo.value= placa+traco;
		}
		if(placa.length>8){
			campo.value= campo.value.substring(0,8);
		}
	}
	return true;
}


function verify_formulario(form){
	var error = '';	
	if((form.nome.value) == ''){
		error+='Campo NOME deve ser preenchido\n';	
	}
	if((form.cpf.value) == ''){
		error+='Campo CPF deve ser preenchido\n';	
	}
	if((form.email.value) == ''){
		error+='Campo EMAIL deve ser preenchido\n';	
	}
	if((form.telefone.value) == ''){
		error+='Campo TELEFONE deve ser preenchido\n';	
	}
	if(error != ''){
		alert(error);
		return false;		
	}
	
	return true;
}

function verify_final(form){
	var error = '';
	var cont=0;
	var ckbox_array= document.getElementsByTagName('input');
	if((form.matricula.value) == ''){
		error+='Campo Matricula deve ser preenchido\n';	
	}
	if((form.curso.value) == 0){
		error+='Selecione um curso\n';	
	}
	for (var i=0;i<ckbox_array.length;i++){
		if (ckbox_array[i].type=='checkbox' && ckbox_array[i].checked){
			cont++;
		}
	}
	if(cont==0){
		error+='Ao Menos um turno deve ser selecionado\n';
	}
	error+=verify_car(form);	
	if(error != ''){
		alert(error);
		return false;		
	}	
	return true;
}

function verify_car(form){
	var error = '';	
	if((form.placa.value) == ''){
		error+='Campo Placa do Carro deve ser preenchido\n';	
	}
	if((form.cor.value) == ''){
		error+='Campo Cor do Carro deve ser preenchido\n';	
	}
	if((form.marca.value) == ''){
		error+='Campo Marca do Carro deve ser preenchido\n';	
	}
	if((form.modelo.value) == ''){
		error+='Campo Modelo do Carro deve ser preenchido\n';	
	}
	if((form.ano.value) == ''){
		error+='Campo Ano do Carro deve ser preenchido\n';	
	}
	return error;
}

function formatadata(campo){
	var pass = campo.value;
	var expr = /[0123456789]/;
	
	for(i=0; i < pass.length; i++){
		var lchar = campo.value.charAt(i);
		var nchar = campo.value.charAt(i+1);
		if(i==0){
			if((lchar.search(expr) != 0) || (lchar > 3)){
				campo.value = '';
			}
			if((lchar==3) && (nchar>1)){
				campo.value = '';
			}
		}else if(i==1){
			if(lchar.search(expr) != 0){
				var tst1 = campo.value.substring(0,(i));
				campo.value = tst1;
				continue;
			}
			if((nchar != '/'	) && (nchar != '')){
				var tst1 = campo.value.substring(0,(i)+1);
				if(nchar.search(expr) != 0){
					var tst2 = campo.value.substring(i+2,pass.length);
				}else{
					var tst2 = campo.value.substring(i+1,pass.length);
				}
				campo.value = tst1 + '/' + tst2;
			}
		}else if(i==3){
			if((lchar.search(expr) != 0) || (lchar > 1)){
				campo.value='';
			}
			if((lchar == 1) && (nchar>2)){
				campo.value='';
			}
		}
		else if(i==4){
			if(lchar.search(expr) != 0){
				var tst1 = campo.value.substring(0,(i));
				campo.value = tst1;
				continue;
			}
			if((nchar != '/') && (nchar != '')){
				var tst1 = campo.value.substring(0,(i)+1);
				if(nchar.search(expr) != 0)
					var tst2 = campo.value.substring(i+2,pass.length);
				else
					var tst2 = campo.value.substring(i+1,pass.length);
				
				campo.value = tst1 + '/' + tst2;
			}
		}
		if(i >= 6){
			if(lchar.search(expr) != 0){
			var tst1 = campo.value.substring(0,(i));
					campo.value = tst1;
			}
		}
	}
	if(pass.length > 10)
		campo.value = campo.value.substring(0,10);
	return true;
}

function valida_cpf(campo){
	var cpf=campo.value;
	if((cpf.length != 11) || (cpf == 00000000000) || (cpf == 11111111111) || (cpf == 22222222222) || (cpf == 33333333333) || (cpf == 44444444444) || 
	(cpf == 55555555555) || (cpf == 66666666666) || (cpf == 77777777777) || (cpf == 88888888888) || (cpf == 99999999999)){
		alert("CPF Inválido");
		campo.value='';
    }else{
		for(var t=9;t<11;t++){
			var d=0;
			for(var c=0;c<t;c++){
				d+=cpf.charAt(c) * ((t+1)-c);
			}
			d=((10 * d) % 11) % 10;
			if (cpf.charAt(c) != d) {
                alert("CPF Inválido");
            	campo.value='';
			}
		}
	}
}

function blocknum(campo){
	var letras=campo.value; 	
	var expr = /[abcdefghijklmnopqrstuvwxyz]/;
	for(i=0; i < letras.length; i++){
		var lchar = campo.value.charAt(i);
		var nchar = campo.value.charAt(i+1);
		if(lchar.search(expr) != 0){
			campo.value=campo.value.substring(0,i);		
		}
	}
}

function blockletra(campo){
	var numeros=campo.value; 	
	var expr = /[0123456789]/;
	for(i=0; i < numeros.length; i++){
		var lchar = campo.value.charAt(i);
		var nchar = campo.value.charAt(i+1);
		if(lchar.search(expr) != 0){
			campo.value=campo.value.substring(0,i);		
		}
	}
}

function maiusculo(campo){
	campo.value.toUpperCase();	
}
