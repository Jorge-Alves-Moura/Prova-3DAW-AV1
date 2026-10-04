<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idPergunta = $_POST["idPergunta"];
    $pergunta = $_POST["pergunta"];
    $resposta = $_POST["resposta"];

    $arqPergunta = fopen("Perguntas Discursivas.txt", "r") or die("Erro ao abrir o arquivo");

    $arqNovo = fopen("Perguntas Discursivas Novo.txt", "w") or die("Erro ao criar o arquivo");

    while (!feof($arqPergunta)) {
        $linha = fgets($arqPergunta);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] == "id") {
                fwrite($arqNovo, $linha);
            } else if (trim($dados[0]) == $idPergunta) {
                $linhaPergunta = $idPergunta . ";" . $pergunta . "\n";
                fwrite($arqNovo, $linhaPergunta);
            } else {
                fwrite($arqNovo, $linha);
            }
        }
    }
    fclose($arqPergunta);
    fclose($arqNovo);

    unlink("Perguntas Discursivas.txt");
    rename("Perguntas Discursivas Novo.txt", "Perguntas Discursivas.txt");

    $arqResposta = fopen("Respostas Discursivas.txt", "r") or die("Erro ao abrir o arquivo");

    $arqNovo = fopen("Respostas Discursivas Novo.txt", "w") or die("Erro ao criar o arquivo");

    while (!feof($arqResposta)) {
        $linha = fgets($arqResposta);
        if ($linha != "") {
            $dados = explode(";", $linha);
            if ($dados[0] == "idPergunta") {
                fwrite($arqNovo, $linha);
            } else if (trim($dados[0]) == $idPergunta) {
                $linhaResposta = $idPergunta . ";" . $resposta . "\n";
                fwrite($arqNovo, $linhaResposta);
            } else {
                fwrite($arqNovo, $linha);
            }
        }
    }
    fclose($arqResposta);
    fclose($arqNovo);

    unlink("Respostas Discursivas.txt");
    rename("Respostas Discursivas Novo.txt", "Respostas Discursivas.txt");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pergunta</title>
</head>

<body>
    <form action="AlterarQuestao-Discursiva.php" method="get">
        <input type="number" name="idPergunta" placeholder="ID da pergunta" required>
        <input type="submit" value="Buscar">
    </form>

    <?php
    if (isset($_GET["idPergunta"]) && !isset($_POST["resposta"])) {
        $idPergunta = $_GET["idPergunta"];
        $perguntaEncontrada = false;
        $arqPergunta = fopen("Perguntas Discursivas.txt", "r") or die("Erro ao abrir o arquivo");

        while (!feof($arqPergunta)) {
            $linha = fgets($arqPergunta);
            if ($linha != "") {
                $dados = explode(";", $linha);
                if (isset($dados[1]) && trim($dados[0]) == $idPergunta) {
                    $pergunta = trim($dados[1]);
                    $perguntaEncontrada = true;
                }
            }
        }
        fclose($arqPergunta);

        if ($perguntaEncontrada) {
            $resposta = "";
            $arqResposta = fopen("Respostas Discursivas.txt", "r") or die("Erro ao abrir o arquivo");

            while (!feof($arqResposta)) {
                $linha = fgets($arqResposta);
                if ($linha != "") {
                    $dados = explode(";", $linha);
                    if (isset($dados[1]) && trim($dados[0]) == $idPergunta) {
                        $resposta = trim($dados[1]);
                    }
                }
            }

            fclose($arqResposta);
            echo "<form action='AlterarQuestao-Discursiva.php' method='post'>";
            echo "<input type='hidden' name='idPergunta' value='$idPergunta'>";
            echo "<input type='text' name='pergunta' value='$pergunta'>";
            echo "<input type='text' name='resposta' value='$resposta'>";
            echo "<input type='submit'>";
            echo "</form>";
        }
    }

    ?>

</body>

</html>