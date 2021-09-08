<?php

class Jogador {

    private $estado;  // 1 vivo, 0 morto	
    private $passouMapa;
    private $movimentou;
    private $posicao = array();
    private $posicaoAnterior = array();
	
    public function __construct(){
	$this->estado = 1;
	$this->passouMapa = false;
	$this->movimentou = false;
    }
	
	public function getEstado(){
        return $this->estado;
    }
	
	public function setEstado($estado){
        $this->estado = $estado;
    }
	
	public function getPassouMapa(){
        return $this->passouMapa;
    }
	
	public function setPassouMapa($passouMapa){
        $this->passouMapa = $passouMapa;
    }
	
	public function getMovientou(){
        return $this->movimentou;
    }
	

        public function getPosicao(){
        return $this->posicao;
    }

	public function setPosicao($posicao){
        $this->posicao = $posicao;
    }
	
	public function getPosicaoAnterior(){
        return $this->posicaoAnterior;
    }

        public function setPosicaoAnterior($posicaoAnterior){
        $this->posicaoAnterior = $posicaoAnterior;
    }
	
   public function mover($caracter, $posicaoDesejada){  
        
	if($caracter == "X"){
		$this->movimentou = false;
                $this->setPosicaoAnterior($this->getPosicao());
			
	} else if($caracter == "_"){
		$this->setPosicaoAnterior($this->getPosicao());
		$this->setPosicao($posicaoDesejada);	
		$this->movimentou = true;

	} else if($caracter == "E"){
	        $this->movimentou = false;

	} else if($caracter == "D"){
		$this->setPosicaoAnterior($this->getPosicao());
		$this->setPosicao($posicaoDesejada);	
		$this->movimentou = true;	
		$this->passouMapa = true;

	}
	
	return $this->posicao;
   }

}

?>
