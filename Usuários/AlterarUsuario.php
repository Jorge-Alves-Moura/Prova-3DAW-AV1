<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST["matricula"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $arqUsuarios = fopen("Usuarios.txt", "r") or die("Erro ao abrir arquivo!");
    $arqNovo = fopen("Usuarios_novo.txt", "w") or die("Erro ao criar!");
    while (!feof($arqUsuarios)) {
        $linha = fgets($arqUsuarios);
        if ($linha == false) {
            break;
        }
        $dados = explode(";", $linha);

        if ($dados[0] == $matricula) {
            $linha = $matricula . ";" . $nome . ";" . $email . "\n";
        }
        fwrite($arqNovo, $linha);
    }
    fclose($arqUsuarios);
    fclose($arqNovo);

    unlink("Usuarios.txt");
    rename("Usuarios_novo.txt", "Usuarios.txt");
    $msg = "Alteraçao bem sucedida";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="AlterarUsuario.php" method="post">
        <input type="text" name="nome" placeholder="Alterar nome:"><br>
        <input type="text" name="email" placeholder="Alterar email:"><br>
        <input type="submit">
    </form>
</body>

</html>
