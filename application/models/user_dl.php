<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class User_dl extends CI_Model {

		function __construct()
		{

			parent::__construct();
		}

		function create_table()
		{

			$sql = "CREATE TABLE IF NOT EXISTS dl_report (
						id int(11) NOT NULL PRIMARY KEY,
						track_id int(11) NOT NULL,
						ip_address varchar(20) DEFAULT NULL,
						expiry_date datetime DEFAULT NULL,
						transaction_id int(11) NOT NULL,
						dl_status varchar(30) NOT NULL,
						dl_source varchar(30) DEFAULT NULL,
						dl_type varchar(30) NOT NULL,
						dl_date datetime NOT NULL
					)";

			try{
				$query = $this->db->query($sql);
			} catch(Exception $e){
				throw $e;
			}
			
		}

		function drop_table()
		{

			$sql = "DROP TABLE IF EXISTS dl_report";

			try{
				$query = $this->db->query($sql);
			} catch(Exception $e){
				throw $e;
			}

		}

		function add($id, $track_id, $ip_address, $expiry_date, $transaction_id, $dl_status, $dl_source, $dl_type, $dl_date)
		{

			$data = array(
							"id" => $id,
							"track_id" => $track_id,
							"ip_address" => $ip_address,
							"expiry_date" => $expiry_date,
							"transaction_id" => $transaction_id,
							"dl_status" => $dl_status,
							"dl_source" => $dl_source,
							"dl_type" => $dl_type,
							"dl_date" => $dl_date
							);
			try{
				$this->db->insert('dl_report', $data);
			} catch (Exception $e) {
				throw $e;
			}

		}

		function getAll() 
		{

			try{
				$query = $this->db->query('SELECT * FROM dl_report ORDER BY dl_date DESC');
			} catch(Exception $e){
				throw $e;
			}

			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}

		}

		function getByIP($ip)
		{

			$sql = "SELECT * FROM dl_report WHERE ip_address LIKE '$ip'";
			try{
				$query = $this->db->query($sql);
			} catch(Exception $e){
				throw $e;
			}

			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}

		}


		function getByDate($date, $datefrom, $dateto)
		{

			$sql = "SELECT * FROM dl_report WHERE $date >= '$datefrom' AND $date <= '$dateto' ORDER BY $date DESC";

			try{
				$query = $this->db->query($sql);
			} catch(Exception $e){
				throw $e;
			}

			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return null;
			}

		}

	}
