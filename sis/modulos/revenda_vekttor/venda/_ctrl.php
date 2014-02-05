<?
//Ações do Formulário
//Recebe ID
//acao enviada a partir de atendimento do vendedor, quando uma interaçao gera uma venda
if($_POST['salva_formulario_contrato_aluguel'] == 1){
			
			if($_POST['venda_id'] > 0){
				update($_POST);
				//echo "atualiza";
			}
			else{
				cadastra($_POST);
				//echo "cadastra";
			}
			
}
//Altera Usuario
if($_POST['action']=='Excluir'){
		excluir($_POST['id']);		
}

if($_POST['action'] == 'Anexar'){
	
}

if($_GET['id'] > 0){
	$id = $_GET['id'];
	/*Atributos Variaveis*/
		$valTableServico = '2';
		$TableDisplay = '';
		$checkedPessoa = "";
	
	
	$venda = mysql_fetch_object(mysql_query(" SELECT * FROM vekttor_venda WHERE id = '$id' "));
	$cliente_vekttor  = mysql_fetch_object(mysql_query(" SELECT * FROM clientes_vekttor WHERE id = '$venda->cliente_vekttor_id'"));
	$cliente_fornecedor = mysql_fetch_object(mysql_query($cf=" SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id = '$cliente_vekttor->id'"));
	$ItemPacote = mysql_query($kv=" SELECT * FROM  vekttor_venda_pacote WHERE vekttor_venda_id = '$venda->id'");
		$val_implantacao = 0;
		$val_mensalidade = 0;
		$totalPacote = 0; 
		while($pr=mysql_fetch_object($ItemPacote)){
					$ArrayPacote[] = $pr->pacotes_id;
					$val_implantacao += $pr->valor_implantacao;
					$val_mensalidade += $pr->valor_mensalidade;
					$totalPacote = $val_implantacao + $val_mensalidade; 
		}
		echo "<script>
			$('.table-add').remove();
		</script>";
		/* Valores para a ABA RESUMO */
			$valServico = mysql_fetch_object(mysql_query(" SELECT SUM(valor) AS totalServico FROM vekttor_venda_servico WHERE vekttor_venda_id = '$venda->id'"));
			$valImplantacao = mysql_fetch_object(mysql_query(" SELECT SUM(valor_implantacao) AS totalImplantacao FROM  vekttor_venda_pacote WHERE vekttor_venda_id = '$venda->id'"));
	//$vendedor = mysql_fetch_object(mysql_query(" SELECT * FROM rh_funcionario WHERE id= '$id' "));
	//$cliente_vendedor = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$vendedor->cliente_fornecedor_id'"));
	$usuario = mysql_fetch_object(mysql_query(" SELECT * FROM usuario WHERE id = '$cliente_fornecedor->usuario_id'"));
	$usuarioTipo = mysql_fetch_object(mysql_query($ut=" SELECT * FROM usuario_tipo WHERE id = '$usuario->usuario_tipo_id'"));
	
}



if($_GET['contato_id']>0){
	$cliente_vekttor  = mysql_fetch_object(mysql_query(" SELECT * FROM revenda_contato WHERE id = '".$_GET['contato_id']."'"));
	$cliente_fornecedor = mysql_fetch_object(mysql_query(" SELECT * FROM revenda_contato WHERE id = '".$_GET['contato_id']."'"));
	$interacao = mysql_fetch_object(mysql_query("SELECT * FROM revenda_contato_interacao WHERE id='".$_GET['contato_id']."'"));
}
?>