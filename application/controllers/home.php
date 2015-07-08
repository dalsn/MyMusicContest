<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() 
	{

		parent::__construct();

		//load helpers
		$this->load->helper('form'); //form helper
		$this->load->helper('url'); //url helper

		//load libraries
		$this->load->library('session'); //session library

		//load models
		$this->load->model('user_dl');

		$msg = null;

	}

	public function index()
	{
		$this->load->view('homepage');
		$this->session->unset_userdata('uploadmsg');
	}

	public function do_upload() 
	{

		$config['allowed_types'] = 'csv';
		$config['max_size']	= '3072';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$config['upload_path'] = "./uploadedfiles/";
		$field_name = 'csvfile';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($field_name))
		{

			$msg = $this->upload->display_errors();
			$this->session->set_userdata('uploadmsg', $this->msg);
			redirect('home');

		}
		else
		{

			$file_data = $this->upload->data();
			$this->session->set_userdata('file_data', $file_data);
			$filename = $file_data['file_name'];
			$this->save_to_database($filename);
			redirect('home');
			
		}

	}

	private function parse_file($p_Filepath, $p_NamedFields = true) 
	{

	    $separator = ',';
	    $max_row_size = 4096;

        $content = false;
        $file = fopen($p_Filepath, 'r');
        if($p_NamedFields) {
            $fields = fgetcsv($file, $max_row_size, $separator);
        }
        while( ($row = fgetcsv($file, $max_row_size, $separator)) != false ) {            
            if( $row[0] != null ) {
                if( !$content ) {
                    $content = array();
                }
                if( $p_NamedFields ) {
                    $items = array();

                    // I prefer to fill the array with values of defined fields
                    foreach( $fields as $id => $field ) {
                        if( isset($row[$id]) ) {
                            $items[$field] = $row[$id];    
                        }
                    }
                    $content[] = $items;
                } else {
                    $content[] = $row;
                }
            }
        }

        fclose($file);
        return $content;

    }

    function save_to_database($filename)
    {

    	$filename = './uploadedfiles/'.$filename;
		$records = $this->parse_file($filename);

		$sql = "DROP TABLE IF EXISTS dl_report";

		try{
			$query = $this->db->query($sql);
		} catch(Exception $e){
			throw $e;
		}

		if (!empty($records)) {

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

			for ($i = 0; $i < count($records); $i++){

				$id = $records[$i]['ID'];
				$track_id = $records[$i]['TRACK ID'];
				$ip_address = $records[$i]['IP ADDRESS'];
				$expiry_date = date('Y-m-d H:i:s', strtotime($records[$i]['EXPIRY DATE']));
				$transaction_id = $records[$i]['TRANSACTION ID'];
				$dl_status = $records[$i]['STATUS'];
				$dl_source = $records[$i]['SOURCE'];
				$dl_type = $records[$i]['TYPE'];
				$dl_date = date('Y-m-d H:i:s', strtotime($records[$i]['DOWNLOAD DATE']));

				try {

					$this->user_dl->add($id, $track_id, $ip_address, $expiry_date, $transaction_id, $dl_status, $dl_source, $dl_type, $dl_date);

				} catch(Exception $e) {

					echo 'Error occurred: ', $e->getMessage(), "\n";

				}
				

			}

			$msg = 'Saving to database completed!';
			$this->session->set_userdata('uploadmsg', $msg);

		} else {

			$msg = 'No content to save to database!';
			$this->session->set_userdata('uploadmsg', $msg);

		}

    }

    function load_table()
    {

    	try {
    		$records = $this->user_dl->getAll();
    	} catch (Exception $e) {
    		echo "Database Error: $e->getMessage()"; 
    	}
    	
		$data['records'] = $records;
		$this->load->view('report', $data);

    }

    function search()
    {
    	$ip_address = trim($this->input->post('ipaddress'));

    	$records = $this->user_dl->getByIP($ip_address);

		$data['records'] = $records;
		$this->load->view('report', $data);
    }

    function searchdates()
    {
    	$datefrom = trim($this->input->post('date1'));
    	$dateto = trim($this->input->post('date2'));
    	$selectdate = $this->input->post('selectdate');

    	$date = ($selectdate == 1 ? 'expiry_date' : 'dl_date');

    	$datefrom = date('Y-m-d', strtotime($datefrom));
    	$dateto = date('Y-m-d', strtotime($dateto));

    	$records = $this->user_dl->getByDate($date, $datefrom, $dateto);

		$data['records'] = $records;
		$this->load->view('report', $data);
    }
}



