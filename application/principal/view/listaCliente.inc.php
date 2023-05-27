    <?php
	$sql = "SELECT count(*) AS qtd FROM financeiro_cliente WHERE fin_situacao = 0 AND cli_codigo = ".$_SESSION['wf_userCliente'];
    $financeiro = $data->find('dynamic', $sql);

	$sql = "SELECT count(*) AS qtd FROM producao_cliente WHERE prc_situacao < 2 AND cli_codigo = ".$_SESSION['wf_userCliente'];
    $producao = $data->find('dynamic', $sql);

    $sql = "SELECT prc_codigo FROM producao_cliente WHERE prc_situacao < 2 AND cli_codigo = ".$_SESSION['wf_userCliente'];
    $prod = $data->find('dynamic', $sql);

    if($producao[0]['qtd'] > 0){
    	//$sql = "SELECT pch_data	FROM producao_cliente_historico WHERE prc_codigo = ".$prod[0]['prc_codigo']." ORDER BY pch_data DESC LIMIT 0,1";
        $sql = "SELECT h.pch_data FROM producao_cliente_historico AS h WHERE h.prc_codigo in (SELECT p.prc_codigo FROM producao_cliente AS p WHERE cli_codigo = ".$_SESSION['wf_userCliente'].") ORDER BY pch_data DESC LIMIT 0,1";

    	$data_atualizacao = $data->find('dynamic', $sql);
    	$data_atualizacao[0]['pch_data'] = implode("/", array_reverse(explode("-", $data_atualizacao[0]['pch_data'])));
    }else{
        $data_atualizacao[0]['pch_data'] = "--/--/----";
    }


    $sql = "SELECT p.*, (SELECT h.pch_data FROM producao_cliente_historico AS h WHERE h.prc_codigo = p.prc_codigo ORDER BY h.pch_data DESC LIMIT 0,1) AS pch_data
            FROM producao_cliente AS p
            WHERE cli_codigo = ".$_SESSION['wf_userCliente'].'
            ORDER BY prc_situacao ASC, prc_data_entrega DESC';
    $graficoProducao = $data->find('dynamic', $sql);

    $gp_label = '';
    $gp_nro   = '';
    for ($i=0; $i < count($graficoProducao); $i++) { 
        $gp_label .= '"'.substr($graficoProducao[$i]['prc_modelo'],0,20).'",';
        $gp_nro   .= '"'.$graficoProducao[$i]['prc_progresso'].'",';
    }
    $gp_label = substr($gp_label, 0, -1);
    $gp_nro = substr($gp_nro, 0, -1);
?>
<script src="library/inspinia/js/plugins/chartJs/Chart.min.js"></script>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    	<h3 style="text-align: center;">Bem-vindo ao sistema de gestão BR Robótica</h3>
    	<br />
    	<div class="col-md-4">
    		<div class="widget style1 navy-bg" style="background: #3a3a3a;">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Titulos em aberto </span>
                        <h2 class="font-bold"><?php echo str_pad($financeiro[0]['qtd'], 2, "0", STR_PAD_LEFT); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
    		<div class="widget style1 navy-bg" style="background: #3a3a3a;">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-cogs fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Equipamentos em produção </span>
                        <h2 class="font-bold"><?php echo str_pad($producao[0]['qtd'], 2, "0", STR_PAD_LEFT); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
    		<div class="widget style1 navy-bg" style="background: #3a3a3a;">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-thumbs-o-up fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Última atualização </span>
                        <h2 class="font-bold"><?php echo $data_atualizacao[0]['pch_data']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Processo de fabricação das máquinas &nbsp;
                        <small>Porcentagem da produção</small>
                    </h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <canvas id="lineChart" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>  
    </div>
	<br />

<script>
    $(document).ready(function() {
        $('.dataTables-example').DataTable({
		 	"searching": false,
		  	"paging":   false,
	        "ordering": false,
	        "info":     false
		});
    });

        var lineData = {
            labels: [<?php echo $gp_label;?>],
            datasets: [
                {
                    label: "Example dataset",
                    fillColor: "rgba(26,179,148,0.5)",
                    strokeColor: "rgba(26,179,148,0.7)",
                    pointColor: "rgba(26,179,148,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [<?php echo $gp_nro;?>]
                }
            ]
        };

        var lineOptions = {
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            bezierCurve: true,
            bezierCurveTension: 0.4,
            pointDot: true,
            pointDotRadius: 4,
            pointDotStrokeWidth: 1,
            pointHitDetectionRadius: 20,
            datasetStroke: true,
            datasetStrokeWidth: 2,
            datasetFill: true,
            responsive: true,
        };

        var ctx = document.getElementById("lineChart").getContext("2d");
        var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
</script>