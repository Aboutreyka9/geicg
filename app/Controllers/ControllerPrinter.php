<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\MainController;
use App\Models\Factory;
use DateTime;
use Exception;

class ControllerPrinter extends MainController
{
    public function print($file)  {
        if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        return $this->viewPdfPrinter($file );
    }

  

    public function download()  {
        if (!Auth::check()) {
            
            exit(http_response_code(405));
        }
        return $this->downloadPdfPrinter("recu", []);
        // return $this->downloadPdfFile("recu", []);
    }


    public function newVersionPdfSave() {
        if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $this->setHeader('<div><strong>École Franco-Arabe</strong><br>Bulletin Scolaire 2024-2025</div>');
        
        $this->setFooter('<div>© 2025 École Franco-Arabe - Tous droits réservés</div>');
        $this->setNumberPage(true);
    
        $data = [
            'annee' => '2024-2025',
            'eleve_nom' => 'Jean Dupont',
            'classe' => '4ème A',
            'moyenne' => '13.5',
            'commentaire' => 'Bon travail globalement, mais peut mieux faire en histoire.',
            'matieres' => [
                ['matiere' => 'Mathématiques', 'note' => '15', 'coef' => '4', 'remarque' => 'Très bon'],
                ['matiere' => 'Français', 'note' => '13', 'coef' => '3', 'remarque' => 'Bon effort'],
                ['matiere' => 'Histoire', 'note' => '12', 'coef' => '2', 'remarque' => 'À améliorer'],
                ['matiere' => 'Anglais', 'note' => '14', 'coef' => '3', 'remarque' => 'Bien'],
            ],
        ];
    
        
        try {

            $success = $this->savePdfPrinter("bulletins",$data, "A5", "landscape");
            
            if ($success) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'PDF enregistré',
                    'fichier' => $this->getLink()
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erreur lors de l\'enregistrement'
                ]);
            }
    
        } catch (Exception $e) {
            echo json_encode([
                'status'=>'error',
                'message' => 'Erreur génération PDF : '.$e->getMessage()
            ]);
        }


    
    }
    
    public function factureData() {

        if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $data = [
            'annee' => '2024-2025',
            'eleve_nom' => 'Jean Dupont',
            'classe' => '4ème A',
            'moyenne' => '13.5',
            'matieres' => '' // On va générer un tableau HTML
        ];
       
        try {
            $pdfContent = $this->generateFromTemplate("facture", $data);
    
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="facture.pdf"');
            echo $pdfContent;
    
        } catch (Exception $e) {
            echo json_encode([
                'status'=>'error',
                'message' => 'Erreur génération PDF : '.$e->getMessage()
            ]);
        }
    }

    public function printFacture($code)  {
        if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $fc = new Factory();
        $reserver = $fc->getDataByCodeReservation($code);
        $services = $fc->getServicesToPrint($code);

        $hotel = $fc->find("hotels","code_hotel",Auth::user('hotel_id'));

        if(!empty($reserver) && !empty($hotel)){
            $this->downloadPdfPrinter('a5',compact('reserver','hotel','services'));
            return;
        }
        exit(http_response_code(405));
        
        // var_dump($reserver);
        // return $reserver;
        // return $this->viewPdfPrinter($file );
    }

    public function printVersement($code)  {
        if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $fc = new Factory();
        $reservations = [];
        $reservations = $fc->getAllReservationsToPrint($code);
        
        
        $hotel = $fc->find("hotels","code_hotel",Auth::user('hotel_id'));
        
        if(!empty($reservations) && !empty($hotel)){

            $infoVersement = $fc->getVersementUserToPrint($code);
            $modep= $fc->getAllReservationsGroupeMoyenToPrint($code);
            $services = $fc->getAllServicesGroupeTypeToPrint($code);
            $reserveCount = $fc->getAllReservationsGroupeTypeChambreToPrint($code);


            $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
            $this->downloadPdfPrinter('print_versement',compact('reservations','hotel','modep','services','reserveCount','infoVersement'));
            return;
        }
        exit(http_response_code(405));
      
    }

    public function printListeClient($periode)  {
         if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $data = decrypter($periode);
       if($data == false){
            http_response_code(405);
            exit();
        }

        [$start, $end] = explode('#', $data);

        if(empty($start) || empty($end)){
            http_response_code(405);
            exit();
        }

        $fc = new Factory();
        // $start = urldecode($start);
        // $end = urldecode($end);
        
        
        $clients = $fc->getAllClient($start, $end);
        if(empty($clients)){
            http_response_code(405);
            exit();
        }
     
        $date_debut = (new DateTime($start))->format('d/m/Y');
        $date_fin = (new DateTime($end))->format('d/m/Y');
        $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
        $this->downloadPdfPrinter('liste_client',compact('clients','date_debut','date_fin'));
       
    }

    public function printListeReservation($periode)  {
        
        if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $data = decrypter($periode);
       if($data == false){
            http_response_code(405);
            exit();
        }
        [$start, $end] = explode('#', $data);

        if(empty($start) || empty($end)){
            http_response_code(405);
            exit();
        }

        $fc = new Factory();
        
        
        $reservations = $fc->getAllReservations($start,$end);
        if(empty($reservations)){
            http_response_code(405);
            exit();
        }
     
        $date_debut = (new DateTime($start))->format('d/m/Y');
        $date_fin = (new DateTime($end))->format('d/m/Y');
        
        $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
        $this->setOrigin('landscape');
        $this->downloadPdfPrinter('liste_reservation',compact('reservations','date_debut','date_fin'));
       
    }

     public function printListeCheckReservation($periode)  {
        
        if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $data = decrypter($periode);
       if($data == false){
            http_response_code(405);
            exit();
        }
        [$start, $etat] = explode('#', $data);

        if(empty($start) || empty($etat)){
            http_response_code(405);
            exit();
        }

        $fc = new Factory();
        
        $reservations = $etat == 1 ?
         $fc->getAllReservationsCheckOut($start,$etat)
         : $fc->getAllReservationsCheckIn($start,$etat);
        if(empty($reservations)){
            http_response_code(405);
            exit();
        }
     
        $date_debut = (new DateTime($start))->format('d/m/Y');
        $date_fin = (new DateTime($etat))->format('d/m/Y');
        
        $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
        $this->setOrigin('landscape');
        $this->downloadPdfPrinter('liste_check_reservation',compact('reservations','date_debut','date_fin'));
       
    }


    public function printListeDepense($periode)  {
         if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $data = decrypter($periode);
       if($data == false){
            http_response_code(405);
            exit();
        }
        [$start, $end] = explode('#', $data);

        if(empty($start) || empty($end)){
            http_response_code(405);
            exit();
        }

        $fc = new Factory();
        
        $depenses = $fc->getAllDepenseToPrint($start,$end);

        if(empty($depenses)){
            http_response_code(405);
            exit();
        }
     
        $date_debut = (new DateTime($start))->format('d/m/Y');
        $date_fin = (new DateTime($end))->format('d/m/Y');
        $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
        $this->setOrigin('portrait');
        $this->downloadPdfPrinter('liste_depense',compact('depenses','date_debut','date_fin'));
       
    }


    public function printListeSalaire($periode)  {
         if (!Auth::check()) {
            
            exit(http_response_code(405));
        }
        
        $data = decrypter($periode);
       if($data == false){
            http_response_code(405);
            exit();
        }
        [$start, $end] = explode('#', $data);

        if(empty($start) || empty($end)){
            http_response_code(405);
            exit();
        }

        $fc = new Factory();
        
        $salaires = $fc->getAllSalaireForSearching($start,$end,1,true);

        if(empty($salaires)){
            http_response_code(405);
            exit();
        }
     
        $date_debut = (new DateTime($start))->format('d/m/Y');
        $date_fin = (new DateTime($end))->format('d/m/Y');
        $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
        $this->setOrigin('portrait');
        $this->downloadPdfPrinter('liste_salaire',compact('salaires','date_debut','date_fin'));
       
    }

     public function printListeVersement($periode)  {
         if (!Auth::check()) {
            
            exit(http_response_code(405));
        }

        $data = decrypter($periode);
       if($data == false){
            http_response_code(405);
            exit();
        }
        [$start, $end] = explode('#', $data);

        if(empty($start) || empty($end)){
            http_response_code(405);
            exit();
        }

        $fc = new Factory();
        $versements = $fc->getAllVersementUserCaisseDepotComptable($start, $end);
        
        if(empty($versements)){
            http_response_code(405);
            exit();
        }
     
        $date_debut = (new DateTime($start))->format('d/m/Y');
        $date_fin = (new DateTime($end))->format('d/m/Y');
        $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
        $this->setOrigin('landscape');
        $this->downloadPdfPrinter('liste_versement',compact('versements','date_debut','date_fin'));
       
    }

     public function printListeChambres()  {
         if (!Auth::check()) {
            
            exit(http_response_code(405));
        }
        
        $fc = new Factory();
        
        $chambres = $fc->getAllChambresWithCategorie();

        if(empty($chambres)){
            http_response_code(405);
            exit();
        }
     
        
        $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
        $this->setOrigin('portrait');
        $this->downloadPdfPrinter('liste_chambre',compact('chambres'));
       
    }

     public function printListeServices()  {
         if (!Auth::check()) {
            
            exit(http_response_code(405));
        }
        
      

        $fc = new Factory();
        
        $services = $fc->getAllServices();

        if(empty($services)){
            http_response_code(405);
            exit();
        }
     
        $this->setFooter('<div>© 2025 izyapp-Hotel - Tous droits réservés</div>');
        $this->setNumberPage(true);
        $this->setOrigin('portrait');
        $this->downloadPdfPrinter('liste_service',compact('services'));
       
    }









}
