<?php
namespace App\Classes;

use Dompdf\Dompdf;
use Dompdf\Options;

trait  PdfGenerator
{
    private Dompdf $dompdf;
    private string $headerHtml = '';
    private string $footerHtml = '';
    private string $format = 'A4';
    private string $origin = 'portrait';
    private bool $numberPage = false;
    private  $contentGenerate;
    
    public function initPdf()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $this->dompdf = new Dompdf($options);
    }

    public function setHeader(string $html): void
    {
        $this->headerHtml = $html;
    }

    public function setFooter(string $html): void
    {
        $this->footerHtml = $html;
    }

    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    public function setOrigin(string $origin): void
    {
        $this->origin = $origin;
    }


    public function setNumberPage(bool$bool): void
    {
        $this->numberPage = $bool;
    }

     

  

     
    /**
     * Renders a PDF template to a string, replacing placeholders with data.
     *
     * @param string $template The name of the template file.
     * @param array $data The data to be injected into the template.
     * @throws \Exception If the template file is not found.
     * @return string The rendered template as a string.
     */
     private function renderTemplatePdf(string $template, array $data = []): string
     {
         $templatePath = __DIR__ .THREE_PIP.'views/templated/pdfs/'. $template . '.php';
         if (!file_exists($templatePath)) {
             throw new \Exception("Template non trouvé : $templatePath");
         }
         
         extract($data, EXTR_SKIP);

         ob_start();
         include $templatePath;
         return ob_get_clean();
        
        //  return $template;
     }

     private function renderTemplatePdf555(string $template, array $data = []): string
     {
         $templatePath = __DIR__ .THREE_PIP.'views/templated/pdfs/'. $template . '.php';
         if (!file_exists($templatePath)) {
             throw new \Exception("Template non trouvé : $templatePath");
         }
         
         $template = file_get_contents($templatePath);
 
         // Boucles {{#boucle}} ... {{/boucle}}
         $template = preg_replace_callback('/{{#(\w+)}}(.*?){{\/\1}}/s', function ($matches) use ($data) {
             $key = $matches[1];
             $block = $matches[2];
             if (!isset($data[$key]) || !is_array($data[$key])) {
                 return '';
             }
             $result = '';
             foreach ($data[$key] as $item) {
                 $temp = $block;
                 foreach ($item as $k => $v) {
                     $temp = str_replace('{{'.$k.'}}', htmlspecialchars($v), $temp);
                 }
                 $result .= $temp;
             }
             return $result;
         }, $template);
 
         // Conditions simples {{#condition}} ... {{/condition}}
         $template = preg_replace_callback('/{{#(\w+)}}(.*?){{\/\1}}/s', function ($matches) use ($data) {
             $key = $matches[1];
             $block = $matches[2];
             return !empty($data[$key]) ? $block : '';
         }, $template);
 
         // Variables simples {{variable}}
         foreach ($data as $key => $value) {
             if (!is_array($value)) {
                 $template = str_replace('{{'.$key.'}}', htmlspecialchars($value), $template);
             }
         }
 
         return $template;
     }
    
   

    /**
     * Builds the full HTML content to be rendered as a PDF, including the header, footer, and body content.
     *
     * @param string $bodyHtml The HTML content to be rendered as the body of the PDF.
     * @return string The full HTML content to be rendered as a PDF.
     */
    private function buildFullHtml(string $bodyHtml): string
    {
        $numberPage = $this->numberPage ? ' Page <span class="page-number"></span>' : '';
        $header = !empty($this->headerHtml) ? "<header>{$this->headerHtml}</header>" : '';
        $footer = !empty($this->footerHtml) ? '  <footer>'.$this->footerHtml.' '.$numberPage.'</footer>' : '';
        

        $css = '
        <style>
            @page {
                margin: 100px 50px 80px 50px;
            }
            header {
                position: fixed;
                top: -80px;
                left: 0;
                right: 0;
                height: 70px;
                text-align: center;
                border-bottom: 1px solid #ddd;
                font-size: 14px;
                line-height: 1.2;
            }
            footer {
                position: fixed;
                bottom: -50px;
                left: 0;
                right: 0;
                height: 40px;
                text-align: center;
                border-top: 1px solid #ddd;
                font-size: 12px;
                color: #666;
            }
            .page-number:before {
                content: counter(page);
            }
            body {
                font-family: DejaVu Sans, sans-serif;
            }
        </style>';

        return '
        <html>
        <head>
            <meta charset="utf-8">
            ' . $css . '
        </head>
        <body>
            ' . $header . '
            ' . $footer . '
            <main>' . $bodyHtml . '</main>
        </body>
        </html>';
    }

    /**
     * Generates a PDF from a template and returns it as a string.
     *
     * @param string $templatePath The path to the template file.
     * @param array $data The data to be injected into the template.
     * @param string $paperFormat The paper format of the generated PDF. Defaults to 'A4'.
     * @param string $orientation The orientation of the generated PDF. Defaults to 'portrait'.
     * @return string The generated PDF as a string.
     */
    public function generateFromTemplate(string $templatePath, array $data): string
    {
        $bodyHtml = $this->renderTemplatePdf($templatePath, $data);
        $fullHtml = $this->buildFullHtml($bodyHtml);

        $this->dompdf->loadHtml($fullHtml);
        $this->dompdf->setPaper($this->format, $this->origin);
        $this->dompdf->render();

        return $this->dompdf->output();
    }

        /**
 * Génère un PDF et l'enregistre dans un fichier sur le serveur
 * @param string $templatePath Contenu HTML à convertir en PDF
 * @param array $data Contenu HTML à insérer sous le titre
 * @param string $cheminFichier Chemin complet (avec nom) où enregistrer le PDF
 * @param string $paperFormat Format papier (par défaut 'A4')
 * @param string $orientation Orientation (par défaut 'portrait')
 * @return bool True si succès, False sinon
 */
public function savePdfToFile(string $templatePath, array $data,string $cheminFichier): bool
{
    $bodyHtml = $this->renderTemplatePdf($templatePath, $data);
    $fullHtml = $this->buildFullHtml($bodyHtml);

    $this->dompdf->loadHtml($fullHtml);
    $this->dompdf->setPaper($this->format, $this->origin);
    $this->dompdf->render();

    $pdfContent = $this->dompdf->output();

    return (bool) file_put_contents($cheminFichier, $pdfContent);
}



    /**
     * Génère un PDF et le télécharge en tant que fichier
     *
     * @param string $templatePath Chemin du template
     * @param array  $data         Données à injecter dans le template
     * @param string $paperFormat  Format du papier (par défaut 'A4')
     * @param string $orientation  Orientation de la page ('portrait' ou 'landscape')
     */
public function downloadPdfFile(string $templatePath, array $data)
{
    $bodyHtml = $this->renderTemplatePdf($templatePath, $data);
    // $bodyHtml = $this->renderTemplatePdf($templatePath, $data);
    $fullHtml = $this->buildFullHtml($bodyHtml);
    $date = date('YmdHis');

    $this->dompdf->loadHtml($fullHtml);
    $this->dompdf->setPaper($this->format, $this->origin);
    $this->dompdf->render();
    $this->dompdf->stream("recu-{$date}.pdf", ["Attachment" => false]);
}


}
