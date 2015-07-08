<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class User_dl extends CI_Model {

		function __construct()
		{

			parent::__construct();
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