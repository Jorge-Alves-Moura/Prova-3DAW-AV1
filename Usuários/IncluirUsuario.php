<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST["matricula"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];

    if (!file_exists("Usuarios.txt")) {
        $arqUsuarios = fopen("Usuarios.txt", "w") or die("Erro ao criar arquivo");
        $linha = "matricula;nnome;email;\n";
        fwrite($arqUsuarios, $linha);
        fclose($arqUsuarios);
    }
    $arqUsuarios = fopen("Usuarios.txt", "a") or die("Erro ao abrir arquivo");
    $linha = $matricula . ";" . $nome . ";" . $email . "\n";
    fwrite($arqUsuarios, $linha);
    fclose($arqUsuarios);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inclusao de usuario</title>
</head>

<body>
    <form action="IncluirUsuario.php" method="post">
        <input type="text" name="nome" placeholder="Nome:"><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="text" name="matricula" placeholder="Matrícula:"><br>
        <input type="submit">
    </form>
</body>

</html>