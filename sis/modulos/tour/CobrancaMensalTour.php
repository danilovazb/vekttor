<?

class CobrancaMensalTour extends Tour{
	const _ETAPAS = 2;
	const _TITULO = "Cobrança Mensal";
	public function __construct(){
		$this->etapas=self::_ETAPAS;
		$this->titulo=self::_TITULO;
	}
	public function etapa1(){
		$qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM cobranca_mensal_configuracao WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[0]= $this->marcarEtapa("Configure os Paramentros da Cobrança",true,545);
		}else{
			$this->itens[0]= $this->marcarEtapa("Configure os Paramentros  da Cobrança",false,545);
		}
	}
	public function etapa2(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM usuario_tipo WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		$this->itens[1] = ($qtd>0)?$this->marcarEtapa("Cadastre os clientes que serão cobrados no <img src='../fontes/img/mais.png'>",true,545):$this->marcarEtapa("Cadastre os clientes que serão cobrados no <img src='../fontes/img/mais.png'>",false,545);
	}
	
}