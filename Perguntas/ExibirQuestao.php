<?php
$idPergunta = $_GET["idPergunta"];
$arqPergunta = fopen("Perguntas.txt", "r") or die("Erro ao abrir arquivo");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Questão</title>
</head>

<body>
    <h1>Questão</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Pergunta</th>
            <th>Resposta</th>
        </tr>
        <?php
        while (!feof($arqPergunta)) {
            $linha = fgets($arqPergunta);
            if ($linha == false) {
                break;
            }
            $dados = explode(";", $linha);
            if ($dados[0] == "id") {
                continue;
            }
            if (trim($dados[0]) == $idPergunta) {
                $id = $dados[0];
                $pergunta = trim($dados[1]);
        ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $pergunta; ?></td>
                    <td>
                        <?php
                        $arqResposta = fopen("Respostas.txt", "r") or die("Erro ao abrir arquivo");
                        while (!feof($arqResposta)) {
                            $linhaResposta = fgets($arqResposta);
                            if ($linhaResposta == false) {
                                break;
                            }
                            $dadosResposta = explode(";", $linhaResposta);
                            if ($dadosResposta[0] == "idPergunta") {
                                continue;
                            }
                            if (trim($dadosResposta[0]) == $idPergunta) {
                                echo trim($dadosResposta[1]);
                            }
                        }
                        fclose($arqResposta);
                        ?>
                    </td>
                </tr>
        <?php
            }
        }
        fclose($arqPergunta);
        ?>
    </table>
</body>

</html>