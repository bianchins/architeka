<?php
/**
 * Classe exportPDF.php
 * @author Stefano Bianchini
 * 
 * Esporta la Bacheca del progetto in formato PDF
 */

require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}
//Carico le librerie neccessarie
require_once('engine/tcpdf/config/lang/ita.php');
require_once('engine/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Architeka');
$pdf->SetTitle('Bacheca di Progetto');
$pdf->SetSubject('Architeka');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('', '', '', '');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

/*
 * Qui inizio caricamento dati
 */

/*
 * Creazione oggetti
 */
$e = new entry($registry);

$p=new project($registry);

$filter="";

//!QUA FARE TUTTI I CONTROLLI DI DIRITTI PER IL PROGETTO SELEZIONATO
//e' un cliente, non puo' stampare il progetto in pdf (puo' solo l'architetto)
if($user->clientOf()>0) {
	$filter=' AND 0';
} else {
	//non e' un cliente, e' il professionista
	//Controllo che il professionista sia il project_authorid
	if($session->data['idproject']>0) {
		if($p->getAuthorId($session->data['idproject'])==$user->getId()) {
			$filter=" AND entry_project_id='".$session->data['idproject']."'";
		}
		else $filter=' AND 0';
	}
}

$entryArray = $e->getAllEntry($filter,'');
$nome_progetto = $p->getName($session->data['idproject']);$professionista = $user->getTitle().' '.$user->getFirstname().' '.$user->getLastname();$listaClienti=$p->getClients($session->data['idproject']);
/*
 * Strutturo l'array delle entry
 */
foreach($entryArray as $entry) {

	$entries[] = array(
	'content'=>$e->elaborateContent($entry['entry_content'],$entry['entry_type']),
	'originalContent'=>$entry['entry_content'],
	'type'=>$entry['entry_type'],
	'entry_id'=>$entry['entry_id'],
	'photo'=>$entry['photo'],
	'description'=>$entry['entry_description'],
	'author'=> $entry['title'].' '.$entry['firstname'].' '.$entry['lastname'], //$e->getAuthorName($entry['entry_author_id']),
	'author_id'=>$entry['entry_author_id'],
	'publish_time'=>$entry['entry_publish_time'],
	'publish_date'=>$e->getPublishDate($entry['entry_publish_date']),
	'comments_list'=>$e->getComments($entry['entry_id'])
	);

}

ob_start();?><style>.rigabassa {border-bottom: 1px solid #cccccc;}</style><h2>Nome progetto: <i><?php echo $nome_progetto;?></i></h2><h3>Eseguito da <?php echo $professionista?></h3>Clienti: <?php foreach($listaClienti as $cliente) { echo $cliente['title'].' '.$cliente['firstname'].' '.$cliente['lastname'].'<br/>';} ?><div class="rigabassa"> </div><?php 
foreach($entries as $entry) {?>
<table id="post">

    <thead id="post">
        <tr>
        	<td>
            <h3><?php echo $entry['author'] ?> </h3>
            </td>
        	<td>
 			<p><?php echo $entry['publish_date'] ?>, <?php echo $entry['publish_time'] ?></p>
            </td>
        </tr>
      </thead>
	<tbody>
	<tr>
		<td valign="top"> 		<?php 		if(file_exists(DIR_IMAGE.$entry['photo']))			echo '<img src="'.DIR_IMAGE.$entry['photo'].'.jpg" />'; 		else			echo '&nbsp;';		?>		</td>
        
		<td>
		<blockquote><span><?php echo $entry['description'] ?></span></blockquote>
		<?php if ($entry['type']!=1) echo $entry['content']."<br/>"; 		else if(file_exists(DIR_IMAGE.$session->data['idproject'].'/'.$entry['originalContent'])) {			echo '<img src="'.DIR_IMAGE.$session->data['idproject'].'/'.$entry['originalContent'].'"/>'; 		}		?> 
        <!-- commenti -->
		<div class="comment_box"><?php 
			if($entry['comments_list']!=NULL)
			foreach($entry['comments_list'] as $comment) {
				?>
                
			<div class="comment_post">
				<span class="title_post"><?php echo LANG_COMMENT_OF;?> <a href="profile.php?userid=<?php echo $comment['comment_author_id'] ?>"><?php echo $comment['comment_author'] ?></a></span>
				<span class="data_post"><?php echo LANG_ATTIME;?> <?php echo $comment['comment_time'] ?> <?php echo LANG_OFDAY;?> <?php echo $comment['comment_date'] ?></span>
				<p><span class="content_post"><?php echo $comment['comment_content'] ?></span></p>
			</div>
			<?php } ?>
		</div>
		<!-- fine commenti -->
        </td>
	</tr>
    </tbody> 
</table>
<?php 
}  

$html = ob_get_contents();
ob_end_clean();
/*
 * Fine caricamento dati
 */

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('architekaProject.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
