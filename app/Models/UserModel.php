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

    public function getUser($field, $value)
    {
        $sql = "SELECT * FROM " . TABLES::USERS . " WHERE " . $field . " = :field LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["field" => $value]);

        return $stmt->fetch() ?: null;
    }

    public function groupes(): ?array
    {
        $data = [];
        try {
            $sql = "SELECT * FROM roles r WHERE r.statut_role = :statut GROUP BY r.groupe";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(["statut" => STATUT_ACTIF]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function createPermission(array $rolePermissions): ?String
    {

        $data = "";
        try {
            $sql = "INSERT INTO user_roles (user_code , role_code, create_permission, edit_permission, show_permission, delete_permission)
                    VALUES (:user_code, :role_code, :create_permission, :edit_permission, :show_permission, :delete_permission)
                    ON DUPLICATE KEY UPDATE 
                    create_permission = VALUES(create_permission), 
                    edit_permission = VALUES(edit_permission), 
                    show_permission = VALUES(show_permission), 
                    delete_permission = VALUES(delete_permission)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($rolePermissions);
            $data = $this->db->lastInsertId() ?: $stmt->rowCount();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }
    public function deletePermission(string $userCode, string $roleCode): ?bool
    {
        $data = false;
        try {
            $sql = "DELETE FROM user_roles WHERE user_code = :user_code AND role_code = :role_code";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'user_code' => $userCode,
                'role_code' => $roleCode
            ]);
            $data = $stmt->rowCount() > 0;
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function getRolesByGroupe($groupe)
    {
        $result = [];
        try {
            $sql = "SELECT * FROM " . TABLES::ROLES . " WHERE groupe = :groupe";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(["groupe" => $groupe]);
            if ($stmt->rowCount() > 0)
                $result = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }

    public function getAllPermissionForUser(string $userCode)
    {
        $data = [];
        $sql = "SELECT * FROM  " . TABLES::USER_ROLES . " ur WHERE ur.user_code =:user_code ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_code' => $userCode]);
        $data =  $stmt->fetchAll();
        return $data;
    }

    public function getUserDataForLogin(string $email, string $value)
    {
        $data = [];
        try {
            $sql = "SELECT fn.libelle_fonction,COALESCE(en.id_enseignant,null) AS enseignant, u.* FROM " . TABLES::USERS . " AS u 
            LEFT JOIN " . TABLES::FONCTIONS . " AS fn ON fn.code_fonction = u.fonction_code
            LEFT JOIN " . TABLES::ENSEIGNANTS . " AS en ON en.user_code = u.code_user AND en.statut_enseignant = :statut
         WHERE {$email} = :email AND statut_user = :statut  LIMIT 1

        ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['email' => $value, 'statut' => STATUT_ACTIF]);
            $data = $stmt->rowCount() > 0 ? $stmt->fetch() : [];
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function updateLastConnexion(string $code): void
    {
        $sql = "UPDATE " . TABLES::USERS . " SET last_connexion = NOW() WHERE code_user = :code";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $code]);
    }

    public function updateLastGoogleUidConnexion(string $code, string $auth_uid): void
    {
        $sql = "UPDATE " . TABLES::USERS . " SET auth_uid = :auth_uid, last_connexion = NOW() WHERE code_user = :code_user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code_user' => $code, 'auth_uid' => $auth_uid]);
    }

    public function getUserGroups(string $userCode): array
    {
        $data = [];
        try {
            $sql = "SELECT r.groupe FROM " . TABLES::ROLES . " AS r 
            JOIN " . TABLES::USER_ROLES . " ur ON r.code_role = ur.role_code WHERE ur.user_code = :userCode GROUP BY r.groupe";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['userCode' => $userCode]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function getUserRoles(string $userCode): array
    {
        $data = [];
        try {
            $sql = "SELECT r.code_role, r.libelle_role, r.description, ur.* FROM " . TABLES::ROLES . " AS r 
            JOIN " . TABLES::USER_ROLES . " ur ON r.code_role = ur.role_code WHERE ur.user_code = :userCode GROUP BY r.code_role";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['userCode' => $userCode]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

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
        return $data['nb'] ?? 0;
    }


    public function DataTableFetchUsersListe(array $likeParams, string $orderBy, string $orderDir, int $start = 0, int $limit = 10)
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
