<?php 
    require("../_config/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
    <?php 
        $categories = false;
        $error = false;
        if(!$_GET || !$_GET["id"]) {
            header('Location: index.php?message=Id da categoria não informado!');
            die();
        }

        $productId = $_GET["id"];
        try {
            $query = "SELECT * FROM categories WHERE id=$productId";
            $result = $conn -> query($query);
            $categories = $result -> fetch_assoc();
            $result -> close();
            
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if(!$categories || $error) {
            header('Location: index.php?message=Erro ao recuperar os dados da categoria!');
            die();
        }

        // Vai realizar algo se tiver conteudo no POST
        $updateResult = false;
        $updateError = false;
        if($_POST) {
            try {
                $name = $_POST["name"];
                $description = $_POST["description"];

                $query = "UPDATE categories SET name='$name', description='$description' WHERE id=$productId";
                $result = $conn->query($query);
                # utilizar caso ocorra algum erro: echo $conn -> error;
                if($result) {
                    header('Location: index.php?message=Categoria inserido com sucesso!');
                    die();
                }
            } catch (Exception $e) {
                $updateError = $e->getMessage();
            }
        }

        $conn -> close();
    ?>
<body>
    <?php
        readfile("../_partials/navbar.html");
    ?>
    <section class="container mt-5 mb-5">

        <?php if($_POST && (!$updateResult || $updateError)): ?>
            <p>Erro ao alterar a Categoria.</p>
            <p><?=$error ? $error : "Erro desconhecido" ?></p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Editar Categoria</h1>
            </div>
        </div>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label"  for="name">Nome: </label>
                <input class="form-control" type="text" name="name" id="name" value="<?=$categories['name']?>" placeholder="Nome da Categoria">
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Descrição:</label>
                <textarea class="form-control" type="text" name="description" id="description" placeholder="Descrição da Categoria"><?=$categories['description']?></textarea>
            </div>
            
            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-success" type="submit">Salvar</button>
            <br/>
        </form>
    </section>
</body>
</html>