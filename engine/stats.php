<?php
class Stats {
	
	private $registry;
	private $db;
	
	public function __construct($registry) {
		$this->registry = $registry;
		$this->db=$registry->get('db');
	}
	
	public function getNumberOfCustomers() {
		$stats_query = $this->db->query("SELECT COUNT(user_id) AS count_total FROM tab_user WHERE client_of>0");
		if ($stats_query->num_rows) {
			return $stats_query->row['count_total'];
		}
	}
	
	function getNumberOfArchitects() {
		$stats_query = $this->db->query("SELECT COUNT(user_id) AS count_total FROM tab_user WHERE client_of=0");
		if ($stats_query->num_rows) {
			return $stats_query->row['count_total'];
		}
	}
	
	public function getNumberOfProjects() {
		$stats_query = $this->db->query("SELECT COUNT(idproject) AS count_total FROM tab_project JOIN tab_user ON project_authorid=user_id");
		if ($stats_query->num_rows) {
			return $stats_query->row['count_total'];
		}
	}
	
	public function getAllArchitects() {
		$stats_query = $this->db->query("SELECT * FROM tab_user WHERE client_of=0");
		if ($stats_query->num_rows) {
			return $stats_query->rows;
		}
	}
	
	public function getNewsletterAddress() {
		$stats_query = $this->db->query("SELECT * FROM tab_newsletter");
		if ($stats_query->num_rows) {
			return $stats_query->rows;
		}
	}
	
}