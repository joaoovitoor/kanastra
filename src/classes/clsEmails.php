<?php
class clsEmails
{
	private $remetente_nome = 'Usuário Kanastra';
	private $remetente_email = 'noreplya@kanastra.com.br';
    private $remetente_senha = '123456';
    private $remetente_servidor  = '';

    public $assunto;
    public $destinatario;
    public $attachment;
    public $mensagem;
    public $conectado = false;
    	
	private function connectSMTP() {
        // phpmailer conectando...

        return true;
    }

    public function enviarEmail (){

        if(!$this->conectado)
            $this->conectado = $this->connectSMTP();

        if(!$this->assunto)
            return true;
        else return false;

    }
}
?>