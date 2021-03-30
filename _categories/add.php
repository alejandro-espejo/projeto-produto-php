<?php 
    require("../_config/connection.php");        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<?php
        // Vai realizar algo se tiver conteudo no POST
        $result = false;
        $error = false;
        if($_POST) {
            try {
            
                $name = $_POST["name"];
                $description = $_POST["description"];

                $query = "INSERT INTO categories ( name, description) VALUES ( '$name', '$description')";
                $result = $conn->query($query);
                # utilizar caso ocorra algum erro: echo $conn -> error;
                header('Location: index.php?message=Categoria inserido com sucesso!');
                die();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
?>

<body>
    <?php
        readfile("../_partials/navbar.html");
    ?>
    
    <section class="container mt-5 mb-5">

        <div class="row mb-3">
            <div class="col">
                <h1>Adicionar Categoria</h1>
            </div>
        </div>

    <form action="" method="post">

        <div class="mb-3">
            <label class="form-label"  for="name">Nome: </label>
            <input class="form-control" type="text" name="name" id="name" placeholder="Nome da categoria">
        </div>

        <div class="mb-3">
            <label class="form-label" for="description">Descrição:</label>
            <textarea class="form-control" type="text" name="description" id="description" placeholder="Descrição da Categoria"></textarea>
        </div>
        
        <a href="index.php" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-success" type="submit">Salvar</button>
        <br/>
    </form>

</section>

    <?php if($_POST && (!$result || $error)): ?>
        <p>Erro ao salvar a nova categoria.</p>
        <p><?=$error ? $error : "Erro desconhecido" ?></p>
    <?php endif; ?>
</body>
</html>