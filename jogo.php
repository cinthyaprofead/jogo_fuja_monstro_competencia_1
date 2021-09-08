<?php

include_once('mapa.php');
include_once('jogador.php');
include_once('personagemNaoJogavel.php');

class Jogo {

	private $mapa;
	private $personagemJogador;
	private $personagemNaoJogavel;
        private $html_saida;
	
public function __construct($mapa, $personagemJogador, $personagemNaoJogavel){       

	
        if(is_null($mapa)){ 
		
			$this->mapa = new Mapa();			
			$this->personagemJogador = new Jogador();
                        $this->personagemNaoJogavel = new PersonagemNaoJogavel();
        } else {

                        $this->mapa = $mapa;			
			$this->personagemJogador = $personagemJogador;		
			$this->personagemNaoJogavel = $personagemNaoJogavel;
			
        }
		$this->personagemJogador->setPosicao($this->mapa->obterPosicaoPersonagem("P"));
		$this->personagemNaoJogavel->setPosicao($this->mapa->obterPosicaoPersonagem("E"));
    }
	
public function executarJogo($posicaoDesejada){

	$this->personagemJogador->mover($this->mapa->obterCaracterePosicao($posicaoDesejada), $posicaoDesejada);
        $passouMapa = $this->personagemJogador->getPassouMapa();

        $zerarJogo = $this->mapa->atualizaPersonagemMapa($this->personagemJogador, $passouMapa);

        if($zerarJogo){
                $this->mapa = new Mapa();			
		$this->personagemJogador = new Jogador();
                $this->personagemNaoJogavel = new PersonagemNaoJogavel();

                $this->personagemJogador->setPosicao($this->mapa->obterPosicaoPersonagem("P"));
		$this->personagemNaoJogavel->setPosicao($this->mapa->obterPosicaoPersonagem("E"));

        }else if(!$passouMapa){
                $this->personagemNaoJogavel->mover($this->personagemJogador->getPosicao(), $this->mapa->getMapaEstadoAtual());
	        $this->mapa->atualizaPersonagemMapa($this->personagemNaoJogavel, $passouMapa);

                if($this->personagemNaoJogavel->getMataPersonagem()){

                        $this->personagemJogador->setEstado(0);
                        $this->mapa->atualizaPersonagemMapa($this->personagemJogador, $passouMapa);

                }
        }
		
    }		
	
	
private function gerarMapa(){
        $saida = '<div >';
        foreach ($this->mapa->getMapaEstadoAtual() as $linha) {
            foreach ($linha as $coluna) {
                if ($coluna == 'X') {
                    $saida .= '<input type=image src="imagens/rocha.png" width="70" height="70">';
                } else if ($coluna == 'P') {
                    $saida .= '<input type=image src="imagens/princesa.png" width="70" height="70">'; 
                } else if ($coluna == 'E') {
                    $saida .= '<input type=image src="imagens/monstro.png" width="70" height="70">';
                } else if ($coluna == 'D') {
                    $saida .= '<input type=image src="imagens/portal.png" width="70" height="70">';                    
                } else if ($coluna == 'O') {
                    $saida .= '<input type=image src="imagens/fantasma.png" width="70" height="70">';
                } else {
                    $saida .= '<input type=image src="imagens/grama.png" width="70" height="70">';   
                }
            }
            $saida .= '<br>';
        }
        return $saida.'</div>';
    }
	

private function gerarFormulario(){

        $personagemJogadorSerializado = serialize($this->personagemJogador);
        file_put_contents('personagemJogadorSerializado', $personagemJogadorSerializado);

        $mapaSerializado = serialize($this->mapa);
        file_put_contents('mapaSerializado', $mapaSerializado);

        $personagemNaoJogavelSerializado = serialize($this->personagemNaoJogavel);
        file_put_contents('personagemNaoJogavelSerializado', $personagemNaoJogavelSerializado);
       
        return '<form method="POST" >
        <button name="dir"  class="botao_esquedo" value="left">Esquerda</button>
        <button name="dir" class="botao_direito" value="right">Direita</button>
        <button name="dir" class="botao_cima" value="up">Cima</button>
        <button name="dir" class="botao_baixo" value="down">Baixo</button>		
			
        </form>
        <p>Você está no nível '.$this->mapa->getNumeroNivel().'</p>';
       
    }
	
public function renderizarMapa(){

        $this->html_saida = '<h1> Fuja do Monstro </h1>';
        $this->html_saida .= $this->gerarMapa();

        if($this->personagemJogador->getEstado()==1){ // se o jogador está vivo
            $this->html_saida.= $this->gerarFormulario();
        }

        $this->html_saida.= file_get_contents('rodape.html');



        echo $this->html_saida;

    }
	
}

?>
