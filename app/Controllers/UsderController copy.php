<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Gqr;
use App\Core\MainController;
use App\Models\Factory;
use App\Services\Service;
use Roles;

class UserControllerumm extends MainController
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

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
        $this->view('admins/user', ['title' => "Liste des utilisateurs"]);
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

    public function login()
    {
        return $this->viewGuest('auth/login', ["title" => "connexion"]);
    }

    public function register()
    {
        return $this->viewGuest('auth/register', ["title" => "Création de compte"]);
    }

    public function resetPassword()
    {
        return $this->viewGuest('auth/reset', ["title" => "Création de compte"]);
    }

    public function changePassword()
    {
        return $this->viewGuest('auth/change', ["title" => "Création de compte"]);
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

    public function updateHotel()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (!empty($_POST["libelle_hotel"]) && !empty($_POST["telephone_hotel"])) {
            extract($_POST);
            if (ctype_digit($telephone_hotel) && mb_strlen($telephone_hotel) == 10) {

                $fc = new Factory();
                $statut_filigramme = isset($statut_filigramme) ? 1 : 0;

                $data_hotel = [
                    'libelle_hotel' => $libelle_hotel,
                    'adresse_hotel' => $adresse_hotel,
                    'telephone_hotel' => $telephone_hotel,
                    'telephone_hotel2' => $telephone_hotel2,
                    'email_hotel' => $email_hotel,
                    'filigramme' => $filigramme,
                    'statut_filigramme' => $statut_filigramme,
                ];

                $res = $fc->update('hotels', "code_hotel", Auth::user("hotel_id"), $data_hotel);

                if ($res || $res == 0) {

                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Informations mises à jour avec succes";
                } else {
                    $msg['message'] = "Echec de mise à jour!";
                }
            } else {
                $msg["message"] = "Le numero de telephone doit etre un numero de telephone valide!";
            }
        } else {

            $msg["message"] = "Veuillez renseigner tous les champs!";
        }

        echo json_encode($msg);
        return;
    }

    public function updateLogo()
    {
        // $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        header('Content-Type: application/json');

        $file      = $_FILES['image_logo'];
        $fileName  = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize  = $file['size'];
        $fileError = $file['error'];

        // var_dump($file,$fileName,$fileTmp,$fileSize,$fileError);
        // return;

        if (isset($file) && $fileError === 0 && $fileSize > 0) {

            if (verifyExt($fileName)) {
                if ($fileSize <= 2000000) {

                    $cheminDossier = __DIR__ . THREE_PIP . 'assets/';
                    $url =  'img/' . Auth::user("hotel_id") . '/logo/';
                    $uploadDir = $cheminDossier . $url; // dossier où enregistrer les fichiers

                    if (creerDossierSiNonExistant($uploadDir)) {

                        $dataFileName = Auth::user("hotel_id") . '.' . getExt($fileName);
                        $filePath = $uploadDir . $dataFileName;

                        if (move_uploaded_file($fileTmp, $filePath)) {
                            $fc = new Factory();
                            $res = $fc->update('hotels', "code_hotel", Auth::user("hotel_id"), ['logo_hotel' => $url . $dataFileName]);
                            if ($res || $res == 0) {

                                $msg['code'] = 200;
                                $msg['type'] = "success";
                                $msg['message'] = "Logo enregistré avec succès !";
                            } else {

                                $msg['message'] = "Erreur lors de l'enregistrement de l'image.";
                            }
                        } else {

                            $msg['message'] = "Erreur lors du telechargement du fichier.";
                        }
                    } else {
                        $msg['message'] = "désolé, Impossible de telecharger le fichier.";
                    }
                } else {
                    $msg['message'] = "désolé, la taille maximum du fichier est de 2Mo.";
                }
            } else {
                $msg['message'] = "Le fichier n'est pas une image valide.";
            }
        } else {

            $msg['message'] = "désolé, une erreur est survenue lors de l'envoi.";
        }


        echo json_encode($msg);
        return;
    }

    public function modalAddUser()
    {


        // $users = getAllusers();
        $fonctions = (new Factory())->getAllFonctions();
        // $services = getAllServices();

        $output = Service::userAddModalService($fonctions);
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }


    public function addUser()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $_POST = sanitizePostData($_POST);
        $user = new Factory();

        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['telephone']) && !empty($_POST['email']) && !empty($_POST['sexe']) && !empty($_POST['fonction']) && !empty($_POST['matricule'])) {
            extract($_POST);
            $telephone = removeSpace($telephone);
            $telephone = str_replace('(+225)', '', $telephone);

            // if (isValidPhoneNumber($telephone)) {
            if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {
                $userTel = $user->find('users', 'telephone', $telephone);

                if (empty($userTel)) {

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $userEmail = $user->find('users', 'email', $email);

                        if (empty($userEmail)) {

                            $passwrod = generetor(5);
                            $code = $user->generatorCode('users', 'code_user');
                            $token = generetor(random_int(50, 70));

                            $data_user = [
                                'nom' => strtoupper($nom),
                                'prenom' => strtoupper($prenom),
                                'telephone' => $telephone,
                                'code_user' => $code,
                                'email' => $email,
                                'matricule' => strtoupper($matricule),
                                'sexe' => $sexe,
                                'fonction_id' => $fonction,
                                'hotel_id' => Auth::user('hotel_id'),
                                'etat_user' => 0,
                                'password_user' => password_hash($passwrod, PASSWORD_BCRYPT),
                                'token' => $token,
                                'created_user' => date('Y-m-d'),
                                'lastime' => date('Y-m-d')
                            ];

                            if ($user->create("users", $data_user)) {

                                $hotel =   $user->getInfoHotel(Auth::user('hotel_id'));

                                $data_mail = [
                                    "appName" => $_ENV["APP_NAME"],
                                    "hotel_name" => $hotel['libelle_hotel'],
                                    "email" => $email,
                                    "password" => $passwrod,
                                    "nom" => strtoupper($nom . " " . $prenom),
                                    "lienActivation" => HOME . "/activation/{$token}"
                                ];


                                $this->SendMail($email, "Création de compte", "activation", $data_mail);


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
            $fc = new Factory();
            // $fc->setKey('code_user');
            $user = [];

            $user = (filter_var($login, FILTER_VALIDATE_EMAIL)) ? $fc->getUserDataForLogin('email', $login) : $fc->getUserDataForLogin('telephone', $login);

            if (!empty($user) && password_verify($password, $user['password_user'])) {
                $groupes = [];
                $roles = [];

                // Vérifier si le compte est actif
                if (($user['etat_hotel'] == 1) || ($user['code_user'] == $user['hotel_id'])) {

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


                    $caisse = $fc->getEtatCaisseUser($user['code_user'], $user['hotel_id']);
                    if (!empty($caisse) && $caisse['cloture'] == null) {
                        $etatCaise = $caisse['code_versement'];
                    }

                    Auth::login($user, $groupes, $roles, $etatCaise);
                    $result['activityYear'] = $fc->getYearActivityStart($user['hotel_id']);
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
}
