<?php

namespace App\Models;

use App\Core\Auth;
use App\Core\Model;
use Exception;
use Roles;

class Factory extends Model
{
    protected string $table = "hotels";
    public string $id = 'code_hotel';








    /**
     * Get all reservations of a room between two dates
     *
     * @param string $dstart Start date of the period
     * @param string $dend End date of the period
     * @return array List of reservations
     */
    public  function clientDataReservation($codeCient)
    {
        $data = [];
        try {
            $sql = "SELECT r.*, COALESCE(SUM(co.prix_consommation * co.quantite_consommation), 0) AS montant_services
        FROM reservations r
        INNER JOIN chambres ch ON ch.code_chambre = r.chambre_id
        LEFT JOIN consommations co ON co.reservation_id = r.code_reservation 
        LEFT JOIN services s ON s.code_service = co.service_id 
        WHERE  r.hotel_id = :hotel_id AND  r.client_id = :client_id  
        GROUP BY r.code_reservation
         ORDER BY r.created_reservation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'client_id' => $codeCient,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllServicesOfReservationsroom($reservation)
    {
        $data = [];
        try {
            $sql = "SELECT r.date_sortie, s.libelle_service, conso.*
     FROM reservations r
        JOIN consommations conso ON conso.reservation_id = r.code_reservation
        JOIN services s ON s.code_service = conso.service_id
        WHERE conso.reservation_id = :reservation_id AND r.hotel_id =:hotel_id  ORDER BY conso.created_consommation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'reservation_id' => $reservation,

                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getVersementUserToPrint($codeVersement)
    {
        $data = [];
        try {
            $sql = "SELECT v.* , CONCAT(u.nom,' ',u.prenom) AS user, CONCAT(cp.nom,' ',cp.prenom) AS cmpt FROM versements v
            JOIN users u ON u.code_user = v.user_id 
            LEFT JOIN users cp ON cp.code_user = v.confirm_id
            WHERE  v.hotel_id = :hotel_id AND v.code_versement = :code_versement LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'code_versement' => $codeVersement
            ]);

            if ($stmt->rowCount() > 0)
                $data = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllReservationsToPrint(string $codeVersement, $etat = 1)
    {
        $data = [];

        try {
            $sql = "SELECT r.*, c.*, COALESCE(SUM(co.prix_consommation * co.quantite_consommation ), 0) AS montant_services, CONCAT(u.nom,' ',u.prenom) AS nom FROM versements v
        JOIN reservations r ON (r.versement_id = v.code_versement OR r.caisse_id = v.code_versement)
        JOIN clients c ON c.code_client = r.client_id
        JOIN users u ON u.code_user = r.user_id
        LEFT JOIN consommations co ON r.code_reservation = co.reservation_id AND co.etat_consommation != 2
        WHERE  v.hotel_id = :hotel_id AND r.statut_reservation = :statut AND v.code_versement = :code_versement AND v.cloture IS NOT NULL
        GROUP BY r.code_reservation ORDER BY r.created_reservation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'code_versement' => $codeVersement,
                'hotel_id' => Auth::user('hotel_id'),
                'statut' => STATUT_RESERVATION[1]

            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $etat) {
            die($etat->getMessage());
        }
        return $data;
    }

    public  function getAllReservationsGroupeTypeChambreToPrint(string $codeVersement, $etat = 1)
    {
        $data = [];

        try {
            $sql = "SELECT r.* ,tp.libelle_typechambre, ch.libelle_chambre FROM versements v
        JOIN reservations r ON r.caisse_id = v.code_versement AND r.statut_reservation = :statut
        JOIN chambres ch ON ch.code_chambre = r.chambre_id
        JOIN type_chambres tp ON tp.code_typechambre = ch.typechambre_id
        WHERE  v.hotel_id = :hotel_id AND v.code_versement = :code_versement AND v.cloture IS NOT NULL
        GROUP BY tp.code_typechambre,ch.code_chambre";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'code_versement' => $codeVersement,
                'hotel_id' => Auth::user('hotel_id'),
                'statut' => STATUT_RESERVATION['1'],

            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }
    public  function getAllReservationsGroupeMoyenToPrint(string $codeVersement, $etat = 1)
    {
        $data = [];

        try {
            $sql = "SELECT f.mode_paiement, COUNT(f.id) AS nbre, SUM(f.montant_total) AS montant_total
        FROM versements v
        JOIN hfactures f ON f.versement_id = v.code_versement
        WHERE  v.hotel_id = :hotel_id AND v.code_versement = :code_versement AND v.cloture IS NOT NULL
        GROUP BY f.mode_paiement ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'code_versement' => $codeVersement,
                'hotel_id' => Auth::user('hotel_id'),

            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllServicesGroupeTypeToPrint(string $codeVersement, $etat = 1)
    {
        $data = [];

        try {
            $sql = "SELECT s.libelle_service, SUM(c.quantite_consommation) AS nbre, SUM(c.quantite_consommation * c.prix_consommation) AS montant_total
        FROM versements v
        JOIN consommations c ON c.versement_id = v.code_versement AND c.etat_consommation != 2
        JOIN services s ON s.code_service = c.service_id
        WHERE  v.hotel_id = :hotel_id AND v.code_versement = :code_versement AND v.cloture IS NOT NULL
        GROUP BY s.code_service ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'code_versement' => $codeVersement,
                'hotel_id' => Auth::user('hotel_id'),

            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllReservations($dstart, $dend, $etat = 2)
    {
        $data = [];
        try {
            $sql = "SELECT r.*, c.*, ch.libelle_chambre, COALESCE(SUM(CASE 
            WHEN co.etat_consommation != 2 THEN co.prix_consommation * co.quantite_consommation 
            ELSE 0 
        END), 0) AS montant_services
        FROM reservations r
        INNER JOIN clients c ON c.code_client = r.client_id
        INNER JOIN chambres ch ON ch.code_chambre = r.chambre_id
        LEFT JOIN consommations co ON co.reservation_id = r.code_reservation 
        LEFT JOIN services s ON s.code_service = co.service_id  
        WHERE  r.hotel_id = :hotel_id AND  r.created_reservation BETWEEN :dstart AND :dend  
        GROUP BY r.code_reservation
         ORDER BY r.created_reservation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'dstart' => $dstart,
                'dend' => $dend,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllReservationsActive($dend, $dstart = null)
    {
        $data = [];
        try {
            if (is_null($dstart)) {

                $sql = "SELECT r.*, cl.*,CONCAT(tp.libelle_typechambre,'/',ch.libelle_chambre) AS chambre
        FROM reservations r
        JOIN clients cl ON cl.code_client = r.client_id
        JOIN chambres ch ON ch.code_chambre = r.chambre_id
        JOIN type_chambres tp ON tp.code_typechambre = ch.typechambre_id
        WHERE  r.hotel_id = :hotel_id AND  statut_reservation = :statut AND DATE(r.date_sortie) >= :dend AND checkin IS NOT NULL 
        GROUP BY r.code_reservation
        ORDER BY r.created_reservation DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    "hotel_id" => Auth::user('hotel_id'),
                    "dend" => $dend,
                    "statut" => STATUT_RESERVATION[1]
                ]);
            } else {

                $sql = "SELECT r.*, cl.*,CONCAT(tp.libelle_typechambre,'/',ch.libelle_chambre) AS chambre
        FROM reservations r
        JOIN clients cl ON cl.code_client = r.client_id
        JOIN chambres ch ON ch.code_chambre = r.chambre_id
        JOIN type_chambres tp ON tp.code_typechambre = ch.typechambre_id
        WHERE  r.hotel_id = :hotel_id AND  statut_reservation = :statut AND DATE(r.date_sortie) <= :dstart AND DATE(r.date_sortie) >= :dend AND checkin IS NOT NULL 
        GROUP BY r.code_reservation
        ORDER BY r.created_reservation DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    "hotel_id" => Auth::user('hotel_id'),
                    "dstart" => $dstart,
                    "dend" => $dend,
                    "statut" => STATUT_RESERVATION[1]
                ]);
            }

            if ($stmt->rowCount() > 0)
                $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllReservationsArrive($dstart, $dend = null)
    {
        $data = [];
        try {
            if (is_null($dend)) {

                $sql = "SELECT r.*, cl.*,CONCAT(tp.libelle_typechambre,'/',ch.libelle_chambre) AS chambre
        FROM reservations r
        JOIN clients cl ON cl.code_client = r.client_id
        JOIN chambres ch ON ch.code_chambre = r.chambre_id
        JOIN type_chambres tp ON tp.code_typechambre = ch.typechambre_id
        WHERE  r.hotel_id = :hotel_id AND  statut_reservation = :statut AND DATE(r.date_entree) >= :dstart  AND checkin IS NULL 
        GROUP BY r.code_reservation
        ORDER BY r.created_reservation DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    "hotel_id" => Auth::user('hotel_id'),
                    "dstart" => $dstart,
                    "statut" => STATUT_RESERVATION[0]
                ]);
            } else {

                $sql = "SELECT r.*, cl.*,CONCAT(tp.libelle_typechambre,'/',ch.libelle_chambre) AS chambre
        FROM reservations r
        JOIN clients cl ON cl.code_client = r.client_id
        JOIN chambres ch ON ch.code_chambre = r.chambre_id
        JOIN type_chambres tp ON tp.code_typechambre = ch.typechambre_id
        WHERE  r.hotel_id = :hotel_id AND  statut_reservation = :statut AND DATE(r.date_entree) >= :dstart AND DATE(r.date_entree) <= :dend AND checkin IS NULL 
        GROUP BY r.code_reservation
        ORDER BY r.created_reservation DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    "hotel_id" => Auth::user('hotel_id'),
                    "dstart" => $dstart,
                    "dend" => $dend,
                    "statut" => STATUT_RESERVATION[0]
                ]);
            }

            if ($stmt->rowCount() > 0)
                $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }
    public  function getAllReservationsCheckIn($date, $etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT r.*,cl.*, tp.libelle_typechambre, ch.libelle_chambre
        FROM reservations r
        JOIN clients cl ON cl.code_client = r.client_id
        JOIN chambres ch ON ch.code_chambre = r.chambre_id
        JOIN type_chambres tp ON tp.code_typechambre = ch.typechambre_id
        WHERE  r.hotel_id = :hotel_id AND r.statut_reservation = :statut AND r.etat_reservation = :etat AND DATE(r.date_entree ) = :date_entree
        GROUP BY r.code_reservation
         ORDER BY r.created_reservation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'date_entree' => $date,
                'statut' => STATUT_RESERVATION[1],
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $etat) {
            die($etat->getMessage());
        }
        return $data;
    }

    public  function getAllReservationsCheckOut($date, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT r.*,cl.*, tp.libelle_typechambre, ch.libelle_chambre
        FROM reservations r
        JOIN clients cl ON cl.code_client = r.client_id
        JOIN chambres ch ON ch.code_chambre = r.chambre_id
        JOIN type_chambres tp ON tp.code_typechambre = ch.typechambre_id
        WHERE  r.hotel_id = :hotel_id AND r.statut_reservation = :statut AND r.etat_reservation = :etat AND DATE(r.date_sortie) = :date_entree
        GROUP BY r.code_reservation
         ORDER BY r.created_reservation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'date_entree' => $date,
                'statut' => STATUT_RESERVATION[1],
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $etat) {
            die($etat->getMessage());
        }
        return $data;
    }


    public  function getAllReservationsNonRegler()
    {
        $data = [];
        try {
            $sql = "SELECT r.*, c.*, COALESCE(SUM(CASE 
            WHEN co.etat_consommation = 0 THEN co.prix_consommation * co.quantite_consommation 
            ELSE 0 
        END), 0) AS montant_services
        FROM reservations r
        INNER JOIN clients c ON c.code_client = r.client_id
        INNER JOIN chambres ch ON ch.code_chambre = r.chambre_id
        LEFT JOIN consommations co ON co.reservation_id = r.code_reservation AND etat_consommation = 0
        LEFT JOIN services s ON s.code_service = co.service_id  
        WHERE  r.hotel_id = :hotel_id AND (r.etat_reservation = 0 OR co.etat_consommation = 0 ) AND r.statut_reservation != :etat GROUP BY r.code_reservation ORDER BY r.created_reservation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'etat' => STATUT_RESERVATION[2]
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllVersementForUser($user, $etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT v.* , COALESCE(SUM(f.montant_total), 0) AS montant_facture FROM versements v
            LEFT JOIN hfactures f ON f.versement_id = v.code_versement
            WHERE  v.hotel_id = :hotel_id AND  v.user_id = :user_id AND v.etat_versement = :etat
            GROUP BY v.code_versement
            ORDER BY v.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'user_id' => $user,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);

            if ($stmt->rowCount() > 0)
                $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllVersementUserCaisseDepotComptable($ouverture, $cloture)
    {
        $data = [];
        try {
            $sql = "SELECT v.* , CONCAT(u.nom,' ',u.prenom) AS nom ,CONCAT(cp.nom,' ',cp.prenom) AS cmpt FROM versements v
            JOIN hfactures f ON f.versement_id = v.code_versement
            JOIN users u ON u.code_user = v.user_id 
            LEFT JOIN users cp ON cp.code_user = v.confirm_id
            WHERE  v.hotel_id = :hotel_id AND f.created_facture BETWEEN :ouverture AND :cloture
            GROUP BY v.code_versement
            ORDER BY v.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture
            ]);

            if ($stmt->rowCount() > 0)
                $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }


    public  function getRecapFactureForUserCompte($code_versement)
    {
        $data = [];
        try {
            $sql = "SELECT COALESCE(SUM(f.montant_total), 0) AS montant_facture FROM hfactures f
        WHERE  f.hotel_id = :hotel_id AND  f.versement_id = :v_id ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $code_versement,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetch();
                $data = $res['montant_facture'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getRecapReservationForUserCompte($code_versement, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT r.* FROM reservations r WHERE  r.hotel_id = :hotel_id AND  r.versement_id = :v_id AND r.etat_reservation = :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $code_versement,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getRecapServiceForUserCompte($code_versement, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT COALESCE(SUM(co.prix_consommation * co.quantite_consommation), 0) AS montant_services FROM consommations co
        WHERE  co.hotel_id = :hotel_id AND  co.versement_id = :v_id AND co.etat_consommation = :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $code_versement,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetch();
                $data = $res['montant_services'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getRecaptReservationForUserCompteEnAttente($code_versement, $etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT r.* FROM reservations r
        WHERE  r.hotel_id = :hotel_id AND  r.versement_id = :v_id AND r.statut_reservation != :statut AND r.etat_reservation = :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $code_versement,
                'statut' => STATUT_RESERVATION[2],
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getRecapCaisseReservationForUserCompte($code_versement, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT r.* FROM reservations r
        WHERE  r.hotel_id = :hotel_id AND  r.versement_id = :v_id AND r.statut_reservation != :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $code_versement,
                'etat' => STATUT_RESERVATION[2],
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getRecapCaisseServiceForUserCompte($code_versement, $etat = 2)
    {
        $data = [];
        try {
            $sql = "SELECT COALESCE(SUM(co.prix_consommation * co.quantite_consommation), 0) AS montant_services FROM consommations co
        WHERE  co.hotel_id = :hotel_id AND  co.versement_id = :v_id AND co.etat_consommation != :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $code_versement,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetch();
                $data = $res['montant_services'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getHistoriqueVersementUser($userCode)
    {
        $data = [];
        try {
            $sql = "SELECT v.* , u.nom ,cp.nom AS cmpt FROM versements v
            JOIN hfactures f ON f.versement_id = v.code_versement
            JOIN users u ON u.code_user = v.user_id 
            LEFT JOIN users cp ON cp.code_user = v.confirm_id
            WHERE  v.hotel_id = :hotel_id AND v.user_id = :user_code
            GROUP BY v.code_versement
            ORDER BY v.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'user_code' => $userCode
            ]);

            if ($stmt->rowCount() > 0)
                $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    /**
     * COMPTABLE SEXION
     * CAISSE -------------------
     */

    // depot caisse
    public  function getTota5577lFactureCaisseComptable($code_versement)
    {
        $data = [];
        try {
            $sql = "SELECT COALESCE(SUM(f.montant_total), 0) AS montant_facture FROM hfactures f
        WHERE  f.hotel_id = :hotel_id AND  f.versement_id = :v_id ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $code_versement,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetch();
                $data = $res['montant_facture'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getTotalFactureStandByCaisseComptable(string $ouverture, string $cloture, $etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT COALESCE(SUM(f.montant_total), 0) AS montant_facture FROM hfactures f 
            JOIN versements v ON f.versement_id = v.code_versement AND v.etat_versement = :etat AND v.cloture IS NOT NULL
            WHERE f.hotel_id = :hotel_id AND f.created_facture BETWEEN :ouverture AND :cloture ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'etat' => $etat
            ]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetch();
                $data = $res['montant_facture'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getTotalFactureEncaisseCaisseComptable(string $ouverture, string $cloture, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT COALESCE(SUM(v.montant_cloture), 0) AS montant_cloture FROM versements v  
            
            WHERE v.hotel_id = :hotel_id AND v.created_confirm BETWEEN :ouverture AND :cloture AND v.etat_versement = :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'etat' => $etat
            ]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetch();
                $data = $res['montant_cloture'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getTotalFactureOpenCaisseComptable(string $ouverture, string $cloture, $etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT COALESCE(SUM(f.montant_total), 0) AS montant_facture FROM hfactures f 
            JOIN versements v ON f.versement_id = v.code_versement AND v.etat_versement = :etat AND v.cloture IS NULL
            WHERE f.hotel_id = :hotel_id AND f.created_facture BETWEEN :ouverture AND :cloture ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'etat' => $etat
            ]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetch();
                $data = $res['montant_facture'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }
    // bilan caisse

    public  function getTotalDepenseCaisseComptable(string $ouverture, string $cloture, $etat = 1)
    {
        $data = 0;
        try {
            $sql = "SELECT SUM(d.montant_depense) AS montant_depense FROM depenses d  
        WHERE d.hotel_id = :hotel_id AND d.periode_depense BETWEEN :ouverture AND :cloture AND d.etat_depense = :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'etat' => $etat
            ]);
            if ($stmt->rowCount() > 0) {

                $res = $stmt->fetch();
                $data = $res['montant_depense'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getTotalSalaireCaisseComptable(string $ouverture, string $cloture, $etat = 1)
    {
        $data = 0;
        try {
            $sql = "SELECT SUM(s.montant_salaire) AS montant_salaire FROM salaires s  
        WHERE s.hotel_id = :hotel_id AND s.created_salaire BETWEEN :ouverture AND :cloture AND s.etat_salaire = :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'etat' => $etat
            ]);
            if ($stmt->rowCount() > 0) {

                $res = $stmt->fetch();
                $data = $res['montant_salaire'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }
    public  function getDetailsBilanCaisseComptableReservation(string $ouverture, string $cloture, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT r.* FROM reservations r
    WHERE  r.hotel_id = :hotel_id AND  r.etat_reservation = :etat AND r.created_reservation BETWEEN :ouverture AND :cloture";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([

                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getDeatailsBilanCaisseComptableService(string $ouverture, string $cloture, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT COALESCE(SUM(co.prix_consommation * co.quantite_consommation), 0) AS montant_services FROM consommations co
    WHERE  co.hotel_id = :hotel_id AND co.etat_consommation = :etat AND co.created_consommation BETWEEN :ouverture AND :cloture";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $res = $stmt->fetch();
                $data = $res['montant_services'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getDetailsBilanCaisseComptableReservationNonRegler(string $ouverture, string $cloture, $etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT r.* ,cl.nom_client,  cl.telephone_client, cl.code_client,ch.libelle_chambre, us.nom, us.prenom, v.code_versement, v.montant_cloture FROM reservations r
    JOIN clients cl ON cl.code_client = r.client_id
    JOIN chambres ch ON ch.code_chambre = r.chambre_id
    JOIN users us ON us.code_user = r.user_id
    JOIN versements v ON v.code_versement = r.versement_id
    WHERE  r.hotel_id = :hotel_id AND  r.etat_reservation = :etat AND r.created_reservation BETWEEN :ouverture AND :cloture AND r.statut_reservation = :statut";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'statut' => STATUT_RESERVATION[1]
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function CaisseComptableReservationNonRegler($etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT r.* ,cl.nom_client,  cl.telephone_client, cl.code_client,ch.libelle_chambre, us.nom, us.prenom, v.code_versement, v.montant_cloture FROM reservations r
    JOIN clients cl ON cl.code_client = r.client_id
    JOIN chambres ch ON ch.code_chambre = r.chambre_id
    JOIN users us ON us.code_user = r.user_id
    JOIN versements v ON v.code_versement = r.versement_id
    WHERE  r.hotel_id = :hotel_id AND  r.etat_reservation = :etat AND r.statut_reservation = :statut";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id'),
                'statut' => STATUT_RESERVATION[1]
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $etat) {
            die($etat->getMessage());
        }
        return $data;
    }

    public  function CaisseComptableServiceNonRegler($etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT co.*, s.libelle_service FROM consommations co
    JOIN services s ON s.code_service = co.service_id
    WHERE  co.hotel_id = :hotel_id AND co.etat_consommation = :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getDetailsBilanCaisseComptableServiceNonRegler(string $ouverture, string $cloture, $etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT co.*, s.libelle_service FROM consommations co
    JOIN services s ON s.code_service = co.service_id
    WHERE  co.hotel_id = :hotel_id AND co.etat_consommation = :etat AND co.created_consommation BETWEEN :ouverture AND :cloture";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getDetailsBilanCaisseComptableReservationEnnuler(string $ouverture, string $cloture, $etat = 0)
    {
        $data = [];
        try {
            $sql = "SELECT r.* ,cl.nom_client,  cl.telephone_client, cl.code_client,ch.libelle_chambre, us.nom, us.prenom, v.code_versement, v.montant_cloture FROM reservations r
    JOIN clients cl ON cl.code_client = r.client_id
    JOIN chambres ch ON ch.code_chambre = r.chambre_id
    JOIN users us ON us.code_user = r.user_id
    JOIN versements v ON v.code_versement = r.versement_id
    WHERE  r.hotel_id = :hotel_id AND  r.etat_reservation = :etat AND r.created_reservation BETWEEN :ouverture AND :cloture AND r.statut_reservation = :statut";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id'),
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'statut' => STATUT_RESERVATION[2]
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getDetailsBilanCaisseComptableServiceEnnuler(string $ouverture, string $cloture, $etat = 2)
    {
        $data = [];
        try {
            $sql = "SELECT co.*, s.libelle_service FROM consommations co
    JOIN services s ON s.code_service = co.service_id
    WHERE  co.hotel_id = :hotel_id AND co.etat_consommation = :etat AND co.created_consommation BETWEEN :ouverture AND :cloture";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'ouverture' => $ouverture,
                'cloture' => $cloture,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    // detail

    public  function getAllDetailesVersementReservationsForUser($codeCaisse, $etat = 1)
    {
        $data = [];
        try {

            $sql = "SELECT cl.nom_client, ch.libelle_chambre, u.nom, r.* FROM reservations r 
            JOIN users u on u.code_user = r.user_id 
            JOIN clients cl on cl.code_client = r.client_id 
            JOIN chambres ch ON ch.code_chambre = r.chambre_id
            WHERE  r.hotel_id = :hotel_id AND  r.caisse_id = :v_id AND r.etat_reservation = :etat";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $codeCaisse,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllDetailsVersementServicesForUser($codeCaisse, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT cl.nom_client, u.nom, r.code_reservation, conso.prix_consommation, conso.quantite_consommation, conso.created_consommation, s.libelle_service, COALESCE(conso.prix_consommation * conso.quantite_consommation, 0) AS montant_services FROM reservations r
        JOIN consommations conso ON conso.reservation_id = r.code_reservation AND conso.etat_consommation = :etat
        JOIN services s ON s.code_service = conso.service_id AND conso.hotel_id = s.hotel_id
        JOIN users u on u.code_user = conso.user_id AND conso.hotel_id = u.hotel_id
        JOIN clients cl on cl.code_client = r.client_id AND r.hotel_id = cl.hotel_id
        WHERE r.hotel_id =:hotel_id AND conso.versement_id = :v_id ORDER BY conso.created_consommation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'v_id' => $codeCaisse,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }
    // fin detai

    // SEXION annuler

    public  function getAllDetailesReservationsAnnulers()
    {
        $data = [];
        try {

            $sql = "SELECT cl.nom_client, ch.libelle_chambre, CONCAT(u.nom,' ',u.prenom) AS user, r.* FROM reservations r 
            JOIN users u on u.code_user = r.user_id 
            JOIN clients cl on cl.code_client = r.client_id 
            JOIN chambres ch ON ch.code_chambre = r.chambre_id
            WHERE  r.hotel_id = :hotel_id AND  r.statut_reservation = :statut ORDER BY r.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'statut' => STATUT_RESERVATION[2],
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllDetailsServicesAnnulers($etat = 2)
    {
        $data = [];
        try {
            $sql = "SELECT cl.nom_client, CONCAT(u.nom,' ',u.prenom) AS user, r.code_reservation, co.prix_consommation, co.quantite_consommation, co.created_consommation, s.libelle_service, COALESCE(co.prix_consommation * co.quantite_consommation, 0) AS montant_services FROM consommations co
        JOIN reservations r ON r.code_reservation = co.reservation_id
        JOIN services s ON s.code_service = co.service_id
        JOIN users u on u.code_user = co.user_id 
        JOIN clients cl on cl.code_client = r.client_id
        WHERE co.hotel_id =:hotel_id AND co.etat_consommation = :etat ORDER BY co.created_consommation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([

                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }


    // FIN Sexion annuler
    public function getAllChambresWithCategorie($etat = 1)
    {
        $result = [];
        try {
            $sql = "SELECT ch.*, ca.libelle_typechambre AS categorie FROM chambres ch 
            join type_chambres ca ON ch.typechambre_id = ca.code_typechambre
            WHERE ca.hotel_id = :hotel_id AND etat_chambre = :etat ORDER BY ca.libelle_typechambre DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'etat' => $etat
            ]);
            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }

    public function getAllCategoriesChambre($etat = 1)
    {
        $result = [];
        try {
            $sql = "SELECT * FROM type_chambres ca WHERE ca.hotel_id = :hotel_id AND etat_typechambre = :etat ORDER BY ca.libelle_typechambre DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'etat' => $etat
            ]);
            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }

    public function getAllTypeDepense()
    {
        $result = [];
        try {
            $sql = "SELECT * FROM type_depenses tp ORDER BY tp.libelle_typedepense DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }



    public function getAllServices($etat = 1)
    {
        $result = [];

        try {
            $sql = "SELECT s.* FROM services s
                    JOIN hotels h ON s.hotel_id = h.code_hotel
                    WHERE  s.hotel_id = :hotel_id AND s.etat_service = :etat ORDER BY s.libelle_service DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'etat' => $etat

            ]);

            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }


    public function verificationAbleChambre($data)
    {
        $result = [];

        try {
            $sql = "SELECT ch.code_chambre, ch.statut_chambre, ch.libelle_chambre, ch.prix_chambre, ca.libelle_typechambre AS categorie, r.statut_reservation FROM chambres ch
                INNER JOIN type_chambres ca ON ch.typechambre_id = ca.code_typechambre AND ch.hotel_id = :hotel_id
                LEFT JOIN reservations r ON ch.code_chambre = r.chambre_id AND (r.date_entree <= :date_fin AND r.date_sortie >= :date_debut) WHERE  (r.chambre_id IS NULL OR r.statut_reservation != :etat) AND ch.etat_chambre = :etat_chambre";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'date_debut' => $data['date_debut'],
                'date_fin' => $data['date_fin'],
                'etat' => STATUT_RESERVATION[1],
                'etat_chambre' => 1
            ]);

            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }

    public function verificationAbleChambreBeforeReservation($data)
    {
        $result = [];

        try {
            $sql = "SELECT ch.code_chambre FROM chambres ch
                 JOIN reservations r ON ch.code_chambre = r.chambre_id AND (r.date_entree <= :date_fin AND r.date_sortie >= :date_debut)
                 WHERE ch.hotel_id = :hotel_id AND  r.chambre_id = :chambre_id AND r.statut_reservation = :etat ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'date_debut' => $data['date_debut'],
                'date_fin' => $data['date_fin'],
                'etat' => STATUT_RESERVATION[1],
                'chambre_id' => $data['chambre_id']
            ]);

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }

    public function getDataByCodeReservation($codeResevation)
    {
        $result = [];

        try {
            $sql = "SELECT r.*, ch.*, ca.libelle_typechambre AS categorie,cl.*, r.date_entree, r.date_sortie FROM chambres ch
    JOIN type_chambres ca ON ch.typechambre_id = ca.code_typechambre 
    JOIN reservations r ON ch.code_chambre = r.chambre_id
    JOIN clients cl ON cl.code_client = r.client_id
    WHERE r.code_reservation = :code AND ch.hotel_id = :hotel_id LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'code' => $codeResevation,
            ]);

            $result = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }

    public function getCountChambreOccuper($today)
    {
        $result = 0;

        try {
            $sql = "SELECT COUNT(ch.id) AS nbre FROM chambres ch
                    JOIN reservations r ON ch.code_chambre = r.chambre_id AND (r.date_entree <= :today AND r.date_sortie >= :today)
                    WHERE ch.hotel_id = :hotel_id AND r.statut_reservation = :etat";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'today' => $today,
                'etat' => STATUT_RESERVATION[1],
            ]);

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch();
                $result = $data['nbre'];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }

    public function getAllClient($date_start, $date_end)
    {
        $result = [];

        try {
            $sql = "SELECT distinct cl.* FROM clients cl
    LEFT JOIN reservations r ON r.client_id = cl.code_client
    WHERE  cl.hotel_id = :hotel_id 
    AND  r.created_reservation BETWEEN :dstart AND :dend 
    ORDER BY r.created_reservation DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'dstart' => $date_start,
                'dend' => $date_end,
                'hotel_id' => Auth::user('hotel_id')

            ]);
            if ($stmt->rowCount() > 0)
                $result = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }








    public function verifyParam($table, $field, $value)
    {
        $data = [];

        try {
            $sql = "SELECT * FROM {$table} AS tb WHERE tb.hotel_id = :hotel_id AND {$field} = :field LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'field' => $value
            ]);
            $data = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function verifyParam2($table, $field1, $field2, $value1, $value2)
    {
        $data = [];

        try {
            $sql = "SELECT * FROM {$table} AS tb WHERE tb.hotel_id = :hotel_id AND {$field1} = :field1 AND {$field2} = :field2 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'field1' => $value1,
                'field2' => $value2
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }


    public function verifTypechambreLibelle($libelle, $etat = 1)
    {
        $result = [];
        try {
            $sql = "SELECT * FROM type_chambres  WHERE hotel_id = :hotel_id AND libelle_typechambre = :libelle AND etat_typechambre = :etat LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'libelle' => $libelle,
                'etat' => $etat
            ]);
            $result = $stm->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }

    public function generateCode($table, $field, $prefixe, $length) // $password = $this->validator->generateCode("proprietaire", "password_pro","@", 6 );
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomCode = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomCode .= $characters[rand(0, $charactersLength - 1)];
        }
        if ($this->verif($table, $field, $randomCode)) {
            return $this->generateCode($table, $field, $prefixe, $length); // Si le code est déjà utilisé, on réessaye
        }

        return $prefixe . $randomCode;
    }

    public function verif($table, $field, $value) // function veriviant l'existance d'une ligne par 1 element
    {
        $result = false;
        try {
            $sql = " SELECT * FROM $table WHERE $field=?";
            $query = $this->db->prepare($sql);
            $query->execute([$value]);
            if ($query->rowCount() > 0) {
                $result = true;
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }

    public function verifServiceLibelle($libelle, $etat = 1)
    {
        $result = [];
        try {
            $sql = "SELECT * FROM services  WHERE hotel_id = :hotel_id AND libelle_service = :libelle AND etat_service = :etat LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'libelle' => $libelle,
                'etat' => $etat
            ]);
            $result = $stm->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }

    public function getDataFactureServiceForClient($codeReservation, $etat = 0)
    {
        $result = [];

        try {
            $sql = "SELECT r.code_reservation,  SUM(co.prix_consommation * co.quantite_consommation) AS total FROM   reservations r
            JOIN consommations co ON co.reservation_id = r.code_reservation AND r.hotel_id = :hotel_id
    WHERE co.reservation_id = :code AND co.etat_consommation = :etat";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'code' => $codeReservation,
                'etat' => $etat
            ]);

            $result = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $result;
    }

    public  function getServicesToPrint(string $codeReservation, $etat = 2)
    {
        $data = [];
        try {
            $sql = "SELECT co.quantite_consommation AS qte,co.prix_consommation AS prix,SUM(co.prix_consommation * co.quantite_consommation) AS total, s.libelle_service FROM consommations co
    JOIN services s ON s.code_service = co.service_id
    WHERE  co.hotel_id = :hotel_id AND co.etat_consommation != :etat AND co.reservation_id = :code
    GROUP BY s.id ORDER BY co.created_consommation DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'code' => $codeReservation,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function verifFonctionLibelle($libelle, $etat = 1)
    {
        $result = [];
        try {
            $sql = "SELECT * FROM fonctions  WHERE hotel_id = :hotel_id AND libelle_fonction = :libelle AND etat_fonction = :etat LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'libelle' => $libelle,
                'etat' => $etat
            ]);
            $result = $stm->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }

    public function verifChambreLibelle($libelle, $categorie, $etat = 1)
    {
        $result = [];
        try {
            $sql = "SELECT ch.* FROM chambres ch  WHERE hotel_id = :hotel_id AND libelle_chambre = :libelle AND ch.typechambre_id = :categorie AND etat_chambre = :etat LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'libelle' => $libelle,
                'categorie' => $categorie,
                'etat' => $etat
            ]);
            $result = $stm->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }


    public  function getAllDepenseForSearching($dstart, $dend)
    {
        $data = [];
        try {
            $sql = "SELECT d.*, tp.libelle_typedepense AS libelle_depense, CONCAT(u.nom, ' ', u.prenom) AS user, CONCAT(u2.nom, ' ', u2.prenom) AS user_confirm FROM depenses d
        JOIN type_depenses tp ON tp.code_typedepense = d.typedepense_id
        JOIN users u ON u.code_user = d.user_id
        LEFT JOIN users u2 ON u2.code_user = d.confirm_id
        WHERE  d.hotel_id = :hotel_id AND d.periode_depense BETWEEN :dstart AND :dend  
        GROUP BY d.code_depense
        ORDER BY d.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'dstart' => $dstart,
                'dend' => $dend,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public  function getAllDepenseToPrint($dstart, $dend, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT d.*, tp.libelle_typedepense AS libelle_depense, CONCAT(u.nom, ' ', u.prenom) AS user, CONCAT(u2.nom, ' ', u2.prenom) AS user_confirm FROM depenses d
        JOIN type_depenses tp ON tp.code_typedepense = d.typedepense_id
        JOIN users u ON u.code_user = d.user_id
        JOIN users u2 ON u2.code_user = d.confirm_id
        WHERE  d.hotel_id = :hotel_id AND d.etat_depense = :etat AND d.periode_depense BETWEEN :dstart AND :dend 
        GROUP BY d.code_depense ORDER BY d.id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'dstart' => $dstart,
                'dend' => $dend,
                'hotel_id' => Auth::user('hotel_id'),
                'etat' => $etat
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }

    public function verifSalaireForMonth($user, $month)
    {
        $result = [];
        try {
            $sql = "SELECT s.* FROM salaires s  WHERE hotel_id = :hotel_id AND user_id = :user AND mois_salaire = :mois LIMIT 1";
            $stm = $this->db->prepare($sql);
            $stm->execute([
                'hotel_id' => Auth::user('hotel_id'),
                'user' => $user,
                'mois' => $month

            ]);
            if ($stm->rowCount() > 0) {
                $result = $stm->fetch();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $result;
    }


    public  function getAllSalaireForSearching($dstart, $dend, $etat = 2, $filter = null)
    {
        $data = [];
        $sql = "";
        if ($filter) {

            $sql = "SELECT s.*, CONCAT(u.nom, ' ', u.prenom) AS user, CONCAT(u2.nom, ' ', u2.prenom) AS user_created, CONCAT(u3.nom, ' ', u3.prenom) AS user_confirm FROM salaires s
        JOIN users u ON u.code_user = s.user_id
        JOIN users u2 ON u2.code_user = s.created_user
        JOIN users u3 ON u3.code_user = s.confirm_id
        WHERE  s.hotel_id = :hotel_id AND s.etat_salaire = :etat AND s.created_salaire BETWEEN :dstart AND :dend  
        GROUP BY s.code_salaire ORDER BY s.id DESC";
        } else {

            $sql = "SELECT s.*, CONCAT(u.nom, ' ', u.prenom) AS user, CONCAT(u2.nom, ' ', u2.prenom) AS user_created, CONCAT(u3.nom, ' ', u3.prenom) AS user_confirm FROM salaires s
        JOIN users u ON u.code_user = s.user_id
        JOIN users u2 ON u2.code_user = s.created_user
        LEFT JOIN users u3 ON u3.code_user = s.confirm_id
        WHERE  s.hotel_id = :hotel_id AND s.etat_salaire != :etat AND s.created_salaire BETWEEN :dstart AND :dend  
        GROUP BY s.code_salaire ORDER BY s.id DESC";
        }


        try {

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'dstart' => $dstart,
                'dend' => $dend,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $etat) {
            die($etat->getMessage());
        }
        return $data;
    }

    public  function getAllSalaireForUser($code_user)
    {
        $data = [];

        $sql = "SELECT s.*, CONCAT(u.nom, ' ', u.prenom) AS user, CONCAT(u2.nom, ' ', u2.prenom) AS user_created, CONCAT(u3.nom, ' ', u3.prenom) AS user_confirm FROM salaires s
        JOIN users u ON u.code_user = s.user_id
        JOIN users u2 ON u2.code_user = s.created_user
        LEFT JOIN users u3 ON u3.code_user = s.confirm_id
        WHERE  s.hotel_id = :hotel_id AND s.user_id = :code_user  
        GROUP BY s.code_salaire ORDER BY s.id DESC";

        try {

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'code_user' => $code_user,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            $data = $stmt->fetchAll();
        } catch (Exception $etat) {
            die($etat->getMessage());
        }
        return $data;
    }


    public  function bilanAnnuelDashboard($year, $etat = 1)
    {
        $data = [];
        try {
            $sql = "SELECT YEAR(v.cloture) AS annee, MONTH(v.cloture) AS mois, SUM(v.montant_cloture) AS montant_total FROM versements v WHERE v.hotel_id = :hotel_id AND YEAR(v.cloture) = :annee AND v.etat_versement = :etat GROUP BY MONTH(v.cloture) ORDER BY MONTH(v.cloture) ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                "annee" => $year,
                'etat' => $etat,
                'hotel_id' => Auth::user('hotel_id')
            ]);
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }


    public function transactReservationClient(array $client, array $reservation)
    {
        $this->transaction(function (Model $query) use ($client, $reservation) {
            // Insertion élève
            $query->create("clients", $client);

            // $eleveId = Database::getInstance()->lastInsertId();
            // $eleveId = $this->db->lastInsertId();
            // Insertion parent
            $query->create("reservations", $reservation);
        });
    }

    public function transactReservationConfirme(array $facture, string $reservation)
    {
        $this->transaction(function (Model $query) use ($facture, $reservation) {
            // Insertion élève
            $query->create("hfactures", $facture);

            // $eleveId = Database::getInstance()->lastInsertId();
            // $eleveId = $this->db->lastInsertId();
            // Insertion parent
            $query->update("reservations", 'code_reservation', $reservation, ['etat_reservation' => 1, 'caisse_id' => Auth::user('caisse')]);
            $query->updateServiceClient($reservation);
        });
    }

    public function transactReservationService(array $facture, string $reservation)
    {
        $this->transaction(function (Model $query) use ($facture, $reservation) {
            // Insertion élève
            $query->create("hfactures", $facture);

            // $eleveId = Database::getInstance()->lastInsertId();
            // $eleveId = $this->db->lastInsertId();
            // Insertion parent
            $query->updateServiceClient($reservation);
            // $query->update("consommations", 'reservation_id', $reservation, ['etat_consommation' => 1, 'caisse_id' => Auth::user('caisse')]);
        });
    }

    public function transactRegisterUser(array $hotel, array $fonction, array $user)
    {

        $this->transaction(function (Model $query) use ($hotel, $fonction, $user) {

            /* reccuper ses  informations pour l'enregistre dans la table users,
                *  puis remplire la table user_roles avec le role super admin (role par defaut)
            ensuite remplire la table hotels avec le code_user et hotel_id = 1 (hotel par defaut)
             */

            $code = $hotel['code_hotel'];



            $data_user_role = [
                [
                    'user_id' => $code,
                    'role_id' => Roles::SUPER, // Role super admin
                    'create_permission' => 1,
                    'edit_permission' => 1,
                    'show_permission' => 1,
                    'delete_permission' => 1
                ],
                [
                    'user_id' => $code,
                    'role_id' => Roles::ADMIN_H, // Role admin
                    'create_permission' => 1,
                    'edit_permission' => 1,
                    'show_permission' => 1,
                    'delete_permission' => 1
                ],
                [
                    'user_id' => $code,
                    'role_id' => Roles::DASHBOARD_H, // Role Dashbord
                    'create_permission' => 1,
                    'edit_permission' => 1,
                    'show_permission' => 1,
                    'delete_permission' => 1
                ],
                [
                    'user_id' => $code,
                    'role_id' => Roles::PARAMETRE, // Role parametre
                    'create_permission' => 1,
                    'edit_permission' => 1,
                    'show_permission' => 1,
                    'delete_permission' => 1
                ]
            ];


            // remplir la table hotels
            $query->create("hotels", $hotel);
            // remplir la table fonctions
            $query->create("fonctions", $fonction);
            // remplir la table services
            // remplir la table users
            $query->create("users", $user);
            // remplir la table user_roles
            foreach ($data_user_role as $role) {
                $query->create("user_roles", $role);
            }
        });
        return true;
    }
}
