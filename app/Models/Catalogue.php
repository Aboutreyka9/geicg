<?php

namespace App\Models;

use App\Core\Auth;
use App\Core\Model;
use Exception;
use PDO;
use Roles;
use TABLES;

class Catalogue extends Model
{
    protected string $table = "hotels";
    public string $id = 'code_hotel';


    public function getAllCategorieByCompteBoutique($compte, $boutique, $etat_actif): ?array
    {
        $data = [];

        try {
            $sql = "
            SELECT *
            FROM " . TABLES::CATEGORIES . "
            WHERE compte_code = :compte_code
              AND boutique_code = :boutique_code
              AND etat_categorie = :etat_actif
            ORDER BY libelle_categorie ASC
        ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'compte_code'   => $compte,
                'boutique_code' => $boutique,
                'etat_actif'    => $etat_actif
            ]);

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $data;
    }

    public function aGetCategorieByField($field, $valeur)
    {
        $allowedFields = ['code_categorie', 'libelle_categorie', 'id_categorie'];

        if (!in_array($field, $allowedFields)) {
            return false;
        }

        try {
            $sql = "SELECT * FROM categories WHERE boutique_code = :boutique_code AND {$field} = :valeur LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                ':valeur' => $valeur,
                ':boutique_code' => Auth::user('boutique_code')
            ]);
            return $stm->fetch();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAllMarkByCompteBoutique($compte, $boutique, $etat_actif): ?array
    {
        $data = [];

        try {
            $sql = "
            SELECT *
            FROM " . TABLES::MARKS . "
            WHERE compte_code = :compte_code
              AND boutique_code = :boutique_code
              AND etat_mark = :etat_actif
            ORDER BY libelle_mark ASC
        ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'compte_code'   => $compte,
                'boutique_code' => $boutique,
                'etat_actif'    => $etat_actif
            ]);

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $data;
    }

    public function aGetMarkByField($field, $valeur)
    {
        $allowedFields = ['code_mark', 'libelle_mark', 'id_mark'];

        if (!in_array($field, $allowedFields)) {
            return false;
        }

        try {
            $sql = "SELECT * FROM marks WHERE boutique_code = :boutique_code AND {$field} = :valeur LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                ':valeur' => $valeur,
                ':boutique_code' => Auth::user('boutique_code')
            ]);
            return $stm->fetch();
        } catch (Exception $e) {
            return false;
        }
    }
    public function getAllUniteByCompteBoutique($compte, $boutique, $etat_actif): ?array
    {
        $data = [];

        try {
            $sql = "
            SELECT *
            FROM " . TABLES::UNITES . "
            WHERE compte_code = :compte_code
              AND boutique_code = :boutique_code
              AND etat_unite = :etat_actif
            ORDER BY libelle_unite ASC
        ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'compte_code'   => $compte,
                'boutique_code' => $boutique,
                'etat_actif'    => $etat_actif
            ]);

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $data;
    }

    public function aGetUniteByField($field, $valeur)
    {
        $allowedFields = ['code_unite', 'libelle_unite', 'id_unite'];

        if (!in_array($field, $allowedFields)) {
            return false;
        }

        try {
            $sql = "SELECT * FROM unites WHERE boutique_code = :boutique_code AND {$field} = :valeur LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                ':valeur' => $valeur,
                ':boutique_code' => Auth::user('boutique_code')
            ]);
            return $stm->fetch();
        } catch (Exception $e) {
            return false;
        }
    }


    public function getAllProduitByCompteBoutique($compte, $boutique, $etat_actif): ?array
    {
        $data = [];

        try {
            $sql = "
            SELECT *
            FROM " . TABLES::PRODUITS . "
            WHERE compte_code = :compte_code
              AND boutique_code = :boutique_code
              AND etat_produit = :etat_actif
            ORDER BY libelle_produit ASC
        ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'compte_code'   => $compte,
                'boutique_code' => $boutique,
                'etat_actif'    => $etat_actif
            ]);

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $data;
    }

    public function aGetProduitByField($field, $valeur)
    {
        $allowedFields = ['id_produit', 'code_produit', 'code_bar', 'boutique_code', 'categorie_code', 'mark_code', 'unite_code', 'libelle_produit', 'prix_achat', 'prix_vente', 'garantie_produit', 'stock_produit', 'etat_produit', 'compte_code'];

        if (!in_array($field, $allowedFields)) {
            return false;
        }

        try {
            $sql = "SELECT * FROM " . TABLES::PRODUITS . " p WHERE p.boutique_code = :boutique_code AND {$field} = :valeur LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                ':valeur' => $valeur,
                ':boutique_code' => Auth::user('boutique_code')
            ]);
            return $stm->fetch();
        } catch (Exception $e) {
            return false;
        }
    }

    public function aGetCatalogueByFields($table, $field1, $field2, $valeur1, $valeur2)
    {
        try {
            $sql = "SELECT * FROM {$table} 
                WHERE boutique_code = :boutique_code AND {$field1} = :valeur1 
                AND {$field2} = :valeur2";

            $stm = $this->db->prepare($sql);
            $stm->execute([
                ':valeur1' => $valeur1,
                ':valeur2' => $valeur2,
                ':boutique_code' => Auth::user('boutique_code')
            ]);

            return $stm->fetchAll();
        } catch (Exception $e) {
            return false;
        }
    }

    function dataTbleCountTotalProduitRow(array $whereParams, $likeParams = [])
    {

        // if (!empty($whereParams)) {
        //     $where = 'WHERE ';
        //     $where .=  implode(
        //         ' AND ',
        //         array_map(fn($f) => "$f = :$f ", array_keys($whereParams))
        //     );
        // }

        $where = "WHERE p.compte_code = :compte_code AND p.boutique_code = :boutique_code AND p.etat_produit = :etat_produit";
        if (!empty($likeParams)) {
            $likes = [];
            foreach ($likeParams as $field => $search) {
                $likes[] = "$field LIKE :$field";
                $likeParams[$field] = "%$search%";
            }
            $where .= " AND (" . implode(' OR ', $likes) . ")";
        }


        $sql = "SELECT p.*, c.libelle_categorie, m.libelle_mark, u.libelle_unite 
            FROM " . TABLES::PRODUITS . " p JOIN " . TABLES::CATEGORIES . " c ON p.categorie_code = c.code_categorie 
            JOIN " . TABLES::MARKS . " m ON p.mark_code = m.code_mark 
            JOIN " . TABLES::UNITES . " u ON p.unite_code = u.code_unite $where";
        $stmt = $this->db->prepare($sql);

        // return $sql;
        $stmt->execute(array_merge($whereParams, $likeParams));
        return (int) $stmt->fetchColumn();
    }

    function DataTableFetchProduitsListe($likeParams = [], int $start = 0, int $limit = 10)
    {


        $where = "WHERE p.boutique_code = :boutique_code AND p.etat_produit = :etat_produit";

        if (!empty($likeParams)) {
            $likes = [];
            foreach ($likeParams as $field => $search) {
                $likes[] = "$field LIKE :$field";
                $likeParams[$field] = "%$search%";
            }
            $where .= " AND (" . implode(' OR ', $likes) . ")";
        }


        $sql = "SELECT p.*, c.libelle_categorie, m.libelle_mark, u.libelle_unite 
            FROM " . TABLES::PRODUITS . " p JOIN " . TABLES::CATEGORIES . " c ON p.categorie_code = c.code_categorie 
            JOIN " . TABLES::MARKS . " m ON p.mark_code = m.code_mark 
            JOIN " . TABLES::UNITES . " u ON p.unite_code = u.code_unite $where ORDER BY p.libelle_produit ASC LIMIT :start, :limit";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(":boutique_code", Auth::user('boutique_code'));
        $stmt->bindValue(":etat_produit", ETAT_ACTIF);

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
