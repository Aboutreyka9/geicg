<?php
namespace App\Classes;

use Dompdf\Dompdf;
use Dompdf\Options;

trait  SimplePdfGenerator
{
    private Dompdf $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Autorise les images externes
        $this->dompdf = new Dompdf($options);
    }

    // Charge un template et remplace les placeholders par les données autoamtique
    public function loadTemplate(string $templatePath, array $data = []): string
    {
        if (!file_exists($templatePath)) {
            throw new \Exception("Template non trouvé : $templatePath");
        }

        $html = file_get_contents($templatePath);

        // Remplacement simple des {{key}} par leurs valeurs
        foreach ($data as $key => $value) {
            $html = str_replace('{{'.$key.'}}', $value, $html);
        }

        return $html;
    }

      // Template engine simple qui remplace loadTemplate 
      public function renderTemplateSimple(string $templatePath, array $data = []): string
      {
          if (!file_exists($templatePath)) {
              throw new \Exception("Template non trouvé : $templatePath");
          }
  
          $template = file_get_contents($templatePath);
  
          // Gestion des boucles {{#boucle}} ... {{/boucle}}
          $template = preg_replace_callback('/{{#(\w+)}}(.*?){{\/\1}}/s', function ($matches) use ($data) {
              $key = $matches[1];
              $block = $matches[2];
              if (!isset($data[$key]) || !is_array($data[$key])) {
                  return '';
              }
              $result = '';
              foreach ($data[$key] as $item) {
                  $temp = $block;
                  // Remplace {{variable}} dans le block par les valeurs de l'item
                  foreach ($item as $k => $v) {
                      $temp = str_replace('{{'.$k.'}}', htmlspecialchars($v), $temp);
                  }
                  $result .= $temp;
              }
              return $result;
          }, $template);
  
          // Gestion des conditions simples {{#condition}} ... {{/condition}}
          $template = preg_replace_callback('/{{#(\w+)}}(.*?){{\/\1}}/s', function ($matches) use ($data) {
              $key = $matches[1];
              $block = $matches[2];
              return !empty($data[$key]) ? $block : '';
          }, $template);
  
          // Remplacement simple des variables {{variable}}
          foreach ($data as $key => $value) {
              if (!is_array($value)) {
                  $template = str_replace('{{'.$key.'}}', htmlspecialchars($value), $template);
              }
          }
  
          return $template;
      }
    /**
     * Génère un PDF à partir d'un contenu HTML
     * @param string $html Contenu HTML à convertir en PDF
     * @param string $paperFormat Format du papier (ex: 'A4')
     * @param string $orientation Orientation de la page ('portrait' ou 'landscape')
     * @return string Contenu binaire du PDF généré
     */
    public function generateFromHtml(string $html, string $paperFormat = 'A4', string $orientation = 'portrait'): string
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper($paperFormat, $orientation);
        $this->dompdf->render();

        return $this->dompdf->output();
    }

    /**
     * Génère un PDF simple avec un titre et un contenu
     * @param string $title Titre du document
     * @param string $content Contenu HTML à insérer sous le titre
     * @return string Contenu binaire du PDF généré
     */
    public function generateSimplePdf(string $title, string $content): string
    {
        $html = "
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: DejaVu Sans, sans-serif; }
                h1 { text-align: center; color: navy; }
                .content { margin-top: 20px; font-size: 14px; }
            </style>
        </head>
        <body>
            <h1>{$title}</h1>
            <div class='content'>{$content}</div>
        </body>
        </html>
        ";

        return $this->generateFromHtml($html);
    }

    public function generateFromTemplate(string $templatePath, array $data, string $paperFormat = 'A4', string $orientation = 'portrait'): string
    {
        $html = $this->loadTemplate($templatePath, $data);
        return $this->generateFromHtml($html, $paperFormat, $orientation);
    }

    public function generateFromTemplateRender(string $templatePath, array $data, string $paperFormat = 'A4', string $orientation = 'portrait'): string
    {
        $html = $this->renderTemplate($templatePath, $data);
        return $this->generateFromHtml($html, $paperFormat, $orientation);
    }

    /**
 * Génère un PDF et l'enregistre dans un fichier sur le serveur
 * @param string $html Contenu HTML à convertir en PDF
 * @param string $cheminFichier Chemin complet (avec nom) où enregistrer le PDF
 * @param string $paperFormat Format papier (par défaut 'A4')
 * @param string $orientation Orientation (par défaut 'portrait')
 * @return bool True si succès, False sinon
 */
public function savePdfToFile(string $html, string $cheminFichier, string $paperFormat = 'A4', string $orientation = 'portrait'): bool
{
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper($paperFormat, $orientation);
    $this->dompdf->render();

    $pdfContent = $this->dompdf->output();

    return (bool) file_put_contents($cheminFichier, $pdfContent);
}

}
