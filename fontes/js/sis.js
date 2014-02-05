function resize(){
	h =document.body.clientHeight;
	document.getElementById('dados').style.height=(h-113)+'px';
}


function addRef(t){
	if(t.getAttribute('src')=='../fontes/img/mais.png'){
		div_subplano = t.parentNode.parentNode.cloneNode(1);
		nova_class = (t.parentNode.parentNode.className=='al')?'':'al';
		div_subplano.className=nova_class;
		insertAfter(div_subplano,t.parentNode.parentNode);
		t.src='../fontes/img/menos.png';
	}else{
		t.parentNode.parentNode.parentNode.removeChild(t.parentNode.parentNode)
	}
}


var cont=1;


function addProdutoEstoque(t){
	if(t.getAttribute('src')=='../fontes/img/mais.png'){
		//copia o elemento modelo
		div_subplano = t.parentNode.parentNode.cloneNode(1);
		/***** atribui a coloração *****/
		nova_class = (t.parentNode.parentNode.className=='al')?'':'al';
		div_subplano.className=nova_class;
		/***** pega os elementos para manipulação *****/
		inputs = div_subplano.getElementsByTagName('input');
		spans=div_subplano.getElementsByTagName('span');
		/***** incrementa para nao haver repeticao de IDS *****/
		spans[0].setAttribute('id','produto_valor'+cont);
		inputs[0].setAttribute('id','produto_id'+cont);
		inputs[1].setAttribute('id','produto'+cont);
		/* implementa a função */
		inputs[1].setAttribute('busca','modulos/cozinha/ficha_tecnica/busca_materia_prima.php,@r0,@r1-value>produto_id'+cont+'|@r2-innerHTML>produto_valor'+cont+',0');
		/***** zera os valores *****/
		inputs[1].setAttribute('onkeyup','');
		spans[0].innerHTML='';
		spans[1].innerHTML='';
		inputs[0].value='';
		inputs[1].value='';
		inputs[2].value='';
		
		/***** corre pro abraço *****/
		insertAfter(div_subplano,t.parentNode.parentNode);
		t.src='../fontes/img/menos.png';
		cont++;
	}else{
		t.parentNode.parentNode.parentNode.removeChild(t.parentNode.parentNode)
	}
}



///
function insertAfter(newElement,targetElement) {
	var parent = targetElement.parentNode;
	if(parent.lastchild == targetElement) {
		parent.appendChild(newElement);
	} else {
		parent.insertBefore(newElement, targetElement.nextSibling);
	}
}

function aba_form(t,n){
	fields_i = t.parentNode.parentNode.parentNode.getElementsByTagName('fieldset');
	fields_total = fields_i.length;
	for(i=0;i<fields_total;i++){
		fields_i[i].style.display='none';
	}
	fields_i[n].style.display='';
}

function add_element(t){
	newdiv=document.createElement("div");
	x=t.parentNode.parentNode;
	divs = 	x.getElementsByTagName('div').length;
	newdiv.innerHTML=x.getElementsByTagName('div')[0].innerHTML;
	
	//
	
	// Limpar Campos de todos os tipos
	
	///
	newdiv.setAttribute("style",x.getElementsByTagName('div')[0].getAttribute("style"));
	newdiv.setAttribute("class",x.getElementsByTagName('div')[0].getAttribute("class"));
	insertAfter(newdiv,x.getElementsByTagName('div')[divs-2])
}

function del_element(t){
	x=t.parentNode.parentNode;
	if(x.getElementsByTagName('div').length>2){
		x.removeChild(t.parentNode);
	}
}

/********Drag And Drop********/


function movemouse(e){
 if (isdrag){
   dobj.parentNode.parentNode.parentNode.style.left = nn6 ? tx + e.clientX - x+"px" : tx + event.clientX - x+"px";
   dobj.parentNode.parentNode.parentNode.style.top  = nn6 ? ty + e.clientY - y+"px" : ty + event.clientY - y+"px";
   return false;
 }
}

function secal(e){
 var fobj       = nn6 ? e.target : event.srcElement;
 var topelement = nn6 ? "HTML" : "BODY";
 if (fobj.getAttribute("calendario")){
	 ano = fobj.value.substr(6,4)*1 ;
	 mes = fobj.value.substr(3,2)*1 ;
	criaCalendario(mes,ano,fobj.id);
 }
}
function selectmouse(e){
 var fobj       = nn6 ? e.target : event.srcElement;
 var topelement = nn6 ? "HTML" : "BODY";
 if (fobj.getAttribute("calendario")){
 	 ano = fobj.value.substr(6,4)*1 ;
	 mes = fobj.value.substr(3,2)*1 ;
	criaCalendario(mes,ano,fobj.id);
 }
 while (fobj.tagName != topelement && fobj.className != "dragme"){
   fobj = nn6 ? fobj.parentNode : fobj.parentElement;
 }
 /*
 if (fobj.className=="dragme"){
   isdrag = true;
   dobj = fobj;
   tx = parseInt(dobj.parentNode.parentNode.style.left+0,10);
   ty = parseInt(dobj.parentNode.parentNode.style.top+0,10);
   x = nn6 ? e.clientX : event.clientX;
   y = nn6 ? e.clientY : event.clientY;
   document.onmousemove=movemouse;
   return false;
 }*/
 
}

function doGetCaretPosition (oField) {
 var iCaretPos = 0;
 if (document.selection) { 
   oField.focus ();
   var oSel = document.selection.createRange ();
   oSel.moveStart ('character', -oField.value.length);
   iCaretPos = oSel.text.length;
 }
 else if (oField.selectionStart || oField.selectionStart == '0')
   iCaretPos = oField.selectionStart;
 return (iCaretPos);
}
function doSetCaretPosition (oField, iCaretPos) {
 if (document.selection) { 
   oField.focus ();
   var oSel = document.selection.createRange ();
   oSel.moveStart ('character', -oField.value.length);
   oSel.moveStart ('character', iCaretPos);
   oSel.moveEnd ('character', 0);
   //oSel.select ();
 }
 else if (oField.selectionStart || oField.selectionStart == '0') {
   oField.selectionStart = iCaretPos;
   oField.selectionEnd = iCaretPos;
   oField.focus ();
 }
}

function formataExclui(e){
	 var fobj       = nn6 ? e.target : event.srcElement;
	 var code       = nn6 ? e : event;
	
	if(fobj.value=='Excluir'){
		if(!confirm('Confirma Exclusão ?')){
			return false;
		}
	}
}
function formataCampo(e){
	 var fobj       = nn6 ? e.target : event.srcElement;
	 var code       = nn6 ? e : event;

	posicao=doGetCaretPosition (fobj)*1;
	//posicao_fim=fobj.selectionEnd*1;
	//selecao = posicao_fim-posicao;
	if(code.keyCode==13&&fobj.type!='textarea'){ return false;}
//	document.title=fobj.type;
	if(code.keyCode==9||code.keyCode==46){
		return true;
	}
	if(!fobj.getAttribute('onblur')){
		fobj.setAttribute("onblur",'validaCampo(this);');
	}
	if(fobj.getAttribute('busca')&&!fobj.getAttribute('onkeyup')){
		fobj.setAttribute("onkeyup",retornaBusca(fobj.getAttribute('busca'),fobj));
	}
	
	if (fobj.getAttribute("calendario")){
	 	 ano = fobj.value.substr(6,4)*1 ;
		 mes = fobj.value.substr(3,2)*1 ;

		criaCalendario(mes,ano,fobj.id)
	}
	if(fobj.getAttribute('mascara')){
		formatamasck = fobj.getAttribute('mascara')
		valor = fobj.value;
		valor_tamanho = valor.length;
		
		caractere = String.fromCharCode(soNumero(code.keyCode));
		if(soNumeroC(String.fromCharCode(soNumero(code.keyCode)))==false && fobj.getAttribute('sonumero')=='1' && code.keyCode!=8 && code.keyCode!=37 && code.keyCode!=38 && code.keyCode!=39&& code.keyCode!=40&& code.keyCode!=46){
			return false
		}
		
		if(formatamasck.length>0){
			if(code.keyCode!=8&&soNumero(code.keyCode)>0){				
				novovalor=valor.substr(0,posicao)+caractere+valor.substr(posicao,valor.length);
				/*
				if(selecao==0){
					novovalor=valor.substr(0,posicao)+caractere+valor.substr(posicao,valor.length);
				}else{
					novovalor=valor.substr(0,posicao)+caractere+valor.substr(posicao_fim,valor.length);
					
										
					novovalor = novovalor
				}*/
				novovalor= limpaFormatacao(novovalor);
				retornoda_funcao=formataMascara(formatamasck,novovalor);
				fobj.value=retornoda_funcao;
				//document.title=retornoda_funcao[1];
				
					//document.title="sonumero:"+retornoda_funcao+" - Posicao:"+posicao+" - Ultimo Caracter+1:"+soNumeroC(retornoda_funcao.substr(posicao+1,1));
				if(posicao==0&&retornoda_funcao.substr(posicao,1)=='('){
						doSetCaretPosition(fobj,posicao*1+2);
						doSetCaretPosition(fobj,posicao*1+2);
				}else{
					
					if(retornoda_funcao.substr(posicao+1,1)!="_" && soNumeroC(retornoda_funcao.substr(posicao+1,1))==false){
	
						doSetCaretPosition(fobj,posicao*1+2);
						doSetCaretPosition(fobj,posicao*1+2);
					}else{
						doSetCaretPosition(fobj,posicao*1+1);
						doSetCaretPosition(fobj,posicao*1+1);
						
					}
				}
				return false;
			}
		}
	}
	
	if(fobj.getAttribute('decimal')&&fobj.getAttribute('decimal')>0&&code.keyCode!=8&&soNumero(code.keyCode)>0){
	
		if(soNumeroC(String.fromCharCode(soNumero(code.keyCode)))==false && fobj.getAttribute('sonumero')=='1' && code.keyCode!=8 && code.keyCode!=37 && code.keyCode!=38 && code.keyCode!=39&& code.keyCode!=40&& code.keyCode!=46){
			return false
		}
		valor = fobj.value;
		fobj.style.textAlign='right';
		strvalor='';
		flagZero=0;
		for(i=0;i<valor.length;i++){
			if((valor.substr(i,1)!='0') || flagZero==1){
				if(valor.substr(i,1)!=','&&valor.substr(i,1)!='.'){
					strvalor=strvalor+valor.substr(i,1);
				}
				flagZero=1;
			}
		}
		
		caractere = String.fromCharCode(soNumero(code.keyCode));
		novovalor = strvalor+caractere;
		decimal = fobj.getAttribute('decimal')*1;
		tamanho_valor = novovalor.length*1; 
		// 13.456
		// 
		// 6-5 = 1
		if(tamanho_valor>decimal){
			valorinfo=novovalor.substr(0,tamanho_valor-decimal)+','+novovalor.substr(tamanho_valor-decimal,tamanho_valor)+'';
			valorinfo_split = valorinfo.split(",");
			valorinfo_split_t = valorinfo_split[0].length;
			if(valorinfo_split_t>3&&valorinfo_split_t<=6){valorinfo=valorinfo_split[0].substr(0,valorinfo_split_t-3)+'.'+valorinfo_split[0].substr(valorinfo_split_t-3,3)+','+valorinfo_split[1];}
			if(valorinfo_split_t>6&&valorinfo_split_t<=9){valorinfo=valorinfo_split[0].substr(0,valorinfo_split_t-6)+'.'+valorinfo_split[0].substr(valorinfo_split_t-6,3)+'.'+valorinfo_split[0].substr(valorinfo_split_t-3,3)+','+valorinfo_split[1];}
			fobj.value=valorinfo;
		}else{
			valorinfo= "0,";
			for(i=0;i<decimal-tamanho_valor;i++){
				valorinfo = valorinfo+'0';
			}
			fobj.value=valorinfo+''+novovalor;
		}
		return false;
 	}

	if(soNumeroC(String.fromCharCode(soNumero(code.keyCode)))==false && fobj.getAttribute('sonumero')=='1' && code.keyCode!=8 && code.keyCode!=37 && code.keyCode!=38 && code.keyCode!=39&& code.keyCode!=40&& code.keyCode!=46){
		return false
	}


}

/*
1 => 0,1 ou 0,01 ou 0,001
12 = 0,12
13 = 1,23
120 =>123,00
120,00 => 123,00

123,23 =>123,23
456.123.456,00
*/

function formataMascara(mascara,valor){
	tamanho_mascara = mascara.length
	tamanho_valor = valor.length
	novastring ="";
	mascara_adicao=0;
	for(i=0;i<tamanho_mascara;i++){
			if(valor.substr(i,1)!=''&& mascara.substr(i+mascara_adicao,1)=='_'){
				novastring = novastring+valor.substr(i,1);
			}
			if(valor.substr(i,1)!=''&& mascara.substr(i+mascara_adicao,1)!='_'){
				novastring = novastring+mascara.substr(i+mascara_adicao,1)+valor.substr(i,1);
				mascara_adicao++;
			}
			if(valor.substr(i,1)==''){
				novastring = novastring+mascara.substr(i+mascara_adicao,1);
			}
	}
	return novastring.substr(0,tamanho_mascara);
}


function limpaFormatacao(a){
	var natural_value = "";
	for (i=0; i<a.length++; i++){
		caracter = a.substring(i,i+1);
		switch (caracter){
			case ".":
				break;
			case ",":
				break;
			case "/":
				break;
			case "-":
				break;
			case "(":
				break;
			case ")":
				break;
			case " ":
				break;
			case ":":
				break;
			case "|":
				break;
			case "_":
				break;
			default:
				natural_value = natural_value + caracter;
		}
	}
	return natural_value;
}

function soNumero(a){
	if (a==96||a==48) return 48;  // number 0
	if (a==97||a==49) return 49;  // number 1
	if (a==98||a==50) return 50;  // number 2
	if (a==99||a==51) return 51;  // number 3
	if (a==100||a==52) return 52;  // number 4
	if (a==101||a==53) return 53;  // number 5
	if (a==102||a==54) return 54;  // number 6
	if (a==103||a==55) return 55;  // number 7
	if (a==104||a==56) return 56;  // number 8
	if (a==105||a==57) return 57;  // number 9
	if (a==111||a==191) return 32;  // number 9
	if (a==109) return 32;  // number 9
	if (a==188)return false;  // number 9
	if (a==65)return false;  // number 9
	if (a==32)return false;  // number 9
	if (a==190)return false;  // number 9
	if (a==49)return false;  // number 9
	if(a==20)return false
	if(a==16)return false
	if(a==17)return false
	if(a==18)return false
	if(a==37)return false
	if(a==40)return false
	if(a==39)return false
	if(a==38)return false
	if(a==37)return false
	if(a==224)return false
	return a
}
function soNumeroC(a){
	if (a==1) return true;  // number 0
	if (a==2) return true;  // number 0
	if (a==3) return true;  // number 0
	if (a==4) return true;  // number 0
	if (a==5) return true;  // number 0
	if (a==6) return true;  // number 0
	if (a==7) return true;  // number 0
	if (a==8) return true;  // number 0
	if (a==9) return true;  // number 0
	if (a==0) return true;  // number 0
	if (a==',') return true;  // number 0
	return false;
}
function validaCampo(t){
  campofocado = new Array();
  campofocado[0]=t
  infos= validador(campofocado,0);
  if(infos*1>0){
	if(campofocado[0].getAttribute('retorno')){
		retorno = campofocado[0].getAttribute('retorno').split('|');
		tipo = retorno[0];
		mensagem= retorno[1];
		if(tipo=='focus'){
			if(!document.getElementById('alert_valida')){
				
			alertval=document.createElement("div");
			alertval.id='alert_valida';
			alertval.innerHTML= "<a class='alert_x'id='alert_x' onclick='valida_x(this)'>x</a><div class='alert_i'></div><span class='alert_info' id='alert_info'>"+mensagem+"</span>";
			alertval.className='alert_valida'
				
				document.getElementsByTagName('body')[0].insertBefore(alertval, document.getElementsByTagName('div')[0]);
			}else{
				alertval=document.getElementById('alert_valida')
				clearTimeout(timers);
			}
			Add_y =t.offsetHeight*1;
			Add_x =t.offsetWidth*1;		
			
			position_auto = findPos(t);			
			position_auto = position_auto.split(',');
			alertval.style.left=((position_auto[0]*1))+'px';
			alertval.style.top=((position_auto[1]*1)+Add_y)+'px';
			document.getElementById('alert_info').innerHTML=mensagem

			timers= setTimeout("x=document.getElementById('alert_valida').parentNode;x.removeChild(document.getElementById('alert_valida'));",8000);
		}
	 }
  }
  //replace(/\./g, '')
}
function validaForm(t){
	vinputs	  = t.getElementsByTagName('input');
	vtextarea = t.getElementsByTagName('textarea');
	vselect   = t.getElementsByTagName('select');
	//vselects  = t.getElementsByTagName('select');
	errox= 0;
	erroMsgx= new Array();
	for(i=0;i<vinputs.length;i++){
		retorno=''
		infos= validador(vinputs,i);
		if(infos*1>0){
			errox++;
			//alert(vinputs[i].name+"="+vinputs[i].value);
			if(vinputs[i].getAttribute('retorno')){
				retorno = vinputs[i].getAttribute('retorno').split('|');
			 }
			 erroMsgx[errox]= retorno[1];
		}
	}
	
	for(i=0;i<vselect.length;i++){
		retorno=''
		infos= validador(vselect,i);
		if(infos*1>0){
			errox++;
			//alert(vinputs[i].name+"="+vinputs[i].value);
			if(vselect[i].getAttribute('retorno')){
				retorno = vselect[i].getAttribute('retorno').split('|');
			 }
			 erroMsgx[errox]= retorno[1];
		}
	}
	
	
	if(errox>0){
		alert(errox+" Erro(s) "+erroMsgx.join("\n"));
		// exibe todos os erros 
		return false;
	}else{
		return true;
	}
	
} 
function validador(vinputs,i){
  valor = vinputs[i].value
  retorno ='';
  jaerrou=0;
  if(vinputs.length>0){
  if(!(vinputs[i].getAttribute('aceita_nulo')&&valor=='')){
	  if(vinputs[i].getAttribute('valida_data')){
		  js_atributo=vinputs[i].getAttribute('valida_data');
		  if(validaData(js_atributo,valor)){
			  if(!jaerrou)campoOk(vinputs[i]);
		  }else{
			  jaerrou=1;
			  campoErro(vinputs[i]);
		  }
		  
	  }
	  
	  if(vinputs[i].getAttribute('valida_cpf')){
		  //alert(vinputs[i].getAttribute('id'));
		  js_atributo=vinputs[i].getAttribute('valida_cpf');
		  
		  if(valida_cpf(vinputs[i])){
			  if(!jaerrou)campoOk(vinputs[i]);
		  }else{
			  jaerrou=1;
			  campoErro(vinputs[i]);
		  }
		  
	  }
	  
	  if(vinputs[i].getAttribute('valida_idade')){
		  js_atributo=vinputs[i].getAttribute('valida_idade');
		  if(validaIdade(js_atributo,valor)){
			  if(!jaerrou)campoOk(vinputs[i]);
		  }else{
			  jaerrou=1;
			  campoErro(vinputs[i]);
		  }
		  
	  }
	  if(vinputs[i].getAttribute('valida_minlength')){
		  js_atributo=vinputs[i].getAttribute('valida_minlength');
  
		  if(validaMinLength(js_atributo,valor)){
			  if(!jaerrou)campoOk(vinputs[i]);
		  }else{
			  jaerrou=1;
			  campoErro(vinputs[i]);
		  }
		  
	  }
	  if(vinputs[i].getAttribute('valida_valor')){
		  js_atributo=vinputs[i].getAttribute('valida_valor');
  
		  if(validaValor(js_atributo,valor)){
			  if(!jaerrou)campoOk(vinputs[i]);
		  }else{
			  jaerrou=1;
			  campoErro(vinputs[i]);
		  }
		  
	  }
	  if(vinputs[i].getAttribute('valida_email')){
		  js_atributo=vinputs[i].getAttribute('valida_email');
  
		  if(validaEmail(valor)){
			  if(!jaerrou)campoOk(vinputs[i]);
		  }else{
			  jaerrou=1;
			  campoErro(vinputs[i]);
		  }
		  
	  }
	  if(vinputs[i].getAttribute('valida_check')){
  
		  if(vinputs[i].checked==true){
			  if(!jaerrou)vinputs[i].parentNode.style.color='';
		  }else{
			  jaerrou=1;
			  vinputs[i].parentNode.style.color='#d61100';
		  }
		  
	  }
	  if(vinputs[i].getAttribute('valida_igual')){
  
		  if(vinputs[i].value==document.getElementById(vinputs[i].getAttribute('valida_igual')).value){
			  if(!jaerrou)campoOk(vinputs[i]);
			  if(!jaerrou)campoOk(document.getElementById(vinputs[i].getAttribute('valida_igual')));
		  }else{
			  jaerrou=1;
			  campoErro(vinputs[i]);
			  campoErro(document.getElementById(vinputs[i].getAttribute('valida_igual')));
		  }
		  
	  }
  }
  }else{
	  campoOk(vinputs[i]);
  }
  return jaerrou;
		
}
function campoOk(campo){
	cp = campo.parentNode.className;
	cp = cp.replace(/\valida_error/g,'');
	campo.parentNode.className = cp;
}
function campoErro(campo){
	cp = campo.parentNode.className;
	cp = cp.replace(/\valida_error/g,'');
	campo.parentNode.className=cp+" valida_error";
}
function validaData(atributo,valor){
	
	separacao =  valor.split('/');
	dia	= separacao[0]*1;
	mes	= separacao[1]*1;
	ano	= separacao[2]*1;
	
	atributos = atributo.split(',');
	
	if(dia<1 || dia>31 ){return false};
	if(mes<1 || mes>12 ){return false};
	if(ano<1 || ano>9999){return false};

	if(dia<10||dia.length<2){dia='0'+dia;}
	if(mes<10||mes.length<2){mes='0'+mes;}
	
	if(atributos.length>1){

		data_valor = ano+''+mes+''+dia;

		atributo_min = atributos[0].split('/');
		
		dia_min=atributo_min[0];
		mes_min=atributo_min[1];
		ano_min=atributo_min[2];
		dt_min =ano_min+''+mes_min+''+dia_min
		
		atributo_max = atributos[1].split('/');
		dia_max=atributo_max[0]
		mes_max=atributo_max[1]
		ano_max=atributo_max[2]
		dt_max =ano_max+''+mes_max+''+dia_max

		if(data_valor<dt_min || data_valor>dt_max)return false;
	}
	return true
}
function validaIdade(atributo,valor){
	splitatributo = atributo.split(',');
	
	idade_min = splitatributo[0];
	idade_max = splitatributo[1];
	
	idade_agora= calcular_idade(valor);

	if(idade_agora<idade_min || idade_agora>idade_max)return false;
	
	return true
	
}

function valida_cpf(campo){
	var cpf=campo.value;
	cpf = cpf.replace(/\./g, '');
	cpf = cpf.replace(/\-/g, '');
	if((cpf.length != 11) || (cpf == 00000000000) || (cpf == 11111111111) || (cpf == 22222222222) || (cpf == 33333333333) || (cpf == 44444444444) || 
	(cpf == 55555555555) || (cpf == 66666666666) || (cpf == 77777777777) || (cpf == 88888888888) || (cpf == 99999999999)){
		campo.value='';
		return false;
    }else{
		for(var t=9;t<11;t++){
			var d=0;
			for(var c=0;c<t;c++){
				d+=cpf.charAt(c) * ((t+1)-c);
			}
			d=((10 * d) % 11) % 10;
			if (cpf.charAt(c) != d) {
            	campo.value='';
				return false;
			}else{
				return true;
			}
		}
	}
}

function validaMinLength(atributo,valor){
	if(valor.length<atributo*1)return false;
	return true;
}
function validaValor(atributo,valor){
	minmax = atributo.split(',');
	minimo = minmax[0]*1; 
	maximo = minmax[1]*1;

	flagZero=0;
	
	valor = valor.replace(/\./g, '')
	valor = valor.replace(/\,/g, '.')*1;
	
	if(valor<minimo||valor>maximo)return false;
	return true;
}
function validaEmail(mail){
  var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
  if(typeof(mail) == "string"){
	if(er.test(mail)){ return true; }
  }else if(typeof(mail) == "object"){
	if(er.test(mail.value)){ 
							return true; 
					}
  }else{
	return false;
	}
}
function calcular_idade(data){
    hoje=new Date();
    var array_data = data.split("/")
    if (array_data.length!=3)return false;
    var ano
    ano = parseInt(array_data[2]);
    if (isNaN(ano)) return false
	
    var mes
    mes = parseInt(array_data[1]);
    
	if (isNaN(mes))return false

    var dia
    dia = parseInt(array_data[0]);
    if (isNaN(dia))return false
	    
	idade=hoje.getFullYear()- ano - 1; 
    
	if (hoje.getMonth() + 1 - mes < 0)return idade
    if (hoje.getMonth() + 1 - mes > 0)return idade+1
    if (hoje.getUTCDate() - dia >= 0)return idade + 1
	
    return idade
}
function valida_x(t){
	x=t.parentNode.parentNode;
	x.removeChild(t.parentNode);
}
function form_x(t){
	x=t.parentNode.parentNode.parentNode.parentNode;
	$(x).fadeOut(300);

}

// função auto completa
try{xml = new XMLHttpRequest();}catch(ee){try{xml = new ActiveXObject("Msxml2.XMLHTTP");} catch(e){try{xml = new ActiveXObject("Microsoft.XMLHTTP");}catch(E){xml = false;}}}
// funcao para eencontrar a posisao x y de um elemento
function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
 		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);   
  		return curleft+","+curtop;
	}
}

var indice =0;

function funcao_bsc(resultado,acao,origem){
	
	actions_W= acao.split('|');
//	document.title=resultado.innerHTML+','+resultado.getAttribute('r0')+','+resultado.getAttribute('r1')+','+resultado.getAttribute('r2')+','+acao+','+origem+','+actions_W.length;
	
	document.getElementById(origem).value=resultado.getAttribute('r0');
	
	for(w=0;w<actions_W.length;w++){
		vlores_e_locais = actions_W[w].split("-");
		local_e_acao = vlores_e_locais[1].split('>');
		
		valor = vlores_e_locais[0].replace(/@/g,'');
		local = local_e_acao[0];
		acao_W  = local_e_acao[1];
		
		if(local=='innerHTML'){
			document.getElementById(acao_W).innerHTML=resultado.getAttribute(valor);
		}else if(local=='value'){
			document.getElementById(acao_W).setAttribute('value',resultado.getAttribute(valor));
			document.getElementById(acao_W).value=resultado.getAttribute(valor);
		}else{
			document.getElementById(acao_W).setAttribute(local,resultado.getAttribute(valor));
		}
	}
	
	document.getElementById(origem).focus();
		
}
function retornaBusca(str_busca,origem){
	//onkeyup="return vkt_ac(this,event,vkt_busaca1,'financeiro.php?busca_internauta=1','@reg0 @reg1','vkt_internautas(this)')" 
	//busca=financeiro.php?busca_internauta=1,@r0 @r1,

	str_split = str_busca.split(',');
	url  = str_split[0];
	temp = str_split[1];
	acao = str_split[2];
	str_array = str_split[3];
	funcao = "funcao_bsc(this,\\'"+acao+"\\',\\'"+origem.id+"\\')";
	
	 return "return vkt_ac(this,event,\'"+str_array+"\',\'"+url+"\',\'"+temp+"\','"+funcao+"')";

}
function vkt_ac(busca,evento,buca_array,url,template,funcao){
	/*
	busca= capo onde vai buscar, pode ser o mesmo 
	evento=  acao do campo
	busca_array = nome do array que é criado na página onde será feita a busca 
	url = onde será feito a busca caso nao encontre na array
	template = forma que será exibido na tela de resultado de busca
	funcao = é criado uma função para cada aplicacão, que pega os atributos solicitados e transforma em resultado na tela como solicitado EX:vkt_internautas(t)
	*/
	
	//busca.autocomplete='off';
	busca.autocomplete=false;
	
	codigo = evento.keyCode ;// condigo da digitação
	//

	if(!document.getElementById('vktauto')){
		vkt_auto=document.createElement("div");
		vkt_auto.id='vktauto';
		//insertAfter(vkt_auto,document.getElementsByTagName('body')[0]);
		//insertAfter(vkt_auto,document.getElementsByTagName('body')[0]);
		document.getElementsByTagName('body')[0].insertBefore(vkt_auto, document.getElementsByTagName('div')[0]);

	}else{
		vkt_auto = document.getElementById('vktauto'); //verifica se já existe a tag de autocomplete
	}
	// se nao existe a div de vkt auto cria.

		vkt_auto.style.position='absolute';
		vkt_auto.style.fontSize='12px';
		vkt_auto.style.fontFamily='Tahoma, Geneva, sans-serif';
		vkt_auto.style.background='#FFF';
		vkt_auto.style.zIndex='1500';
		vkt_auto.autocomplete=false;

		vkt_auto.style.border= "1px solid #AAA";
	// posiciona a busca de acordo com o campo de busca
		Add_y =busca.offsetHeight*1;
		Add_x =busca.offsetWidth*1;		
		vkt_auto.style.width=Add_x+'px';
		position_auto = findPos(busca);			
		position_auto = position_auto.split(',');
		vkt_auto.style.left=((position_auto[0]*1))+'px';
		vkt_auto.style.top=((position_auto[1]*1)+Add_y)+'px';
		
	// se perde o foco some a layer 
	vkt_auto.style.display='';
	// se perde o foco some a layer
	busca.onblur=function (){ setTimeout("vkt_auto.style.display='none';",500);}
	
	//alert(vkt_auto.innerHTML)
	

	variaver = vkt_auto.getElementsByTagName('a');
	tamanho  = variaver.length;
	if(tamanho>0){
	// navegação pode seta 
	for(i=0;i<variaver.length;i++){
		variaver[i].style.color='#444';
		variaver[i].style.background='#FFF';
	}
	if(codigo !=40 && codigo !=39 && codigo != 38 && codigo != 37&& codigo != 13){
		indice =-1;	
	}
	if(codigo ==40 || codigo ==39){//pra baixo
	//alert(variaver.length)
		if(indice < variaver.length-1){
			indice++;
			variaver[indice].style.background='#8BA7C9';
			variaver[indice].style.color='#FFF';
		}else{
			indice=0;
			variaver[0].style.background='#8BA7C9';
			variaver[0].style.color='#FFF';
		}
	}
	if(codigo == 38 || codigo == 37){//pra Cima
		if(indice > 0){
			indice--;
			variaver[indice].style.background='#8BA7C9';
			variaver[indice].style.color='#FFF';
		}else{
			indice=variaver.length-1
			variaver[indice].style.background='#8BA7C9';
			variaver[indice].style.color='#FFF';
		}
	}
	}
	if(codigo ==13){//enter
		nfunction = funcao.replace('this',"document.getElementById('vktauto').getElementsByTagName('a')[indice]");
		eval (nfunction);
		vkt_auto.style.display='none';
		return false;
		//return mostraresultado(indice,exibidor);
		//eval funcao;
	}else{
		if(busca.value.length >1 && codigo!= 37 && codigo !=38 && codigo!= 39 && codigo !=40){
			var d = new Date()
			// Procura na array que entrou na funcao "buca_array"
			tmx=buca_array.length; // pega o tamanho da array
			inn= '';// declarei a variavel
			xx=0;
			if(buca_array!='0'){
			
			// busca na array buca_array o que tem no compo de busca
			inn= new Array();
			for(xs=0;xs<tmx;xs++){
				bsc = new RegExp(busca.value,"i");// isso é igual a /busca/i

				if(buca_array[xs].search(bsc)>-1  && xx<=10){
					
					// substitue no template o reg0 reg1 pela variavel que ele encontrou e exibe o template
					regs = buca_array[xs].split('|');
					atributox = new Array();
					substitui = template;
					for(xr=0;xr<regs.length;xr++){
						tx_substr = "@r"+xr; 
						atr = "r"+xr; 
						new_subst = regs[xr];
						atributox.push(atr+"=\""+new_subst+"\"");
						substitui= substitui.replace(tx_substr,new_subst)
						//alert(substitui);
					}
					
					atributox = atributox.join(' ');
					substitui = "<a href='#' onclick=\""+funcao+"\" "+atributox+" style='display:block; color:#444;text-decoration:none;'>"+substitui+"</a>";
					
					inn.push(substitui);
					xx++;
				}
			}
			vkt_auto.innerHTML=inn.join(' ');// esse cara faz exibir na tela
			}
			
			if(xx==0){
				document.getElementById('vktauto').innerHTML='<i style="padding:10px">Aguarde um momento, estamos procurando no servidor</i>';
				buscaonline(url,busca.value,d,xml,'vktauto',template,funcao);
			
			}
		}
	}
}

function buscaonline(url,busca,d,xml,exibidor,template,funcao){
	
	if(url.indexOf('?')>0){
		separador ='&';	
	}else{
		separador ='?';	
	}
	
	xml.open("GET", url+separador+"busca_auto_complete="+busca+"&temp="+d.getMilliseconds() ,true);
	xml.onreadystatechange=function() {
		if (xml.readyState==4){
			//Lê o texto
			var texto=xml.responseText;
			document.getElementById(exibidor).style.display='inline';
			//Desfaz o urlencode
			texto=texto.replace(/\+/g," ")
			texto=unescape(texto);
			//alert(texto)
			divide_nomes= texto.split("\n");
			numero_resultados = divide_nomes.length-1;
			
			inn = new Array();
			buca_array = divide_nomes;
			for(g=0;g<numero_resultados;g++){
				regs = buca_array[g].split('|');
				atributox = new Array();
				substitui = template;
				for(xr=0;xr<regs.length;xr++){
					tx_substr = "@r"+xr; 
					atr = "r"+xr; 
					new_subst = regs[xr];
					atributox.push(atr+"=\""+new_subst+"\"");
					substitui= substitui.replace(tx_substr,new_subst)
					//alert(substitui);
				}
				
				
				atributox = atributox.join(' ');
				substitui = "<a href='#' onclick=\""+funcao+"\" "+atributox+" style='display:block; color:#444;text-decoration:none;'>"+substitui+"</a>";
				
				
				inn.push(substitui);
			}
			
			document.getElementById(exibidor).innerHTML=inn.join(' ');// esse cara faz exibir na tela
			
			
		}
	}
	xml.send(null);
}

// Inicia Funções de Calendário

function ultimos_dias(mes,p_year){
	ultimoDiadoMes = new Array()
	if ((p_year % 4) == 0) {
		if ((p_year % 100) == 0 && (p_year % 400) != 0){
			ultimoDiadoMes = Array(0,31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		}else{
			// anos bissestos
			ultimoDiadoMes = Array(0,31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		}
	}else{
		ultimoDiadoMes = Array(0,31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	}
	return ultimoDiadoMes[mes];
}


function exibeSemna(semana,tmp){
	var inner='';
	for(i=0;i<semana.length;i++){
		inner = inner+'<strong style="display:block;float:left; width:25px;line-height:15px; height:15px;text-align:center; font-size:7px;border-bottom:1px solid #bac6d3;background:transparent">'+semana[i]+'</strong>'
	}
	return inner;
}

function exibeDias(mes,ano,tmp){
	mesE 		= new Array(" ","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");// precisa disso pra manipular mes para pegar o primeiro dia

	var d 		= new Date(", 1 "+mesE[mes]+" "+ano+" 00:01:01 UTC");//Primeiro dia do Mes
	
	var semana 	= d.getDay(); //SEMANA
	var uDia	= ultimos_dias(mes,ano)

	var inner	= '';
	// exibe dias aantes de começar o mes
	datahoje = new Date();
	diahoje = datahoje.getDate();
	meshoje = datahoje.getMonth()+1;
	 
	for(i=0;i<=semana;i++){
		inner = inner+'<div  style="display:block;float:left; width:23px; height:23px; color:#666666;border-left:1px solid #edeef3; border-top:1px solid #edeef3; border-right:1px solid #bac6d3; border-bottom:1px solid #bac6d3;background:none">&nbsp;&nbsp;</div>';
	}
	
	// exibe os dias do mes
	if(diahoje<10){diahoje=""+'0'+diahoje+""}else{diahoje=""+diahoje+""}
	if(meshoje<10){meshoje=""+'0'+meshoje+""}else{meshoje=""+meshoje+""}
	
	for(i=1;i<=uDia;i++){
		if(i<10){js_dia=""+'0'+i+""}else{js_dia=""+i+""}
		if(mes<10){js_mes=""+'0'+mes+""}else{js_mes=""+mes+""}
		if(diahoje== js_dia&&js_mes==meshoje){adicional='style="border:1px solid #526792;background:#0078e5;font-weight:bold; color:#FFF"'}else{adicional=''}
		inner=	inner+"<a href=\"javascript:cal_preenche('"+js_dia+"','"+js_mes+"','"+ano+"','"+tmp+"')\" "+adicional+" >"+i+'</a>';
	}

	return inner;
}
function cal_preenche(dia,mes,ano,origem){
	document.getElementById(origem).setAttribute('value',dia+'/'+mes+'/'+ano);
	document.getElementById(origem).value=dia+'/'+mes+'/'+ano;
	document.getElementById(origem).blur()
	document.getElementById(origem).focus()
	document.getElementById('calendario').style.display='none';
	
}
function criaCalendario(mes,ano,origem){
/*
onfocus="criaCalendario('<?=date("m")*1?>','<?=date("Y")?>','calendario','ficaixadata(dia,mes,ano)');swc(1,105,460)"

*/
	tmp='';
	ano 
	if(ano*1<1900||isNaN(ano)){
		var 	dx= new Date();
		ano = 	dx.getFullYear();
	}
	if(isNaN(mes)||mes>12){
		var 	dx= new Date();
		mes = 	dx.getMonth();
	}
	tasd=setTimeout('',1);
	if(!document.getElementById('calendario')){
		local=document.createElement("div");
		local.id='calendario';
		//local.setAttribute('style',"z-index:1000;position:absolute;background:url(i/bgc.png);padding:5px 0 5px 0;-moz-border-radius: 5px;border-radius: 5px;-webkit-border-radius: 5px;-moz-box-shadow: 2px 2px 5px #686868;-webkit-box-shadow: 2px 2px 5px #686868;box-shadow: 2px 2px 5px #686868;border:1px solid #a7a7a7;");
		
		local.setAttribute('onmouseout',"tasd=setTimeout(\"document.getElementById(\'calendario\').style.display=\'none\'\",1000)");
		local.setAttribute('onmouseover',"this.style.display='';clearTimeout(tasd);");
	
		document.getElementsByTagName('body')[0].insertBefore(local, document.getElementsByTagName('div')[0]);

	}else{
		local = document.getElementById('calendario'); //verifica se já existe a tag de autocomplete
		local.style.display=''; //verifica se já existe a tag de autocomplete
	}
	ooorrig =document.getElementById(origem);
		
	Add_y =ooorrig.offsetHeight*1;
	Add_x =ooorrig.offsetWidth*1;		
	
	position_auto = findPos(ooorrig);			
	position_auto = position_auto.split(',');
	local.style.left=((position_auto[0]*1)+Add_x)+'px';
	local.style.top=((position_auto[1]*1))+'px';

	var 	d 		= new Date();
	
	if((mes*1)<1){
		var mes 	= d.getMonth()+1; 	// MES
		var ano 	= d.getFullYear(); 	// ANO

	}
	
	var semana 	= d.getDay(); 		//SEMANA
	var dia 	= d.getDate(); 		//DIA 

	var	dSemana = Array("Dom","Seg","Ter","Qua","Qui","Sex","Sab");
	var meses = Array('',"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", 
	"Dezembro");

	var pmes 	= (mes*1)+1; 	// proximo mes
	var pano 	= ano; 	// proximo mes
	var ames 	= (mes*1)-1; 	// anterior mes
	var aano 	= ano; 	// anterior mes
	
	if(pmes==13){
		pmes 	= 1;
		pano	= (ano*1)+1
	}
	if(ames==0){
		ames 	= 12;
		aano	= (ano*1)-1
	}
	// Coloca Links
 	inner 	= '<div style="text-align:center;width:175px;padding-top:3px;font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif;">';
	inner 	= inner+'<div class="calendarioLink1" onclick="criaCalendario(\''+ames+'\',\''+aano+'\',\''+origem+'\')" ></div>'
	inner	= inner+"<strong style='float:left; width:128px;text-align:center'>"+meses[mes]+' '+ano+'</strong>';
	inner 	= inner+'<div class="calendarioLink2" onclick="criaCalendario(\''+pmes+'\',\''+pano+'\',\''+origem+'\')" ></div>'
	inner	= inner+'<div style="clear:both; margin:0; padding:0;" ></div>';
	inner	= inner+exibeSemna(dSemana,origem);
	inner 	= inner+exibeDias(mes,ano,origem);
	inner	= inner+'<div style="clear:both; margin:0; padding:0;" ></div></div>';
	
	local.innerHTML = inner;
	
}
function openForm(){
	$(top.document.getElementById('exibe_formulario')).hide();
	document.getElementById('exibe_formulario').innerHTML=carregador.document.getElementById('aSerCarregado').innerHTML;
	$(top.document.getElementById('exibe_formulario')).fadeIn(300);

}
function selall(t){
	checks = t.parentNode.parentNode.getElementsByTagName('input');
	
	if(t.checked==true){
		
		for(i=0;i<checks.length;i++){
		
			checks[i].checked=true;
		}

	}else{
		for(i=0;i<checks.length;i++){
		
			checks[i].checked=false;
		}
	}
	
}
function exibeConjugue(){
	
	x=document.getElementById("dados_conjugue").style.display;
	if(x=="none"){
		document.getElementById("dados_conjugue").style.display="block";
	}else{
		document.getElementById("dados_conjugue").style.display="none";
	}
	
}
function confirmAutorizar(t){
	if(t.value=='Autorizar'){
		if(!confirm('Ao autorizar, não será mais possível alterar os valores. Tem certeza?')){
			return false;
		}
	}
}
function confirmEfetivar(t){
	if(t.value=='Efetivar'){
		if(!confirm('Ao efetivar, não será mais possível alterar os valores. Tem certeza?')){
			return false;
		}
	}
}
function confirmFinalizar(t){
	if(t.value=='Finalizar'){
		if(!confirm('Ao finalizar, não será mais possível alterar os valores. Tem certeza?')){
			return false;
		}
	}
}
function confirmCancelar(t){
	if(t.value=='Cancelar'){
		if(!confirm('Ao cancelar, não será mais possível dar continuidade. Tem certeza?')){
			return false;
		}
	}
}




////





function moedaBrToUsa(v){
	//pega o numero de caracteres dps da vírgula para decidir o número de casas decimais
	nv = v+'';
	nv = nv.replace(/\./g,'');
	nv = nv.replace(/,/g,'.')*1;
	return nv.toFixed(2);
	
}
function qtdBrToUsa(v,limite){
	//pega o numero de caracteres dps da vírgula para decidir o número de casas decimais
	nv = v+'';
	nv = nv.replace(/\./g,'');
	nv = nv.replace(/,/g,'.')*1;
	return nv.toFixed(limite);
	
}
function qtdUsaToBr(v,limite){
	//pega o numero de caracteres dps da vírgula para decidir o número de casas decimais
//	v = v.toFixed(limite);
	nv = v+'';
	nv = nv.replace(/ /g,'');
	nv = nv.replace(/,/g,'');
	nv = nv.replace(/\./g,',');
	separa = nv.split(',');
	
	valor = separa[0];
	decimal = separa[1];
	
//	document.title=v+'='+nv+"="+valor+'='+decimal+'; Limite='+decimal.length;
	if(decimal*1>0){
		if(decimal.length>limite){
			decimal = ','+decimal.substr(0,limite);
		}else{
			decimal = ','+decimal;
		}

	}else{
		decimal = '';
	}
	valor_final =valor+''+decimal;
	
	
	return valor_final;

	
}
function moedaUsaToBR(v){
	nv = v+'';
	nv = nv.replace(/ /g,'');
	nv = nv.replace(/,/g,'');
	nv = nv.replace(/\./g,',');
	
	separa = nv.split(',');
	valor = separa[0];
	if(separa.length<2){
		decimal = '00';
	}else{
		decimal = separa[1];
	}
	tamanho_valor=valor.length;
	if(tamanho_valor<4){
		valor_final = valor+','+decimal;
	}
	if(tamanho_valor>3&&tamanho_valor<7){
		valor_final = valor.substr(0,tamanho_valor-3)+'.'+valor.substr(tamanho_valor-3,3)+','+decimal;
	}else if(tamanho_valor>6&&tamanho_valor<10){
		valor_final = valor.substr(0,tamanho_valor-6)+'.'+valor.substr(tamanho_valor-6,3)+'.'+valor.substr(tamanho_valor-3,3)+','+decimal;
	}else{
		valor_final = nv;
	}
	
	
	return valor_final;
}
//123
//1.234
//123.456

function setCookie(c_name,value,exdays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name){
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
		{
		return unescape(y);
		}
	  }
}
