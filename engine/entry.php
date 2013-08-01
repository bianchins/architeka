<?php

/**
 *
 * @author Stefano Bianchini
 *
 * Tipo di entry (ID):
 * 1) Immagine
 * 2) Link
 * 3) Messaggio
 * 4) Allegato
 * 5) Mappa
 * 6) Incontro / Appuntamento / Evento
 */
class entry {

	private $registry;

	public function __construct($registry) {
		$this->registry=$registry;
		$this->db=$registry->get('db');

	}

	/*
	 * Invio notifica via mail
	 */
	public function sendNotifyMail($to,$entry_description,$entry_content) {
		//!da fare: gestione contenuti entry, gestione lettere accentate e caratteri particolari
		// (forse enconding da cambiare in mail.php?)	
		$m = new Mail();
		$m->setTo($to);
		$m->setSender('Architeka');
		$m->setFrom('no-reply@architeka.it');
		$m->setSubject('Nuovo elemento sul progetto che stai seguendo - Portale Architeka.it');
		$m->setText('Ciao, è stata pubblicato un nuovo elemento: '.$m->newline.$m->newline.$entry_description.$m->newline.$m->newline.'Collegati a '.SITE_URL.' per leggere la entry completa'.$m->newline.$m->newline.$m->newline.'Architeka is a product of Simplenetworks s.r.l');
		$m->send();
		
	}
	
	/*
	 * Elaborazione visiva del contenuto di una entry a seconda del tipo
	 */
	public function elaborateContent($content,$entry_type) {
		switch($entry_type) {
			
			case "1": 				if(file_exists(DIR_IMAGE.$this->registry->get('session')->data['idproject']."/or_".$content))									return '<a href="image.php?name=or_'.$content.'" rel="facebox"><img src="image.php?name='.$content.'" /></a>';							else 					return '<img src="image.php?name='.$content.'" />';
				break;
			case "2": return '<img src="template/default/images/icons/icon_link.gif" align="absmiddle" style="border:0px;"/> <a href="'.$content.'" target="_blank">'.$content.'</a>';
				break;
			case "3": return $content;
				break;
			case "4": return '<img src="template/default/images/icons/icon_attachment.gif" align="absmiddle" style="border:0px;"/> <a href="attachment.php?name='.$content.'" target="_blank">'.$content.'</a>';
				break;
			case "5":
				$prova = '		<div id="map_canvas'.md5($content).'"
			style="width: 400px; height: 250px; border: 1px solid #cccccc;"></div>
		<script type="text/javascript">


      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas'.md5($content).'"));
        map.setCenter(new GLatLng('.$content.'), 13);
		map.addOverlay(new GMarker(new GLatLng('.$content.')));
        map.setUIToDefault();
      }

	</script>';
				
					  return $prova;
				break;											
		}
		
	}
	
	/*
	 * Ottiene i dati di una entry specifica
	 */
	public function getSpecificEntry($entry_id) {
		$entry_query = $this->db->query("SELECT * FROM tab_entry WHERE entry_id='" . $entry_id . "'");
		if ($entry_query->num_rows) {
			return $entry_query->row;
		}
		else {
			return NULL;
		}

	}

	/*
	 * Ottiene tutte le entry filtrate
	 * @param $filter parte della query che filtra l'elenco
	 * @param $limit solitamente e' LIMIT 0,15
	 */
	public function getAllEntry($filter,$limit="") {
		$entry_query = $this->db->query("SELECT * FROM tab_entry JOIN tab_user ON entry_author_id=user_id WHERE 1 ".$filter." ORDER BY entry_publish_date DESC, entry_publish_time DESC ".$limit);
		if ($entry_query->num_rows) {
			return $entry_query->rows;
		}
		else {
			return NULL;
		}
	}

	/*
	 * Elimina una entry
	 */
	public function deleteEntry($entry_id) {
		//!Devo controllare di avere i diritti per cancellare (CONTROLLO DA FARE)
		$entry = $this->getSpecificEntry($entry_id);
		switch($entry["entry_type"]) {
			//Cancello l'immagine
			case '1':
					unlink(DIR_IMAGE.$entry['entry_project_id'].'/'.$entry['entry_content']);
					break;
			case '4':
					unlink(DIR_ATTACHMENT.$entry['entry_content']);
					break;		
		}
		$entry_query = $this->db->query("DELETE FROM tab_entry WHERE entry_id='".$this->db->escape($entry_id)."'");
		$entry_query = $this->db->query("DELETE FROM tab_comments WHERE comment_entry_id='".$this->db->escape($entry_id)."'");
		
	}
	/**	 * 	 * Eliminazione commento	 * @param int $comment_id	 */	public function deleteComment($comment_id) {		//!Devo controllare di avere i diritti per cancellare (CONTROLLO DA FARE)		$entry_query = $this->db->query("DELETE FROM tab_comments WHERE comment_id='".$this->db->escape($comment_id)."'");	}	
	/*
	 * Inserimento di una nuova entry
	 */
	public function insertEntry($entry_author_id,$entry_receiver_id,$entry_project_id,$entry_description,$entry_content,$entry_type) {
		//filtrare tutti i parametri con $this->db->escape
		$entry_author_id = $this->db->escape($entry_author_id);
		$entry_description = $this->db->escape($entry_description);
		$entry_project_id = $this->db->escape($entry_project_id);
		$entry_content = $this->db->escape($entry_content);
		$entry_type = $this->db->escape($entry_type);
		
		//Controllo: author_id, project_id e type devono essere numeri		
		if(!is_numeric($entry_author_id) || !is_numeric($entry_project_id) || !is_numeric($entry_type)) {
			return false;
		}
		/*
		 * Salvo diversamente a seconda del tipo di entry
		 */
		switch($entry_type) {
			//Immagine
			case 1:
				if (!file_exists(DIR_IMAGE.$this->registry->get('session')->data['idproject'])) {
					@mkdir(DIR_IMAGE.$this->registry->get('session')->data['idproject']);
				}
				$request = $this->registry->get('request');
				
				if(is_uploaded_file($request->files['attachment']['tmp_name'])) {	
					$imm = new Image($request->files['attachment']['tmp_name']);
					if(!$imm->isImage()) return;
					$info = pathinfo($request->files['attachment']['name']);
					
					if($info['extension'] == ('jpeg' || 'jpg')) {
						$entry_content = md5(microtime()).".jpg";
					} elseif($info['extension'] == 'png') {
						$entry_content = md5(microtime()).".png";
					} elseif($info['extension'] == 'gif') {
						$entry_content = md5(microtime()).".gif";
					} else $entry_content = md5(microtime()).".jpg";					//Salvo l'originale					$temp = new Image($request->files['attachment']['tmp_name']);					$temp->resize(1000);
					$temp->save(DIR_IMAGE.$this->registry->get('session')->data['idproject']."/or_".$entry_content);					//Ridimensiono					$imm->resize(400);					//Salvo il ridimensionato
					$imm->save_withWatermark(DIR_IMAGE.$this->registry->get('session')->data['idproject']."/".$entry_content);
					$res = $this->db->query("INSERT INTO tab_entry(entry_author_id,entry_receiver_id,entry_project_id,entry_description,entry_publish_date,entry_publish_time,entry_content,entry_type) VALUES('".$entry_author_id."','".$entry_receiver_id."','".$entry_project_id."','".$entry_description."','".date("Y-m-d")."','".date("H:i:s")."','".$entry_content."','".$entry_type."')");
				}				
				break;
			//Link
			case 2: 
				if (filter_var($entry_content, FILTER_VALIDATE_URL)) {
					$res = $this->db->query("INSERT INTO tab_entry(entry_author_id,entry_receiver_id,entry_project_id,entry_description,entry_publish_date,entry_publish_time,entry_content,entry_type) VALUES('".$entry_author_id."','".$entry_receiver_id."','".$entry_project_id."','".$entry_description."','".date("Y-m-d")."','".date("H:i:s")."','".$entry_content."','".$entry_type."')");
				}
				break;
			//Messaggio
			case 3: $res = $this->db->query("INSERT INTO tab_entry(entry_author_id,entry_receiver_id,entry_project_id,entry_description,entry_publish_date,entry_publish_time,entry_content,entry_type) VALUES('".$entry_author_id."','".$entry_receiver_id."','".$entry_project_id."','".$entry_description."','".date("Y-m-d")."','".date("H:i:s")."','".$entry_content."','".$entry_type."')");
				break;
			//Allegato
			case 4: 
				if (!file_exists(DIR_ATTACHMENT.$this->registry->get('session')->data['idproject'])) {
					@mkdir(DIR_ATTACHMENT.$this->registry->get('session')->data['idproject']);
				}
				$request = $this->registry->get('request');	
				//Controllo che il file non sia maggiore di 16 MB
				if (filesize($request->files['attachment']['tmp_name'])>16777216) {
					return false;
				}					
				$info = pathinfo($request->files['attachment']['name']);				
				$entry_content = md5(microtime()).'.'.$info['extension'];			
				if(is_uploaded_file($request->files['attachment']['tmp_name'])) {					
					if(move_uploaded_file($request->files['attachment']['tmp_name'],DIR_APPLICATION.DIR_ATTACHMENT.$this->registry->get('session')->data['idproject'].'/'.$entry_content)) {
						$res = $this->db->query("INSERT INTO tab_entry(entry_author_id,entry_receiver_id,entry_project_id,entry_description,entry_publish_date,entry_publish_time,entry_content,entry_type) VALUES('".$entry_author_id."','".$entry_receiver_id."','".$entry_project_id."','".$entry_description."','".date("Y-m-d")."','".date("H:i:s")."','".$entry_content."','".$entry_type."')");
					}
				}
				break;
			//Mappa
			case 5:  $res = $this->db->query("INSERT INTO tab_entry(entry_author_id,entry_receiver_id,entry_project_id,entry_description,entry_publish_date,entry_publish_time,entry_content,entry_type) VALUES('".$entry_author_id."','".$entry_receiver_id."','".$entry_project_id."','".$entry_description."','".date("Y-m-d")."','".date("H:i:s")."','".$entry_content."','".$entry_type."')");
				break;
			//Appuntamento: deprecato (inseribile tramite date.php)
			case 6:
				break;
			default:  $res = $this->db->query("INSERT INTO tab_entry(entry_author_id,entry_receiver_id,entry_project_id,entry_description,entry_publish_date,entry_publish_time,entry_content,entry_type) VALUES('".$entry_author_id."','".$entry_receiver_id."','".$entry_project_id."','".$entry_description."','".date("Y-m-d")."','".date("H:i:s")."','".$entry_content."','".$entry_type."')");
				break;	
		}
		
	}

	/*
	 * Inserimento di un commento
	 */
	public function insertComment($entry_id,$comment_author_id,$content) {
		$res = $this->db->query("INSERT INTO tab_comments(comment_entry_id,comment_author_id,comment_content,comment_date,comment_time) VALUES('".$entry_id."','".$comment_author_id."','".$this->db->escape($content)."','".date("Y-m-d")."','".date("H:i")."')");
		//echo "INSERT INTO tab_comments(comment_entry_id,comment_author_id,comment_content,comment_date,comment_time) VALUES('".$entry_id."','".$comment_author_id."','".$content."','".date("Y-m-d")."','".date("H:i")."')";
	}

	/*
	 * Ottiene i commenti di una entry specificata
	 */
	public function getComments($entry_id) {
		$entry_query = $this->db->query("SELECT comment_id, comment_entry_id, comment_author_id, comment_content,DATE_FORMAT(comment_date, '%d/%m/%Y') AS comment_date, TIME_FORMAT(comment_time,'%H:%i') AS comment_time, firstname, lastname FROM tab_comments JOIN tab_user ON comment_author_id=user_id WHERE comment_entry_id='".$entry_id."' ORDER BY comment_date ASC, comment_time ASC");
		if ($entry_query->num_rows) {
			$commenti = array();
			foreach($entry_query->rows as $righe) {
					
				$commenti[] = array(
				'comment_author_id'=>$righe['comment_author_id'],								'comment_id'=>$righe['comment_id'],
				'comment_date'=>$righe['comment_date'],
				'comment_time'=>$righe['comment_time'],
				'comment_content'=>$righe['comment_content'],
				'comment_author'=>$righe['firstname']." ".$righe['lastname']
				);
			}
			return $commenti;
		}
		else {
			return NULL;
		}
	}

	public function getContent() {
		return $this->content;
	}

	public function getEntryType() {
		return $this->entryType;
	}

	/*
	 * Trasforma la data yyyy-mm-dd in una data leggibile
	 */
	public function getPublishDate($date) {
		$day_of_week_numeric = date("w",mktime(0, 0, 0, substr($date,5,2), substr($date,8,2), substr($date,0,4)));		switch($day_of_week_numeric) {			case 0: $day_of_week = LANG_SUNDAY; break;			case 1: $day_of_week = LANG_MONDAY; break;			case 2: $day_of_week = LANG_TUESDAY; break;			case 3: $day_of_week = LANG_WEDNESDAY; break;			case 4: $day_of_week = LANG_THURSDAY; break;			case 5: $day_of_week = LANG_FRIDAY; break;			case 6: $day_of_week = LANG_SATURDAY; break;		}		$month_numeric=date("m",mktime(0, 0, 0, substr($date,5,2), substr($date,8,2), substr($date,0,4)));		switch($month_numeric) {			case 1: $month = LANG_JANUARY; break;			case 2: $month = LANG_FEBRUARY; break;			case 3: $month = LANG_MARCH; break;			case 4: $month = LANG_APRIL; break;			case 5: $month = LANG_MAY; break;			case 6: $month = LANG_JUNE; break;			case 7: $month = LANG_JULY; break;			case 8: $month = LANG_AUGUST; break;			case 9: $month = LANG_SEPTEMBER; break;			case 10: $month = LANG_OCTOBER; break;			case 11: $month = LANG_NOVEMBER; break;			case 12: $month = LANG_DECEMBER; break;		}						return $day_of_week." ".date("d", mktime(0, 0, 0, substr($date,5,2), substr($date,8,2), substr($date,0,4)))." ".$month." ".date("Y", mktime(0, 0, 0, substr($date,5,2), substr($date,8,2), substr($date,0,4)));
	}

	/*
	 * DEPRECATO per ottimizzazione query sql
	 */
	private function getAuthorName($author_id) {
			
		$entry_query = $this->db->query("SELECT firstname,lastname FROM tab_user WHERE user_id='" . $author_id . "'");
		if ($entry_query->num_rows) {
			return $entry_query->row['firstname']." ".$entry_query->row['lastname'];
		}
	}

	public function getDescription() {
		return $this->description;
	}



}
?>