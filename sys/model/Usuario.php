<?php
    namespace sys\model;

    use sys\model\Object;

    class Usuario extends Object
    {
        protected $id;
        protected $nome;
        protected $email;
        protected $nascimento;
        protected $senha;

        public function getId()
        {
            return $this->id;
        }
        
        public function getNome()
        {
            return $this->nome;
        }
        
        public function setNome( $nome)
        { 
            $this->nome = $nome;
        }
        
        public function getEmail()
        {
            return $this->email;
        }
        
        public function setEmail( $email)
        { 
            $this->email = $email;
        }
        
        public function getNascimento()
        {
            return $this->nascimento;
        }
        
        public function setNascimento( $nascimento)
        { 
            $this->nascimento = $nascimento;
        }
        
        public function getSenha()
        {
            return $this->senha;
        }
        
        public function setSenha( $senha)
        { 
            $this->senha = $senha;
        }
        
        /**
         * 
         */
        public function __construct()
        {
            parent::__construct();
        }

        public static function find($where = '1=1', $params = array(), $class = true)
        {
            $find = new self();
            $find->beginTransaction();
            $consul = $find->prepare( "SELECT * FROM usuarios WHERE email = 'matheushsoaress@gmail.com' and senha = '202cb962ac59075b964b07152d234b70'");
//            $consul = $find->prepare( "SELECT * FROM usuarios WHERE ".$where);
//            $consul->execute( $params);
            $consul->execute( );
//            print_r($consul);
//            var_dump($where);
//            var_dump($params);
            if($class){
                $result = $consul->fetchAll( \PDO::FETCH_CLASS, get_class());
            }else{
                $result = $consul->fetchAll();
            }
            var_dump($result);
            return $result?$result:false;
        }
        
        public function delete() 
        {
            if(isset($this->id)){
                $delete = $this->prepare( "DELETE FROM usuarios WHERE id = {$this->id}");
                $result = $delete->execute();
                return ($result)?true:false;
            }
        }

        public function save() 
        {
            if(isset($this->id)){
                $params = array(
                    'p_email' => $this->email, 
                    'p_nascimento' => $this->nascimento,
                    'p_nome' => $this->nome,
                    'p_senha' => $this->senha,
                    'p_id' => $this->id
                );
                $update = $this->prepare( 'UPDATE usuarios SET email = :p_email, nascimento = :p_nascimento, nome = :p_nome, senha = :p_senha WHERE id = :p_id');
                $result = $update->execute($params);
                return $result?true:false;
            }else{
                $params = array(
                    'p_email' => $this->email,
                    'p_nascimento' => $this->nascimento,
                    'p_nome' => $this->nome,
                    'p_senha' => $this->senha
                );
                $new = $this->prepare( 'INSERT INTO usuario( nome, nascimento, email, senha) VALUES (:p_nome, :p_nascimento, :p_email, :p_senha)');
                $result = $new->execute( $params);
                return $result?true:false;
            }
        }
    }