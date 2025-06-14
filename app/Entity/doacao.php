<?php 

namespace App\Entity;

use \PDOException;
use \App\Db\Database;

class Doacao {
    public $id;
    public $id_item;
    public $data;
    public $quant;
    public $local;
    public $obs;
    public $id_usuario;
    public $arquivo;

    public function cadastrar() {
        try {
            $obDatabase = new Database('doacao');
            $this->id = $obDatabase->insert([
                'id_item'    => $this->id_item,
                'data'       => $this->data,
                'quant'      => $this->quant,
                'local'      => $this->local,
                'obs'        => $this->obs,
                'id_usuario' => $this->id_usuario,
                'arquivo'    => $this->arquivo
            ]);
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




