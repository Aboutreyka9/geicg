<?php

namespace App\Models;

use App\Core\Auth;
use App\Core\Model;
use Exception;
use PDO;
use TABLES;

class UserModel extends Model
{
    protected string $table = "users";
    public string $id = 'code_user';

    
        public function getUserByCodeWithFoction($codeUser): ?array
    {
        $data = [];
        try {
            $sql = "SELECT us.*, fn.libelle_fonction FROM " . TABLES::USERS . " AS us JOIN " . TABLES::FONCTIONS . " fn ON fn.code_fonction = us.fonction_code 
            WHERE us.etablissement_code = :etablissement_code AND us.code_user = :code LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'code' => $codeUser,
                'etablissement_code' => Auth::user('etablissement_code')
            ]);
            if ($stmt->rowCount() > 0)
                $data = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function getUserWithFoction($etat = 1): ?array
    {
        $data = [];
        try {
            $sql = "SELECT us.*, fn.libelle_fonction FROM " . TABLES::USERS . " AS us JOIN " . TABLES::FONCTIONS . " fn ON fn.code_fonction = us.fonction_code AND fn.statut_fonction = :etat 
            WHERE us.etablissement_code = :etablissement_code  ORDER BY us.statut_user DESC, us.nom_user";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'etat' => $etat,
                'etablissement_code' => Auth::user('etablissement_code')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }


    
    public function dataTbleCountTotalUsersRow(array $whereParams, array $likeParams = [])
    {



        // if (!empty($whereParams)) {
        //     $where = 'WHERE ';
        //     $where .=  implode(
        //         ' AND ',
        //         array_map(fn($f) => "$f = :$f ", array_keys($whereParams))
        //     );
        // }

        $where = "WHERE us.etablissement_code = :etablissement_code";

        if (!empty($likeParams)) {
            $likes = [];
            foreach ($likeParams as $field => $search) {
                $likes[] = "$field LIKE :$field";
                $likeParams[$field] = "%$search%";
            }
            $where .= " AND (" . implode(' OR ', $likes) . ")";
        }

        // if (!empty($likeParams)) {
        //     $where .= empty($where) ? ' WHERE ' : ' AND ';
        //     $likes = [];
        //     foreach ($likeParams as $field => $search) {
        //         // $key = "$field";
        //         $likes[] = "$field LIKE :$field";
        //         $likeParams[$field] = "%$search%";
        //     }
        //     // return $likeParams;
        //     $where .= '(' . implode(' OR ', $likes) . ')';
        // }

            
        $sql = "SELECT COUNT(*) AS nb FROM " . TABLES::USERS . " us 
            JOIN " . TABLES::FONCTIONS . " fn  ON fn.code_fonction = us.fonction_code  $where";

        $stmt = $this->db->prepare($sql);

        // return $sql;
        $stmt->execute(array_merge($whereParams, $likeParams));
        $data = $stmt->fetch();
        return $data['nb'] ?? 0 ;


    }


    public function DataTableFetchUsersListe(array $likeParams, string $orderBy , string $orderDir, int $start = 0, int $limit = 10)
    {


        $where = "WHERE us.etablissement_code = :etablissement_code";

        if (!empty($likeParams)) {
            $likes = [];
            foreach ($likeParams as $field => $search) {
                $likes[] = "$field LIKE :$field";
                $likeParams[$field] = "%$search%";
            }
            $where .= " AND (" . implode(' OR ', $likes) . ")";
        }


       
         $sql = "SELECT us.*, fn.* FROM " . TABLES::USERS . " us 
        LEFT JOIN " . TABLES::FONCTIONS . " fn  ON fn.code_fonction = us.fonction_code $where ORDER BY $orderBy $orderDir LIMIT :start, :limit";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(":etablissement_code", Auth::user('etablissement_code'));

        // Bind les parametreslike
        $like = [];
        if (!empty($likeParams)) {

            foreach ($likeParams as $key => $value) {
                $like[] = "$key => $value";
                $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
            }
        }

        // ✅ Bind LIMIT params correctement
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

}