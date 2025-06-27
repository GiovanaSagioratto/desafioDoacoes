<?php 

namespace App\Entity;

use \PDOException;
use \App\Db\Database;

class Usuario {
    public $id_usuario;
    public $nome;
    public $email;
    public $senha;
    public $curso;

    public function cadastrar() {
         try {
            $usuDatabase = new Database('usuario');
            $this->id_usuario = $usuDatabase->insert([
                'nome'         => $this->nome,
                'email'        => $this->email,
                'senha'        => $this->senha,
                'curso'        => $this->curso,     
            ]);
            echo "Usuário cadastrado com ID: " . $this->id_usuario;
        } catch (PDOException $e) {
            echo 'Erro ao cadastrar: ' . $e->getMessage();
        }
    }
}


// public function atualizar(){
//     return (new Database('validacao'))->update('item = '.$this->item,[
//         'item' => $this->item,
//         'categoria' => $this->categoria,
//         'quant' => $this->quant,
//         'datado' => $this->datado,
//         'local' => $this->local,
//         'anexo' => $this->anexo,
//         'obg' => $this->obs
//     ]);
//   }

//   public function excluir(){
//     return (new Database('validacao'))->delete('item = '.$this->item);
//   }
  

//   public static function getDoacao($where = null, $order = null, $limit = null){
//     return (new Database('validacao'))->select($where,$order,$limit)
//                                   ->fetchAll(PDO::FETCH_CLASS,self::class);
//   }

 
//   public static function getDoacao($item){
//     return (new Database('validacao'))->select('item = '.$item)
//                                   ->fetchObject(self::class);
//   }




