<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\MainController;
use App\Models\Factory;
use App\Services\Service;

class ControllerHotel extends MainController
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES VUES
     * SEXION POUR LES VIEWS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public  function categorieChambres()
    {

        return $this->view('hotels/categorie', ['title' => "Catégorie de chambre"]);
    }

    public  function chambres()
    {

        return $this->view('hotels/chambre', ['title' => "Chambre d'hotel"]);
    }

    public  function services()
    {

        return $this->view('hotels/service', ['title' => "Service d'hotel"]);
    }

    public  function reservation()
    {
        $code = '';
        return $this->view('receptions/hotel/reservation', ['show' =>  $code, 'title' => "Réservation d'hotel"]);
    }

    public  function addReservation()
    {

        return $this->view('receptions/hotel/verification', ['title' => "Vérification de la réservation d'hotel"]);
    }


    public  function reservationDetails($code)
    {
        // $codeReservation = decrypter($code);
        $fc = new Factory();
        $reservation = $fc->getDataByCodeReservation($code);
        if (empty($reservation)) {
            Auth::redirect('/page-not-found');
            return;
        }

        return $this->view('receptions/hotel/recap', ['title' => " Réservation d'hotel", 'reservation' => $reservation]);
    }

    public  function check($code)
    {

        if (!in_array(strtolower($code), ['in', 'out', 'history'])) {
            header('Location:' . route('page.notfound'));
            die();
        }
        return $this->view('receptions/hotel/reservation', ['show' =>  $code, 'title' => "Vérification de la réservation d'hotel"]);
    }


    public  function clients()
    {
        return $this->view('receptions/hotel/client', ['title' => "Clients"]);
    }

    public  function profile($code)
    {
        $fc = new Factory();
        $client = $fc->verifyParam('clients', 'code_client', $code);
        if (empty($client)) {
            Auth::redirect('/page-not-found');
        }
        return $this->view(
            'receptions/hotel/profile',
            ['title' => "Clients", 'client' => $client]
        );
    }

    public  function versement()
    {


        return $this->view('receptions/hotel/versement', [
            'title' => "Versement"
        ]);
    }

    public  function factureNonRegler()
    {
        return $this->view('recapt/non_regler', [
            'title' => "Versement"
        ]);
    }

    public  function reservationAnnuler()
    {
        return $this->view('recapt/res_annuler', [
            'title' => "Versement"
        ]);
    }

    public  function serviceAnnuler()
    {
        return $this->view('recapt/ser_annuler', [
            'title' => "Versement"
        ]);
    }


    public  function recaptListeChambres()
    {

        return $this->view('recapt/chambre', ['title' => "Liste des Chambres"]);
    }

    public  function recaptListeClients()
    {

        return $this->view('recapt/client', ['title' => "Liste des Clients"]);
    }

    public  function recaptListeReservations()
    {

        return $this->view('recapt/reservation', ['title' => "Liste des Reservations"]);
    }


    public  function recaptListeDepenses()
    {

        return $this->view('recapt/depense', ['title' => "Liste des Depenses"]);
    }

    public  function recaptListeServices()
    {

        return $this->view('recapt/service', ['title' => "Liste des Services"]);
    }



    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */




    // RESERVATION
    public function verification()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $_POST = sanitizePostData($_POST);

        if (!empty($_POST['date_debut']) && !empty($_POST['date_fin'])) {
            extract($_POST);
            $date = date('Y-m-d');
            if ($date_debut >= $date && $date_fin >= $date) {

                $data_chambre = [
                    'date_debut' => $date_debut,
                    'date_fin' => $date_fin,
                ];
                Auth::clean(PERIODE);
                $data = (new Factory())->verificationAbleChambre($data_chambre);
                // $heure = date('H:i:s');
                if (!empty($data)) {
                    $reservation = [
                        'date_debut' => $date_debut,
                        'date_fin' => $date_fin
                    ];
                    //ajouter data_chambre dans la session user
                    $nberDays = daysBetweenDates($date_debut, $date_fin);
                    Auth::create(PERIODE, $reservation);
                    $msg['data'] = Service::dataSearchReservation($data, $nberDays);
                    $msg['code'] = 200;
                    $msg['message'] = "Recherche effectuée avec succès!";
                } else {
                    $msg['message'] = "Désolé aucune chambre disponible pour cette periode!";
                }
            } else {
                $msg['message'] = "Désolé, date invalide";
            }
        } else {
            $msg['message'] = "Veuillez Choisir la periode";
        }

        echo json_encode($msg);
        return;
    }



    public function verificationNumber()
    {

        $msg['code'] = 400;
        $_POST = sanitizePostData($_POST);
        $output = "";
        if (!empty($_POST['telephone'])) {
            extract($_POST);
            $telephone = removeSpace($telephone);
            $telephone = str_replace('(+225)', '', $telephone);

            $client = (new Factory())->verifyParam('clients', 'telephone_client', $telephone);

            if ($client) {
                $output = Service::lookForClientExist($client);
                $msg['code'] = 200;
                $msg['data'] = $output;
            } else {
                $msg['type'] = "warning";
                $msg['message'] = "<span class='text-danger fw-200'>Aucun client trouvé avec ce numéro de téléphone!</span>";
            }
        } else {
            $msg['code'] = 400;
            $msg['type'] = "warning";
            $msg['message'] = "Veuillez entrer le numéro!";
        }
        echo json_encode($msg);
        return;
    }



    public function modalShowReservation()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $id = decrypter($id_chambre);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $output = "";

        if (Auth::user('caisse') != null) {

            if ($id) {
                $fc = new Factory();

                $data_check = [
                    'chambre_id' => $id,
                    'date_debut' => Auth::getData(PERIODE, 'date_debut'),
                    'date_fin' => Auth::getData(PERIODE, 'date_fin')
                ];

                $dataVerif = $fc->verificationAbleChambreBeforeReservation($data_check);

                if (empty($dataVerif)) {

                    Auth::create(RESERVATION, ['chambre' => $id, 'montant' => $montant]);

                    $output = Service::chargerClienForReservation();
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['data'] = $output;
                } else {
                    $msg['message'] = "Désolé, cette chambre n'est plus disponible pour cette periode";
                }
            } else {
                $msg['message'] = "Vueillez d'abord selectionner une chambre";
            }
        } else {
            $msg['message'] = "Vueillez d'abord ouvrir votre caisse";
        }


        echo json_encode($msg);
        return;
    }

    public function listeReservationsRecapt()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $start = $_POST['date_debut'];
        $end = $_POST['date_fin'];


        if (!empty($start) && !empty($end)) {


            $reservation = (new Factory())->getAllReservations($start, $end);

            if (!empty($reservation)) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Recherche effectuée avec success!";
                $msg['periode'] = crypter($start . "#" . $end);

                $msg['data'] = Service::reservationRecaptData($reservation);
            } else {
                $msg['data'] = "<tr>
    <td colspan='8' class='text-center text-danger'>Aucune reservation disponible</td> 
    </tr>";
                $msg['message'] = "Désolé, aucune reservation trouvée!";
            }
        } else {
            $msg['message'] = "Désolé, une erreur est survenue lors de la recherche!";
        }
        echo json_encode($msg);
        return;
    }

    public function listeReservations()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $start = $_POST['date_debut'];
        $end = $_POST['date_fin'];


        if (!empty($start) && !empty($end)) {


            $reservation = (new Factory())->getAllReservations($start, $end);

            if (!empty($reservation)) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Recherche effectuée avec success!";
                $msg['periode'] = crypter($start . "#" . $end);

                $msg['data'] = Service::reservationDataForSearching($reservation);
            } else {
                $msg['data'] = "<tr>
    <td colspan='9' class='text-center text-danger'>Aucune reservation disponible</td> 
    </tr>";
                $msg['message'] = "Désolé, aucune reservation trouvée!";
            }
        } else {
            $msg['message'] = "Désolé, une erreur est survenue lors de la recherche!";
        }
        echo json_encode($msg);
        return;
    }

    public function listeReservationsArrive()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $start = $_POST['date_debut'];
        $end = $_POST['date_fin'];


        if (!empty($start) && !empty($end)) {


            $reservation = (new Factory())->getAllReservationsArrive($start, $end);

            if (!empty($reservation)) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Recherche effectuée avec success!";
                $msg['periode'] = crypter($start . "#" . $end);

                $msg['data'] = Service::reservationsArrive($reservation);
            } else {
                $msg['data'] = "";
                $msg['message'] = "Désolé, aucune reservation trouvée!";
            }
        } else {
            $msg['message'] = "Désolé, une erreur est survenue lors de la recherche!";
        }
        echo json_encode($msg);
        return;
    }

    public function listeReservationsActive()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $start = $_POST['date_debut'];
        $end = $_POST['date_fin'];


        if (!empty($start) && !empty($end)) {


            $reservation = (new Factory())->getAllReservationsActive($start, $end);

            if (!empty($reservation)) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Recherche effectuée avec success!";
                $msg['periode'] = crypter($start . "#" . $end);

                $msg['data'] = Service::reservationsActive($reservation);
            } else {
                $msg['data'] = "";
                $msg['message'] = "Désolé, aucune reservation trouvée!";
            }
        } else {
            $msg['message'] = "Désolé, une erreur est survenue lors de la recherche!";
        }
        echo json_encode($msg);
        return;
    }

    public function deleteReservation()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = decrypter($_POST['code_reservation']);
        if (!empty($code)) {

            $data_reservation = [
                'statut_reservation' => STATUT_RESERVATION[2]
            ];

            $rest = (new Factory())->update("reservations", 'code_reservation', $code, $data_reservation);
            if ($rest) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Reservation annulé avec succes";
            } else {
                $msg['message'] = "Echec de traitement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }

    public function ajouterReservation()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (Auth::user('caisse') != null) {

            if (isset($_POST['client']) && !empty($_POST['client'])) {


                $fc = new Factory();

                $data_check = [
                    'chambre_id' => Auth::getData(RESERVATION, 'chambre'),
                    'date_debut' => Auth::getData(PERIODE, 'date_debut'),
                    'date_fin' => Auth::getData(PERIODE, 'date_fin')
                ];

                $dataVerif = $fc->verificationAbleChambreBeforeReservation($data_check);

                if (empty($dataVerif)) {


                    $client = $_POST['client'];
                    $date = date("Y-m-d H:i:s");
                    $codeResevation = $fc->generatorCode("reservations", "code_reservation");
                    $chambre = Auth::getData(RESERVATION, 'chambre');
                    $montant = Auth::getData(RESERVATION, 'montant');
                    $debut = Auth::getData(PERIODE, 'date_debut');
                    $fin = Auth::getData(PERIODE, 'date_fin');
                    $days = daysBetweenDates($debut, $fin);
                    $totalMontant = $montant * $days;




                    $data_servation = [
                        'chambre_id' => $chambre,
                        'client_id' => $client,
                        'etat_reservation' => 0,
                        'prix_reservation' => $montant,
                        'user_id' => Auth::user('id'),
                        'date_entree' => $debut,
                        'date_sortie' => $fin,
                        'code_reservation' => $codeResevation,
                        'hotel_id' => Auth::user("hotel_id"),
                        'statut_reservation' => STATUT_RESERVATION[0],
                        'created_reservation' => $date,
                    ];

                    if ($fc->create("reservations", $data_servation)) {
                        Auth::clean(RESERVATION);
                        Auth::clean(PERIODE);

                        $output = Service::chargerFactureForReservation($codeResevation, $totalMontant);

                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['data'] = $output;
                        $msg['message'] = "Reservation effectuée avec succès";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
                } else {
                    $msg['message'] = "Désolé, cette chambre n'est plus disponible pour cette periode";
                }
            } else {
                $msg['message'] = "Désolé, aucun client selectionné";
            }
        } else {
            $msg['message'] = "Veuillez D'abord ouvrir votre caisse!";
        }

        echo json_encode($msg);
    }

    public function addNewClient()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (Auth::user('caisse') != null) {

            if (!empty($_POST['nom_client']) && !empty($_POST['telephone_client']) && !empty($_POST['genre_client'])) {
                extract($_POST);
                $telephone = removeSpace($telephone_client);
                $telephone = str_replace('(+225)', '', $telephone);

                if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {

                    $fc = new Factory();

                    $client = $fc->verifyParam('clients', 'telephone_client', $telephone);

                    if ($client) {
                        $output = Service::lookForClientExist($client);
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['data'] = $output;
                        $msg['message'] = "Ce client existe déjà ";
                    } else {


                        if (!empty($type_piece) && empty($piece_client)) {
                            $msg['message'] = "Veuillez renseiller la piece. ";
                        } else {

                            $date = date("Y-m-d H:i:s");
                            $codeCient = $fc->generatorCode("clients", "code_client");

                            $data_client = [
                                'nom_client' => strtoupper($nom_client),
                                'telephone_client' => $telephone,
                                'code_client' => $codeCient,
                                'hotel_id' => Auth::user("hotel_id"),
                                'genre_client' => $genre_client,
                                'type_piece' => $type_piece ?? null,
                                'piece_client' => $piece_client ?? null,
                                'created_client' => $date
                            ];

                            if ($fc->create('clients', $data_client)) {

                                $output = Service::lookForClientExist($data_client);


                                // $chambre = Auth::getData(RESERVATION, 'chambre');
                                // $montant = Auth::getData(RESERVATION, 'montant');
                                // $debut = Auth::getData(PERIODE, 'date_debut');
                                // $fin = Auth::getData(PERIODE, 'date_fin');
                                // $days = daysBetweenDates($debut, $fin);
                                // $totalMontant = $montant * $days;


                                // Auth::clean(RESERVATION);
                                // Auth::clean(PERIODE);

                                // $output = Service::chargerFactureForReservation($codeResevation, $totalMontant);


                                $msg['code'] = 200;
                                $msg['type'] = "success";
                                $msg['data'] = $output;
                                $msg['message'] = "Client enregistré avec succès";
                            } else {
                                $msg['message'] = "Désolé, erreur d'enregistrement du client";
                            }
                        }
                    }
                } else {
                    $msg['message'] = "Numero de telephone invalide.";
                }
            } else {
                $msg['message'] = "Veuillez remplire tous les champs.";
            }
        } else {
            $msg['message'] = "Veuillez D'abord ouvrir votre caisse!";
        }
        echo json_encode($msg);
    }

    public function modalUpdateReservation()
    {
        extract($_POST);
        if (!empty($code_reservation)) {
            $fc = new Factory();
            $output = "";
            $data = $fc->getDataByCodeReservation($code_reservation);
            $output .= Service::chargerFrmModifierReservation($data);
        }
        // $output = Service::frmUpdateReservation($code_reservation);
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function factureReservtion()
    {

        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['code']);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $montant = 0;

        if (Auth::user('caisse') != null) {

            if (!empty($code)) {
                $fc = new Factory();
                $ser = $fc->verifyParam2('consommations', 'reservation_id', 'etat_consommation', $code, 0);
                $reserve = $fc->verifyParam2('reservations', 'code_reservation', 'etat_reservation', $code, 0);
                if (!empty($ser) || !empty($reserve)) {

                    if (!empty($_POST['type_paiement'])) {

                        $fc = new Factory();

                        $res = $fc->getDataByCodeReservation($code);
                        $conso = $fc->getDataFactureServiceForClient($code);



                        if (!empty($res) && $res['etat_reservation'] == 0) {
                            $days = daysBetweenDates($res['date_entree'], $res['date_sortie']);
                            $montant += $res['prix_chambre'] * $days;
                        }

                        if (!empty($conso) && !empty($conso['total'])) {
                            $montant += $conso['total'];
                        }

                        $code_facture = random_int(10, 99999999);


                        if ($_POST['montant_payer'] >= $montant) {

                            $data_facture = [
                                "code_facture" => $code_facture,
                                "reservation_id" => $code,
                                "montant_total" => $montant,
                                "mode_paiement" => $_POST['type_paiement'],
                                "created_facture" => date('Y-m-d H:i:s'),
                                "hotel_id" => Auth::user('hotel_id'),
                                "versement_id" => Auth::user('caisse'),
                            ];

                            $fc->transactReservationConfirme($data_facture, $code);

                            $msg['code'] = 200;
                            $msg['reservation'] = $code;
                            $msg['message'] = "Reservation confirmée avec succeès";
                        } else {
                            $msg['message'] = "Désolé montant inferieur! ";
                        }
                    } else {
                        $msg['message'] = "Veuillez bien renseigner tous les champs!";
                    }
                } else {
                    $msg['message'] = "La facture a déjà été reglée! ⚠";
                }
            } else {
                $msg['message'] = "Désolé, erreur de verification donnée!";
            }
        } else {
            $msg['message'] = "Veuillez D'abord ouvrir votre caisse!";
        }

        echo json_encode($msg);
        return;
    }

    public function confirmReservation()
    {
        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['code_reservation']);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (Auth::user('caisse') != null) {

            if (!empty($code)) {
                $fc = new Factory();
                $totalMontant = 0;

                $res = $fc->getDataByCodeReservation($code);
                $conso = $fc->getDataFactureServiceForClient($code);
                if (!empty($res) && $res['etat_reservation'] == 0) {
                    $days = daysBetweenDates($res['date_entree'], $res['date_sortie']);
                    $totalMontant += $res['prix_chambre'] * $days;
                }

                if (!empty($conso) && !empty($conso['total'])) {
                    $totalMontant += $conso['total'];
                }


                if ($totalMontant > 0) {

                    $output = Service::chargerFactureForReservation($code, $totalMontant);

                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['data'] = $output;
                } else {
                    $msg['message'] = "La facture a déjà été reglée! ⚠";
                }
            } else {
                $msg['message'] = "Désolé erreur de verification donnée!";
            }
        } else {
            $msg['message'] = "Veuillez D'abord ouvrir votre caisse!";
        }
        echo json_encode($msg);
        return;
    }

    public function modalServiceReservation()
    {
        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['code_reservation']);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (Auth::user('caisse') != null) {

            if (!empty($code)) {

                $fc = new Factory();
                $services = $fc->getAllServices();



                $output = Service::modalAddServiceReservation($services, $code);

                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['data'] = $output;
                $msg['services'] = $services;
            } else {
                $msg['message'] = "Désolé erreur de verification donnée!";
            }
        } else {
            $msg['message'] = "Veuillez D'abord ouvrir votre caisse!";
        }
        echo json_encode($msg);
        return;
    }

    public function attribuerServiceReservation()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        extract($_POST);

        if (Auth::user('caisse') != null) {

            if (!empty($reservation)) {
                if (!empty($service) && !empty($qte_service)) {
                    if (ctype_digit($qte_service) && $qte_service > 0) {

                        $fc = new Factory();
                        $res = $fc->verifyParam('services', 'code_service', $service);
                        $code = $fc->generatorCode('consommations', 'code_consommation');

                        $data_consommation = [
                            'reservation_id' => $reservation,
                            'service_id' => $service,
                            'quantite_consommation' => $qte_service,
                            'prix_consommation' => $res['prix_service'],
                            'code_consommation' => $code,
                            'etat_consommation' => 0,
                            'created_consommation' => date('Y-m-d H:i:s'),
                            'hotel_id' => Auth::user('hotel_id'),
                            'user_id' => Auth::user('id'),
                            'versement_id' => Auth::user('caisse')

                        ];

                        if ($fc->create('consommations', $data_consommation)) {

                            $msg['code'] = 200;
                            $msg['type'] = "success";
                            $msg['message'] = "Service attribuer avec success";
                        } else {
                            $msg['message'] = "Désolé erreur de traitement!";
                        }
                    } else {
                        $msg['message'] = "Désolé quantité inferieur ou vide!";
                    }
                } else {
                    $msg['message'] = "Désolé vueillez renseigner tous les champs!";
                }
            } else {
                $msg['message'] = "Désolé erreur de verification donnée!";
            }
        } else {
            $msg['message'] = "Veuillez D'abord ouvrir votre caisse!";
        }
        echo json_encode($msg);
        return;
    }

    public function modalModifierServiceReservation()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $code = $_POST['code'];

        if (!empty($code)) {

            $fc = new Factory();
            $services = $fc->getAllServices();
            $consommation = $fc->verifyParam('consommations', 'code_consommation', $code);

            $output = Service::modalModifierServiceReservation($services, $consommation);

            $msg['code'] = 200;
            $msg['type'] = "success";
            $msg['data'] = $output;
            $msg['services'] = $services;
        } else {
            $msg['message'] = "Désolé erreur de verification donnée!";
        }
        echo json_encode($msg);
        return;
    }

    public function deleteServiceClient()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = $_POST['code_consommation'];
        if (!empty($code)) {

            $data_consommation = [
                'etat_consommation' => 2
            ];

            $rest = (new Factory())->update("consommations", 'code_consommation', $code, $data_consommation);
            if ($rest) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Service annulé avec succes";
            } else {
                $msg['message'] = "Echec de traitement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }

    public function modalReglerNoteServiceReservation()
    {
        $_POST = sanitizePostData($_POST);
        $code = $_POST['code'];
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (Auth::user('caisse') != null) {

            if (!empty($code)) {

                $fc = new Factory();
                $res = $fc->getDataFactureServiceForClient($code);
                if (!empty($res) && !empty($res['total'])) {
                    $totalMontant = $res['total'];

                    $output = Service::chargerFactureForService($code, $totalMontant);

                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['data'] = $output;
                } else {
                    $msg['message'] = "Désolé aucune facture disponible!";
                }
            } else {
                $msg['message'] = "Désolé erreur de verification donnée!";
            }
        } else {
            $msg['message'] = "Veuillez D'abord ouvrir votre caisse!";
        }
        echo json_encode($msg);
        return;
    }

    public function reglerFactureServiceReservtion()
    {

        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['code']);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (Auth::user('caisse') != null) {


            if (!empty($code)) {
                $fc = new Factory();

                $ser = $fc->verifyParam2('consommations', 'reservation_id', 'etat_consommation', $code, 0);

                if (!empty($ser)) {

                    if (!empty($_POST['type_paiement'])) {

                        $res = $fc->getDataFactureServiceForClient($code);


                        if ($_POST['montant_payer'] >= $res['total']) {
                            $code_facture = random_int(10, 99999999);

                            $data_facture = [
                                "code_facture" => $code_facture,
                                "reservation_id" => $code,
                                "montant_total" => $res['total'],
                                "mode_paiement" => $_POST['type_paiement'],
                                "created_facture" => date('Y-m-d H:i:s'),
                                "hotel_id" => Auth::user('hotel_id'),
                                "versement_id" => Auth::user('caisse'),
                            ];

                            $fc->transactReservationService($data_facture, $code);

                            $msg['code'] = 200;
                            $msg['type'] = 'success';
                            $msg['message'] = "Operation effectuée avec succès";
                        } else {
                            $msg['message'] = "Désolé montant inferieur! ";
                        }
                    } else {
                        $msg['message'] = "Veuillez bien renseigner tous les champs!";
                    }
                } else {
                    $msg['message'] = " La facture a déjà été reglée ! ⚠";
                }
            } else {
                $msg['message'] = "Désolé, erreur de verification donnée!";
            }
        } else {
            $msg['message'] = "Veuillez D'abord ouvrir votre caisse!";
        }

        echo json_encode($msg);
        return;
    }

    public function modifierServiceForReservation()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        extract($_POST);

        if (!empty($consommation)) {
            if (!empty($service) && !empty($qte_service)) {
                if (ctype_digit($qte_service) && $qte_service > 0) {

                    $fc = new Factory();
                    $res = $fc->verifyParam('services', 'code_service', $service);


                    $data_consommation = [
                        'service_id' => $service,
                        'quantite_consommation' => $qte_service,
                        'prix_consommation' => $res['prix_service'],
                    ];

                    if ($fc->update('consommations', 'code_consommation', $consommation, $data_consommation)) {

                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Operation effectuée avec success";
                    } else {
                        $msg['message'] = "Désolé erreur de traitement!";
                    }
                } else {
                    $msg['message'] = "Désolé quantité inferieur ou vide!";
                }
            } else {
                $msg['message'] = "Désolé vueillez renseigner tous les champs!";
            }
        } else {
            $msg['message'] = "Désolé erreur de verification donnée!";
        }
        echo json_encode($msg);
        return;
    }

    public function modalDetailsVersement()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);
        if (!empty($code)) {
            $fc = new Factory();
            $output = "";

            $reservations = $fc->getAllDetailesVersementReservationsForUser($code);
            $services = $fc->getAllDetailsVersementServicesForUser($code);

            $output = Service::modalDataDetailsVersement($reservations, $services);
        }
        // $output = Service::frmUpdateReservation($code_reservation);
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    // debut client 

    public function listeClientsRecapt()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $start = $_POST['date_debut'];
        $end = $_POST['date_fin'];


        if (!empty($start) && !empty($end)) {
            $clients = (new Factory())->getAllClient($start, $end);

            if (!empty($clients)) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Recherche effectuée avec succès!";
                $msg['periode'] = crypter($start . "#" . $end);

                $msg['data'] = Service::clientRecaptData($clients);
            } else {
                $msg['data'] = "<tr>
        <td colspan='8' class='text-center text-danger'>Aucun client disponible</td> 
        </tr>";
                $msg['message'] = "Désolé, aucun client trouvé!";
            }
        } else {
            $msg['message'] = "Désolé, une erreur est survenue lors de la recherche!";
        }
        echo json_encode($msg);
        return;
    }
    public function listeClients()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $start = $_POST['date_debut'];
        $end = $_POST['date_fin'];


        if (!empty($start) && !empty($end)) {
            $clients = (new Factory())->getAllClient($start, $end);

            if (!empty($clients)) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Recherche effectuée avec succès!";
                $msg['periode'] = crypter($start . "#" . $end);

                $msg['data'] = Service::clientDataForSearching($clients);
            } else {
                $msg['data'] = "<tr>
        <td colspan='9' class='text-center text-danger'>Aucun client disponible</td> 
        </tr>";
                $msg['message'] = "Désolé, aucun client trouvé!";
            }
        } else {
            $msg['message'] = "Désolé, une erreur est survenue lors de la recherche!";
        }
        echo json_encode($msg);
        return;
    }

    public function updateClient()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";


        if (!empty($_POST['code_client'])) {

            extract($_POST);

            if (!empty($_POST['nom']) && !empty($_POST['telephone']) && !empty($_POST['genre'])) {

                $telephone = removeSpace($telephone);
                $telephone = str_replace('(+225)', '', $telephone);

                if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {


                    if (!empty($type_piece) && empty($piece)) {
                        $msg['message'] = "Vueillez bien renseigner le numero de piece!";
                    } else {
                        $fc = new Factory();

                        $client = $fc->verifyParam2("clients", "hotel_id", 'telephone_client', Auth::user('hotel_id'), $telephone);

                        if (empty($client) || $code_client == $client['code_client']) {
                            $data_client = [
                                "nom_client" => $nom,
                                "type_piece" => $type_piece,
                                "piece_client" => $piece,
                                "telephone_client" => $telephone,
                                "genre_client" => $genre
                            ];
                            $res = $fc->update("clients", "code_client", $code_client, $data_client);
                            if ($res || $res == 0) {
                                $msg['code'] = 200;
                                $msg['type'] = "success";
                                $msg['message'] = "Information client modifiée avec succès!";
                            } else {
                                $msg['message'] = "Désolé, une erreur est survenue lors du traitement!";
                            }
                        } else {
                            $msg['message'] = "Désolé, ce numero appartient déjà à un autre client! ";
                        }
                    }
                } else {
                    $msg["message"] = "Le numero de telephone doit etre composé de 10 chiffres";
                }
            } else {
                $msg['message'] = "Vueillez bien renseigner tous les champs!";
            }
        } else {
            $msg["message"] = "Désolé, une erreur est survenue lors du traitement!";
        }
        echo json_encode($msg);
        return;
    }

    // fin client
    // debut service



    public function modalAddService()
    {
        $output = "";

        $output = Service::modalAddService();
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function ajouterServices()
    {
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $_POST = sanitizePostData($_POST);

        if (!empty($_POST['libelle_service']) && !empty($_POST['prix_service'])) {
            extract($_POST);
            if (ctype_digit($prix_service) && $prix_service > 0) {

                $fc = new Factory();

                $service = $fc->verifServiceLibelle($libelle_service);

                if (empty($service)) {
                    $code = $fc->generatorCode("services", "code_service");
                    $description = !empty($description_service) ?
                        ucfirst($description_service) : null;
                    $data_service = [
                        'libelle_service' => strtoupper($libelle_service),
                        'etat_service' => 1,
                        'code_service' => $code,
                        'prix_service' => $prix_service,
                        'hotel_id' => Auth::user('hotel_id'),
                        'user_id' => Auth::user('id'),
                        'description_service' => $description
                    ];

                    if ($fc->create('services', $data_service)) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Service enregistré avec succes";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
                } else {
                    $msg['message'] = "Service deja enregistré!";
                }
            } else {
                $msg['message'] = "Desolé! Montant invalide";
            }
        } else {
            $msg['message'] = "Veuillez rensigner tous les champs. ";
        }

        echo json_encode($msg);
        return;
    }

    public function modalUpdateService()
    {

        $_POST = sanitizePostData($_POST);

        $code = decrypter($_POST['code']);
        $result['code'] = 400;
        $output = "";
        if ($code) {
            $fc = new Factory();
            $service = $fc->verifyParam('services', 'code_service', $code);
            if (!empty($service)) {
                $output = Service::modalUpdateService($service);
                $result['data'] = $output;
                $result['code'] = 200;
            }

            echo json_encode($result);
            return;
        }
    }

    public function updateService()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = decrypter($_POST['id_service']);

        if (!empty($code)) {

            if (!empty($_POST['libelle_service']) && !empty($_POST['prix_service'])) {
                extract($_POST);

                if (ctype_digit($prix_service) && $prix_service > 0) {

                    $fc = new Factory();

                    $service = $fc->verifServiceLibelle($libelle_service);

                    if (empty($service) || ($code == $service['code_service'])) {

                        $data_service = [
                            'libelle_service' => strtoupper($libelle_service),
                            'prix_service' => strtoupper($prix_service),
                            'description_service' => ucfirst($description_service),
                        ];

                        $rest = $fc->update("services", 'code_service', $code, $data_service);

                        if ($rest) {
                            $msg['code'] = 200;
                            $msg['type'] = "success";
                            $msg['message'] = "Service modifiée avec succes";
                        } else {
                            $msg['message'] = "Echec d'enregistrement!";
                        }
                    } else {
                        $msg['message'] = "Desolé! Ce service existe déjà. ";
                    }
                } else {
                    $msg['message'] = "Desolé! Montant invalide";
                }
            } else {
                $msg['message'] = "Veuillez remplire tous les champs. ";
            }
        } else {
            $msg['message'] = "Erreur de donnée, vueillez ressayer plus tard. ";
        }

        echo json_encode($msg);
        return;
    }

    public function deleteService()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = decrypter($_POST['id_service']);
        if (!empty($code)) {

            $data_service = [
                'etat_service' => 0
            ];
            $rest = (new Factory())->update("services", 'code_service', $code, $data_service);
            if ($rest) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Service Supprimée avec succes";
            } else {
                $msg['message'] = "Echec d'enregistrement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }

    // fin service

    public function modalAddCategorie()
    {
        $output = "";

        $output = Service::modalAddTypechambre();
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function ajouterCategorieChambre()
    {
        $msg['code'] = 400;
        $_POST = sanitizePostData($_POST);


        if (!empty($_POST['libelle_categorie'])) {
            extract($_POST);

            $fc = new Factory();

            $categorie = $fc->verifTypechambreLibelle($libelle_categorie);

            if (empty($categorie)) {
                $code = $fc->generatorCode("type_chambres", "code_typechambre");
                $description = !empty($description_categorie) ?
                    ucfirst($description_categorie) : null;
                $data_categorie = [
                    'libelle_typechambre' => strtoupper($libelle_categorie),
                    'etat_typechambre' => 1,
                    'code_typechambre' => $code,
                    'hotel_id' => Auth::user('hotel_id'),
                    'description_typechambre' => $description
                ];

                if ($fc->create('type_chambres', $data_categorie)) {
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Categorie enregistré avec succes";
                } else {
                    $msg['type'] = "warning";
                    $msg['message'] = "Echec d'enregistrement!";
                }
            } else {

                $msg['type'] = "warning";
                $msg['message'] = "Desolé! Cette categorie existe déjà. ";
            }
        } else {
            $msg['type'] = "warning";
            $msg['message'] = "Veuillez remplire tous les champs. ";
        }
        echo json_encode($msg);
    }

    public function modalUpdateCategorie()
    {

        $_POST = sanitizePostData($_POST);

        $code = decrypter($_POST['code']);
        $result['code'] = 400;
        $output = "";
        if ($code) {
            $fc = new Factory();
            $categorie = $fc->verifyParam('type_chambres', 'code_typechambre', $code);
            if (!empty($categorie)) {
                $output = Service::modalUpdateTypeCategorie($categorie);
                $result['data'] = $output;
                $result['code'] = 200;
            }

            echo json_encode($result);
            return;
        }
    }

    public function updateCategoriChammbre()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = decrypter($_POST['id_categorie']);

        if (!empty($code)) {

            if (!empty($_POST['libelle_categorie'])) {
                extract($_POST);

                $fc = new Factory();

                $categorie = $fc->verifTypechambreLibelle($libelle_categorie);

                if (empty($categorie) || ($code == $categorie['code_typechambre'])) {

                    $data_categorie = [
                        'libelle_typechambre' => strtoupper($libelle_categorie),
                        'description_typechambre' => ucfirst($description_categorie),
                    ];

                    $rest = $fc->update("type_chambres", 'code_typechambre', $code, $data_categorie);

                    if ($rest) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Categorie chambre modifiée avec succes";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
                } else {
                    $msg['message'] = "Desolé! Cette categorie existe déjà. ";
                }
            } else {
                $msg['message'] = "Veuillez remplire tous les champs. ";
            }
        } else {
            $msg['message'] = "Erreur de donnée, vueillez ressayer plus tard. ";
        }

        echo json_encode($msg);
        return;
    }

    public function deleteCategorieChammbre()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = decrypter($_POST['id_categorie']);
        if (!empty($code)) {

            $data_categorie = [
                'etat_typechambre' => 0
            ];
            $rest = (new Factory())->update("type_chambres", 'code_typechambre', $code, $data_categorie);
            if ($rest) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Categorie chambre Supprimée avec succes";
            } else {
                $msg['message'] = "Echec d'enregistrement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }

    public function addtoImage()
    {
        return false;
        if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {

            $file = $_FILES['file'];
            $valideExtension = ["jpg", "jpeg", "png"];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            if (in_array($extension, $valideExtension) || $file['size'] < 3000000) {
                $name = rand() . '.' . $extension;
                $to = "../assets/images/categorie/" . $name;
                $from = $file['tmp_name'];
                $path = "../assets/images/categorie/";

                if (!file_exists($path)) {
                    mkdir($path, 511, true);
                    $to = $path . $name;
                }

                move_uploaded_file($from, $to);
            } else {
                $msg['type'] = "alert-warning";
                $msg['message'] = "Fichier image invalide ou la taille trop volumineuse";
            }
        }
    }
    public function updatetoImage()
    {
        if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {

            $file = $_FILES['file'];
            $valideExtension = ["jpg", "jpeg", "png"];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            if (in_array($extension, $valideExtension) || $file['size'] < 3000000) {
                $name = rand() . '.' . $extension;
                $to = "../assets/images/categorie/" . $name;
                $from = $file['tmp_name'];
                $path = "../assets/images/categorie/";

                if (!file_exists($path)) {
                    mkdir($path, 511, true);
                    $to = $path . $name;
                }

                move_uploaded_file($from, $to);
            } else {
                $msg['type'] = "alert-warning";
                $msg['message'] = "Fichier image invalide ou la taille trop volumineuse";
            }
        }
    }

    public function modalAddChambre()
    {

        $output = "";
        $result['code'] = 200;
        $categories = (new Factory())->getAllCategoriesChambre();

        if (!empty($categories)) {
            $output = Service::modalAddChambreHotel($categories);;
            $result['data'] = $output;
        }

        echo json_encode($result);
        return;
    }

    public function ajouterChambre()
    {
        // $chambre = $_POST;
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";


        if (!empty($_POST['libelle_chambre']) && !empty($_POST['categorie']) && !empty($_POST['prix_chambre'])) {
            extract($_POST);
            if (ctype_digit($prix_chambre) && $prix_chambre > 0) {
                $fc = new Factory();
                if (empty($fc->verifChambreLibelle($libelle_chambre, $categorie))) {

                    $code = $fc->generatorCode('chambres', 'code_chambre');
                    $date = date('Y-m-d H:i:s');
                    $image_chambre = "123";

                    $data_chambre = [
                        'libelle_chambre' => strtoupper($libelle_chambre),
                        'telephone_chambre' => $telephone_chambre,
                        'code_chambre' => $code,
                        'etat_chambre' => 1,
                        'prix_chambre' => $prix_chambre,
                        'typechambre_id' => $categorie,
                        'statut_chambre' => 0,
                        'image_chambre' => $image_chambre,
                        'created_chambre' => $date,
                        'updated_chambre' => $date,
                        'hotel_id' => Auth::user('hotel_id'),
                    ];

                    if ($fc->create('chambres', $data_chambre)) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Chambre enregistrée avec succes";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
                } else {
                    $msg['message'] = "Desolé! Cette chambre existe déjà. ";
                }
            } else {
                $msg['message'] = "Desolé! montant invalide. ";
            }
        } else {
            $msg['message'] = "Veuillez renseigner tous les champs. ";
        }
        echo json_encode($msg);
        return;
    }

    public function modalUpdateChambre()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $code = decrypter($id_chambre);

        if ($code) {
            $fc = new Factory();
            $output = "";
            $categories = $fc->getAllCategoriesChambre();

            $chambre = $fc->find('chambres', 'code_chambre', $code);
            $output = Service::frmUpdateChambre($categories, $chambre);
        }
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function updateChambre()
    {
        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['id_chambre']);
        $msg['code'] = 400;
        $msg['type'] = "warning";


        if (!empty($code)) {
            if (!empty($_POST['libelle_chambre']) && !empty($_POST['categorie']) && !empty($_POST['prix_chambre'])) {
                extract($_POST);
                if (ctype_digit($prix_chambre) && $prix_chambre > 0) {

                    $fc = new Factory();

                    $chambre = $fc->verifChambreLibelle($libelle_chambre, $categorie);


                    if (empty($chambre) || $chambre['code_chambre'] == $code) {
                        $image_chambre = "123";
                        $data_chambre = [
                            'libelle_chambre' => strtoupper($libelle_chambre),
                            'typechambre_id' => $categorie,
                            'prix_chambre' => $prix_chambre,
                            'image_chambre' => $image_chambre,
                            'telephone_chambre' => $telephone_chambre
                        ];

                        if ($fc->update('chambres', 'code_chambre', $code, $data_chambre)) {
                            $msg['code'] = 200;
                            $msg['type'] = "success";
                            $msg['message'] = "Chambre modifiée avec succes";
                        } else {
                            $msg['message'] = "Echec d'enregistrement!";
                        }
                    } else {
                        $msg['message'] = "Desolé! Ce libelle chambre existe déjà";
                    }
                } else {
                    $msg['message'] = "Desolé! montant invalide.";
                }
            } else {
                $msg['message'] = "Veuillez renseigner tous les champs. ";
            }
        } else {
            $msg['message'] = "Erreur de verification.";
        }

        echo json_encode($msg);
        return;
    }

    public function deleteChammbre()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = decrypter($_POST['id_chambre']);
        if (!empty($code)) {

            $data_chambre = [
                'etat_chambre' => 0
            ];
            $rest = (new Factory())->update("chambres", 'code_chambre', $code, $data_chambre);
            if ($rest) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Chambre Supprimée avec succes";
            } else {
                $msg['message'] = "Echec d'enregistrement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }
}
