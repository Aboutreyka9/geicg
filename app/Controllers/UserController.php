<?php

namespace App\Controllers;

use Roles;
use App\Core\Gqr;
use App\Core\Auth;
use App\Models\User;
use App\Models\Factory;
use App\Services\Service;
use App\Core\MainController;
use App\Services\UserService;
use Groupes;
use TABLES;

class UserController extends MainController
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public function role()
    {
        $users = [];
        $fc = new User();
        $users = Auth::hasGroupe(Groupes::SUPER) ?
            $fc->getSupUserWithFoction() :
            $fc->getUserWithFoction();

        // if (Auth::hasGroupe(Groupes::SUPER)) {
        //     $user = $fc->getSupUserWithFoction();

        //     $this->view('admins/role', ["users" => $user, 'title' => 'Gestion des roles']);

        //     return;
        // }

        // $user = $fc->getUserWithFoction();

        return $this->view('admins/role', ["users" => $users, 'title' => 'Gestion des roles']);
    }


    public function acueil()
    {

        $result = "";
        // $start = "2025-10-06 00:00:00";
        // $end = "2025-10-010 23:59:59";
        // $img =  Gqr::qrcode();
        // echo "<img src='.$img.' >";
        $fc = new Factory();
        //   $data = $fc->select("type_depense")->all();

        //   foreach ($data as $k ) {
        //     $fc->create("type_depenses", [
        //         "libelle_typedepense" => $k['libelle_type'],
        //         'code_typedepense' => $fc->generatorCode('type_depenses', 'code_typedepense'),

        //     ]);
        //   }

        //   var_dump($data);
        // return;
        // $result = Gqr::qrReserve(1, "Hicham", "101", "2022-01-01", "2022-01-02");

        // return;

        return $this->view('welcome', ["result" => $result, "title", 'title' => "Mon espace"]);
    }

    public function userListe()
    {
        $this->view('users/liste', ['title' => "Liste des utilisateurs"]);
    }

    public function profileEmploye($code)
    {
        $code = decrypter($code);
        if (!$code) exit(http_response_code(500));

        $fc = new Factory();
        $user = $fc->getUserByCodeWithFoction($code);
        $fonctions = $fc->getAllFonctions();
        $activities = $fc->getAllDetailesVersementReservationsForUser($code);

        $this->view('admins/profile', ["user" => $user, "activities" => $activities, "fonctions" => $fonctions, 'title' => "Profile employe"]);
    }

    public function myProfile($code)
    {

        if (!$code || empty($code)) exit(http_response_code(500));

        $fc = new Factory();
        $user = $fc->getUserByCodeWithFoction($code);

        $this->view('auth/my_profile', ["user" => $user, 'title' => "Mon Profile"]);
    }

    public  function home()
    {
        return $this->viewGuest('auth/welcome', []);
    }



    public function register()
    {
        return $this->viewGuest('auth/register', ["title" => "Création de compte"]);
    }


    public function fonction()
    {
        return $this->view('parametres/fonction', ["title" => "Création de compte"]);
    }

    public function setting()
    {
        $fc = new Factory();
        $hotel = $fc->find("hotels", "code_hotel", Auth::user("hotel_id"));

        return $this->view('parametres/setting', ["hotel" => $hotel, "title" => "Parametres"]);
    }

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



    public function bGetListeUser()
    {

        extract($_POST);
        $output = "";
        $user = new User();

        $likeParams = [];
        $whereParams = ['boutique_code' => Auth::user('boutique_code'), 'etat_user' => ETAT_ACTIF];


        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        // $search = $_POST['search'] ?? '';
        $search = $_POST['search']['value'] ?? '';




        // 🔎 Recherche
        if (!empty($search)) {
            $likeParams = ['nom_user' => $search, 'prenom_user' => $search, 'email_user' => $search, 'telephone_user' => $search, 'matricule_user' => $search, 'sexe_user' => $search, 'fonction_code' => $search, 'user_created_at' => $search];
        }

        // 🔢 Total
        $total = $user->dataTbleCountTotalUsersRow($whereParams);
        // 🔢 Total filtré

        $totalFiltered = $user->dataTbleCountTotalUsersRow($whereParams, $likeParams);
        // 📄 Données

        $userList = $user->DataTableFetchUsersListe($likeParams, $start, $limit);

        $data = [];


        $data = UserService::userDataService($userList);
        echo json_encode([
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
            // "data"            => $userList
        ]);
        // echo json_encode(['data' => $total, 'code' => 200]);
        return;
    }

    public function modalAddUser()
    {

        // $users = getAllusers();
        $fonctions = (new User())->getAllFonctions();
        // $services = getAllServices();

        $output = UserService::userAddModalService($fonctions);
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }


    public function addUser()
    {

        $msg['code'] = 400;
        $msg['type'] = "warning";

        $_POST = sanitizePostData($_POST);
        $user = new User();
        // var_dump($_POST);
        // return;
        if (!empty($_POST['nom_user']) && !empty($_POST['prenom_user']) && !empty($_POST['telephone_user']) && !empty($_POST['email_user']) && !empty($_POST['sexe_user']) && !empty($_POST['fonction_user']) && !empty($_POST['matricule_user'])) {
            extract($_POST);
            $telephone = removeSpace($telephone_user);
            $telephone = str_replace('(+225)', '', $telephone);

            // if (isValidPhoneNumber($telephone)) {
            if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {
                $userTel = $user->find(TABLES::USERS, 'telephone_user', $telephone);

                if (empty($userTel)) {

                    if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
                        $userEmail = $user->find(TABLES::USERS, 'email_user', $email_user);

                        if (empty($userEmail)) {

                            $passwrod = generetor(5);
                            $code = $user->generatorCode(TABLES::USERS, 'code_user');
                            $token = generetor(random_int(50, 70));

                            $data_user = [
                                'nom_user' => strtoupper($nom_user),
                                'prenom_user' => strtoupper($prenom_user),
                                'telephone_user' => $telephone_user,
                                'code_user' => $code,
                                'email_user' => $email_user,
                                'matricule_user' => strtoupper($matricule_user),
                                'sexe_user' => $sexe_user,
                                'fonction_code' => $fonction_user,
                                'boutique_code' => Auth::user('boutique_code'),
                                'compte_code' => Auth::user('compte_code'),
                                'etat_user' => ETAT_INACTIF,
                                'password_user' => password_hash($passwrod, PASSWORD_BCRYPT),
                                'token' => $token,
                                'created_user' => date('Y-m-d'),
                                'lastime' => date('Y-m-d')
                            ];

                            if ($user->create(TABLES::USERS, $data_user)) {

                                $boutique =   $user->getInfoBoutique(Auth::user('boutique_code'));

                                $data_mail = [
                                    "appName" => $_ENV["APP_NAME"],
                                    "libelle_structure" => $boutique['libelle_boutique'],
                                    "email" => $email_user,
                                    "password" => $passwrod,
                                    "nom" => strtoupper($nom_user . " " . $prenom_user),
                                    "lienActivation" => HOME . "/activation/{$token}"
                                ];


                                // $this->SendMail($email_user, "Création de compte", "activation", $data_mail);


                                $msg['code'] = 200;
                                $msg['type'] = "success";
                                $msg['message'] = "Utilisateur enregistré avec succes";
                            } else {
                                $msg['message'] = "Echec d'enregistrement!";
                            }
                        } else {
                            $msg['message'] = "Desolé! Cette adresse email existe déjà. ";
                        }
                    } else {
                        $msg['message'] = "Adresse email invalide. ";
                    }
                } else {
                    $msg['message'] = "Desolé! Ce numero de telephone existe déjà. ";
                }
            } else {

                $msg['message'] = "Numero de telephone invalide. ";
            }
        } else {
            $msg['message'] = "Veuillez remplire tous les champs. ";
        }
        echo json_encode($msg);
        return;
    }

    public function enableUser()
    {

        $msg['code'] = 400;
        extract($_POST);

        $code = decrypter($id_user);

        $fn = new Factory();
        $res = $fn->update('users', 'code_user', $code, ['etat_user' => 1]);
        if ($res || $res == 0) {
            $msg['code'] = 200;
            $msg['type'] = "success";
            $msg['message'] = "Compte activé avec succes";
        } else {
            $msg['type'] = "warning";
            $msg['message'] = "Echec de 'opération!";
        }

        echo json_encode($msg);
        return;
    }


    public function disableUser()
    {

        $msg['code'] = 400;
        extract($_POST);

        $code = decrypter($id_user);
        $fn = new Factory();
        $res = $fn->update('users', 'code_user', $code, ['etat_user' => 0]);
        if ($res || $res == 0) {
            $msg['code'] = 200;
            $msg['type'] = "success";
            $msg['message'] = "Compte desactivé avec succes";
        } else {
            $msg['type'] = "warning";
            $msg['message'] = "Echec de 'opération!";
        }

        echo json_encode($msg);
        return;
    }

    public function sendMailActivation()
    {
        $msg['code'] = 400;
        extract($_POST);

        $code = decrypter($id_user);
        $fc = new Factory();
        $user = $fc->find('users', 'code_user', $code);

        $token = generetor(random_int(50, 70));

        $password = generetor(5);

        $data_user = [
            'token' => $token,
            'password_user' => password_hash($password, PASSWORD_BCRYPT)
        ];

        $name = $user['nom'] . ' ' . $user['prenom'];
        $hotel = $fc->getInfoHotel(Auth::user('hotel_id'));

        $data_mail = [
            "appName" => $_ENV["APP_NAME"],
            "hotel_name" => $hotel["libelle_hotel"],
            "email" => $user['email'],
            "password" => $password,
            "nom" => strtoupper($name),
            "lienActivation" => HOME . "/activation/{$token}"
        ];

        $resultat = $fc->update("users", "code_user", $code, $data_user);

        $res = $this->SendMail($user['email'], "Création de compte", "activation", $data_mail);


        if ($resultat && $res) {
            $msg['code'] = 200;
            $msg['type'] = "success";
            $msg['message'] = "Email envoyé avec succes";
        } else {
            $msg['type'] = "warning";
            $msg['message'] = "Echec de 'opération!";
        }

        echo json_encode($msg);
        return;
    }


    public function openCaisse()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $fc = new Factory();
        $code = $fc->generatorCode('versements', 'code_versement');
        $data_versement = [
            'code_versement' => $code,
            'ouverture' => date('Y-m-d H:i:s'),
            'hotel_id' => Auth::user('hotel_id'),
            'user_id' => Auth::user('id')
        ];

        if ($fc->create('versements', $data_versement)) {

            Auth::update('caisse', $code);
            $msg['code'] = 200;
            $msg['type'] = "success";
            $msg['message'] = "Caisse ouverte avec succes";
        } else {
            $msg['message'] = "Echec d'ouverture!";
        }
        echo json_encode($msg);
        return;
    }

    public function closeCaisse()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $fc = new Factory();

        $recap = $this->recapCaisseClosing();
        $data_versement = [
            'cloture' => date('Y-m-d H:i:s'),
            'montant_cloture' => $recap['facture'],
            'montant_total' => $recap['montant_attendu']
        ];

        if ($fc->update2('versements', ['code_versement' => Auth::user('caisse')], $data_versement)) {
            Auth::update('caisse', null);

            $msg['code'] = 200;
            $msg['type'] = "success";
            $msg['message'] = "Caisse fermée avec succes";
        } else {
            $msg['message'] = "Echec de fermeture!";
        }

        echo json_encode($msg);
        return;
    }

    private function recapCaisseClosing()
    {
        $fc = new Factory();
        $montant_attendu = 0;

        $caisseReservations = $fc->getRecapCaisseReservationForUserCompte(Auth::user('caisse'));
        $CaisseServices = $fc->getRecapCaisseServiceForUserCompte(Auth::user('caisse'));
        $facture = $fc->getRecapFactureForUserCompte(Auth::user('caisse'));


        // reservation en cours
        if (!empty($caisseReservations)) {
            foreach ($caisseReservations as $r) {
                $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
                $montant_attendu += $day * $r['prix_reservation'];
            }
        }

        if (!empty($CaisseServices)) {
            $montant_attendu += $CaisseServices;
        }
        return ['montant_attendu' => $montant_attendu, 'facture' => $facture];
    }

    public  function loginUser()
    {

        $result = [];
        $result['code'] = 400;
        $etatCaise = null;
        $_POST = sanitizePostData($_POST);

        $login = $_POST['login'];
        $password = $_POST['password'];


        if (empty($login)) {
            $result['msg'] = "Veuillez renseigner votre login.";
        } elseif (empty($password)) {
            $result['msg'] = "Veuillez renseigner votre mot de passe.";
        } else {
            $fc = new User();
            // $fc->setKey('code_user');
            $user = [];

            $user = (filter_var($login, FILTER_VALIDATE_EMAIL)) ? $fc->getUserDataForLogin('email_user', $login) : $fc->getUserDataForLogin('telephone_user', $login);
            if (!empty($user) && password_verify($password, $user['password_user'])) {
                $groupes = [];
                $roles = [];

                // Vérifier si le compte est actif
                if (($user['etat_compte'] == ETAT_ACTIF)) {

                    // Récupérer les rôles de l'utilisateur
                    $rolesuser = $fc->getUserRoles($user['code_user']);

                    $Groupesuser = $fc->getUserGroups($user['code_user']);

                    // Mettre a jour lastime connection
                    $fc->update("users", "code_user", $user['code_user'], ['lastime' => date('Y-m-d H:i:s')]);

                    if (!empty($Groupesuser)) {
                        foreach ($Groupesuser as $groupe) {
                            $groupes[] = $groupe['groupe'];
                        }
                    }

                    if (!empty($rolesuser)) {
                        foreach ($rolesuser as $role) {

                            $roles[$role['code_role']] = [
                                'create' => (bool) $role['create_permission'],
                                'edit'   => (bool) $role['edit_permission'],
                                'show'   => (bool) $role['show_permission'],
                                'delete' => (bool) $role['delete_permission'],
                            ];
                        }
                    }


                    $caisse = $fc->getEtatCaisseUser($user['code_user'], $user['boutique_code']);
                    if (!empty($caisse) && $caisse['cloture'] == null) {
                        $etatCaise = $caisse['code_versement'];
                    }

                    Auth::login($user, $groupes, $roles, $etatCaise);
                    $result['activityYear'] = $fc->getYearActivityStart($user['boutique_code']);
                    $result['msg'] = "Connexion réussie !";
                    $result['code'] = 200;
                } else {
                    $result['msg'] = "Votre abonement a expiré. Veuillez contacter l'administrateur.";
                }
            } else {
                $result['msg'] = "Email/telephone  ou mot de passe incorrect !";
            }
        }

        echo json_encode($result);
        return;
    }

    public  function DefaultloginUser()
    {

        $result = [];
        $result['code'] = 400;
        $etatCaise = null;
        $_POST = sanitizePostData($_POST);

        $login = $_POST['login'];
        $password = $_POST['password'];


        if (empty($login)) {
            $result['msg'] = "Veuillez renseigner votre login.";
        } elseif (empty($password)) {
            $result['msg'] = "Veuillez renseigner votre mot de passe.";
        } else {
            $fc = new User();
            // $fc->setKey('code_user');
            $user = [];

            $user = (filter_var($login, FILTER_VALIDATE_EMAIL)) ? $fc->getUserDataForLogin('email_user', $login) : $fc->getUserDataForLogin('telephone_user', $login);
            if (!empty($user) && password_verify($password, $user['password_user'])) {
                $groupes = [];
                $roles = [];

                // Vérifier si le compte est actif
                if (($user['etat_boutique'] == ETAT_ACTIF) || ($user['code_user'] == $user['boutique_code'])) {

                    // Récupérer les rôles de l'utilisateur
                    $rolesuser = $fc->getUserRoles($user['code_user']);
                    $Groupesuser = $fc->getUserGroups($user['code_user']);
                    // Mettre a jour lastime connection
                    $fc->update("users", "code_user", $user['code_user'], ['lastime' => date('Y-m-d H:i:s')]);



                    if (!empty($Groupesuser)) {
                        foreach ($Groupesuser as $groupe) {
                            $groupes[] = $groupe['groupe'];
                        }
                    }

                    if (!empty($rolesuser)) {
                        foreach ($rolesuser as $role) {

                            $roles[$role['code_role']] = [
                                'create' => (bool) $role['create_permission'],
                                'edit'   => (bool) $role['edit_permission'],
                                'show'   => (bool) $role['show_permission'],
                                'delete' => (bool) $role['delete_permission'],
                            ];
                        }
                    }


                    $caisse = $fc->getEtatCaisseUser($user['code_user'], $user['boutique_code']);
                    if (!empty($caisse) && $caisse['cloture'] == null) {
                        $etatCaise = $caisse['code_versement'];
                    }

                    Auth::login($user, $groupes, $roles, $etatCaise);
                    $result['activityYear'] = $fc->getYearActivityStart($user['boutique_code']);
                    $result['msg'] = "Connexion réussie !";
                    $result['code'] = 200;
                } else {
                    $result['msg'] = "Votre compte est désactivé. Veuillez contacter l'administrateur.";
                }
            } else {
                $result['msg'] = "Email/telephone  ou mot de passe incorrect !";
            }
        }

        echo json_encode($result);
        return;
    }

    public function registerUser()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $_POST = sanitizePostData($_POST);

        if (!empty($_POST['nom']) && !empty($_POST['telephone']) && !empty($_POST['email']) && !empty($_POST['hotel'])) {
            extract($_POST);
            $telephone = removeSpace($telephone);
            $telephone = str_replace('(+225)', '', $telephone);

            // if (isValidPhoneNumber($telephone)) {
            if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $user = new Factory();
                    $userphone = $user->find("users", "telephone", $telephone);

                    if (empty($userphone)) {

                        $userEmail = $user->find("users", "email", $email);

                        if (empty($userEmail)) {
                            $code = $user->generatorCode('hotels', 'code_hotel');
                            $passwrod = generetor(5);
                            $token = generetor(random_int(50, 70));

                            $data_fonction = [
                                'code_fonction' => $code,
                                'libelle_fonction' => 'Super Administrateur',
                                'etat_fonction' => 2,
                                'hotel_id' => $code,
                            ];

                            $data_hotel = [
                                'code_hotel' => $code,
                                'libelle_hotel' => strtoupper($hotel),
                                'etat_hotel' => 0,
                                'created_hotel' => date('Y-m-d H:i:s')
                            ];


                            $data_user = [
                                'nom' => strtoupper($nom),
                                'prenom' => strtoupper(''),
                                'telephone' => $telephone,
                                'code_user' => $code,
                                'email' => $email,
                                'matricule' => $code,
                                'sexe' => "",
                                'fonction_id' => $code,
                                'service_id' => $code,
                                'hotel_id' => $code,
                                'etat_user' => 0,
                                'password_user' => password_hash($passwrod, PASSWORD_BCRYPT),
                                'token' => $token,
                                'created_user' => date('Y-m-d H:i:s'),
                                'lastime' => date('Y-m-d H:i:s')
                            ];

                            $create = $user->transactRegisterUser($data_hotel,  $data_fonction,  $data_user);

                            // $user->

                            if ($create) {
                                $hotel =   $user->getInfoHotel($code);

                                $data_mail = [
                                    "appName" => $_ENV["APP_NAME"],
                                    "hotel_name" => $hotel["libelle_hotel"],
                                    "email" => $email,
                                    "password" => $passwrod,
                                    "nom" => strtoupper($nom),
                                    "lienActivation" => HOME . "/activation/{$token}"
                                ];


                                $this->SendMail($email, "Création de compte", "activation", $data_mail);

                                $msg['code'] = 200;
                                $msg['type'] = "success";
                                $msg['message'] = "Compte crée avec succes. Un lien d'activation vous a été envoyé.";
                            } else {
                                $msg['message'] = "Echec d'enregistrement!";
                            }
                        } else {
                            $msg['message'] = "Desolé! Cette adresse email existe déjà. ";
                        }
                    } else {
                        $msg['message'] = "Desolé! Ce numero de telephone existe déjà. ";
                    }
                } else {
                    $msg['message'] = "Adresse email invalide. ";
                }
            } else {

                $msg['message'] = "Numero de telephone invalide. ";
            }
        } else {
            $msg['message'] = "Veuillez remplire tous les champs. ";
        }
        echo json_encode($msg);
        return;
    }

    public function activationAccount($token)
    {
        $user = new Factory();
        $compte = $user->find("users", "token", $token);

        if (!empty($compte)) {
            if ($compte['etat_user'] == 0) {


                $rest = $user->update("users", "code_user", $compte['code_user'], ['etat_user' => 1, 'token' => ""]);

                if ($rest) {
                    $data = [
                        "type" => "success",
                        "title" => "Activation de compte",
                        "message" => "Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.",
                        "lienConnexion" => HOME . "/login"
                    ];

                    return $this->viewGuest('auth/activation', $data);
                }

                $data = [
                    "type" => "warning",
                    "title" => "Activation de compte",
                    "message" => "Une erreur est survenue lors de l'activation de votre compte. Veuillez réessayer plus tard."
                ];

                return $this->viewGuest('auth/activation', $data);
            } else {

                $data = [
                    "type" => "info",
                    "title" => "Activation de compte",
                    "message" => "Votre compte est déjà activé. Vous pouvez vous connecter.",
                    "lienConnexion" => HOME . "/login"
                ];

                return $this->viewGuest('auth/activation', $data);
            }
        } else {
            $data = [
                "type" => "danger",
                "title" => "Activation de compte",
                "message" => "Lien d'activation invalide ou expiré."
            ];

            return $this->viewGuest('auth/activation', $data);
        }
    }

    public function activationAccountUser($token)
    {
        $user = new Factory();
        $compte = $user->find("comptes", "token", $token);

        if (!empty($compte)) {
            if ($compte['etat_compte'] == 0) {

                // $create = $user->transactActivation($compte);
                if ($compte) {
                    $data = [
                        "type" => "success",
                        "title" => "Activation de compte",
                        "message" => "Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.",
                        "lienConnexion" => HOME . "/login"
                    ];

                    return $this->viewGuest('auth/activation', $data);
                }

                $data = [
                    "type" => "warning",
                    "title" => "Activation de compte",
                    "message" => "Une erreur est survenue lors de l'activation de votre compte. Veuillez réessayer plus tard."
                ];

                return $this->viewGuest('auth/activation', $data);
            } else {

                $data = [
                    "type" => "info",
                    "title" => "Activation de compte",
                    "message" => "Votre compte est déjà activé. Vous pouvez vous connecter.",
                    "lienConnexion" => HOME . "/login"
                ];

                return $this->viewGuest('auth/activation', $data);
            }
        } else {
            $data = [
                "type" => "danger",
                "title" => "Activation de compte",
                "message" => "Lien d'activation invalide ou expiré."
            ];

            return $this->viewGuest('auth/activation', $data);
        }
    }

    public function updateUser()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $_POST = sanitizePostData($_POST);
        if ($_POST['code']) {

            if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['telephone']) && !empty($_POST['email']) && !empty($_POST['fonction']) && !empty($_POST['genre'])) {
                extract($_POST);
                $telephone = removeSpace($telephone);
                $telephone = str_replace('(+225)', '', $telephone);

                // if (isValidPhoneNumber($telephone)) {
                if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $user = new Factory();
                        $userphone = $user->find("users", "telephone", $telephone);

                        if (empty($userphone) || $userphone['code_user'] == $code) {

                            $userEmail = $user->find("users", "email", $email);

                            if (empty($userEmail) || $userEmail['code_user'] == $code) {

                                $data_user = [
                                    'nom' => strtoupper($nom),
                                    'prenom' => strtoupper($prenom),
                                    'telephone' => $telephone,
                                    'email' => $email,
                                    'sexe' => $genre,
                                    'fonction_id' => $fonction,
                                ];

                                $res = $user->update('users', 'code_user', $code, $data_user);

                                if ($res || $res == 0) {

                                    $msg['code'] = 200;
                                    $msg['type'] = "success";
                                    $msg['message'] = "Modification effectuée avec succès!";
                                } else {
                                    $msg['message'] = "Echec d'operation!";
                                }
                            } else {
                                $msg['message'] = "Desolé! Cette adresse email existe déjà. ";
                            }
                        } else {
                            $msg['message'] = "Desolé! Ce numero de telephone existe déjà. ";
                        }
                    } else {
                        $msg['message'] = "Adresse email invalide. ";
                    }
                } else {

                    $msg['message'] = "Numero de telephone invalide. ";
                }
            } else {
                $msg['message'] = "Veuillez remplire tous les champs. ";
            }
        } else {
            $msg['message'] = "Echec de verification des données ";
        }
        echo json_encode($msg);
        return;
    }

    public function resetPasswordUser()
    {
        $result = [];
        $result['code'] = 400;
        $result['type'] = "warning";
        $_POST = sanitizePostData($_POST);

        $email = $_POST['email'];


        if (!empty($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $user = new Factory();
                $compte = $user->find("users", "email", $email);

                if (!empty($compte)) {
                    $newPassword = generetor(5);
                    $data_user = [
                        'password_user' => password_hash($newPassword, PASSWORD_BCRYPT)
                    ];

                    if ($user->update("users", "code_user", $compte['code_user'], $data_user)) {

                        $data_mail = [
                            "password" => $newPassword,
                            "nom" => strtoupper($compte['nom']),
                            "lienReset" => HOME . "/login"
                        ];

                        $this->SendMail($email, "Réinitialisation de mot de passe", "reset", $data_mail);

                        $result['code'] = 200;
                        $result['type'] = "success";
                        $result['msg'] = "Un nouveau mot de passe vous a été envoyé par email.";
                    } else {
                        $result['msg'] = "Echec de réinitialisation!";
                    }
                } else {
                    $result['msg'] = "Désolé! aucun compte associé à cette adresse email. ";
                }
            } else {
                $result['msg'] = "Désolé! Cette adresse email est invalide. ";
            }
        } else {
            $result['msg'] = "Veuillez renseigner votre email.";
        }
        echo json_encode($result);
        return;
    }

    public function changePasswordUser()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $_POST = sanitizePostData($_POST);

        if (!empty($_POST['confirm_password']) && !empty($_POST['password'])) {
            if ($_POST['confirm_password'] == $_POST['password']) {
                $fc = new Factory();
                $res = $fc->update('users', 'code_user', Auth::user('id'), ['password_user' => password_hash($_POST['password'], PASSWORD_BCRYPT)]);
                if ($res) {
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Mot de passe modifié avec succes";
                } else {
                    $msg['message'] = "Echec de modification!";
                }
            } else {
                $msg['message'] = "Mot de passe de confirmation incorrect";
            }
        } else {
            $msg['message'] = "Veuillez remplire tous les champs. ";
        }
        echo json_encode($msg);
        return;
    }




    public function deconnexion()
    {

        if (Auth::check()) {
            Auth::disconect();
            echo json_encode(['code' => 200, 'message' => 'Déconnexion réussie']);
        }
        return;
    }


    // ### SEXION FONCTION

    public function modalAddFonction()
    {

        $output = "";
        $output .= Service::modalFonctionAdd();
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }


    public function addFonction()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $_POST = sanitizePostData($_POST);

        if (!empty($_POST['libelle_fonction'])) {
            extract($_POST);
            $fc = new Factory();
            $fonction = $fc->verifFonctionLibelle($libelle_fonction);

            if (empty($fonction)) {

                $code = $fc->generatorCode('fonctions', 'code_fonction');
                $data_fonction = [
                    'libelle_fonction' => strtoupper($libelle_fonction),
                    'code_fonction' => $code,
                    'description_fonction' => $description ?? "",
                    'etat_fonction' => 1,
                    'hotel_id' => Auth::user('hotel_id'),
                    'user_id' => Auth::user('id')
                ];

                if ($fc->create('fonctions', $data_fonction)) {
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Fonction enregistré avec succes";
                } else {
                    $msg['message'] = "Echec d'enregistrement!";
                }
            } else {
                $msg['message'] = "Desolé! Ce liblle de fonction existe déjà. ";
            }
        } else {
            $msg['message'] = "Veuillez remplire tous les champs. ";
        }
        echo json_encode($msg);
        return;
    }



    public function modalModifierFonction()
    {

        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['code_fonction']);
        $output = "";
        $fonction = (new Factory())->find('fonctions', 'code_fonction', $code);

        $output .= Service::modaleUpdateFonction($fonction);
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }


    public function modifierFonction()
    {
        $msg['code'] = 400;

        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['code_fonction']);
        $libelle_fonction = $_POST['libelle_fonction'];
        $description = $_POST['description'];

        if (!empty($code)) {
            if (!empty($libelle_fonction)) {
                $fn = new Factory();
                $fonction = $fn->verifFonctionLibelle($libelle_fonction);
                // var_dump($_POST,$fonction);
                // return ;
                if (empty($fonction) || $fonction['code_fonction'] == $code) {

                    $data_fonction = [
                        'libelle_fonction' => strtoupper($libelle_fonction),
                        'description_fonction' => $description
                    ];

                    if ($fn->update('fonctions', 'code_fonction', $code,  $data_fonction)) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "fonction Modifié avec succes";
                    } else {
                        $msg['type'] = "warning";
                        $msg['message'] = "Echec d'enregistrement!";
                    }
                } else {
                    $msg['type'] = "warning";
                    $msg['message'] = "Desolé! Ce liblle de fonction existe déjà. ";
                }
            } else {
                $msg['type'] = "warning";
                $msg['message'] = "Veuillez remplire tous les champs. ";
            }
        } else {
            $msg['message'] = "Erreur de donnée ! ";
        }

        echo json_encode($msg);
        return;
    }


    public function deleteFonction()
    {

        $msg['code'] = 400;
        extract($_POST);

        $code_fonction = decrypter($code_fonction);
        $fn = new Factory();
        if ($fn->update('fonctions', 'code_fonction', $code_fonction, ['etat_fonction' => 0])) {
            $msg['code'] = 200;
            $msg['type'] = "success";
            $msg['message'] = "Fonction supprimé avec succes";
        } else {
            $msg['type'] = "warning";
            $msg['message'] = "Echec de suppression!";
        }

        echo json_encode($msg);
        return;
    }



    public function loadDataRole()
    {

        $output = "";
        $_POST = sanitizePostData($_POST);
        $code_role = $_POST['code_role'];
        $code_user = $_POST['code_user'];

        $fc = new User();


        $roles = $fc->getRolesByGroupe($code_role);
        var_dump($roles, $_POST);
        return;
        $userPermissions = $fc->getAllPermissionForUser($code_user);

        $userRolesPermissions = $this->resolveTablePermission($userPermissions);
        // $output = $userRolesPermissions;

        if ($roles) {

            foreach ($roles as $data) {
                $equal = $this->checkIfExistRole($userRolesPermissions, $data);

                $c = $equal['create'] ? 'checked' : '';
                $s = $equal['show'] ? 'checked' : '';
                $e = $equal['edit'] ? 'checked' : '';
                $d = $equal['delete'] ? 'checked' : '';

                $output .= '
                <tr data-id="' . $data['code_role'] . '" >
                    <td> &nbsp; &nbsp;' . $data['name'] . '</td>
                    <td><input id="create' . $data['code_role'] . '" ' . $c . ' class="perm" data-type="create" type="checkbox"></td>
                    <td><input id="show' . $data['code_role'] . '" ' . $s . ' class="perm" data-type="show" type="checkbox"></td>
                    <td><input id="edit' . $data['code_role'] . '" ' . $e . ' class="perm" data-type="edit" type="checkbox"></td>
                    <td><input id="delete' . $data['code_role'] . '" ' . $d . ' class="perm" data-type="delete" type="checkbox"></td>
                </tr>
                ';
            }
        }

        // echo json_encode(['data' => $userRolesPermissions,'code' => 200]);
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }


    public function ajouterPermissionRole()
    {

        $output = "";
        $msg['code'] = 400;
        $userCode = $_POST['codeuser'];

        $rolesData = json_decode($_POST["roles"], true);

        if ($rolesData) {


            foreach ($rolesData as $role) {

                if ($role["create"] || $role["show"] || $role["edit"] || $role["delete"]) {
                    $dataPermissions = [
                        ':user_id' => $userCode,
                        ':role_id' => $role["role"],
                        ':create_permission' => $role["create"],
                        ':show_permission' => $role["show"],
                        ':edit_permission' => $role["edit"],
                        ':delete_permission' => $role["delete"]
                    ];
                    $role = (new Factory())->createPermission($dataPermissions);
                } else {
                    $role = (new Factory())->deletePermission($userCode, $role["role"]);
                }
            }


            $msg['type'] = "success";
            $msg['code'] = 200;
            $msg['message'] = "Operation effectuée avec succes. ";
        } else {

            $msg['type'] = "warning";
            $msg['message'] = "Erreur de validation. ";
        }

        echo json_encode($msg);

        return;
    }


    public function modalAddPermission()
    {

        $code = $_POST['code_user'];
        $html = "";
        $fc = new User();

        $user = $fc->getUser('code_user', $code);



        $fullName = $user['nom_user'] . ' ' . $user['prenom_user'];
        $groupes = $fc->groupes();

        if (!empty($groupes)) {
            $html = UserService::rolesDataGroupes($groupes, $code);
        }

        echo json_encode(['user' => $fullName, 'data' => $html, 'code' => 200]);
        return;
    }



    public function resolveTablePermission($UserPermission)
    {

        $permissions = [];

        if (empty($UserPermission)) return [];

        foreach ($UserPermission as $key => $value) {

            $permissions[$value['role_id']] = [
                'create' => $value['create_permission'],
                'edit'   => $value['edit_permission'],
                'show'   => $value['show_permission'],
                'delete' => $value['delete_permission'],
            ];
        }

        return $permissions;
    }

    public function checkIfExistRole($user_permissions, $role)
    {
        return $user_permissions[$role['code_role']] ?? ['create' => 0, 'show' => 0, 'edit' => 0, 'delete' => 0];
    }
}
