<?php

namespace App\Core;

use App\Classes\Mailer;
use App\Classes\PdfGenerator;
use Exception;

class MainController
{
    protected $link;

    use Mailer, PdfGenerator;
    public function __construct()
    {
        $this->initMailer();
        $this->initPdf();
    }


    /**
     * Get the value of link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of link
     *
     * @return  self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

  
    protected function   view($view, $data = ['title' => "Mon espace"])
    {

        extract($data);
        $viewFile = __DIR__ . THREE_PIP .'views/' . $view . '.php';

        if (file_exists($viewFile)) {
            include __DIR__ . THREE_PIP .'views/layout.php'; // Inclure le layout général
        } else {
            throw new Exception("Vue introuvable : $viewFile");
        }
    }

    protected function   viewError($view, $data = ['title' => "Mon espace"])
    {

        extract($data);
        $viewFile = __DIR__ . THREE_PIP .'views/errors/' . $view . '.php';

        if (file_exists($viewFile)) {
            include __DIR__ . THREE_PIP .'views/error.php'; // Inclure le layout général
        } else {
            throw new Exception("Vue introuvable : $viewFile");
        }
    }

    protected function   downloadPdfPrinter($view, $data = ['title' => "Mon espace"])
    {
        $this->downloadPdfFile($view, $data);
    }

    protected function   savePdfPrinter($view, $data = ['title' => "Mon espace"], $paperFormat = 'A4', $orientation = 'portrait')
    {
        $link = $this->generateLinkPdf();
        return $this->savePdfToFile($view, $data, $link, $paperFormat, $orientation);
    }

 

    protected function   viewPdfPrinter(string $file)
    {

        $cheminFichier = __DIR__ . THREE_PIP.'public/pdfs/' . basename($file);
        // return $file;
        // return $cheminFichier;
        if (!file_exists($cheminFichier)) {
            http_response_code(405);
            exit('Fichier non trouvé');
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($cheminFichier));

        readfile($cheminFichier);
        exit;
    }

    protected function   viewGuest($view, $data = ['title' => "Mon espace"])
    {

        extract($data);

        $viewFile = __DIR__ . THREE_PIP .'views/' . $view . '.php';

        if (file_exists($viewFile)) {
            include __DIR__ . THREE_PIP .'views/guest.php'; // Inclure le layout général
        } else {
            throw new Exception("Vue introuvable : $viewFile");
        }
    }

    private function   generateLinkPdf()
    {
        $cheminDossier = __DIR__ . THREE_PIP.'public/pdfs';

        if (!creerDossierSiNonExistant($cheminDossier)) {
            throw new Exception("Error Processing Request", 1);
        }

        $nomFichier = 'bulletin_' . time() . '.pdf';
        $link = $cheminDossier . '/' . $nomFichier;
        $this->setLink($nomFichier);
        return $link;
    }
}
