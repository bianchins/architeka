<?php

/**
 *
 * @author Stefano Bianchini
 *
 */
class appointment {

	private $registry;

	public function __construct($registry) {
		$this->registry=$registry;
		$this->db=$registry->get('db');

	}
	/*
	 * Inserimento di un appuntamento
	 */
	public function insertAppointment($author_id,$idproject,$description,$place,$date,$time) {
		
		$date_db=substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2);
		
		$res = $this->db->query("INSERT INTO tab_appointment(appointment_description,appointment_date,appointment_time,appointment_project_id,appointment_place,appointment_author_id) VALUES ('".$this->db->escape($description)."','".$this->db->escape($date_db)."','".$this->db->escape($time)."','".$this->db->escape($idproject)."','".$this->db->escape($place)."','".$this->db->escape($author_id)."')");
	}
	
	/*
	 * Ottiene i dati di un appuntamento specifico
	 */
	public function getAppointment($appointment_id) {
		$entry_query = $this->db->query("SELECT appointment_id, appointment_description, DATE_FORMAT(appointment_date, '%d/%m/%Y') AS appointment_date, TIME_FORMAT(appointment_time,'%H:%i') AS appointment_time,appointment_project_id,appointment_place,appointment_author_id, project_description,idproject FROM tab_appointment JOIN tab_project ON appointment_project_id=idproject WHERE appointment_id='".$appointment_id."'  ORDER BY appointment_date DESC, appointment_time DESC");
		if ($entry_query->num_rows) {
			return $entry_query->row;
		}
		else {
			return NULL;
		}
	}
	/*
	 * Ottiene la lista di tutti gli appuntamenti futuri
	 * @param $filter il filtro applicato alla query
	 */
	public function getAllAppointment($filter) {
		$entry_query = $this->db->query("SELECT appointment_id, appointment_description, DATE_FORMAT(appointment_date, '%d/%m/%Y') AS appointment_date, TIME_FORMAT(appointment_time,'%H:%i') AS appointment_time,appointment_project_id,appointment_place,appointment_author_id,project_description,idproject FROM tab_appointment JOIN tab_project ON appointment_project_id=idproject WHERE 1 ".$filter."  ORDER BY appointment_date DESC, appointment_time DESC");
		if ($entry_query->num_rows) {
			return $entry_query->rows;
		}
		else {
			return NULL;
		}
	}
		public function deleteAppointment($appointment_id,$actual_user_id) {		return $this->db->query("DELETE FROM tab_appointment WHERE appointment_id='".$this->db->escape($appointment_id)."' AND appointment_author_id='".$actual_user_id."'");			}	
}
?>