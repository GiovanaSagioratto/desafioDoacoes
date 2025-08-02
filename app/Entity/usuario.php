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
    public $tipo_usuario;
    public $campanha;

    public function cadastrar() {
         try {
            $usuDatabase = new Database('usuario');
            $this->id_usuario = $usuDatabase->insert([
                'nome'         => $this->nome,
                'email'        => $this->email,
                'senha'        => $this->senha,
                'curso'        => $this->curso,  
                'tipo_usuario' => $this->tipo_usuario,
                'campanha'     => $this->campanha
                 
            ]);
           return $this->id_usuario;
        } catch (PDOException $e) {
            echo 'Erro ao cadastrar: ' . $e->getMessage();
        }
    }
    public static function getNomePorId($id_usuario) {
    return (new Database('usuario'))->select("id_usuario = $id_usuario")
                                    ->fetchObject(self::class);
}
public static function getUsuarioPorId($id) {
    return (new Database('usuario'))->select('id_usuario = ' . (int)$id)
                                     ->fetchObject(self::class);
}
public function atualizar() {
    $db = new \App\Db\Database('usuarios');
    return $db->update('id_usuario = ' . $this->id_usuario, [
        'nome' => $this->nome,
        'email' => $this->email,
        'foto_perfil' => $this->foto_perfil
    ]);
}

public static function getUsuariosPorTipo($tipo)
{
    try {
        $pdo = new \PDO('mysql:host=localhost;dbname=validacao', 'root', '1234');
        $stmt = $pdo->prepare('SELECT * FROM usuario WHERE tipo_usuario = :tipo');
        $stmt->bindValue(':tipo', $tipo);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    } catch (\PDOException $e) {
        echo 'Erro ao buscar usuários: ' . $e->getMessage();
        return [];
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




