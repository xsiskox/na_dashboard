<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nuova_fattura extends CI_Controller {

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
			$data['user']=wp_get_current_user();
			$this->load->model('Fattura_model','model');
			$data['numeroFattura']=$this->model->numero_fattura($data['user']->ID);
			$data['elencoClienti']=$this->model->elenco_clienti($data['user']->ID);
			$this->load->view('nuova_fattura',$data);
		}
		else
		{
			echo 'login';
		}
	}
	public function add_fattura()
	{
		
		$this->load->model('Fattura_model','model');
		$fattura=array
		(
			'cliente_id'=>$this->input->post('formCliente'),
			'fattura_irpef'=>$this->input->post('formIrpef'),
			'fattura_enpapi'=>$this->input->post('formEnpapi'),
			'fattura_numero'=>$this->input->post('formNumeroFattura'),
			'fattura_data'=>$this->input->post('formDataFattura'),
			'fattura_pagato'=>0,
			'fattura_iva'=>$this->input->post('formIva'),
			'user_id'=>$this->input->post('userID'),
			'fattura_irpef_sino'=>(!($this->input->post('formCheckIrpef'))?0:1)
			
		);
		
	
		
		$dettaglio_fattura=array
		(
			'fattura_id'=>0,
			'descrizione'=>$this->input->post('descrizione'),
			'quantita'=>$this->input->post('qta'),
			'prezzo_unitario'=>$this->input->post('prezzoUnitario'),
			'imponibile'=>$this->input->post('setImponibile')
		);
		$this->model->insert_data($fattura,$dettaglio_fattura);
		$this->index();
	}
}