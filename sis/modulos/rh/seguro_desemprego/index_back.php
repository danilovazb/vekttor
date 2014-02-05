<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Preenchimento de Formul&aacute;rio - Cinybuca&ccedil;&atilde;o de Dispensa - CD</title>
<link href="cd.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="550" height="180" id='win_add_cont' border="0" cellspacing="0" cellpadding="0" >
  <form action="cd.php" method="post" id="form1">
    <tr  >
      <td width="6" height="29"><img src="img/win_canto_e_s.gif" width="6" height="29" /></td>
      <td background="img/win_f_s.gif" class="titulo_janela" height="29">Cadastro de Comunica&ccedil;&atilde;o de Dispensa - CD <a href="#" onclick=""  class="arv_fecha_msg"></a></td>
      <td width="6" height="29"><img src="img/win_canto_d_s.gif" width="6" height="29" /></td>
    </tr>
    <tr>
      <td background="img/win_bor_e.gif" width="6">&nbsp;</td>
      <td height="150" valign="middle" bgcolor="#ECE9D8" style="padding:20px;" >Nome Empregado: 
        <input name="empregado" type="text" id="empregado" size="50" maxlength="38" />
        <br />
        <br />
        <br />
        Nome da M&atilde;e: 
        <input name="mae" type="text" id="mae" size="50" maxlength="38" />
        <br />
        <br />
        Endere&ccedil;o :
        <input name="endereco" type="text" id="endereco" size="50" maxlength="38" />
        <br />
        <br />
         
        Complemento :
        <input name="complemento" type="text" id="complemento" size="20" maxlength="15" />
        CEP:
        <input name="cep" type="text" id="cep" size="10" maxlength="9" />
                 UF:
                 <input name="uf" type="text" id="uf" size="2" maxlength="2" />

                 <br />
                 <br />
        Telefone:
<input name="telefone" type="text" id="telefone" size="10" maxlength="8" />
                 Nascimento:
                 <input name="nascimento" type="text" id="nascimento" size="8" maxlength="8" />
                 
        Pis/Pasep/Nit:
        <input name="pis" type="text" id="pis" size="12" maxlength="11" />
                 <br />
        <br />
        CTPS:
        <input name="ctps" type="text" id="ctps" size="7" maxlength="7" />
                Numero Serie: 
                <input name="ctps_numero" type="text" id="ctps_numero" size="10" maxlength="10" />
        UF:
        <input name="ctps_uf" type="text" id="ctps_uf" size="2" maxlength="2" />
        <br />
        <br />
        CPF: 
        <input name="cpf" type="text" id="cpf" size="20" maxlength="20" />
        Tipo de Instri&ccedil;&atilde;o: 
        <select name="tipo_inscricao" id="tipo_inscricao">
          <option value="1">CNPJ</option>
          <option value="2">CEI (inss)</option>
        </select>
        <br />
        <br />
        Sexo:
        <select name="sexo" id="select">
          <option value="1">Masculino</option>
          <option value="2">Femenino</option>
        </select>
Banco:
<input name="banco" type="text" id="banco" size="3" maxlength="3" />
&nbsp; Agencia:
<input name="agencia" type="text" id="agencia" size="6" maxlength="6" />
<br />
<br />
Grau de Instru&ccedil;&atilde;o: 
<select name="grau" id="select2">
  <option value="1">Analfabeto</option>
  <option value="2">At&eacute; 4 S&eacute;rie Incompleto</option>
  <option value="3">4 S&eacute;rie Completa do 1 Grau</option>
  <option value="4">De 5 a 8 S&eacute;rie Incompleto</option>
  <option value="5">At&eacute; o 1 Grau (completo)</option>
  <option value="6">At&eacute; o 2 Grau (Incompleto)</option>
  <option value="7">Segundo Grau Incompleto (Completo)</option>
  <option value="8">Superior Incompleto</option>
  <option value="9">Superior Completo</option>
</select>
<br />
        <br />
        Atividade Economica:
        <input name="atividade" type="text" id="atividade" size="10" maxlength="10" />
        <br />
        <br />
        CNPJ:
        <input name="cnpj" type="text" id="cnpj" size="20" maxlength="20" />
        <br />
        <br />
<hr />

<br />
CBO
<input name="cbo" type="text" id="cbo" size="7" maxlength="7" />
Ocupa&ccedil;&atilde;o
<input name="ocupacao" type="text" id="ocupacao" size="20" maxlength="20" />
<br />
<br />
Data de Admiss&atilde;o 
<input name="admissao" type="text" id="admissao" size="10" maxlength="8" />
&nbsp;Data de Dispensa
<input name="dispensa" type="text" id="dispensa" size="10" maxlength="8" />
<br />
<br />
Quantidade de Meses que Trabalhou
<input name="meses" type="text" id="meses" size="1" maxlength="2" /> &nbsp;&nbsp;
Horas Trabalhadas por semana 
<input name="horas" type="text" id="horas" size="1" maxlength="2" />
<br />
<hr />
<br />
M&ecirc;s 
<input name="mes2" type="text" id="mes2" size="1" maxlength="2" /> 
Ante Penultimo Sal&aacute;rio 
<input name="salario2" type="text" id="salario2" size="10" maxlength="10" />
<br />
<br />
M&ecirc;s
<input name="mes3" type="text" id="mes3" size="1" maxlength="2" />
Penultimo Sal&aacute;rio
<input name="salario3" type="text" id="salario3" size="10" maxlength="10" />
<br />
<br />
M&ecirc;s
<input name="mes4" type="text" id="mes4" size="1" maxlength="2" />
Ulltimo Sal&aacute;rio
<input name="salario4" type="text" id="salario4" size="10" maxlength="10" />
<br />
<br />
Soma dos 3 Ultimos S&aacute;larios 
<input name="soma" type="text" id="soma" size="10" maxlength="10" />
<br />
<br />
Recebeu Sal&aacute;rio em cada um dos Ultimos Meses&nbsp;
<select name="recebeu" id="recebeu">
  <option value="1">Sim</option>
  <option value="2">N&atilde;o</option>
</select> 
<br />
<br />
Aviso Pr&eacute;vio Idenizado ? &nbsp;
<select name="aviso" id="aviso">
  <option value="1">Sim</option>
  <option value="2">N&atilde;o</option>
</select>
<br />
<br />

<label><input name="pagina" type="radio" id="radio" value="1" checked="checked" />Pagina 1</label>
<label><input type="radio" name="pagina" id="radio2" value="2" />Pagina 2</label><br />
<br />
<label><input name="modelo" type="radio" id="radio" value="1" checked="checked" />
	Modelo 1</label>
<label><input type="radio" name="modelo" id="radio2" value="2" />
Modelo 2</label>
<br />
        <br />
      <a href="#" onclick="document.getElementById('form1').submit()" class="arv_botao"> Cadastrar </a></td>
      <td background="img/win_bor_d.gif" width="6">&nbsp;</td>
    </tr>
    <tr>
      <td width="6"><img src="img/win_canto_e_i.gif" width="6" height="3" /></td>
      <td background="img/win_f_i.gif" height="3"></td>
      <td width="6"><img src="img/win_canto_d_i.gif" width="6" height="3" /></td>
    </tr>
  </form>
</table>
</body>
</html>
