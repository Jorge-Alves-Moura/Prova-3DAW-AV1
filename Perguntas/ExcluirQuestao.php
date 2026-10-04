<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPergunta = $_POST["idPergunta"];
    $tipo = $_POST["tipo"];
    if ($tipo == "multipla") {
        $arquivoPergunta = "Perguntas Multipla.txt";
        $arquivoResposta = "Respostas Multipla.txt";
    } else {
        $arquivoPergunta = "Perguntas Discursivas.txt";
        $arquivoResposta = "Respostas Discursivas.txt";
    }
    $arqPergunta = fopen($arquivoPergunta, "r") or die("Erro ao abrir o arquivo");
    $arqNovo = fopen("Perguntas Novo.txt", "w") or die("Erro ao criar o arquivo");
    while (!feof($arqPergunta)) {
        $linha = fgets($arqPergunta);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] == "id") {
                fwrite($arqNovo, $linha);
            } else if (trim($dados[0]) != $idPergunta) {
                fwrite($arqNovo, $linha);
            }
        }
    }
    fclose($arqPergunta);
    fclose($arqNovo);
    unlink($arquivoPergunta);
    rename("Perguntas Novo.txt", $arquivoPergunta);
    $arqResposta = fopen($arquivoResposta, "r") or die("Erro ao abrir o arquivo");
    $arqNovo = fopen("Respostas Novo.txt", "w") or die("Erro ao criar o arquivo");
    while (!feof($arqResposta)) {
        $linha = fgets($arqResposta);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] == "idPergunta") {
                fwrite($arqNovo, $linha);
            } else if (trim($dados[0]) != $idPergunta) {
                fwrite($arqNovo, $linha);
            }
        }
    }
    fclose($arqResposta);
    fclose($arqNovo);
    unlink($arquivoResposta);
    rename("Respostas Novo.txt", $arquivoResposta);
    echo "Pergunta excluída com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Pergunta</title>
</head>
<body>
    <form action="ExcluirQuestao.php" method="post">
        <input type="number" name="idPergunta" placeholder="ID da pergunta" required>
        <select name="tipo">
            <option value="multipla">Múltipla escolha</option>
            <option value="discursiva">Discursiva</option>
        </select>
        <input type="submit" value="Excluir">
    </form>
</body>
</html>