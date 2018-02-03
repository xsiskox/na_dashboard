<?php
/**
 * classe principale
 * @param1 parametro 1
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('sidebarmenuitems');
		$this->load->helper('wpusers');
		$this->load->library('na_cv');
	    
		
	}

    /**
     *
     */
    public function index()
	{
		if(is_user_logged_in())
		{
			$data['user']=wp_get_current_user();
			$data["myHTML"]=$this->load->view("home",'',true);
			$this->load->view('dashboard_view',$data);
		}
		else
		{
			/*-- open login form --*/
			redirect("/wp-login.php");
			
		}
	}
	public function elenco_clienti()
	{
		if(is_user_logged_in())
		{
			$user=wp_get_current_user();
			$this->load->model('Fattura_model','model');
			$data['list']=$this->model->elenco_clienti($user->ID);
			echo $this->load->view('templates/clienti/list_clienti',$data,true);
		}
		else{redirect('/wp-login.php');}
	}
	public function elenco_fatture()
	{

		if(is_user_logged_in()){$this->load_view('','','','');}
		else{redirect('/wp-login.php');}
	}
	public function refresh_view()
	{
		$year=$this->input->post('anno');
		$customer=$this->input->post('cliente');
		$status=$this->input->post('status');
		$this->load_view('refresh',$year,$customer,$status);
	}
	public function home()
	{
		if(is_user_logged_in())
		{
			echo $this->load->view('home','',true);
		}
		else
		{
			redirect('/wp-login.php');
		}
	}
	public function get_dettaglio()
	{
		
		if(is_user_logged_in())
		{
			
			$id=$this->input->post('fattura');
			$data=$this->dettaglio_fattura($id);
			echo $this->load->view('templates/fatture/dettagli',$data,true);
		}
		else
		{
			redirect('/wp-login.php');
		}
	}

    /**
     * @param $id_fattura
     */
    public function set_invoice_pdf($id_fattura)
	{
		//load dati fattura (data, numero,irpef%,...)
		$this->load->model('Fattura_model','model');
		$data['data']=$this->model->get_fattura_data($id_fattura);
		//load deCuld1945@teleworm.usttagli fattura
		$data['dettaglio']=$this->model->get_dettagli_fattura($id_fattura);
		//load dati cliente todo: add code to load customer data
		$id_cliente=$data['data'][0]['cliente_id'];
		$data['cliente']=$this->model->get_cliente($id_cliente);
		echo json_encode($data);

	}
	/**
	 * @param $id_fattura
	 * @param $mess
	 * @return mixed
	 */
	private function dettaglio_fattura($id_fattura)
	{
			$user=wp_get_current_user();
			$this->load->model('Fattura_model','model');
			$data['list']=$this->model->get_dettagli_fattura($id_fattura);
			return $data;

	}

    /**
     * mostra l'elenco fatture emesse dall'user.
     * @param $mess='refresh' reload elenco fatture
     * @param $anno filtro elenco
     * @param $cust filtro elenco
     * @param $stat filtro elenco
     */
    private function load_view($mess, $anno, $cust, $stat)
	{
		
		$user=wp_get_current_user();
		if($user->ID>0)
		{
			$this->load->model('Fattura_model','model');


			switch($mess)
			{
				case 'refresh':
                    $data['list']=$this->model->get_fatture_list($user->ID,$anno,$cust,$stat);
					echo $this->load->view('templates/fatture/list',$data,true);
					break;
				default:
					$data['user']=$user;
					$data['anni_list']=$this->model->get_anni_list($user->ID);
					$data['clienti_list']=$this->model->elenco_clienti($user->ID);
					echo $this->load->view('templates/fatture/list_fatture',$data,true);
					break;
	
			}
		}
		else
		{
			redirect('/wp-login.php');
		}
	}
	function sidebar_items()
	{
		echo json_encode(menu_items());
	}
	public function nuovo_cliente()
	{
		if(is_user_logged_in())
		{
			echo $this->load->view('templates/clienti/nuovo_cliente','',true);
		}
		else
		{
			redirect('/wp-login.php');
		}
	}

    /**
     *
     */
    public function nuova_fattura()
	{
		if(is_user_logged_in())
		{
			$data['user']=wp_get_current_user();
			$this->load->model('Fattura_model','model');
			$data['numeroFattura']=$this->model->numero_fattura($data['user']->ID);
			$data['elencoClienti']=$this->model->elenco_clienti($data['user']->ID);
			echo $this->load->view('templates/fatture/nuova_fattura',$data,true);
		}
		else
		{
			redirect('/wp-login.php');
		}
	}

    /**
     *todo: dopo inserimento della fattura nel db, mostra nuova form per inserimento di una nuova fattura
     */
    public function add_fattura()
	{
		
		if(is_user_logged_in())
		{
			$this->load->model('Fattura_model','model');
			$userId=wp_get_current_user();
			$fattura=array
			(
				'cliente_id'=>$this->input->post('formCliente'),
				'fattura_irpef'=>$this->input->post('formIrpef'),
				'fattura_enpapi'=>$this->input->post('formEnpapi'),
				'fattura_numero'=>$this->input->post('formNumeroFattura'),
				'fattura_data'=>$this->input->post('formDataFattura'),
				'fattura_pagato'=>0,
				'fattura_iva'=>$this->input->post('formIva'),
				'user_id'=>$userId->ID,
				'fattura_irpef_sino'=>(!($this->input->post('formCheckIrpef'))?0:1),
				'fattura_enpapi_sino'=>(!($this->input->post('formCheckEnpapi'))?0:1),
                'fattura_iva_sino'=>(!($this->input->post('formCheckIva'))?0:1)
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
			//$view['myHTML']= $this->load->view('templates/fatture/nuova_fattura','',true);
			
			//$this->load->view('dashboard_view');TODO: remove this line
			echo "nuova_fattura";
		}
		else
		{
			redirect('/wp-login.php');
		}
	}
	public function add_cliente()
	{//todo: completare funzione
		if(is_user_logged_in())
		{
			$this->load->model('Fattura_model','model');
			$userId=wp_get_current_user();
			$cliente=array
			(
				'rag'=>$this->input->post('inputRagsoc'),
				'nome'=>$this->input->post('inputName'),
				'mail'=>$this->input->post('inputEmail'),
				'phone'=>$this->input->post('inputPhone'),
				'piva'=>$this->input->post('inputPiva'),
				'cap'=>$this->input->post('inputCAP'),
				'citta'=>$this->input->post('inputCity'),
				'provincia'=>$this->input->post('inputProvincia'),
				'address'=>$this->input->post('inputAddress'),
				'altro'=>$this->input->post('inputInfo'),
				'user_id'=>$userId->ID
			);
			
		
			
			
			$this->model->insert_data_cliente($cliente);
			//$view['myHTML']= $this->load->view('templates/fatture/nuova_fattura','',true);
			
			//$this->load->view('dashboard_view');
			echo "nuovo_cliente";
		}
		else
		{
			redirect('/wp-login.php');
		}
	}
	function view_cv()
	{
		if(is_user_logged_in())
		{
			$this->load->model('cv_model','model');
			$result=$this->model->get_sections();
			if(isset($result)){$this->na_cv->set_sections($result);}
			echo $this->load->view('templates/cv/cv','',true);
			
		}
		else
		{
			redirect('/wp-login.php');
		}
	}
	function edit_cv()
    {
        if(is_user_logged_in())
        {
            $this->load->model('cv_model','model');
            $result=$this->model->get_sections();
            if(isset($result)){$this->na_cv->set_sections($result);}
            echo $this->load->view('templates/cv/cv_edit','',true);

        }
        else
        {
            redirect('/wp-login.php');
        }
    }
	function cv_update()
	{
        if (is_user_logged_in())
        {
            $this->load->model('cv_model','model');
            $post=$this->input->post();
            $user=wp_get_current_user();
            $this->model->update($post,$user->ID);
            echo "view_cv";
        }
        else {
            redirect('/wp-login.php');
        }

		
		
	}


}

