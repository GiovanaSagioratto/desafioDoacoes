<?php 

namespace App\Entity;

use \PDO;
use \PDOException;

use \App\Db\Database;

class Doacao {
    public $id;
    public $item;
    public $data;
    public $local;
    public $obs;
    public $arquivo;
    public $id_usuario;
    public $status;
    public $categoria;
    public $motivo_recusa;
    public $campanha;
    public $created_at;
    
    public function cadastrar() {
        
        try {
            $obDatabase = new Database('doacao');
        
            $this->id = $obDatabase->insert([
                'item'    => $this->item,
                'data'       => $this->data,
                'categoria'  => $this->categoria,
                'local'      => $this->local,
                'obs'        => $this->obs,
                'arquivo'    => $this->arquivo,
                'id_usuario' => $this->id_usuario,
                'campanha'   => $this->campanha,
                'status' => 'pendente'
            ]);

        } catch (PDOException $e) {
            echo 'Erro ao cadastrar: ' . $e->getMessage();
        }
    }
    
public static function getDoacoesPorUsuario($id_usuario, $status = null) {
    $where = "id_usuario = $id_usuario";

    if ($status !== null) {
        $where .= " AND status = '$status'";
    }

    return (new Database('doacao'))->select($where)
                                   ->fetchAll(\PDO::FETCH_CLASS, self::class);
}

public static function getDoacaoPorId($id) {
    return (new Database('doacao'))->select("id = $id")
                                   ->fetchObject(self::class);
}
   public static function getPendentes() {
    return (new Database('doacao'))->select("status = 'pendente'")
                                   ->fetchAll(\PDO::FETCH_CLASS, self::class);
}

public function atualizar() {
    return (new Database('doacao'))->update('id = '.$this->id, [
        'item'    => $this->item,
        'data'    => $this->data,
        'local'   => $this->local,
        'obs'     => $this->obs,
        'arquivo' => $this->arquivo,
        'status'  => $this->status,
        'id_usuario' => $this->id_usuario,
        'campanha' => $this->campanha,
        'motivo_recusa'  => $this->motivo_recusa
    ]);
}
public static function getProximaPendente() {
    return (new Database('doacao'))->select("status = 'pendente' ORDER BY id ASC LIMIT 1")
                                   ->fetchObject(self::class);
}
public static function getDoacoesPorCampanha()
{
    $db = new Database('doacao');
    $query = "SELECT campanha, DATE(created_at) as dia, COUNT(*) as total
              FROM doacao
              WHERE status = 'aprovado'
              GROUP BY campanha, dia
              ORDER BY campanha, dia";
    return $db->execute($query)->fetchAll(PDO::FETCH_ASSOC);
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




