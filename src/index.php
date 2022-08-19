<?php
require('./classes/clsBoletos.php');
require('./classes/clsCobrancas.php');
require('./classes/clsEmails.php');

if($_POST['acao'] == 'importar-csv'){
    $handle = fopen($_FILES['csv']['tmp_name'], "r");
    $row = 0;
    while ($line = fgetcsv($handle, 1000, ",")) {
        if ($row++ == 0) {
            continue;
        }
        
        $clsCobrancas = new clsCobrancas;
        $clsCobrancas->name = $line[0];
        $clsCobrancas->governmentId = $line[1];
        $clsCobrancas->debtAmount = $line[2];
        $clsCobrancas->debtDueDate = $line[3];
        $clsCobrancas->debtId = $line[4];
        
        if($clsCobrancas->save()){
            echo 'Cobrança salva com sucesso';

            $clsBoletos = new clsBoletos;
            $clsBoletos->name = $clsCobrancas->name;
            $clsBoletos->valor = $clsCobrancas->valor;
            $clsBoletos->data = $clsCobrancas->data;
            
            if($clsBoletos->gerarBoleto()){
                echo 'Boleto gerado com sucesso';

                $clsEmails  = new clsEmails;
                $clsEmails->assunto = 'Envio de boleto';
                $clsEmails->destinatario = $clsCobrancas->name;
                $clsEmails->attachment = $clsBoletos->getFile();
                $clsEmails->mensagem = 'Pague o seu boleto';
                
                if($clsEmails->enviarEmail())
                    echo 'E-mail enviado com sucesso';
                else
                    echo 'Erro ao enviar e-mail';

            }
        }
    }

    fclose($handle);
} else if($_POST['acao'] == 'importar-cnab'){

}?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>


<form method="post" enctype="multipart/form-data">
<img class="d-block mx-auto mb-4" src="https://kanastra.com.br/wp-content/uploads/2022/05/kanastragreen.svg">
<div class="px-4 py-5 my-5 text-center">
    <div class="col-lg-6 mx-auto">
      <div class="col-12">
        <h1 class="display-5 fw-bold">Importação CSV</h1>
        <p class="lead mb-4">Este é um programa para o teste da empresa kanastra, realizando a importação de um arquivo CSV</p>
        <input type="file" name="csv" id="csv" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
        
        

        <button name="acao" value="importar-csv" type="submit" class="btn btn-primary btn-lg px-4 gap-3">Importar CSV</button>
      </div>

      <hr>

      <div class="col-12">
        <h1 class="display-5 fw-bold">Importação CNAB</h1>
        <p class="lead mb-4">Este é um programa para o teste da empresa kanastra, realizando a importação de um arquivo CNAB</p>
        <input type="file" name="cnab" id="cnab">
        
        

        <button name="acao" value="importar-cnab" type="submit" class="btn btn-primary btn-lg px-4 gap-3">Importar CNAB</button>
      </div>
    </div>
  </div>
<?php
?>
