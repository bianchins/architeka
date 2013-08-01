<?php

class project {

	private $registry;

	private $db;

	public function __construct($registry) {
		$this->registry=$registry;
		$this->db=$registry->get('db');
	}

	/*
	* Ottiene l'author id di un progetto
	*
	*/
	public function getAuthorId($idproject) {
		$entry_query = $this->db->query("SELECT project_authorid FROM tab_project WHERE idproject='" . $idproject . "'");
		if ($entry_query->num_rows) {
			return $entry_query->row['project_authorid'];
		}
	}

	/*
	* Invia una mail di notifica per l'entry
	*/
	public function getAuthorIdMail($idproject) {
		$entry_query = $this->db->query("SELECT email FROM tab_project JOIN tab_user ON user_id=project_authorid WHERE idproject='" . $idproject . "' AND notify_on_entry=1");
		if ($entry_query->num_rows) {
			return $entry_query->row['email'];
		}
		else return false;
	}

	/*
	* Ottiene il nome di un progetto
	*/
	public function getName($idproject) {
		$entry_query = $this->db->query("SELECT project_description FROM tab_project WHERE idproject='" . $idproject . "'");
		if ($entry_query->num_rows) {
			return $entry_query->row['project_description'];
		}
	}

	/*
	* Elimina un progetto
	*/
	public function delete($idproject) {
		//!Mancano tutti i controlli del caso (il professionista ha il diritto di eliminare il progetto?)
		$query= $this->db->query("DELETE FROM tab_project WHERE idproject='".$this->db->escape($idproject)."'");
	}

	/*
	* Inserimento di un nuovo progetto
	*
	*/
	public function insert($project_description,$project_authorid,$project_comune) {
		$insert_query = $this->db->query("INSERT INTO tab_project(project_description,project_authorid,project_comune) VALUES('".$this->db->escape($project_description)."','".$this->db->escape($project_authorid)."','".$this->db->escape($project_comune)."')");		
		if($insert_query) return true;
		else return false;
	}

	/*
	* Gestione dell'associazione cliente - progetto
	*
	*/
	public function updateClients($array_user_id,$idproject) {
		$this->db->query("DELETE FROM tab_user_project WHERE corr_project_id='".$this->db->escape($idproject)."' AND corr_isCollaborator=0");
		foreach($array_user_id as $user) {
			$insert_query = $this->db->query("INSERT INTO tab_user_project(corr_user_id,corr_project_id,corr_isCollaborator) VALUES('".$this->db->escape($user)."','".$this->db->escape($idproject)."','0')");
		}

	}	/*	* Gestione dell'associazione collaboratore - progetto	*	*/	public function updateCollaborators($array_user_id,$idproject) {		$this->db->query("DELETE FROM tab_user_project WHERE corr_project_id='".$this->db->escape($idproject)."' AND corr_isCollaborator=1");		foreach($array_user_id as $user) {			$insert_query = $this->db->query("INSERT INTO tab_user_project(corr_user_id,corr_project_id,corr_isCollaborator) VALUES('".$this->db->escape($user)."','".$this->db->escape($idproject)."','1')");		}	}

	/*
	* Ottiene le email dei clienti che hanno richiesto la notifica su nuove entry
	*/
	public function getClientsMailWithNotify($idproject) {
		$entry_query = $this->db->query("SELECT email FROM tab_user_project LEFT JOIN tab_user ON corr_user_id=user_id WHERE corr_project_id='".$idproject."' AND notify_on_entry=1");
		if ($entry_query->num_rows) {
			return $entry_query->rows;
		}
		else {
			return NULL;
		}
	}

	/*
	* Ottiene la lista degli user_id dei clienti di un determinato progetto
	*/
	public function getClients($idproject) {
		$entry_query = $this->db->query("SELECT user_id, firstname, lastname, title FROM tab_user_project LEFT JOIN tab_user ON corr_user_id=user_id WHERE corr_project_id='".$idproject."'");
		if ($entry_query->num_rows) {
			return $entry_query->rows;
		}
		else {
			return NULL;
		}
	}	/*	* Ottiene la lista degli user_id dei collaboratori di un determinato progetto	*/	public function getCollaborators($idproject) {		$entry_query = $this->db->query("SELECT user_id, firstname, lastname, title FROM tab_user_project LEFT JOIN tab_user ON corr_user_id=user_id WHERE corr_project_id='".$idproject."' AND isCollaborator=1");		if ($entry_query->num_rows) {			return $entry_query->rows;		}		else {			return NULL;		}	}

	/*
	* Ottiene tutti i progetti seguiti da un determinato professionista
	*
	*/
	public function getAll($user_id) {
		$entry_query = $this->db->query("SELECT COUNT(corr_user_id) AS clienti, project_description, idproject FROM tab_project LEFT JOIN tab_user_project ON idproject=corr_project_id WHERE (project_authorid='".$user_id."' OR corr_user_id='".$user_id."') GROUP BY idproject, project_description");
		if ($entry_query->num_rows) {
			return $entry_query->rows;
		}
		else {
			return NULL;
		}
	}

	/*
	* Ottiene il numero dei progetti seguiti da un determinato professionista
	*
	*/
	public function getProjectNumbers($project_authorid) {
		$entry_query = $this->db->query("SELECT idproject FROM tab_project WHERE project_authorid='".$project_authorid."'");
		//Ottengo il numero di righe
		return $entry_query->num_rows;
	}

	public function getAllWithClients($user_id) {
		$entry_query = $this->db->query("SELECT * FROM tab_project AS tp LEFT JOIN tab_user_project AS tup ON idproject=corr_project_id LEFT JOIN tab_user ON corr_user_id=user_id WHERE (project_authorid='".$user_id."' OR corr_user_id='".$user_id."') ORDER BY idproject, corr_isCollaborator");
		if ($entry_query->num_rows) {
			return $entry_query->rows;
		}
		else {
			return NULL;
		}
	}



}

?>