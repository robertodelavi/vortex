<?php
/**
 * Classe para Conexao com banco de dados MySql
 */
class MySql
{

    private $conn; // Propriedade para armazenar a conexão
    private $database; // Propriedade para armazenar o nome do banco de dados

    // Conexão com o banco de dados
    function connOpen($database)
    {   
        $server = 'localhost';     
        $user = 'root';             
        $passw = '';         
        $this->database = $database;

        $this->conn = mysqli_connect($server, $user, $passw, $this->database);
        mysqli_set_charset($this->conn, "utf8");

        if (!$this->conn) { // Caso haja erro na conexão
            echo 'Erro ao conectar com o servidor. '.$this->error();
            exit (1);
        }
    }

    // Fechar a conexão com o banco
    function connClose()
    {
        mysqli_close($this->conn);
    }

    /**
     * Executa uma consulta SQL no banco
     *
     * @param String $sql Comando SQL a ser executado no banco ex: SELECT * FROM tabela
     * @param Boolean $param True retorna última id, False retorna resultado
     * @return Variante
     */
    function executeQuery($sql, $param = false)
    {
        $this->connOpen($this->database);

        $this->result = mysqli_query($this->conn, $sql);
        if (!$this->result) { // Caso não execute a query corretamente
            echo 'Não foi possível executar o comando SQL. '.$this->error();
            exit (1);
        }
        
        if ($param) {
            $this->result = $this->lastId();
        }
        
        $this->connClose();
        
        return $this->result;
    }

    /**
     * Conta e retorna o número de linhas de uma consulta
     *
     * @return integer
     */
    function countLines($array)
    {
        return @mysqli_num_rows($array);
    }

    /**
     * Mostra o erro caso haja
     *
     * @return String
     */
    function error()
    {
        return mysqli_error($this->conn);
    }

    /**
     * Retorna o valor do campo
     *
     * @param Integer $num Número da linha a ser mostrada o valor
     * @param String $field Nome do campo a ser mostrado o valor
     * @return Variante
     */
    function result($result, $i, $field)
    {
        if (mysqli_data_seek($result, $i)) {
            $row = mysqli_fetch_assoc($result);
            return $row[$field];
        }
    }
    
    /**
     * Retorna o último id inserido no banco
     * 
     * @return Integer
     */
    function lastId()
    {
        return mysqli_insert_id($this->conn);
    }
    
    function countFields($array)
    {
        return @mysqli_num_fields($array);
    }
    
    function fieldName($array, $num)
    {        
        return mysqli_fetch_field($array);
    }
}
?>
