<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Vekttor</title>
<link href="../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script src="../fontes/js/sis.js"></script>
<!--<meta http-equiv="refresh" content="2"> -->
<script>
// Chamada do Resize para a barra ficar em baixo e o tamanho da tabela ser proporcional
window.onresize=function() {
	resize();
}
// Chamada do Arrastar Janela

var nn6=document.getElementById&&!document.all;
var isdrag=false;
var x,y;
var dobj;
document.onmousedown=selectmouse;

document.onmouseup=new Function("isdrag=false");

document.onkeydown=formataCampo
document.onkeyup=secal

</script>
</head>

<body>
<script>
//criaCalendario('','','')
</script>

<!-- Local de exibição de Formulários -->
<div class='exibe_formulario'  style="top:30px; left:50px;">
	<div>
    <img src="i/t3.png" class='t3'/>
    <img src="i/t1.png" class='t1'/>
    <div  class="dragme" ><img src="i/x.png" class='f_x' onclick="form_x(this)" /><span>Titulo do Formulário</span></div>
    </div>
<form onsubmit="return validaForm(this)" class="form_float" style="width:600px">

<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
<fieldset  id='campos_1' >
	<legend>
    <a onclick="aba_form(this,0)"><strong>Campos</strong></a>
    <a onclick="aba_form(this,1)">Adição de Campos</a>
    <a onclick="aba_form(this,2)">Auto Complete</a>
    </legend>
<label style="width:180px">
	Nome
    <input type="text" id='nome' name="" value="" valida_minlength='5' 
    busca='modelo_resultado_busca.php,@r0,@r1-value>data,0' autocomplete='off' retorno='focus|Coloque no minimo 5 caracter' />
    <!-- 
    busca='url_destino,Informacao exibida,Retorno do selecionado,array de cache'
    
    url_destino 
    Lembrar que term que ter o caminho completo apartir do /sis
    
    Informação exibida
    ex: o que vem do pho 
    cada uma qubra de linha é um registro independete
    @r0|@r1|@r2|@r3|@r
    cpf|nome|idade|nascimento|endereco
    cpf|nome|idade|nascimento|endereco
    cpf|nome|idade|nascimento|endereco
    cpf|nome|idade|nascimento|endereco
    
    Retorno
    @r0-value>ID_HTML_DESTINO
    
    @r0-value>cpf(cpf é o id do input que etá html)
    @r0-value>cpf|@r2-value>idade|@r2-innerHTML>enderco (endereco é id da div onde será preenchid com o endereco )
    
    
    
    
    
    -->
</label>

<label style="width:80px">
	Fone
    <input type="text" id='data_usa' name="" value=""  mascara='(__)____-____' sonumero='1' />
</label>



<label style="width:70px">
	data
      <input type="text" id='data' mascara='__/__/____' calendario='1' sonumero='1' valida_data='1' retorno='focus|Data Simples'  name="" value=""  maxlength=""/>
</label>
<label style="width:70px">
	Data Min
	  <input type="text"id='data_minimo' mascara='__/__/____' calendario='1' sonumero='1' valida_data='25/08/2010,99/99/9999' aceita_nulo='1' retorno='focus|Data 6 meses' name="" value="25/08/2010" title='25/08/2010,99/99/9999'  maxlength=""/>
</label>
<label style="width:70px">
	Data Max
      <input type="text" mascara='__/__/____' id='data_max' calendario='1' sonumero='1' valida_data='01/01/0001,25/08/2010' retorno='focus|Maximo de 6 meses' name="" value=""  maxlength="" title='01/01/0001,25/08/2010'/>
</label>
<label style="width:70px">
	Dt Min Max
      <input type="text" id='data_maxima' mascara='__/__/____' calendario='1' sonumero='1' valida_data='01/02/2011,31/02/2011' retorno='focus|Minimo de 6 meses' name="" value=""  maxlength="" title="01/02/2011,31/02/2011"/>
</label>
<label style="width:70px">
	Nascimento 
      <input type="text" mascara='__/__/____'  sonumero='1' valida_idade='10,17' retorno='focus|Idade Minima' name="" value=""  maxlength=""/>
</label>



<label style="width:35px">
	Hora
    <input type="text" name="" value="22:53" mascara='__:__' sonumero='1'/>
</label>
<label style="width:80px; text-align:right">
	Valor R$ 
    <input type="text" decimal="5" name="" value="" valida_valor='100,1000' maxlength="15"/>
</label>
<label style="width:95px;">
	CPF
    <input type="text" name="" mascara='___.___.___-__' busca='modelo_resultado_busca_cpf.php,@r0 @r1,@r1-value>nome,0' id='cpf' sonumero='1' value="520.597.402-82"/>
</label>
<label style="width:70px;">
	Telefone
    <input type="text" name="" mascara='____-____' sonumero='1' value="3232-5169" />
</label>
<label style="width:30px;">
	DDD
    <input type="text" name="" sonumero='1' value="92" />
</label>
<label style="width:70px;">
	CEP
    <input type="text" name="" mascara='__.___-___' sonumero='1'   value="69.025-370"/>
</label>
<label style="width:120px;">
	CNPJ
    <input type="text" name="" mascara='__.___.___/____-__' sonumero='1' value="05.580.553/0001-84"/>
</label>
<label style="width:120px;">
	E-mail
    <input type="text" name="" value="mario@vekttor.com" valida_email='1' retorno='focus|Coloque o email corretamente'/>
</label>
<label>
	Nome
    <select>
    	<option>Teste</option>
    </select>
</label>
<label style="width:400">
	Descrição
    <textarea></textarea>
</label>

<div class="divisao_options"><!--  sempre usar um div pra dividir-->
	<span  class="titulo_options">Lista de op&ccedil;&otilde;es simples um do lado do outro</span>
	<label>
    	<input type="radio" >
        Opcao 1
    </label>
	<label>
    	<input type="radio" >
        Opcao 2
    </label>
	<label>
    	<input type="radio" >
        Opcao 3
    </label>
	<div style="clear:both"></div>
</div>

<div class="divisao_options">
	<span class="titulo_options">Op&ccedil;&otilde;es em colunas com <img src="i/sd.png" width="8" height="8" />&lt;div&gt;</span>
	<div style="float:left; width:100px">
        <label>
            <input type="checkbox" >
            Opcao 1
        </label>
        <label>
            <input type="checkbox" >
            Opcao 2
        </label>
    </div>
	<div  style="float:left;width:100px">
        <label>
            <input type="checkbox" >
            Opcao 3
        </label>
        <label>
            <input type="checkbox" >
            Opcao 4
        </label>
        <label>
            <input type="checkbox" >
            Opcao 5
        </label>
    </div>
	<div  style="float:left;width:100px">
        <label>
            <input type="checkbox" >
            Opcao 6
        </label>
        <label>
            <input type="checkbox" >
            Opcao 7
        </label>
        <label>
            <input type="checkbox" >
            Opcao 8
        </label>
    </div>
	<div style="clear:both"></div>
</div>
<div class="divisao_options"><!--  sempre usar um div pra dividir-->
	<label>
    	<input type="checkbox" valida_check='1' >
        Aceita o Termo de uso da função
    </label>
	
	<div style="clear:both"></div>
</div>
<div ><!--  sempre usar um div pra dividir-->
	<label style="width:100px">
        Senha
    	<input type="password" id='senha1'  retorno='focus|No Minimo 5 Caracter, e Confima Senha' valida_minlength='5' >
    </label>


	<label  style="width:100px">
        Confirma
    	<input type="password" id='senha2' valida_igual='senha1' retorno='focus|Senha não Confere' valida_minlength='5'>
    </label>
		<div style="clear:both"></div>

</div>
</fieldset>


<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
<fieldset id='campos_2' style="display:none" >
	<legend>
    <a onclick="aba_form(this,0)">Campos</a>
    <a onclick="aba_form(this,1)"><strong>Adição de Campos</strong></a>
    <a onclick="aba_form(this,2)">Auto Complete</a>
    </legend>
    
    <div>
        
        
        <span class="titulo_options">Adição de Campo Selects<br />
        <label style="width:110px">
            Titulo
        </label>
        <label style="width:80px">
           valor
        </label>
        <label  style="width:110px">
            Compra
        </label>
        <label  style="width:110px">
            Sexo
        </label>
               <span style="clear:both; display:block"></span>
</span>
    
    	<div class="linha_add">
    	<img src="i/menos.png" width="18" height="18" style="float:right; margin-top:2px" onclick="del_element(this)" /> 
        
        <label style="width:110px">
            <input type="text" >
        </label>
        <label style="width:80px">
            <input type="text" >
        </label>
        <label  style="width:110px">
            <input type="text" >
        </label>
        <label  style="width:110px">
            <select>
            	<option>Masculino</option>
            	<option>Feminino</option>
            </select>
        </label>
               <span style="clear:both; display:block"></span>

       </div>
        
        <div style="clear:both; text-align:right;"><img src="i/mais.png" width="18" height="18" onclick="add_element(this)" /> </div>
    	
    
    
    
    </div>
    

</fieldset>
<!--Fim dos fiels set-->



<div style="width:100%; text-align:center" >
<input name="" type="button"  value="Deletar" style="float:left" />
<input name="" type="submit" value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>

<!-- FIM Local do Formulário -->

<div id='menu' >
<a><img src="i/su.png" width="8" height="8" style="margin:0 2px 0 -10px" />Administrativo</a>
 	<span>
    <a>Usuários</a>
 	<span>
        <a class="menu_selected">Tipo de Usuários</a>
    </span>
    <a>Clientes</a>
    <a>Fornecedores</a>
    
    <a>Empreendimentos/Obra</a>
    	
        <a>Negociação</a>
        <a>Disponibilidade</a>
        
    <a>Planejamento Obra </a>
    
    <a>Vendas</a>
 	<span>
        <a>Já Vendidos</a>
        <a>Disponíveis</a>
        <a>Pré-Venda/Reservas</a>
    </span>
	</span>
    
<a><img src="i/su.png" width="8" height="8" style="margin:0 2px 0 -10px" />Corretor</a>
   	<span>
        <a>Clientes</a>
        <a>Lista Já Vendidos/Corretor</a>
        <a>Pré-Vendas/Reservas</a>
        <a>Emprrendimentos</a>
 	</span>
  
<a><img src="i/su.png" width="8" height="8" style="margin:0 2px 0 -10px" />Suprimento/Estoque</a>
   	<span>
        <a>Produtos</a>
        <a>Serviços</a>
        <a>Pedido de Produto</a>
        <a>Cotação</a>
        <a>Compra</a>
        <a>Inventário</a>
 	</span>
    
    
<a><img src="i/su.png" width="8" height="8" style="margin:0 2px 0 -10px" />Monitoramento de Obra</a>
   	<span>
        <a>Acompanhamento</a>
        <a>Autorização de Pagamento</a>
 	</span>
<a><img src="i/su.png" width="8" height="8" style="margin:0 2px 0 -10px" /><b style="font-size:12px">Financeiro</b></a>
   	<span>
        <a>Contas / Caixas</a>
        <a>Centros de Custos</a>
        <a>Plano de Contas</a>
        <a>Contas a Pagar</a>
        <a>Contas a Receber</a>
        <a>Movimentação</a>
        <a>Despesas por Obra</a>
 	</span>
  
    
</div>

<!-- Página modelo de Conteúdo -->

<div id='conteudo'>
<div id='navegacao'>
<a><img src="i/bgns1.png"/>
  	Sistema  
</a>
<a><img src="i/bgns1.png"/>
    Administrativo 
</a>
<a><img src="i/bgns1.png"/>
    Clientes 
</a>
<a><img src="i/bgns2.png" />
    Pagamento 
</a>
<a class="navegacao_ativo"><img src="i/bgns3.png" width="18" height="41" />
    Nome do Cliente 
</a>
</div>
<div id="barra_info">
	Teste
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="80"><a>Vencimento <img src="i/su2.png" width="6" height="6" /></a></td>
          	<td width="80"><a>Pagamento</a></td>
          	<td width="80"><a>Valor</a></td>
          	<td width="80"><a>Pago</a></td>
          	<td width="80"><a>Boleto <img src="i/sd2.png" width="6" height="6" /></a></td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
T body
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="80"><a>Total</a></td>
            <td width="80">&nbsp;</td>
            <td width="80">&nbsp;</td>
            <td width="80">&nbsp;</td>
            <td width="80">R$ 1280.00</td>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	356 Registros <select name="select" id="select" style="margin-left:10px">
    <option>15</option>
    <option>30</option>
    <option>50</option>
    <option>100</option>
  </select>
  Por P&aacute;gina 
<div style="float:right; margin:0px 20px 0 0">
	<img src="i/b_left.gif" width="87" height="17" />
	<input name="textfield" style="height:10px; text-align:center" type="text" id="textfield" size="2" value="1" />
	<img src="i/b_right.gif" width="87" height="17" />  </div>
</div>

<!-- Fim da Página modelo de Conteúdo -->
</body>
</html>