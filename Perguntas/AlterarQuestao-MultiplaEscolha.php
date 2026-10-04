<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPergunta = $_POST["idPergunta"];
    $pergunta = $_POST["pergunta"];
    $quantidade = $_POST["quantidade"];
    if (isset($_POST["resposta"])) {
        $respostas = $_POST["resposta"];
        $gabaritos = $_POST["gabarito"];
        $arqPergunta = fopen("Perguntas Multipla.txt", "r") or die("Erro ao abrir o arquivo");
        $arqNovo = fopen("Perguntas Multipla Novo.txt", "w") or die("Erro ao criar o arquivo");
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
        unlink("Perguntas Multipla.txt");
        rename("Perguntas Multipla Novo.txt", "Perguntas Multipla.txt");
        $arqResposta = fopen("Respostas Multipla.txt", "r") or die("Erro ao abrir o arquivo");
        $arqNovo = fopen("Respostas Multipla Novo.txt", "w") or die("Erro ao criar o arquivo");
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
        $idResposta = 1;
        while ($idResposta <= $quantidade) {
            $resposta = $respostas[$idResposta - 1];
            $gabarito = $gabaritos[$idResposta - 1];
            $linhaResposta = $idPergunta . ";" . $idResposta . ";" . $resposta . ";" . $gabarito . "\n";
            fwrite($arqNovo, $linhaResposta);
            $idResposta = $idResposta + 1;
        }
        fclose($arqNovo);
        unlink("Respostas Multipla.txt");
        rename("Respostas Multipla Novo.txt", "Respostas Multipla.txt");
    }
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
    <form action="AlterarQuestao-MultiplaEscolha.php" method="get">
        <input type="number" name="idPergunta" placeholder="ID da pergunta" required>
        <input type="submit" value="Buscar">
    </form>

    <?php

    if (isset($_GET["idPergunta"]) && !isset($_POST["resposta"])) {

        $idPergunta = $_GET["idPergunta"];
        $perguntaEncontrada = false;

        $arqPergunta = fopen("Perguntas Multipla.txt", "r")
            or die("Erro ao abrir o arquivo");

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

            $respostas = array();
            $gabaritos = array();

            $arqResposta = fopen("Respostas Multipla.txt", "r")
                or die("Erro ao abrir o arquivo");

            while (!feof($arqResposta)) {

                $linha = fgets($arqResposta);

                if ($linha != "") {

                    $dados = explode(";", $linha);

                    if (isset($dados[3]) && trim($dados[0]) == $idPergunta) {

                        $respostas[] = trim($dados[2]);
                        $gabaritos[] = trim($dados[3]);
                    }
                }
            }

            fclose($arqResposta);

            $quantidade = count($respostas);
            echo "<form action='AlterarQuestao-MultiplaEscolha.php' method='post'>";
            echo "<input type='hidden' name='idPergunta' value='$idPergunta'>";
            echo "<input type='text' name='pergunta' value='$pergunta'>";
            echo "<input type='hidden' name='quantidade' value='$quantidade'>";
            $idResposta = 1;

            while ($idResposta <= $quantidade) {
                echo "<input type='text' name='resposta[]' value='" . $respostas[$idResposta - 1] . "'>";
                echo "<select name='gabarito[]'>";
                if ($gabaritos[$idResposta - 1] == "1") {
                    echo "<option value='0'>0</option>";
                    echo "<option value='1' selected>1</option>";
                } else {
                    echo "<option value='0' selected>0</option>";
                    echo "<option value='1'>1</option>";
                }
                echo "</select>";
                $idResposta = $idResposta + 1;
            }
            echo "<input type='submit'>";
            echo "</form>";
        }
    }

    ?>

</body>

</html>