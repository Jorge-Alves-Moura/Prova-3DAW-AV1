<?php
$arqPerguntaMultipla = fopen("Perguntas Multipla.txt", "r") or die("Erro ao abrir arquivo");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Perguntas</title>
</head>

<body>
    <h1>Lista de Perguntas</h1>
    <table border="1">
        <tr>
            <th>Tipo</th>
            <th>ID</th>
            <th>Pergunta</th>
            <th>Resposta</th>
            <th>Ações</th>
        </tr>
        <?php
        while (!feof($arqPerguntaMultipla)) {
            $linha = fgets($arqPerguntaMultipla);
            if ($linha == false) {
                break;
            }
            $dados = explode(";", $linha);
            if ($dados[0] == "id") {
                continue;
            }
            $idPergunta = $dados[0];
            $pergunta = trim($dados[1]);
        ?>
            <tr>
                <td>Múltipla escolha</td>
                <td><?php echo $idPergunta; ?></td>
                <td><?php echo $pergunta; ?></td>
                <td>
                    <?php
                    $arqResposta = fopen("Respostas Multipla.txt", "r") or die("Erro ao abrir arquivo");
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
                            echo $dadosResposta[2] . " (Gabarito: " . trim($dadosResposta[3]) . ")<br>";
                        }
                    }
                    fclose($arqResposta);
                    ?>
                </td>
                <td>
                    <a href="ExibirQuestao.php?idPergunta=<?php echo $idPergunta; ?>&tipo=multipla">
                        <button>Exibir</button>
                    </a>
                    <a href="AlterarQuestao-MultiplaEscolha.php?idPergunta=<?php echo $idPergunta; ?>">
                        <button>Alterar</button>
                    </a>
                    <a href="ExcluirQuestao.php?idPergunta=<?php echo $idPergunta; ?>&tipo=multipla">
                        <button>Excluir</button>
                    </a>
                </td>
            </tr>
        <?php
        }
        fclose($arqPerguntaMultipla);
        $arqPerguntaDiscursiva = fopen("Perguntas Discursivas.txt", "r") or die("Erro ao abrir arquivo");
        while (!feof($arqPerguntaDiscursiva)) {
            $linha = fgets($arqPerguntaDiscursiva);
            if ($linha == false) {
                break;
            }
            $dados = explode(";", $linha);
            if ($dados[0] == "id") {
                continue;
            }
            $idPergunta = $dados[0];
            $pergunta = trim($dados[1]);
        ?>
            <tr>
                <td>Discursiva</td>
                <td><?php echo $idPergunta; ?></td>
                <td><?php echo $pergunta; ?></td>
                <td>
                    <?php
                    $arqResposta = fopen("Respostas Discursivas.txt", "r") or die("Erro ao abrir arquivo");
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
                <td>
                    <a href="ExibirQuestao.php?idPergunta=<?php echo $idPergunta; ?>&tipo=discursiva">
                        <button>Exibir</button>
                    </a>
                    <a href="AlterarQuestao-Discursiva.php?idPergunta=<?php echo $idPergunta; ?>">
                        <button>Alterar</button>
                    </a>
                    <a href="ExcluirQuestao.php?idPergunta=<?php echo $idPergunta; ?>&tipo=discursiva">
                        <button>Excluir</button>
                    </a>
                </td>
            </tr>
        <?php
        }
        fclose($arqPerguntaDiscursiva);
        ?>
    </table>
</body>

</html>