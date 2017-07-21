<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Elenco_fatture extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('wpusers');
		
	}
	public function index()
	{
		
		if(is_user_logged_in())
		{
			$this->load_view('-','tutti');
			
		}
		else
		{
			$this->load->view('login');

		}
		
	}
	
	public function refresh_view()
	{
		$year=$this->input->post('anno');
		$this->load_view('refresh',$year);
	}
	public function elencoFatture()
	{
		$this->load_view('elenco','');
	}
	public function get_dettaglio()
	{
		$user=wp_get_current_user();
		$id=$this->input->post('fattura');
		$this->load->model('Fattura_model','model');
		$data['list']=$this->model->get_dettagli_fattura($user->ID,$id);
		echo $this->load->view('templates/elenco_fatture/dettagli',$data,true);
		
	}
	private function load_view($mess,$anno)
	{
		
		$user=wp_get_current_user();
		$this->load->model('Fattura_model','model');
		//$anno="tutti";
		$cliente="tutti";
		$pagato="";
		$data['list']=$this->model->get_fatture_list($user->ID,$anno,$cliente,$pagato);
		switch($mess)
		{
			case 'refresh':
				echo $this->load->view('templates/elenco_fatture/list',$data,true);
				break;
			case 'elenco':
				$data['user']=$user;
				$data['anni_list']=$this->model->get_anni_list($user->ID);
				echo $this->load->view('templates/elenco_fatture/list_fatture',$data,true);
				break;
			default:
				$data['user']=$user;
				$data['anni_list']=$this->model->get_anni_list($user->ID);
				$this->load->view('elenco_fatture',$data);
				
		}
		
	}
	
}
	