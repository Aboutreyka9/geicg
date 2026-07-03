<?php

namespace App\Models;

use App\Core\Auth;
use App\Core\Model;
use Exception;
use PDO;
use TABLES;

class User extends Model
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

    // get all fonction
    public function getAllFonctions(): array
    {
        $data = [];
        try {
            $sql = "SELECT * FROM " . TABLES::FONCTIONS . " AS fn WHERE fn.boutique_code = :boutique_code AND etat_fonction = 1 ORDER BY libelle_fonction";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['boutique_code' => Auth::user('boutique_code')]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
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

    public function getUserDataForLogin(string $login, $value)
    {
        $data = [];
        try {
            $sql = "SELECT fn.libelle_fonction, cpt.etat_compte, u.* FROM " . TABLES::USERS . " AS u
            JOIN " . TABLES::COMPTES . " AS cpt ON cpt.code_compte = u.compte_code 
            JOIN " . TABLES::FONCTIONS . " AS fn ON fn.code_fonction = u.fonction_code 
        WHERE {$login} = :login AND etat_user = :etat_user  LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['login' => $value, 'etat_user' => ETAT_ACTIF]);
            $data = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function defaultgetUserDataForLogin(string $login, $value)
    {
        $data = [];
        try {
            $sql = "SELECT bt.etat_boutique, code_user,password_user,nom_user,prenom_user ,f.libelle_fonction, f.code_fonction, u.boutique_code, u.compte_code  FROM " . TABLES::USERS . " AS u
            JOIN " . TABLES::FONCTIONS . " AS f ON f.code_fonction = u.fonction_code
            JOIN " . TABLES::BOUTIQUES . " AS bt ON bt.code_boutique = u.boutique_code 
        WHERE {$login} = :login AND etat_user = 1  LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['login' => $value]);
            $data = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function getUserByCodeWithFoction($codeUser): ?array
    {
        $data = [];
        try {
            $sql = "SELECT us.*, fn.libelle_fonction FROM users AS us JOIN fonctions fn ON fn.code_fonction = us.fonction_id 
            WHERE us.hotel_id = :hotel_id AND us.code_user = :code LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'code' => $codeUser,
                'hotel_id' => Auth::user('hotel_id')
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
            $sql = "SELECT us.*, fn.libelle_fonction FROM " . TABLES::USERS . " AS us JOIN " . TABLES::FONCTIONS . " fn ON fn.code_fonction = us.fonction_code AND fn.etat_fonction = :etat 
            WHERE us.boutique_code = :boutique_code  ORDER BY us.etat_user DESC, us.nom_user";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'etat' => $etat,
                'boutique_code' => Auth::user('boutique_code')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    function dataTbleCountTotalUsersRow(array $whereParams, $likeParams = [])
    {



        // if (!empty($whereParams)) {
        //     $where = 'WHERE ';
        //     $where .=  implode(
        //         ' AND ',
        //         array_map(fn($f) => "$f = :$f ", array_keys($whereParams))
        //     );
        // }

        $where = "WHERE us.boutique_code = :boutique_code AND us.etat_user = :etat_user";
        if (!empty($likeParams)) {
            $likes = [];
            foreach ($likeParams as $field => $search) {
                $likes[] = "us.$field LIKE :$field";
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

        $sql = "SELECT us.*, fn.* 
            FROM " . TABLES::USERS . " us JOIN " . TABLES::FONCTIONS . " fn  ON fn.code_fonction = us.fonction_code AND fn.etat_fonction = :etat_fonction $where";
        $stmt = $this->db->prepare($sql);

        // return $sql;
        $stmt->execute(array_merge($whereParams, $likeParams, ['etat_fonction' => ETAT_ACTIF]));
        return (int) $stmt->fetchColumn();
    }


    function DataTableFetchUsersListe($likeParams = [], int $start = 0, int $limit = 10)
    {


        $where = "WHERE us.boutique_code = :boutique_code AND us.etat_user = :etat_user";

        if (!empty($likeParams)) {
            $likes = [];
            foreach ($likeParams as $field => $search) {
                $likes[] = "us.$field LIKE :$field";
                $likeParams[$field] = "%$search%";
            }
            $where .= " AND (" . implode(' OR ', $likes) . ")";
        }


        $sql = "SELECT us.*, fn.* 
            FROM " . TABLES::USERS . " us JOIN " . TABLES::FONCTIONS . " fn  ON fn.code_fonction = us.fonction_code AND fn.etat_fonction = :etat_fonction $where ORDER BY nom_user ASC, prenom_user ASC LIMIT :start, :limit";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(":etat_fonction", ETAT_ACTIF);
        $stmt->bindValue(":boutique_code", Auth::user('boutique_code'));
        $stmt->bindValue(":etat_user", ETAT_ACTIF);

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

    public function getSupUserWithFoction(): ?array
    {
        $data = [];
        try {
            $sql = "SELECT us.*, fn.libelle_fonction FROM " . TABLES::USERS . " AS us 
            JOIN " . TABLES::FONCTIONS . " fn ON fn.code_fonction = us.fonction_code
            WHERE us.boutique_code = :boutique_code ORDER BY us.nom_user";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['boutique_code' => Auth::user('boutique_code')]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function getGroupesAndRolesUser($code): ?array
    {
        $data = [];
        try {
            $sql = "SELECT r.groupe,ur.role_id FROM roles r 
            JOIN user_roles ur ON r.code_role = ur.role_id
            JOIN users u ON u.code_user = ur.user_id
            WHERE u.hotel_id = :hotel_id AND ur.user_id = :user_id ORDER BY r.groupe";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                "hotel_id" => Auth::user("hotel_id"),
                "user_id" => $code
            ]);
            if ($stmt->rowCount() > 0)
                $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function groupes(): ?array
    {
        $data = [];
        try {
            $sql = "SELECT * FROM roles r WHERE r.etat_role = :etat GROUP BY r.groupe";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(["etat" => ETAT_ACTIF]);
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
            $sql = "INSERT INTO user_roles (user_id , role_id, create_permission, edit_permission, show_permission, delete_permission)
                    VALUES (:user_id, :role_id, :create_permission, :edit_permission, :show_permission, :delete_permission)
                    ON DUPLICATE KEY UPDATE 
                    create_permission = VALUES(create_permission), 
                    edit_permission = VALUES(edit_permission), 
                    show_permission = VALUES(show_permission), 
                    delete_permission = VALUES(delete_permission)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($rolePermissions);
            $data = $this->db->lastInsertId() ?: $stmt->rowCount();;
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }
    public function deletePermission(string $userId, string $roleId): ?bool
    {
        $data = false;
        try {
            $sql = "DELETE FROM user_roles WHERE user_id = :user_id AND role_id = :role_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'user_id' => $userId,
                'role_id' => $roleId
            ]);
            $data = $stmt->rowCount() > 0;
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
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
}
