<?PHP
    include('connect.php');

    $id = $_POST['idEditar'];
    $nome = $_POST['nome_prod'];
    $preco = $_POST['preco_prod'];
    $nome = strtoupper($nome);

    // RECUPERA O IDPRECO 
    $sql_idpreco = "SELECT produtos.IDPRECO FROM produtos WHERE IDPROD = '$id';";
    $query_idpreco = mysqli_query($con, $sql_idpreco);
    $linha = mysqli_fetch_assoc($query_idpreco);
    $idpreco = $linha['IDPRECO'];

    if (empty($nome) || empty($preco)) {
        echo "<script> alert('Está faltando informação.'); </script>";
        header('Location: index.php');
    }else {
        $sql_up_produtos = "UPDATE produtos SET NOME = '$nome' WHERE IDPROD = $id;";
        $sql_up_preco = "UPDATE preco SET PRECO = '$preco' WHERE IDPRECO = $idpreco;";
        mysqli_query($con, $sql_up_produtos);
        mysqli_query($con, $sql_up_preco);
        header('Location: index.php');
    }
?>