<?
include("../../../_config.php");
include("../../../_functions_base.php");
include("../_functions_financeiro.php");
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];
$dia=$_GET[dia];
$mes=$_GET[mes];
$ano=$_GET[ano];
if($dia<10)$dia='0'.$dia;
if($mes<10)$mes='0'.$mes;
$dataBR = $dia.'/'.$mes.'/'.$ano;
$dataUS = $ano.'-'.$mes.'-'.$dia;
$valor=moedaBrToUsa($_GET[valor]);
$valor_a[]=$_GET[valor];
$dados_q=mysql_query("SELECT * FROM financeiro_contas_fixas WHERE id='$id'");
$dados=mysql_fetch_object($dados_q);
$centro_custo_id[]=$dados->centro_custo_id;
$plano_conta_id[]=$dados->plano_conta_id;
echo $dataUS;
//Cadastra Registro
if(isset($_GET['id'])){
		$retorno = pagarReceberInsert(
		$_SESSION[usuario]->cliente_vekttor_id,
							'0',
							'0',
							$dados->fornecedor_id,
							$centro_custo_id,
							'',
							$valor_a,
							$dataUS,
							$mes.'/'.$ano,
							$dados->descricao,
							'',
							'',
							'0',
							$valor,
							'pagar',
							'',
							$plano_conta_id,
							'',
							$valor_a,
							'Salvar',
							$_POST[efetivar_movimento],
							$dataBR,
							$dados->id,
							'Conta Fixa');
		if($retorno!='ok'){
			echo "<script>alert('Erro ".mysql_error()."')</script>";	
		}
		$ultimo_q=mysql_query("SELECT id FROM financeiro_movimento ORDER BY id DESC LIMIT 1");
		$ultimo=mysql_fetch_object($ultimo_q);
		$proximo_id=$ultimo->id;
		
		$inserir_fixa_valor=mysql_query("INSERT INTO financeiro_contas_fixas_valor SET conta_fixa_id='{$dados->id}', movimento_id='$proximo_id' " );
		if(!$inserir_fixa_valor){
			echo "<script>alert('".mysql_error()."')</script>";
		}
		
}

?>
