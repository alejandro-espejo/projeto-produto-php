<?php 
    require("../_config/connection.php");        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar de Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

    <?php
        // Vai realizar algo se tiver conteudo no POST
        $result = false;
        $error = false;

        if($_POST) {
            try {
                $image = $_POST["image"];
                $name = $_POST["name"];
                $description = $_POST["description"];
                $quantity = $_POST["quantity"];
                $category_id = $_POST["category_id"];

                $query = "INSERT INTO products ( name, description, quantity, image, category_id) VALUES ( '$name', '$description',$quantity, '$image', $category_id)";
                
                $result = $conn->query($query);
                $conn ->close();

                if ($result) {
                    # utilizar caso ocorra algum erro: echo $conn -> error;
                    header('Location: exemploCadastroBanco.php?message=Produto inserido com sucesso!');
                    die();
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        try {
            $categoryQuery = "SELECT * FROM categories";
            $categoryResult = $conn -> query($categoryQuery);
        } catch (Exception $e) {
            header('Location: exemploCadastroBanco.php?message=Erro ao cadastrar Categoria!');
            die();
        }
        $conn -> close();
    ?>

<body>
    <?php
        readfile("../_partials/navbar.html");
    ?>
    <section class="container mt-5 mb-5">
        <?php if($_POST && (!$result || $error)): ?>
            <p>Erro ao salvar o novo produto.</p>
            <p><?=$error ? $error : "Erro desconhecido" ?></p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Adicionar Produto</h1>
            </div>
        </div>

        <form action="" method="post">

            <div class="mb-3">
                <label for="category_id" class="form-label">Categoria:</label>
                <select  id="category_id" class="form-control" name="category_id" name="category_id"required>
                    <option value=""></option>
                    <?php while($category = $categoryResult->fetch_assoc()): ?>
                        <option value="<?=$category['id']?>">
                            <?=$category["name"]?>
                        </option>
                    <?php endwhile; ?>

                    <?php $categoryResult->close(); ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">imagem</label>
                <input type="text" class="form-control" id="image" name="image" placeholder="Url da imagem do produto">
            </div>

            <div class="mb-3">
                <label class="form-label"  for="name">Nome: </label>
                <input class="form-control" type="text" name="name" id="name" placeholder="Nome do Produto">
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Descrição:</label>
                <textarea class="form-control" type="text" name="description" id="description" placeholder="Descrição do Produto"></textarea>
            </div>

            <div class="mb-3">
            <label class="form-label" for="quantity">Quantidade</label>
            <input class="form-control" type="number" min="0" max="9999" name="quantity" id="quantity" placeholder="Quantidade no Estoque"/>
            </div>
            
            <a href="exemploCadastroBanco.php" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-success" type="submit">Salvar</button>
            <br/>
        </form>
    </section>
</body>
</html>