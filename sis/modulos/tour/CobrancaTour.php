<?

class OdontoTour extends Tour{
	const _ETAPAS = 2;
	const _TITULO = "Cobran�a Mensal";
	public function __construct(){
		$this->etapas=self::_ETAPAS;
		$this->titulo=self::_TITULO;
	}
	public function etapa1(){
		$qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM cobranca_mensal_configuracao WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		if ($qtd>0){
			$this->itens[0]= $this->marcarEtapa("Configure os Paramentros da Cobran�a",true,545);
		}else{
			$this->itens[0]= $this->marcarEtapa("Cadastre os clientes que voc� cobrar� Mensalmente",false,545);
		}
	}
	public function etapa2(){
		$qtd=mysql_result(mysql_query("SELECT COUNT(*) FROM usuario_tipo WHERE vkt_id='".$_SESSION['usuario']->cliente_vekttor_id."'"),0,0);
		$this->itens[1] = ($qtd>0)?$this->marcarEtapa("Cadastre os clientes que ser�o cobrados no (+)",true,545):$this->marcarEtapa("Cadastre os clientes que ser�o cobrados no (+)",false,545);
	}
	
}