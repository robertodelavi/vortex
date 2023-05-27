<?php
    $sql = "SELECT upe_descricao FROM usuario_permissao WHERE upe_codigo = ".$_SESSION['wf_userPermissao'];
    $permissao = $data->find('dynamic', $sql);

	$sql = "SELECT usu_foto FROM usuario WHERE usu_codigo = ".$_SESSION['wf_userId'];
	$foto = $data->find('dynamic', $sql);

	if($foto[0]['usu_foto']){
		$img_perfil = $foto[0]['usu_foto'];
	}else{
    	$img_perfil = 'application/images/sem_img_profile.svg';
    }

    $tam_image = getimagesize($img_perfil);

    //Compara se altura é largura é maior que altura
    if($tam_image[0]>$tam_image[1]){
        $bs = 'background-size:100% auto;';
    }else
        if($tam_image[0]<$tam_image[1]){
            $bs = 'background-size:auto 100%;';
        }else{
            $bs = 'background-size:100%;';
        }
?>

<style>
    .avatar{ 
        background-image:url('<?php echo $img_perfil; ?>');
        <?php echo $bs; ?>
        background-position:center center; 
        /*border-radius:50%;*/
        border: none;
        background-repeat: no-repeat;
        background-color: #FFF; 
    }
    .reduzido.avatar{
        margin-right: auto;
        margin-left: auto;
        width:32px; 
        height:32px; 
    }
    
</style>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header" style="padding: 27px 25px;">
                <div class="dropdown profile-element"> 
                    <a title="Visualizar usuário" href="#" onClick="nextPage('?module=usuario&acao=visualiza_usuario', <?php echo $_SESSION['wf_userId'];?>);" style="text-decoration:none;">
                	<span>
                        <div class="avatar" style="width:60px; height:60px;">
                            <br />
                        </div>
                    </span>
                    </a>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> 
                        	<span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION['wf_userName']; ?></strong></span> 
                        	<span class="text-muted text-xs block"><?php echo $permissao[0]['upe_descricao']; ?> <b class="caret"></b></span> 
                        </span> 
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a title="Visualizar usuário" href="#" onClick="nextPage('?module=usuario&acao=visualiza_usuario', <?php echo $_SESSION['wf_userId'];?>);" style="text-decoration:none;">Meus Dados</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="background: transparent;">
                    	<div class="reduzido avatar">
                            <br />
                        </div>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs" style="color:#000;">
                        <li><a href="#" onClick="nextPage('?module=usuario&acao=visualiza_usuario', <?php echo $_SESSION['wf_userId'];?>);">Meus Dados</a></li>
                        <li class="divider"></li>
                        <li><a href="?module=index&acao=logout">Sair do Sistema</a></li>
                    </ul>
                </div>
            </li>
            <?php 
                if($_SESSION['wf_userCliente']){ //CASO FOR UM CLIENTE
            ?>

            <?php 
                if($_GET['module']=='principal'){
                    echo '<li class="active">';
                }else{
                    echo '<li>';
                }

                echo '<a href="?module=principal&acao=listacliente_principal"><i class="fa fa-th-large"></i> <span class="nav-label">Inicio</span></a>';              
            ?>
            </li>

            <?php 
                if($_GET['acao']=='listacliente_clientefinan'){
                    echo '<li class="active">';
                }else{
                    echo '<li>';
                }

                echo '<a href="#" onClick="nextPage(\'?module=contato&acao=listacliente_clientefinan\', '.$_SESSION['wf_userCliente'].');"><i class="fa fa-money"></i> <span class="nav-label">Financeiro</span></a>';                
            ?>
            </li>

            <?php 
                $acaoC = explode('_', $_GET['acao']);
                if($acaoC[1]=='clienteprod'){
                    echo '<li class="active">';
                }else{
                    echo '<li>';
                }

                echo '<a href="#" onClick="nextPage(\'?module=contato&acao=listacliente_clienteprod\', '.$_SESSION['wf_userCliente'].');"><i class="fa fa-cogs"></i> <span class="nav-label">Produção</span></a>';                
            ?>
            </li>

            <?php 
                $acaoC = explode('_', $_GET['acao']);
                if($acaoC[1]=='clientemanutencao'){
                    echo '<li class="active">';
                }else{
                    echo '<li>';
                }

                echo '<a href="#" onClick="nextPage(\'?module=contato&acao=lista_clientemanutencao\', '.$_SESSION['wf_userCliente'].');"><i class="fa fa-cogs"></i> <span class="nav-label">Manutenção</span></a>';                
            ?>
            </li>


            <?php 
                if($_GET['acao']=='novo_clientemanu'){
                    echo '<li class="active">';
                }else{
                    echo '<li>';
                }

                echo '<a href="#" onClick="nextPage(\'?module=contato&acao=novo_clientemanu\', '.$_SESSION['wf_userCliente'].');"><i class="fa fa-bullhorn"></i> <span class="nav-label">Solicitar Manutenção</span></a>';                
            ?>
            </li>

            <?php 
                if($_GET['acao']=='novo_monitoramento'){
                    echo '<li class="active">';
                }else{
                    echo '<li>';
                }

                echo '<a href="#"><i class="fa fa-area-chart"></i> <span class="nav-label">Monit. Máquinas</span></a>';
            ?>
            </li>

            <?php 
                if($_GET['acao']=='lista_clienteprojeto'){
                    echo '<li class="active">';
                }else{
                    echo '<li>';
                }

                echo '<a href="#" onClick="nextPage(\'?module=contato&acao=lista_clienteprojeto\', '.$_SESSION['wf_userCliente'].');"><i class="fa fa-image"></i> <span class="nav-label">Projeto Fábrica</span></a>';                
            ?>
            </li>

            <?php }else{ ?>
            <?php 
                if($_GET['module']=='principal'){
                    echo '<li class="active">';
                }else{
                    echo '<li>';
                }

                echo '<a href="?module=principal&acao=lista_principal"><i class="fa fa-th-large"></i> <span class="nav-label">Inicio</span></a>';              
            ?>
            </li>

            <?php } ?>

            <?php 
                if($_GET['module']=='almoxarifado'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'categoria':
                            $item_sel[0] = 'class="active"';
                            break;
                        case 'produto':
                            $item_sel[1] = 'class="active"';
                            break;
                        case 'compra':
                            $item_sel[2] = 'class="active"';
                            break;
                        case 'estoque':
                            $item_sel[3] = 'class="active"';
                            break;        
                    }
                }else{
                    echo '<li>';
                }

                switch($_SESSION['wf_userPermissao']) {
                    case '1': //ADMINISTRADOR
                    case '3': //AUX. ADM
                        echo '
                        <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Almoxarifado</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li '.$item_sel[0].' ><a href="?module=almoxarifado&acao=lista_categoria">Categoria</a></li>
                            <li '.$item_sel[1].' ><a href="?module=almoxarifado&acao=lista_produto">Produtos</a></li>
                            <li '.$item_sel[2].' ><a href="?module=almoxarifado&acao=lista_compra">Compras</a></li>
                            <li '.$item_sel[3].' ><a href="?module=almoxarifado&acao=lista_estoque">Estoque</a></li>
                        </ul>';
                        break;
                    
                    case '2': //VENDAS
                    case '4': //PRODUÇÃO
                    case '6': //GERENTE DE VENDAS
                    case '7': //VENDAS / JURIDICO
                    case '8': //JURIDICO
                        break;

                    case '5': //ALMOXARIFADO
                        echo '
                        <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Almoxarifado</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li '.$item_sel[2].' ><a href="?module=almoxarifado&acao=lista_compra">Compras</a></li>
                            <li '.$item_sel[3].' ><a href="?module=almoxarifado&acao=lista_estoque">Estoque</a></li>
                        </ul>';
                        break;
                }
            ?>
            </li>

            <?php 
            	if($_GET['module']=='contato'){
            		echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'fornecedor':
                            $item_sel[4] = 'class="active"';
                            break;
                        case 'cliente':
                            $item_sel[5] = 'class="active"';
                            break;
                    }
            	}else{
            		echo '<li>';
            	}

            	switch($_SESSION['wf_userPermissao']) {
            		case '1': //ADMINISTRADOR
                    case '3': //AUX. ADM
            			echo '
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Contatos</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                			<li '.$item_sel[4].' ><a href="?module=contato&acao=lista_fornecedor">Fornecedores</a></li>
    	                    <li '.$item_sel[5].' ><a href="?module=contato&acao=lista_cliente">Clientes</a></li>
                        </ul>';
            			break;
            		
            		case '2': //VENDAS
                    case '6': //GERENTE DE VENDAS
                        echo '
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Contatos</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                			<li '.$item_sel[4].' ><a href="?module=contato&acao=lista_fornecedor">Fornecedores</a></li>
    	                    <li '.$item_sel[5].' ><a href="?module=contato&acao=lista_cliente">Clientes</a></li>
                        </ul>';
                        break;
                    case '7': //VENDAS / JURIDICO
                        echo '
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Contatos</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[5].' ><a href="?module=contato&acao=lista_cliente">Clientes</a></li>
                        </ul>';
                        break;

                    case '4': //PRODUÇÃO
                    case '8': //JURIDICO
                        break;

                    case '5': //ALMOXARIFADO
                        echo '
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Contatos</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[4].' ><a href="?module=contato&acao=lista_fornecedor">Fornecedores</a></li>
                        </ul>';
                        break;
            	}
            ?>	
            </li>

            <?php 
                if($_GET['module']=='financeiro'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'comissao':
                            $item_sel[6] = 'class="active"';
                            break;
                    }
                }else{
                    echo '<li>';
                }

                switch($_SESSION['wf_userPermissao']) {
                    case '1': //ADMINISTRADOR
                    case '2': //VENDAS
                    case '3': //AUX. ADM
                    case '6': //GERENTE DE VENDAS
                    case '7': //VENDAS / JURIDICO
                        echo '
                        <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Financeiro</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[6].' ><a href="?module=financeiro&acao=lista_comissao">Comissão</a></li>
                        </ul>';
                        break;

                    case '4': //PRODUÇÃO
                    case '5': //ALMOXARIFADO
                    case '8': //JURIDICO
                    break;
                }
            ?>     
            </li>

            <?php 
                if($_GET['module']=='juridico'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'categoria':
                            $item_sel[6] = 'class="active"';
                            break;
                        case 'processo':
                            $item_sel[7] = 'class="active"';
                            break;
                    }
                }else{
                    echo '<li>';
                }

                switch($_SESSION['wf_userPermissao']) {
                    case '1': //ADMINISTRADOR
                    	echo '
                        <a href="#"><i class="fa fa-balance-scale"></i> <span class="nav-label">Jurídico</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[6].' ><a href="?module=juridico&acao=lista_categoria">Categorias</a></li>
                            <li '.$item_sel[7].' ><a href="?module=juridico&acao=lista_processo">Processos</a></li>
                        </ul>';
                        break;
                    case '3': //AUX. ADM
                    case '7': //VENDAS / JURIDICO
                    case '8': //JURIDICO
                        echo '
                        <a href="#"><i class="fa fa-balance-scale"></i> <span class="nav-label">Jurídico</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[7].' ><a href="?module=juridico&acao=lista_processo">Processos</a></li>
                        </ul>';
                        break;

                    case '2': //VENDAS
                    case '4': //PRODUÇÃO
                    case '5': //ALMOXARIFADO
                    case '6': //GERENTE DE VENDAS
                        break;    
                }
            ?>     
            </li>

            <?php 
                if($_GET['module']=='marketing'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'maladireta':
                            $item_sel[1] = 'class="active"';
                            break;
                    }
                }else{
                    echo '<li>';
                }

                switch($_SESSION['wf_userPermissao']) {
                    case '1': //ADMINISTRADOR
                    case '3': //AUX. ADM
                    case '6': //GERENTE DE VENDAS
                        echo '
                        <a href="#"><i class="fa fa-heart"></i> <span class="nav-label">Marketing</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[1].' ><a href="?module=marketing&acao=novo_maladireta">Mala direta</a></li>
                        </ul>';
                        break;

                    case '2': //VENDAS
                    case '7': //VENDAS / JURIDICO
                    case '4': //PRODUÇÃO
                    case '5': //ALMOXARIFADO
                    case '8': //JURIDICO
                        break;
                }
            ?>     
            </li>   

            <?php 
                if($_GET['module']=='producao'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'producao':
                            $item_sel[8]  = 'class="active"';
                            break;
                        case 'cotacao':
                            $item_sel[9]  = 'class="active"';
                            break;      
                        case 'pausada':
                            $item_sel[10] = 'class="active"';
                            break;          
                        case 'concluida':
                            $item_sel[11] = 'class="active"';
                            break;
                        case 'instalacao':
                            $item_sel[12] = 'class="active"';
                            break;
                        case 'manutencao':
                            $item_sel[13] = 'class="active"';
                            break;       
                    }
                }else{
                    echo '<li>';
                }
            
                switch($_SESSION['wf_userPermissao']) {
                    case '1': //ADMINISTRADOR
                    case '3': //AUX. ADM
                    case '6': //GERENTE DE VENDAS
                        echo '
                        <a href="#"><i class="fa fa-tachometer"></i> <span class="nav-label">Produção</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li '.$item_sel[8].'  ><a href="?module=producao&acao=lista_producao">Em produção</a></li>
                            <li '.$item_sel[9].'  ><a href="?module=producao&acao=lista_cotacao">Em cotação</a></li>
                            <li '.$item_sel[10].' ><a href="?module=producao&acao=lista_pausada">Pausadas</a></li>
                            <li '.$item_sel[11].' ><a href="?module=producao&acao=lista_concluida">Concluída</a></li>
                            <li '.$item_sel[12].' ><a href="?module=producao&acao=lista_instalacao">Instalação</a></li>
                            <li '.$item_sel[13].' ><a href="?module=producao&acao=lista_manutencao">Manutenção</a></li>
                        </ul>';
                        break;
                    
                    case '2': //VENDAS
                    case '5': //ALMOXARIFADO
                    case '7': //VENDAS / JURIDICO
                    case '8': //JURIDICO
                        break;

                    case '4': //PRODUÇÃO
                        echo '
                        <a href="#"><i class="fa fa-tachometer"></i> <span class="nav-label">Produção</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li '.$item_sel[8].'  ><a href="?module=producao&acao=lista_producao">Em produção</a></li>
                            <li '.$item_sel[13].' ><a href="?module=producao&acao=lista_manutencao">Manutenção</a></li>
                        </ul>';
                        break;
                    
                    case '10': //Instalação e Manutenção     
                        echo '
                        <a href="#"><i class="fa fa-tachometer"></i> <span class="nav-label">Produção</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li '.$item_sel[12].' ><a href="?module=producao&acao=lista_instalacao">Instalação</a></li>
                            <li '.$item_sel[13].' ><a href="?module=producao&acao=lista_manutencao">Manutenção</a></li>
                        </ul>';
                        break;
                        break;
                }
            ?>     
            </li>

            <?php 
                if($_GET['module']=='relatorio'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'acesso':
                            $item_sel[1] = 'class="active"';    
                            break;
                        case 'cotacao':
                            $item_sel[2] = 'class="active"';
                            break;
                        case 'estoquebaixo':
                            $item_sel[3] = 'class="active"';
                            break;
                        case 'prospeccao':
                            $item_sel[4] = 'class="active"';    
                            break;
                    }
                }else{
                    echo '<li>';
                }
                
                switch($_SESSION['wf_userPermissao']) {
                    case '1': //ADMINISTRADOR
                        echo '
                            <a href="#"><i class="fa fa-bar-chart"></i> <span class="nav-label">Relatórios</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li '.$item_sel[1].' ><a href="?module=relatorio&acao=filtro_acesso">Acessos no sistema</a></li>
                                <li '.$item_sel[2].' ><a href="?module=relatorio&acao=filtro_cotacao">Cotação</a></li>
                                <li '.$item_sel[3].' ><a href="application/relatorio/view/estoquebaixo/relatorio.php" target="_blank">Estoque baixo</a></li>
                                <li '.$item_sel[4].' ><a href="?module=relatorio&acao=filtro_prospeccao">Prospecção</a></li>
                            </ul>';
                        break;
                    
                    case '3': //AUX. ADM
                    case '4': //PRODUÇÃO
                    case '5': //ALMOXARIFADO
                        echo '
                            <a href="#"><i class="fa fa-bar-chart"></i> <span class="nav-label">Relatórios</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li '.$item_sel[1].' ><a href="application/relatorio/view/estoquebaixo/relatorio.php" target="_blank">Estoque baixo</a></li>
                            </ul>';
                        break;
                    case '2': //VENDAS
                    case '6': //GERENTE DE VENDAS
                    case '7': //VENDAS / JURIDICO
                    case '8': //JURIDICO
                        break;    
                }
            ?>      
            </li>

            <?php 
                if($_GET['module']=='rh'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'funcionario':
                            $item_sel[6] = 'class="active"';
                            break;
                        case 'recibo':
                            $item_sel[7] = 'class="active"';
                            break;                            
                    }
                }else{
                    echo '<li>';
                }

                switch($_SESSION['wf_userPermissao']) {
                    case '1': //ADMINISTRADOR
                    case '3': //AUX. ADM
                        echo '
                        <a href="#"><i class="fa fa-suitcase"></i> <span class="nav-label">RH</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[6].' ><a href="?module=rh&acao=lista_funcionario">Pessoal</a></li>
                            <li '.$item_sel[7].' ><a href="?module=rh&acao=lista_recibo">Recibo</a></li>
                        </ul>';
                        break;

                    case '2': //VENDAS
                    case '4': //PRODUÇÃO
                    case '5': //ALMOXARIFADO
                    case '6': //GERENTE DE VENDAS
                    case '7': //VENDAS / JURIDICO
                    case '8': //JURIDICO
                        break;    
                }
            ?>     
            </li>

            <?php 
                if($_GET['module']=='tabela'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {                        
                        case 'categoria':
                            $item_sel[6] = 'class="active"';
                            break;
                        case 'produto':
                            $item_sel[7] = 'class="active"';
                            break;        
                    }
                }else{
                    echo '<li>';
                }

                switch($_SESSION['wf_userPermissao']){
                    case '1': //ADMINISTRADOR
                    case '3': //AUX. ADM
                        echo '
                            <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Tabela de Preços</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">    
                                <li '.$item_sel[6].' ><a href="?module=tabela&acao=lista_categoria">Categorias</a></li>
                                <li '.$item_sel[7].' ><a href="?module=tabela&acao=lista_produto">Produtos</a></li>
                            </ul>';
                        break;

                    case '2': //VENDAS
                    case '6': //GERENTE DE VENDAS
                        echo '
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Tabela de Preços</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[6].' ><a href="?module=tabela&acao=lista_categoria">Categorias</a></li>
                            <li '.$item_sel[7].' ><a href="?module=tabela&acao=lista_produto">Produtos</a></li>
                        </ul>';
                        break;
                    case '7': //VENDAS / JURIDICO
                        echo '
                            <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Tabela de Preços</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">       
                                <li '.$item_sel[7].' ><a href="?module=tabela&acao=lista_produto">Produtos</a></li>
                            </ul>';
                        break;

                    case '4': //PRODUÇÃO
                    case '5': //ALMOXARIFADO
                    case '8': //JURIDICO
                        break;  
                }
            ?>
            </li>

            <?php 
            	if($_GET['module']=='usuario'){
            		echo '<li class="active">';
            	}else{
            		echo '<li>';
            	}
            	
            	switch($_SESSION['wf_userPermissao']) {
            		case '1': //ADMINISTRADOR
            			echo '<a href="?module=usuario&acao=lista_usuario"><i class="fa fa-user"></i> <span class="nav-label">Usuários</span></a>';
            			break;
            		
            		case '2': //VENDAS
                    case '3': //AUX. ADM
                    case '4': //PRODUÇÃO
                    case '5': //ALMOXARIFADO
                    case '6': //GERENTE DE VENDAS
                    case '7': //VENDAS / JURIDICO
                    case '8': //JURIDICO
                        break;    
            	}
            ?>	    
            </li>

            <?php 
                if($_GET['module']=='vendas'){
                    echo '<li class="active">';
                    //Valida qual variavel vai receber active
                    unset($item_sel);
                    $acao = explode('_',$_GET['acao']);
                    switch ($acao[1]) {
                        case 'cotacao':
                            $item_sel[6] = 'class="active"';
                            break;
                        case 'cliente':
                            $item_sel[7] = 'class="active"';
                            break;
                        case 'representante':
                            $item_sel[8] = 'class="active"';
                            break;
                        case 'metas':
                            $item_sel[9] = 'class="active"';
                            break;
                    }
                }else{
                    echo '<li>';
                }

                switch($_SESSION['wf_userPermissao']) {
                    case '1': //ADMINISTRADOR
                        echo '
                        <a href="#"><i class="fa fa-usd"></i> <span class="nav-label">Vendas</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[6].' ><a href="?module=vendas&acao=lista_cotacao">Cotação</a></li>
                            <li '.$item_sel[7].' ><a href="?module=vendas&acao=lista_cliente">Clientes (prospecção)</a></li>
                            <li '.$item_sel[8].' ><a href="?module=vendas&acao=lista_representante">Representantes</a></li>
                            <li '.$item_sel[9].' ><a href="?module=vendas&acao=configuracao_meta">Metas</a></li>
                        </ul>';
                        break;
                    case '3': //AUX. ADM
                    case '6': //GERENTE DE VENDAS
                        echo '
                        <a href="#"><i class="fa fa-usd"></i> <span class="nav-label">Vendas</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[6].' ><a href="?module=vendas&acao=lista_cotacao">Cotação</a></li>
                            <li '.$item_sel[7].' ><a href="?module=vendas&acao=lista_cliente">Clientes (prospecção)</a></li>
                            <li '.$item_sel[8].' ><a href="?module=vendas&acao=lista_representante">Representantes</a></li>
                        </ul>';
                        break;
                    case '2': //VENDAS
                    case '7': //VENDAS / JURIDICO
                        echo '
                        <a href="#"><i class="fa fa-usd"></i> <span class="nav-label">Vendas</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[6].' ><a href="?module=vendas&acao=lista_cotacao">Cotação</a></li>
                            <li '.$item_sel[7].' ><a href="?module=vendas&acao=lista_cliente">Clientes (prospecção)</a></li>
                            <li '.$item_sel[8].' ><a href="?module=vendas&acao=lista_representante">Representantes</a></li>
                        </ul>';
                        break;

                    case '4': //PRODUÇÃO
                    case '5': //ALMOXARIFADO
                    case '8': //JURIDICO
                        echo '
                        <a href="#"><i class="fa fa-usd"></i> <span class="nav-label">Vendas</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">    
                            <li '.$item_sel[8].' ><a href="?module=vendas&acao=lista_representante">Representantes</a></li>
                        </ul>';
                        break;
                }
            ?>     
            </li>
        </ul>
    </div>
</nav>