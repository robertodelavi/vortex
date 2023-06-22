<?php 

class Auth {
    private $username;
    private $password;
    private $loggedIn = false;
    private $conn;
    private $userID;

    public function __construct($username, $password, $conn){
        $this->username = $username;
        $this->password = $password;
        $this->conn = $conn;
    }

    public function login(){
        // Aqui você pode fazer a validação do login com os dados fornecidos
        // Pode ser usando banco de dados, API ou outro meio de armazenamento

        // Vamos supor que você tenha uma tabela "users" com colunas "username" e "password"
        $sql = "SELECT * FROM usuario WHERE email = '$this->username'";
        $result = $this->conn->query($sql);
        $row = $result->fetch();

        if ($row) {                
            // Verificar se a senha está correta
            $passwordCheck = password_verify($this->password, $row['senha']);
            
            if ($passwordCheck === true) {
                $this->loggedIn = true;
                $this->userID = $row['usuarioID']; // Armazena o ID do usuário
                return true;
            }
        }

        return false;
    }

    public function isLoggedIn(){
        return $this->loggedIn;
    }

    public function logout(){
        echo 'logout na classe';
        // Destrói a sessão do usuário
        session_destroy();                    
        $this->loggedIn = false;
    }

    public function getUserID(){
        return $this->userID;
    }
}