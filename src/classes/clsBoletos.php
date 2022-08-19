<?php
class clsBoletos
{
    public $name;
    public $valor;
    public $data;
    public $return = false;

    public function gerarBoleto(){

        if(!empty($this->name))
            $this->return = true;

        return $this->return;
    }

    public function getFile(){
        return 'boleto.pdf';
    }
}
?>