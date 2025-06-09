<?php 

namespace App\Entity;

use \App\db\dataBase;
use \PDO;

class doacao{
    
    public $id;

    public $id_item;

    public $data;

    public $quant;
 
    public $local;

    public $obs;

    public $arquivo;

    public $id_usuario;


    public function cadastrar(){
        $this->data = date('Y-m-d H:i:s');

    
        $doacao = new database('doacao');
        echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
        // $this->id = $doacao->insert([
        //                                     'id' => $this->id,    
        //                                     'item' => $this->id_item,                                        
        //                                     'quant' => $this->quant,
        //                                     'local' => $this->local,
        //                                     'obs' => $this->obs,
        //                                     'anexo' => $this->arquivo,
        //                                     'id_usuario' => $this->id_usuario
                                            
        //                                 ]);

    return  true;
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

}


