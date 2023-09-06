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
    // $conn->connOpen('brs36.brs.com.br','vegacscom_vortex','vegacscom_vortex', 'vortex@54741');

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
        -- Caracteristicas
        i.imo_codigo, 
        ti.tpi_descricao, 
        tc.tcn_descricao,
        i.imo_rua, 
        i.imo_numero,
        i.imo_cep,
        i.imo_complemento,
        b.bai_descricao, 
        i.imo_areaconstruida, 
        i.imo_quartos, 
        i.imo_suites,
        i.imo_banheiros, 
        i.imo_garagem,
        i.imo_rua,
        b.bai_descricao,
        c.cid_descricao,
        c.cid_uf,
        u.uti_descricao,
        i.imo_edificio,
        i.imo_pontoreferencia,
        i.imo_posicao,
        i.imo_longitude,
        i.imo_latitude,
        i.imo_quadra,
        i.imo_lote,
        i.imo_horariovisitacao,
        o.ocp_descricao,
        i.imo_dimensoes,
        i.imo_areaterreno,
        i.imo_areaconstruida,
        i.imo_areaprivativa,
        i.imo_areautil,
        i.imo_areacomum,
        i.imo_areagaragem,
        i.imo_andares,
        i.imo_elevadores,
        i.imo_anoconstrucao,
        tp.tpp_descricao,
        i.imo_construtora,
        tf.tpf_descricao,
        tm.tpm_descricao,
        i.imo_salaestar,
        i.imo_salatv,
        i.imo_lareira,
        i.imo_cozinha,        
        i.imo_areadeservico,
        i.imo_dependenciaempregada,
        i.imo_gascentral,
        i.imo_playground,
        i.imo_lavabo,
        i.imo_churrasqueira,
        i.imo_salaofestas,
        i.imo_sacada,
        i.imo_portaoeletronico,
        i.imo_pocoartesiano,
        i.imo_condominiofechado,
        i.imo_detalhes,
        i.imo_numerodagaragem,
        i.imo_numerododeposito,
        i.imo_hobbybox,
        i.imo_arealazer,
        i.imo_topografia,
        i.imo_viabilidade,
        e.epr_descricao,
        i.imo_permiteanimais,
        te.tpe_descricao,
        i.imo_pavimentacao,
        i.imo_urlvideo,
        i.imo_urltour,
        i.imo_urldescricao,
        i.imo_datacad,
        i.imo_dataatual,
        i.imo_onibus,
        i.imo_ondepegar,
        i.imo_ondedescer,
        i.imo_entreruaa,
        i.imo_entreruab,
        i.imo_chavedisponivel,
        i.imo_piscina,
        i.imo_terraco,        
        -- Valor
        (((iv.imv_valor*m.moe_valor)/100)/100) AS imv_valor,        
        -- Foto
        ft.imf_arquivo,
        ft.imf_descricao,
        ft.imf_ficha,
        ft.imf_web
    FROM imoveis AS i 
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo)
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
        LEFT JOIN imovelfoto AS ft ON (i.imo_codigo = ft.imf_imovel AND ft.imf_principal = "s")
        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
        LEFT JOIN tipoconstrucao AS tc ON (i.imo_tipoconstrucao = tc.tcn_codigo)
        LEFT JOIN utilizacao AS u ON (i.imo_utilizacao = u.uti_codigo)
        LEFT JOIN ocupacao AS o ON (i.imo_ocupacao = o.ocp_codigo)
        LEFT JOIN tipopiso AS tp ON (i.imo_tipopiso = tp.tpp_codigo)
        LEFT JOIN tipoforro AS tf ON (i.imo_tipoforro = tf.tpf_codigo)
        LEFT JOIN tipomobilia AS tm ON (i.imo_tipomobilia = tm.tpm_codigo)
        LEFT JOIN empreendimentos AS e ON (i.imo_empreendimento = e.epr_codigo)
        LEFT JOIN tipoestrutura AS te ON (i.imo_tipoestrutura = te.tpe_codigo)
        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        LEFT JOIN cidades AS c ON (i.imo_cidade = c.cid_codigo)
    WHERE i.imo_codigo = '.$_GET['id'];
    $result = $conn->executeQuery($sql);

    if(!$result || $conn->countLines($result) == 0){
        echo json_encode(array('status' => false, 'message' => 'Imovel nao encontrado!'));
        exit;
    }

    $imagesBaseUrl = 'http://vegax.com.br/clientes/'.$_GET['emp'].'/imoveis/';

    // Galeria de fotos
    $sql = '
    SELECT 
        imf_arquivo,
        imf_descricao,
        imf_ficha,
        imf_web
    FROM imovelfoto
    WHERE imf_imovel = '.$_GET['id'].' AND imf_principal = "n"';
    $resultGaleria = $conn->executeQuery($sql);
    $galeria = [];
    if ($conn->countLines($resultGaleria) > 0){
        for ($i=0; $i< $conn->countLines($resultGaleria); $i++){
            $galeria[] = array(
                'url' => $imagesBaseUrl.$conn->result($resultGaleria, $i, 'imf_arquivo'),
                'descricao' => $conn->result($resultGaleria, $i, 'imf_descricao'),
                'ficha' => $conn->result($resultGaleria, $i, 'imf_ficha'),
                'web' => $conn->result($resultGaleria, $i, 'imf_web')
            );
        }
    }

    // Empresa 
    $sql = '
    SELECT p.pes_nome1, IF(LENGTH(p.pes_cpfcnpj) > 11, p.pes_cpfcnpj, null) AS pes_cnpj, p.pes_foneres1, p.pes_fonecel1, p.pes_fonecom1, pes_email, p.pes_rua1, p.pes_numero1, b.bai_descricao, p.pes_complemento1, c.cid_descricao, c.cid_uf, p.pes_cep1, p.pes_creci, e.emp_logomarca
    FROM sisempresas AS e 
        LEFT JOIN pessoas AS p ON (e.emp_pessoa = p.pes_codigo)
        LEFT JOIN bairros AS b ON (p.pes_bairro1 = b.bai_codigo)
        LEFT JOIN cidades AS c ON (p.pes_cidade1 = c.cid_codigo)
    WHERE emp_codigo = '.$_GET['emp'];
    $resultEmpresa = $conn->executeQuery($sql);    

    // Resultado
    $res = [];
    if ($conn->countLines($result) > 0){
        for ($i=0; $i< $conn->countLines($result); $i++){
            $res[] = array(
                'disponivel' => true,
                'codigo' => $conn->result($result, $i, 'imo_codigo'),
                'tipo' => $conn->result($result, $i, 'tpi_descricao'),
                'tipoConstrucao' => $conn->result($result, $i, 'tcn_descricao'),
                'utilizacao' => $conn->result($result, $i, 'uti_descricao'),
                'rua' => $conn->result($result, $i, 'imo_rua'),
                'numero' => $conn->result($result, $i, 'imo_numero'),
                'complemento' => $conn->result($result, $i, 'imo_complemento'),
                'cep' => $conn->result($result, $i, 'imo_cep'),
                'bairro' => $conn->result($result, $i, 'bai_descricao'),
                'area' => $conn->result($result, $i, 'imo_areaconstruida'),
                'quartos' => $conn->result($result, $i, 'imo_quartos'),
                'suites' => $conn->result($result, $i, 'imo_suites'),
                'banheiros' => $conn->result($result, $i, 'imo_banheiros'),
                'garagem' => $conn->result($result, $i, 'imo_garagem'),
                'cidade' => $conn->result($result, $i, 'cid_descricao'),
                'uf' => $conn->result($result, $i, 'cid_uf'),
                'edificio' => $conn->result($result, $i, 'imo_edificio'),
                'pontoReferencia' => $conn->result($result, $i, 'imo_pontoreferencia'),
                'posicao' => $conn->result($result, $i, 'imo_posicao'),
                'longitude' => $conn->result($result, $i, 'imo_longitude'),
                'latitude' => $conn->result($result, $i, 'imo_latitude'),
                'quadra' => $conn->result($result, $i, 'imo_quadra'),
                'lote' => $conn->result($result, $i, 'imo_lote'),
                'horarioVisita' => $conn->result($result, $i, 'imo_horariovisitacao'),
                'ocupacao' => $conn->result($result, $i, 'ocp_descricao'),
                'dimensoes' => $conn->result($result, $i, 'imo_dimensoes'),
                'areaTerreno' => $conn->result($result, $i, 'imo_areaterreno'),
                'areaConstruida' => $conn->result($result, $i, 'imo_areaconstruida'),
                'areaPrivativa' => $conn->result($result, $i, 'imo_areaprivativa'),
                'areaUtil' => $conn->result($result, $i, 'imo_areautil'),
                'areaComum' => $conn->result($result, $i, 'imo_areacomum'),
                'areaGaragem' => $conn->result($result, $i, 'imo_areagaragem'),
                'andares' => $conn->result($result, $i, 'imo_andares'),
                'elevadores' => $conn->result($result, $i, 'imo_elevadores'),
                'anoConstrucao' => $conn->result($result, $i, 'imo_anoconstrucao'),
                'tipoPiso' => $conn->result($result, $i, 'tpp_descricao'),
                'construtora' => $conn->result($result, $i, 'imo_construtora'),
                'tipoForro' => $conn->result($result, $i, 'tpf_descricao') ? $conn->result($result, $i, 'tpf_descricao') : '',
                'tipoMobilia' => $conn->result($result, $i, 'tpm_descricao') ? $conn->result($result, $i, 'tpm_descricao') : '',
                'salaEstar' => $conn->result($result, $i, 'imo_salaestar'),
                'salaTv' => $conn->result($result, $i, 'imo_salatv'),
                'lareira' => $conn->result($result, $i, 'imo_lareira'),
                'cozinha' => $conn->result($result, $i, 'imo_cozinha'),
                'areaDeServico' => $conn->result($result, $i, 'imo_areadeservico'),
                'dependenciaEmpregada' => $conn->result($result, $i, 'imo_dependenciaempregada'),
                'gasCentral' => $conn->result($result, $i, 'imo_gascentral'),
                'playground' => $conn->result($result, $i, 'imo_playground'),
                'lavabo' => $conn->result($result, $i, 'imo_lavabo'),
                'churrasqueira' => $conn->result($result, $i, 'imo_churrasqueira'),
                'salaoFestas' => $conn->result($result, $i, 'imo_salaofestas'),
                'sacada' => $conn->result($result, $i, 'imo_sacada'),
                'portaoEletronico' => $conn->result($result, $i, 'imo_portaoeletronico'),
                'pocoArtesiano' => $conn->result($result, $i, 'imo_pocoartesiano'),
                'condominioFechado' => $conn->result($result, $i, 'imo_condominiofechado'),                
                // 'detalhes' => base64_encode($conn->result($result, $i, 'imo_detalhes')),                
                'numeroDaGaragem' => $conn->result($result, $i, 'imo_numerodagaragem'),
                'numeroDoDeposito' => $conn->result($result, $i, 'imo_numerododeposito'),
                'hobbyBox' => $conn->result($result, $i, 'imo_hobbybox'),
                'areaLazer' => $conn->result($result, $i, 'imo_arealazer'),
                'topografia' => $conn->result($result, $i, 'imo_topografia'),
                'viabilidade' => $conn->result($result, $i, 'imo_viabilidade'),
                'empreendimento' => $conn->result($result, $i, 'epr_descricao') ? $conn->result($result, $i, 'epr_descricao') : '',
                'permiteAnimais' => $conn->result($result, $i, 'imo_permiteanimais'),
                'tipoEstrutura' => $conn->result($result, $i, 'tpe_descricao') ? $conn->result($result, $i, 'tpe_descricao') : '',
                'pavimentacao' => $conn->result($result, $i, 'imo_pavimentacao'),
                'urlVideo' => $conn->result($result, $i, 'imo_urlvideo'),
                'urlTour' => $conn->result($result, $i, 'imo_urltour'),
                'urlDescricao' => $conn->result($result, $i, 'imo_urldescricao'),
                'dataCad' => date('d/m/Y', strtotime($conn->result($result, $i, 'imo_datacad'))),
                'dataAtual' => date('d/m/Y', strtotime($conn->result($result, $i, 'imo_dataatual'))),
                'onibus' => $conn->result($result, $i, 'imo_onibus') ? $conn->result($result, $i, 'imo_onibus') : '',
                'ondePegar' => $conn->result($result, $i, 'imo_ondepegar') ? $conn->result($result, $i, 'imo_ondepegar') : '',
                'ondeDescer' => $conn->result($result, $i, 'imo_ondedescer') ? $conn->result($result, $i, 'imo_ondedescer') : '',
                'entradaRuaA' => $conn->result($result, $i, 'imo_entreruaa') ? $conn->result($result, $i, 'imo_entreruaa') : '',
                'entradaRuaB' => $conn->result($result, $i, 'imo_entreruab') ? $conn->result($result, $i, 'imo_entreruab') : '',
                'chaveDisponivel' => $conn->result($result, $i, 'imo_chavedisponivel'),
                'piscina' => $conn->result($result, $i, 'imo_piscina'),
                'terraco' => $conn->result($result, $i, 'imo_terraco'),
                'valor' => number_format($conn->result($result, $i, 'imv_valor'), 2, ',', '.'),
                'fotos' => array(
                    'capa' => array(
                        'url' => $imagesBaseUrl.$conn->result($result, $i, 'imf_arquivo'),
                        'descricao' => $conn->result($result, $i, 'imf_descricao'),
                        'ficha' => $conn->result($result, $i, 'imf_ficha'),
                        'web' => $conn->result($result, $i, 'imf_web')
                    ),
                    'galeria' => $galeria
                ),
                'empresa' => array(
                    'nome' => $conn->result($resultEmpresa, 0, 'pes_nome1'),
                    'cnpj' => maskCnpj($conn->result($resultEmpresa, 0, 'pes_cnpj')),
                    'creci' => $conn->result($resultEmpresa, 0, 'pes_creci'),
                    'logomarca' => 'http://vegax.com.br/clientes/'.$_GET['emp'].'/empresa/'.$conn->result($resultEmpresa, 0, 'emp_logomarca'),
                    'telefone' => array(
                        'residencial' => $conn->result($resultEmpresa, 0, 'pes_foneres1'),
                        'celular' => $conn->result($resultEmpresa, 0, 'pes_fonecel1'),
                        'comercial' => $conn->result($resultEmpresa, 0, 'pes_fonecom1')
                    ),
                    'email' => $conn->result($resultEmpresa, 0, 'pes_email'),
                    'endereco' => configAddress($resultEmpresa, $conn)
                )
            );            
        }
    }

    function configAddress($result, $conn){
        $endereco = '';
        if ($conn->countLines($result) > 0){
            for ($i=0; $i< $conn->countLines($result); $i++){
                // Inserir em $endereco somente os campos que nao estiverem vazios
                $endereco .= $conn->result($result, $i, 'pes_rua1') ? $conn->result($result, $i, 'pes_rua1').', ' : '';
                $endereco .= $conn->result($result, $i, 'pes_numero1') ? $conn->result($result, $i, 'pes_numero1').', ' : '';
                $endereco .= $conn->result($result, $i, 'pes_complemento1') ? $conn->result($result, $i, 'pes_complemento1').', ' : '';
                $endereco .= $conn->result($result, $i, 'bai_descricao') ? $conn->result($result, $i, 'bai_descricao').', ' : '';
                $endereco .= $conn->result($result, $i, 'pes_cep1') ? $conn->result($result, $i, 'pes_cep1').', ' : '';
                $endereco .= $conn->result($result, $i, 'cid_descricao') ? ($conn->result($result, $i, 'cid_descricao').'/'.$conn->result($result, $i, 'cid_uf')).', ' : '';
                $endereco = substr($endereco, 0, -2);
            }
        }
        return $endereco;
    }

    function maskCnpj($cnpj){
        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);
        $cnpj = substr($cnpj, 0, 2).'.'.substr($cnpj, 2, 3).'.'.substr($cnpj, 5, 3).'/'.substr($cnpj, 8, 4).'-'.substr($cnpj, 12, 2);
        return $cnpj;
    }

    echo json_encode(array('status' => true, 'data' => $res));