<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Moedas2.0</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Conversor de Moedas 2.0</h1>
            <?php 
            //Cotação vinda da API do Banco Central
                        
            $inicio = date("m-d-Y", strtotime("-7 days"));
            $fim = date("m-d-Y");
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''.$inicio.'\'&@dataFinalCotacao=\''.$fim.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

            $dados = json_decode(file_get_contents($url), true);

            //var_dump($dados);

            $cotação = $dados["value"][0]["cotacaoCompra"];

                //Quanto você tem?
                $real = $_REQUEST["din"] ?? 0;

                //Equivalência em dólar
                $dolar = $real / $cotação;

                //Mostrar o resultado (Forma Simples)
                //echo "Seus R\$" . number_format($real, 2, ",", ".") . " equivalent a US\$" . number_format($dolar, 2, ",", ".");

                //Formatação de moedas com internacionalização! (Forma Profissional)

                $padrão = numfmt_create("us", NumberFormatter::CURRENCY);

                echo "<p>Seus " . numfmt_format_currency($padrão, $real, "BRL") . " equivalem a " . numfmt_format_currency($padrão, $dolar, "USD") . "</p>";

                echo "A cotação atual: US\$ $cotação";

            
            ?>
        <button onclick="javascript:history.go(-1)">Voltar</button>
    </main>
    
</body>
</html>