<?php 
    require("../_config/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>


    <?php 
        $product = false;
        $error = false;
        if(!$_GET || !$_GET["id"]) {
            header('Location: exemploCadastroBanco.php?message=Id do produto não informado!');
            die();
        }

        $productId = $_GET["id"];
        try {
            $query = "SELECT * FROM products WHERE id=$productId";
            $result = $conn -> query($query);
            $product = $result -> fetch_assoc();
            $result -> close();
            
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if(!$product || $error) {
            header('Location: exemploCadastroBanco.php?message=Erro ao recuperar os dados do produto!');
            die();
        }

        $updateResult = false;
        $updateError = false;
        if($_POST) {
            try {
                $image = $_POST["image"];
                $name = $_POST["name"];
                $description = $_POST["description"];
                $quantity = $_POST["quantity"];
                $category_id = $_POST["category_id"];

                $query = "UPDATE products SET name='$name', description='$description', quantity=$quantity, image='$image', category_id=$category_id WHERE id=$productId";
                
                $updateResult = $conn -> query($query);

                if($updateResult) {
                    header('Location: index.php?message=Produto alterado com sucesso!');
                    die();
                }
            } catch (Exception $e) {
                $updateError = $e->getMessage();
            }
        }

        try {
            $categoryQuery = "SELECT * from categories";
            $categoryResult = $conn->query($categoryQuery);
        } catch (Exception $e) {
            header('Location: index.php?message=Erro ao recuperar categorias!');
            die();
        }

        $conn->close();

    ?>

    <?php
        readFile("../_partials/navbar.html");
    ?>

    <section class="container mt-5 mb-5">
        <?php if($_POST && (!$updateResult || $updateError)): ?>
            <p>Erro ao alterar o produto.</p>
            <p><?=$error ? $error : "Erro desconhecido" ?></p>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col">
                <h1>Editar Produto</h1>
            </div>
        </div>

        <form action="" method="post">

            <div class="mb-3">
                <label for="category_id" class="form-label">Categoria</label>
                <select 
                    class="form-control" 
                    id="category_id" 
                    name="category_id"
                    required>
                        <option value></option>

                        <?php while($category = $categoryResult->fetch_assoc()): ?>
                            <option 
                                value="<?=$category["id"]?>"
                                <?= $category["id"] == $product["category_id"] ? 'selected' : '';?>
                                >
                                <?=$category["name"]?>
                            </option>
                        <?php endwhile; ?>
                        
                        <?php $categoryResult->close(); ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Imagem</label>
                <input type="text" class="form-control" id="image" name="image" placeholder="Url da imagem do produto" value="<?=$product['image']?>">
            </div>

            <div class="mb-3">
                <label class="form-label"  for="name">Nome: </label>
                <input class="form-control" type="text" name="name" id="name" value="<?=$product['name']?>" placeholder="Nome do Produto">
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Descrição:</label>
                <textarea class="form-control" type="text" name="description" id="description" placeholder="Descrição do Produto"><?=$product['description']?></textarea>
            </div>

            <div class="mb-3">
            <label class="form-label" for="quantity">Quantidade</label>
            <input class="form-control" type="number" min="0" max="9999" name="quantity" id="quantity" value="<?=$product['quantity']?>" placeholder="Quantidade no Estoque">
            </div>
            
            <a href="index.php" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-success" type="submit">Salvar</button>
            
        </form>
    </section>
</body>
</html>