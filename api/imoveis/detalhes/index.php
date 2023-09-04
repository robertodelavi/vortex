<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Verifica se os parametros foram informados e se sao inteiros positivos evitando sql injection
    if(!isset($_GET['emp']) || !isset($_GET['id']) || !is_numeric($_GET['emp']) || !is_numeric($_GET['id']) || $_GET['emp'] <= 0 || $_GET['id'] <= 0){
        echo json_encode(array('status' => false, 'message' => 'Parametros invalidos!'));
        exit;
    }    

    // Header default
    session_start();
    require_once('../../../library/DataManipulation.php');
    require_once('../../../library/MySql.php');
    $data = new DataManipulation();
    $conn = new MySql();

    //* Autenticação
	 $conn->connOpen('localhost','vortex__autenticacao','root', '');
    //$conn->connOpen('brs36.brs.com.br','vegacscom_vortex','vegacscom_vortex', 'vortex@54741');

    $sql = 'SELECT * FROM sisempresas WHERE emp_codigo = '.$_GET['emp'].' AND emp_ativado = "s"';
    $resultAuth = $conn->executeQuery($sql);

    $emp_bd = null;
    if ($conn->countLines($resultAuth) > 0){
        for ($i=0; $i< $conn->countLines($resultAuth); $i++){
            $emp_host = $conn->result($resultAuth, $i, 'emp_bd_host');
            $emp_bd = $conn->result($resultAuth, $i, 'emp_bd');
            $emp_user = $conn->result($resultAuth, $i, 'emp_bd_user');
            $emp_pass = $conn->result($resultAuth, $i, 'emp_bd_pass');
        }
    }

    if(!$emp_bd){
        echo json_encode(array('status' => false, 'message' => 'Empresa nao encontrada!'));
        exit;
    }

    //* Banco de dados do cliente
    $conn->connOpen($emp_host, $emp_bd, $emp_user, $emp_pass);

    $sql = '
    SELECT 
        i.imo_codigo, 
        ti.tpi_descricao, 
        i.imo_rua, 
        b.bai_descricao, 
        i.imo_areaconstruida, 
        i.imo_quartos, 
        i.imo_banheiros, 
        i.imo_garagem,
        i.imo_rua,
        b.bai_descricao,
        c.cid_descricao,
        c.cid_uf,
        
        ((iv.imv_valor*m.moe_valor)/100) AS imv_valor,
        ft.imf_arquivo
    FROM imoveis AS i 
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo)
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
        LEFT JOIN imovelfoto AS ft ON (i.imo_codigo = ft.imf_imovel AND ft.imf_principal = "s")
        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        LEFT JOIN cidades AS c ON (i.imo_cidade = c.cid_codigo)
    WHERE i.imo_codigo = '.$_GET['id'];
    $result = $conn->executeQuery($sql);

    if(!$result || $conn->countLines($result) == 0){
        echo json_encode(array('status' => false, 'message' => 'Imovel nao encontrado!'));
        exit;
    }

    $res = [];
    if ($conn->countLines($result) > 0){
        for ($i=0; $i< $conn->countLines($result); $i++){
            $res[] = array(
                'codigo' => $conn->result($result, $i, 'imo_codigo'),
                'tipo' => $conn->result($result, $i, 'tpi_descricao'),
                'rua' => $conn->result($result, $i, 'imo_rua'),
                'bairro' => $conn->result($result, $i, 'bai_descricao'),
                'area' => $conn->result($result, $i, 'imo_areaconstruida'),
                'quartos' => $conn->result($result, $i, 'imo_quartos'),
                'banheiros' => $conn->result($result, $i, 'imo_banheiros'),
                'garagem' => $conn->result($result, $i, 'imo_garagem'),
                'bairro' => $conn->result($result, $i, 'bai_descricao'),
                'cidade' => $conn->result($result, $i, 'cid_descricao'),
                'uf' => $conn->result($result, $i, 'cid_uf'),
                'valor' => $conn->result($result, $i, 'imv_valor'),
                'foto' => array(
                    'base_url' => 'http://vegax.com.br/clientes/'.$_GET['emp'].'/imoveis/',
                    'arquivo' => $conn->result($result, $i, 'imf_arquivo'), 
                    'url' => 'http://vegax.com.br/clientes/'.$_GET['emp'].'/imoveis/'.$conn->result($result, $i, 'imf_arquivo')
                ),
            );
            
        }
    }

    echo json_encode(array('status' => true, 'data' => $res));