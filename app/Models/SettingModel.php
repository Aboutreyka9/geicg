<?php

namespace App\Models;

use App\Core\Auth;
use App\Core\Model;
use Exception;
use PDO;
use TABLES;

class SettingModel extends Model
{
    protected string $table = "fonctions";
    public string $id = 'code_fonction';

        public function getSingleFonctionByCode(string $code): array
    {
        $data = [];
        try {
            $sql = "SELECT * FROM " . TABLES::FONCTIONS . " AS fn WHERE fn.code_fonction = :code LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['code' => $code]);
            $data = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

            public function getSingleServiceByCode(string $code): array
    {
        $data = [];
        try {
            $sql = "SELECT * FROM " . TABLES::SERVICES . " AS se WHERE se.code_service = :code LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['code' => $code]);
            $data = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    // get all fonction
    public function getAllFonctions($etablissement_code): array
    {
        $data = [];
        try {
            $sql = "SELECT * FROM " . TABLES::FONCTIONS . " AS fn WHERE fn.etablissement_code = :etablissement_code AND statut_fonction = :statut ORDER BY libelle_fonction";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['etablissement_code' => $etablissement_code,'statut' => STATUT_ACTIF]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    // get all Services
    public function getAllServices($etablissement_code): array
    {
        $data = [];
        try {
            $sql = "SELECT * FROM " . TABLES::SERVICES . " AS se WHERE se.etablissement_code = :etablissement_code AND statut_service = :statut ORDER BY libelle_service";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['etablissement_code' => $etablissement_code,'statut' => STATUT_ACTIF]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }
    
    function dataTbleCountTotalFonctionsRow(array $whereParams, $likeParams = [])
    {
        // if (!empty($whereParams)) {
        //     $where = 'WHERE ';
        //     $where .=  implode(
        //         ' AND ',
        //         array_map(fn($f) => "$f = :$f ", array_keys($whereParams))
        //     );
        // }

        $where = "WHERE fn.etablissement_code = :etablissement_code";

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

            
        $sql = "SELECT COUNT(*) AS nb FROM " . TABLES::FONCTIONS . " fn $where";

        $stmt = $this->db->prepare($sql);

        // return $sql;
        $stmt->execute(array_merge($whereParams, $likeParams));
        $data = $stmt->fetch();
        return $data['nb'] ?? 0 ;


    }


    function DataTableFetchFonctionsListe($likeParams = [], int $start = 0, int $limit = 10)
    {


        $where = "WHERE fn.etablissement_code = :etablissement_code";

        if (!empty($likeParams)) {
            $likes = [];
            foreach ($likeParams as $field => $search) {
                $likes[] = "$field LIKE :$field";
                $likeParams[$field] = "%$search%";
            }
            $where .= " AND (" . implode(' OR ', $likes) . ")";
        }


       
         $sql = "SELECT fn.* FROM " . TABLES::FONCTIONS . " fn $where ORDER BY fn.libelle_fonction ASC LIMIT :start, :limit";

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