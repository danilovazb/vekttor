<?

class FinanceiroTour extends Tour{
	const _ETAPAS = 5;
	const _TITULO = "Ordem de Serviço";
	public function __construct(){
		$this->etapas=self::_ETAPAS;
		$this->titulo=self::_TITULO;
	}
	public function etapa1(){
		$qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM financeiro_contas WHERE cliente_vekttor_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[0]= $this->marcarEtapa("Cadastro de conta",true,49);
		}else{
			$this->itens[0]= $this->marcarEtapa("Cadastro de conta",false,49);
		}
	}
	public function etapa2(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM financeiro_centro_custo WHERE cliente_id='".$_SESSION['usuario']->cliente_vekttor_id."' AND plano_ou_centro='centro'"),0,0);
		$this->itens[1] = ($qtd>0)?$this->marcarEtapa("Cadastro de centro de custo",true,50):$this->marcarEtapa("Cadastro de centro de custo",false,50);
	}
	public function etapa3(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM financeiro_centro_custo WHERE cliente_id='".$_SESSION['usuario']->cliente_vekttor_id."' AND plano_ou_centro='plano'"),0,0);
		if ($qtd>0){
			$this->itens[2]= $this->marcarEtapa("Cadastro de plano de conta",true,51);
		}else{
			$this->itens[2]= $this->marcarEtapa("Cadastro de plano de conta",false,51);
		}
	}
	public function etapa4(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM financeiro_movimento WHERE cliente_id='".$_SESSION['usuario']->cliente_vekttor_id."' AND tipo='receber'"),0,0);
		if ($qtd>0){
			$this->itens[3]= $this->marcarEtapa("Cadastro de conta a receber",true,53);
		}else{
			$this->itens[3]= $this->marcarEtapa("Cadastro de conta a receber",false,53);
		}
	}
	public function etapa5(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM financeiro_movimento WHERE cliente_id='".$_SESSION['usuario']->cliente_vekttor_id."' AND tipo='pagar'"),0,0);
		if ($qtd>0){
			$this->itens[4]= $this->marcarEtapa("Cadastro de conta a pagar",true,52);
		}else{
			$this->itens[4]= $this->marcarEtapa("Cadastro de conta a pagar",false,52);
		}
	}
	
	public function etapa6(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM financeiro_movimento WHERE cliente_id='".$_SESSION['usuario']->cliente_vekttor_id."' AND status='1' "),0,0);
		if ($qtd>0){
			$this->itens[5]= $this->marcarEtapa("Efetive uma movimentação e verifique no caixa",true,54);
		}else{
			$this->itens[5]= $this->marcarEtapa("Efetive uma movimentação e verifique no caixa",false,54);
		}
	}
	
	
}