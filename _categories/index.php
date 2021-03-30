<?php 
    require("../_config/connection.php");
    $message = false;
    if($_GET && $_GET["message"]) {
        $message = $_GET["message"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <?php
        $query = "SELECT * FROM categories";
        $result = $conn -> query($query);
        $rows = $result -> fetch_all(MYSQLI_ASSOC);

        $result -> close();
        $conn -> close();
    ?>

    <?php
        readfile("../_partials/navbar.html");
    ?>

    <section class="container mt-5 mb-5">

        <?php if($message): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?=$message?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    
        <div class="row mb-3">
            <div class="col">
                <h1>Categoria</h1>
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <a class="btn btn-primary" href="add.php">Adicionar</a>
            </div>
        </div>
    

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($rows as $categories): ?>
                    <tr>
                        <td><?=$categories["id"] ?></td>
                        <td><?=$categories["name"] ?></td>
                        <td><?=$categories["description"] ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                <button type="button" class="btn btn-outline-primary" onclick="confirmDelete(<?=$categories['id']?>)">
                                    Excluir
                                </button>
                                <a href="edit.php?id=<?=$categories['id']?>" class="btn btn-outline-primary">Editar</a>
                                <a href="view.php?id=<?=$categories['id']?>" class="btn btn-outline-primary">Verificar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <!-- O primeiro foreach vai percorrer as linhas 
    <?php foreach($rows as $row): ?>
             O segundo vai percorrer as colunas 
        <?php foreach($row as $key => $value): ?>
            <p>
                <?="O atributo $key tem valor $value"?>
            </P>
            <?php endforeach; ?>
    <?php endforeach; ?>
    -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script>
        const confirmDelete = (productId) => {
            const response = confirm("Deseja realmente excluir esta categoria?")
            if(response) {
                window.location.href = "delete.php?id=" + productId;
            }
        }
    </script>
</body>
</html>