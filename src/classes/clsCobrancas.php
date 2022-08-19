<?php
class clsCobrancas
{
	public $id;
	public $name = '';
    public $governmentId = '';
    public $debtAmount = '';
    public $debtDueDate = '';
    public $debtId = '';
    	
	public function save () {

		/* schema database */

		$this->id = $this->id + 1;
		return true;
	}
}
?>