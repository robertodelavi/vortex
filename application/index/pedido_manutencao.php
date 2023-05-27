<?php
    $randon = md5(uniqid(time()));
    $_SESSION['idSession'] = $randon;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão - Azambuja</title>
    <link href="../../library/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../library/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../../library/inspinia/css/animate.css" rel="stylesheet">
    <link href="../../library/inspinia/css/style.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="../../library/inspinia/css/plugins/toastr/toastr.min.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="passwordBox animated fadeInDown" style="margin-top: -90px; max-width: 800px;">
        <div class="row form-group">
            <div class="col-md-12">
                <div class="ibox-content">
                    <h2 class="font-bold" style="text-align: center;">Solicitação de Manutenção</h2>
                    <p>Prezado cliente! Disponibilizamos para você este canal de atendimento, no qual você pode solicitar a manutenção de suas máquinas.</p>
                    <br />
                    <form role="form" action="view/enviaPedido.php" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="ped_situacao" value="5" />
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <label class="control-label">Nro. Pedido:</label>
                                <input name="ped_numero" type="text" class="form-control" placeholder="Número do Pedido" style="text-transform: uppercase;" required="">
                            </div>
                            <div class="col-sm-8">
                                <label class="control-label">Empresa contratante:</label>
                                <input name="ped_empresa" type="text" class="form-control" placeholder="Nome da empresa que comprou a máquina" style="text-transform: uppercase;" required="">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-12">
                                <label class="control-label">Descrição:</label>
                                <textarea name="ped_descricao" rows="5" class="form-control" placeholder="Descreva aqui o motivo do pedido de manutenção" style="text-transform: uppercase;" required=""></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-12">
                                <input type="file" name="arquivo1" class="form-control" />
                            </div>
                        </div>        
                            
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary block full-width m-b">Enviar solicitação</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
    </div>

    <!-- Mainly scripts -->
    <script src="../../library/inspinia/js/jquery-2.1.1.js"></script>
    <script src="../../library/inspinia/js/bootstrap.min.js"></script>
    <!-- Toastr script -->
    <script src="../../library/inspinia/js/plugins/toastr/toastr.min.js"></script>
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: "slideDown",
            timeOut: 5000
        };
        <?php
            switch ($_GET['ms']){
                case 1:
                    echo 'toastr.success("Pedido cadastrado com sucesso!", "Incluido!");';
                    break;
                case 2:
                    echo 'toastr.success("Pedido atualizado com sucesso", "Atualizado!");';
                    break;
                case 3:
                    echo 'toastr.success("Pedido excluido com sucesso", "Excluido!");';
                    break;
                case 4:
                    echo 'toastr.info("Pedido foi inativado", "Inativado!");';
                    break;
                case 5:
                    echo 'toastr.success("Pedido foi reativado", "Reativado!");';
                    break;
                case 6:
                    echo 'toastr.success("Cotação foi transferida com sucesso", "Transferida!");';
                    break;
            }
        ?>
    </script>
</body>

</html>

<style type="text/css">
    .gray-bg{
        background-color: #efefef;
    }
</style>