<?php
    class Clientes{

        private $conn;
        private $db_table = "clientes";

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function getClientes()
        {
            $sqlQuery = "SELECT id, nome, email, foto, senha FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $this->formatBodyGet($stmt);
        }

        public function getSingleCliente($clienteId = null, $clienteEmail = null)
        {
            $sqlQuery = "SELECT id, nome, email, foto, senha 
                        FROM ". $this->db_table ."
                        WHERE id = ? OR email = ? LIMIT 1";

            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $clienteId);
            $stmt->bindParam(2, $clienteEmail);
            $stmt->execute();

            return $this->formatBodyGet($stmt);
        }  

        public function createCliente()
        {
            if(!$this->validateAuth())
            {
                return [
                    "message" => 'Falha na autenticação. Token inválido.'
                ];
            }

            if($this->verificarEmailExiste($_POST['email']))
            {
                return [
                    "message" => 'E-mail já cadastrado.'
                ];
            }

            $sql = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        nome = :nome, 
                        email = :email, 
                        foto = :foto, 
                        senha = :senha";
        
            $stmt = $this->conn->prepare($sql);

            extract($_POST);
        
            $nome = htmlspecialchars(strip_tags($nome));
            $email = htmlspecialchars(strip_tags($email));
            $foto = $this->formatFileBase64($_FILES['foto']);
            $senha = htmlspecialchars(strip_tags($senha));
            $senha = password_hash($senha, PASSWORD_DEFAULT);
        
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":foto", $foto);
            $stmt->bindParam(":senha", $senha);

            return [
                "success" => $stmt->execute()
            ];
        }

        function deleteCliente($clienteId)
        {
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $clienteId = htmlspecialchars(strip_tags($clienteId));
        
            $stmt->bindParam(1, $clienteId);

            return [
                "success" => $stmt->execute()
            ];
        }

        function formatBodyGet($stmt)
        {
            $clientesArr = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $e = array(
                    "id" => $id,
                    "nome" => $nome,
                    "email" => $email,
                    "foto" => $foto
                );

                array_push($clientesArr, $e);
            }

            return $clientesArr;
        }

        function formatFileBase64($file)
        {
            $type = pathinfo($file['name'], PATHINFO_EXTENSION);
            $data = file_get_contents($file['tmp_name']);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        function validateAuth()
        {
           $token = $this->getBearerToken();

           if ($token !== "55148e8eb9d875926395d95480f7bba6c1f5a8eb")
           {
             return false;
           }
           return true;
        }
        
        function verificarEmailExiste($email)
        {
            $sqlQuery = "SELECT id FROM ". $this->db_table ." WHERE email = ? LIMIT 1";

            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $email);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        }

        function getBearerToken()
        {
            $headers = $this->getAuthorizationHeader();
            if (!empty($headers))
            {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches))
                {
                    return $matches[1];
                }
            }
            return null;
        }

        function getAuthorizationHeader()
        {
            $headers = null;
            if (isset($_SERVER['Authorization']))
            {
                $headers = trim($_SERVER["Authorization"]);
            }
            else if (isset($_SERVER['HTTP_AUTHORIZATION']))
            {
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            }
            elseif (function_exists('apache_request_headers'))
            {
                $requestHeaders = apache_request_headers();
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                if (isset($requestHeaders['Authorization']))
                {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
            return $headers;
        }
    }
?>

