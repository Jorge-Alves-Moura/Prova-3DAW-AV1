<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $pergunta = $_POST["pergunta"];
    $quantidade = $_POST["quantidade"];

    if(!file_exists("Perguntas.txt"))
    {
        $arqPergunta = fopen("Perguntas.txt", "w") or die("Erro ao criar o arquivo");
        $arqResposta = fopen("Respostas.txt", "w") or die("Erro ao criar o arquivo");

        $linhaPergunta = "id;pergunta\n";
        $linhaResposta = "idPergunta;idResposta;resposta;gabarito\n";

        fwrite($arqPergunta, $linhaPergunta);
        fwrite($arqResposta, $linhaResposta);

        fclose($arqPergunta);
        fclose($arqResposta);

        $idPergunta = 1;
    }
    else
    {
        $arqPergunta = fopen("Perguntas.txt", "r") or die("Erro ao abrir o arquivo");

        $idPergunta = 0;

        while(!feof($arqPergunta))
        {
            $linha = fgets($arqPergunta);

            if($linha != "")
            {
                $dados = explode(";", $linha);

                if(is_numeric($dados[0]))
                {
                    $idPergunta = $dados[0];
                }
            }
        }

        $idPergunta = $idPergunta + 1;

        fclose($arqPergunta);
    }

    if(isset($_POST["resposta"]))
    {
        $respostas = $_POST["resposta"];
        $gabaritos = $_POST["gabarito"];

        $arqPergunta = fopen("Perguntas.txt", "a") or die("Erro ao incluir pergunta!");
        $arqResposta = fopen("Respostas.txt", "a") or die("Erro ao incluir resposta!");

        $linhaPergunta = $idPergunta . ";" . $pergunta . "\n";

        fwrite($arqPergunta, $linhaPergunta);
        $idResposta = 1;

        while($idResposta <= $quantidade)
        {
            $resposta = $respostas[$idResposta - 1];
            $gabarito = $gabaritos[$idResposta - 1];

            $linhaResposta = $idPergunta . ";" . $idResposta . ";" . $resposta . ";" . $gabarito . "\n";

            fwrite($arqResposta, $linhaResposta);

            $idResposta = $idResposta + 1;
        }

        fclose($arqPergunta);
        fclose($arqResposta);

        echo "Pergunta cadastrada com sucesso!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incluir Pergunta</title>
</head>

<body>

    <form action="Incluir.php" method="post">

        <label>Pergunta:</label>
        <input type="text" name="pergunta">

        <br><br>

        <label>Quantidade de respostas:</label>
        <input type="number" name="quantidade" min="2">

        <br><br>

        <input type="submit" value="Continuar">

    </form>

    <?php

    if(isset($_POST["quantidade"]) && !isset($_POST["resposta"]))
    {
        $quantidade = $_POST["quantidade"];

        echo "<form action='Incluir.php' method='post'>";

        echo "<input type='hidden' name='pergunta' value='" . $pergunta . "'>";
        echo "<input type='hidden' name='quantidade' value='" . $quantidade . "'>";

        $idResposta = 1;

        while($idResposta <= $quantidade)
        {
            echo "<p>";
            echo "<label>Resposta " . $idResposta . ":</label>";
            echo "<input type='text' name='resposta[]'>";

            echo "<label> Gabarito:</label>";
            echo "<select name='gabarito[]'>";
            echo "<option value='0'>Não</option>";
            echo "<option value='1'>Sim</option>";
            echo "</select>";
            echo "</p>";

            $idResposta = $idResposta + 1;
        }

        echo "<input type='submit' value='Cadastrar'>";
        echo "</form>";
    }

    ?>
</body>
</html>