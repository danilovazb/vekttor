<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Confirmação de Cadastro</title>
<style>
#frm_cadastro{
	width:600px;
}
.campo{
	clear:both;
	margin-bottom:20px;
}
.campo label{
	float:left;
	width:140px;
}

#nome,#email,#endereco,#profissao{
	width:300px;
}
#data_nascimento,#telefone1,#telefone2,#cep{
	width:90px;
} 
#numero_casa,#estado,#qtd_dependentes{
	width:40px;
}
.error{
	float:left;
	margin-left:2px;
	margin-top:5px;
	color:red;
	clear:right;
	margin-bottom:20px;
}
</style>
<script src="jquery-1.7.2.min.js"></script>
<script>
$("#confirmar").live('click',function(){

	if($("#email").val()==''){
		alert('Campo E-mail Obrigatório');
		$("#lemail").css('color','red');
	}else{
		$("#frm_cadastro").submit();
	}
});
</script>
</head>

<body>
<div class="campo">
<form method="post" autocomplete='off' action="http://vkt.srv.br/~nv/eleitoral/index.php" id="frm_cadastro">  
  <label id="lemail">
    Digite Seu E-mail
  </label>
  <input type="text" maxlength="44" autocomplete="off" value="" name="email" id="email">
  <input type="button" value="Confirmar" id="confirmar"/>
  <input type="hidden" name="action" id="action" value="confirmar_email"/>
   <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>"/>
</form>
</div>
</body>
</html>
