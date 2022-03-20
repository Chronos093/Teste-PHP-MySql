<?PHP
    include('connect.php');

    $id = $_POST['idExcluir'];

    //echo $id;

    $sql_idpreco = "SELECT preco.IDPRECO FROM preco INNER JOIN produtos ON preco.IDPRECO = produtos.IDPRECO WHERE produtos.IDPROD = $id;";
    $query_idpreco = mysqli_query($con, $sql_idpreco);

    $linha = mysqli_fetch_assoc($query_idpreco);
    $idPreco = $linha['IDPRECO'];

    $sql_del_produto = "DELETE FROM produtos WHERE IDPROD = $id;";
    $sql_del_preco = "DELETE FROM preco WHERE IDPRECO = $idPreco";

    mysqli_query($con, $sql_del_preco);
    mysqli_query($con, $sql_del_produto);

    mysqli_close($con);
        
    header("Location: index.php");
?>