<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fattura_model extends CI_Model
{
	public function __construct()
	{
/*
|--------------------------------------------------------------------------
| Nomi tabelle e colonne
|--------------------------------------------------------------------------
|definizine dei nomi delle tabelle e colonne del DB
|
*/
		parent::__construct();
		//*****************************************************************
		//***************** VIEW na_fattura_cliente **********
		define('TABLE_FATTURE_CLIENTE','na_fattura_cliente');
		define('COL_FATTURA_NUMERO','fattura_numero');
		define ('COL_FATTURA_DATA','fattura_data');
		define('COL_F_CLIENTE_NOME','cliente_nome');
		define('COL_F_CLIENTE_ID','cliente_id');
		define('COL_FATTURA_PAGATO','pagato');
		define('COL_USER_ID','user_id');
		define('COL_FATTURA_VIEW_ID','fattura_id');
		//****************** TABLE na_dettaglio_fattura ********
		define('TABLE_DETTAGLIO_FATTURA','na_dettaglio_fattura');
		define('COL_FATTURE_FATTURA_ID','fattura_id');
		define('COL_FATTURE_DESCRIZIONE','descrizione');
		define('COL_FATTURE_PREZZO','prezzo_unitario');
		define('COL_FATTURE_IMPONIBILE','imponibile');
		define('COL_FATTURE_QUANTITA','quantita');
		//****************** TABLE na_fatture ****************
		define('TABLE_FATTURE','na_fatture');
		define('COL_FATTURA_ID','id');
		define('COL_FATTURA_CLIENTE','cliente_id');
		define('COL_FATTURA_IRPEF','fattura_irpef');
		define('COL_FATTURA_ENPAPI','fattura_enpapi');
		define('COL_FATTURA_IVA','fattura_iva');
		define('COL_FATTURA_USER_ID','user_id');
		define('COL_FATTURA_ENPAPI_SINO','fattura_enpapi_sino');
		define('COL_FATTURA_IRPEF_SINO','fattura_acconto_irpef_sino');
		//*************** TABLE na_clienti ***************
		define('TABLE_CLIENTI','na_clienti');
		define('COL_CLIENTE_ID','id');
		define('COL_CLIENTE_USER','cliente_user');
		define('COL_CLIENTE_NOME','cliente_nome');
		define('COL_CLIENTE_PIVA','cliente_piva');
		define('COL_CLIENTE_ADDRESS','cliente_indirizzo');
		define('COL_CLIENTE_RAG','cliente_rag');
		define('COL_CLIENTE_CITTA','cliente_citta');
		define('COL_CLIENTE_CAP','cliente_cap');
		//*********************TABLE na_clienti_meta*************************
		define('TABLE_CLIENTI_META','na_clienti_meta');
		define('COL_CLIENTE_METAKEY','meta_key');
		define('COL_CLIENTE_METAVALUE','meta_value');
		define('COL_CLIENTE_META_CLIENTEID','na_clienti_id');
		//*******************************************************************
		$this->load->database();
		
	}
	public function get_fatture_list($user,$anno,$cliente,$pagato)
	{
		$anno=($anno>0 && $anno!='tutti')?' and year('.COL_FATTURA_DATA.')='.$anno:"";
		$cliente=($cliente=='tutti')?"":" and ".COL_F_CLIENTE_ID."=".$cliente;
		$pagato=($pagato!='tutti')?" and ".COL_FATTURA_PAGATO."={$pagato}":'';
		//switch($pagato)
		//{
		//	case 'si':
		//		$pagato=" and ".COL_FATTURA_PAGATO."=1";
		//		break;
		//	case 'no':
		//		$pagato=" and ".COL_FATTURA_PAGATO."=0";
		//		break;
		//	default:
		//		$pagato="";
		//}
		$query="select * from ".TABLE_FATTURE_CLIENTE." where ".COL_USER_ID."=".$user.$anno.$cliente.$pagato." order by ".COL_FATTURA_NUMERO;
		$sql=$this->db->query($query);
		$result=$sql->result_array();
		return $result;
	}
	public function get_anni_list($user)
	{
		$query="select distinct year(".COL_FATTURA_DATA.") as anno from ".TABLE_FATTURE_CLIENTE." where ".COL_USER_ID."=".$user." order by anno desc";
		$sql=$this->db->query($query);
		return $sql->result_array();
	}
	public function get_fattura_data($fattura_id)
	{
		$query="select * from ".TABLE_FATTURE_CLIENTE." where ".COL_FATTURA_VIEW_ID."={$fattura_id}";
		$sql=$this->db->query($query);
		return $sql->result_array();
	}

	public function get_dettagli_fattura($id)
	{
		$query = "select * from " . TABLE_DETTAGLIO_FATTURA . " where " . COL_FATTURE_FATTURA_ID . "=" . $id;
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
	public function get_cliente($id)
	{
		$query = "select * from " . TABLE_CLIENTI . " where " . COL_CLIENTE_ID . "=" . $id;
		$sql = $this->db->query($query);
		return $sql->result_array();
	}
	public function numero_fattura($user)
	{
		$sql=$this->db->query("select ".COL_FATTURA_NUMERO." from ".TABLE_FATTURE." where ".COL_FATTURA_USER_ID."=$user order by ".COL_FATTURA_NUMERO." desc limit 1");
		$result=$sql->row_array();
		return $this->calcola_numero_fattura($result[COL_FATTURA_NUMERO]);
		
	}
	public function elenco_clienti($user)
	{
		//$sql=$this->db->query("select * from ".TABLE_CLIENTI." where ".COL_CLIENTE_USER."=$user");
		$sql=$this->db->query("select * from ".TABLE_CLIENTI." where ".COL_CLIENTE_USER."=$user");
		$result=$sql->result_array();
		return $result;
	}
	private function calcola_numero_fattura($numeroFattura)
	//calcola numero progressivo della nuova fattura
	{
		$numero=1;
		$anno=substr($numeroFattura,1,2);
		$numero=intval(substr($numeroFattura,4));
		$annoCorrente=date("y",time());
		if($anno==$annoCorrente){
			$numero++;
		}
		else{$numero=1;}
		if($numero<10){
			$numero="00".$numero;
			}
			elseif($numero<100){
				$numero="0".$numero;
			}
			
		$numeroFattura="A".$annoCorrente."-".$numero;
		return $numeroFattura;
	}
	public function insert_data($data,$details)
	{
		//inserisci nuova fattura nella tabella 'nib_fatture'
		$nuova_fattura=array
		(
			COL_FATTURA_CLIENTE=>$data['cliente_id'],
			COL_FATTURA_IRPEF=>$data['fattura_irpef'],
			COL_FATTURA_ENPAPI=>$data['fattura_enpapi'],
			COL_FATTURA_NUMERO=>$data['fattura_numero'],
			COL_FATTURA_DATA=>"",
			COL_FATTURA_PAGATO=>1,
			COL_FATTURA_IVA=>$data['fattura_iva'],
			COL_FATTURA_USER_ID=>$data['user_id'],
			COL_FATTURA_IRPEF_SINO=>$data['fattura_irpef_sino']
		);
		$date = DateTime::createFromFormat('d/m/Y', $data['fattura_data']);
		$nuova_fattura[COL_FATTURA_DATA]=$date->format("Y/m/d");
		
		if(! $this->db->insert(TABLE_FATTURE,$nuova_fattura)){
			return 'errore';
			}
		$idFattura=$this->db->insert_id();// id record inserito
		$i=0;
		$qta=$details['quantita'];
		$prezzo_unitario=$details['prezzo_unitario'];
		$imponibile=$details['imponibile'];
		$dettaglio_fattura=array
		(
			COL_FATTURE_FATTURA_ID=>$idFattura,
			COL_FATTURE_DESCRIZIONE=>'',
			COL_FATTURE_QUANTITA=>0,
			COL_FATTURE_PREZZO=>0,
			COL_FATTURE_IMPONIBILE=>0
		);
		foreach($details['descrizione'] as $voce)
		{
			$dettaglio_fattura[COL_FATTURE_DESCRIZIONE]=$voce;
			$dettaglio_fattura[COL_FATTURE_QUANTITA]=$qta[$i];
			$dettaglio_fattura[COL_FATTURE_PREZZO]=$prezzo_unitario[$i];
			$dettaglio_fattura[COL_FATTURE_IMPONIBILE]=$imponibile[$i];
			
			$this->db->insert(TABLE_DETTAGLIO_FATTURA,$dettaglio_fattura);
			$i++;
		}
		

	}
	public function insert_data_cliente($data)
	{
		//inserisci nuovo cliente nel database
		$newCost=array
		(
			COL_CLIENTE_USER=>$data['user_id'],
			COL_CLIENTE_PIVA=>$data['piva'],
			COL_CLIENTE_ADDRESS=>$data['address'],
			COL_CLIENTE_NOME=>$data['nome'],
			COL_CLIENTE_CAP=>$data['cap'],
			COL_CLIENTE_RAG=>$data['rag'],
			COL_CLIENTE_CITTA=>$data['citta']
		);
		//if(! $this->db->insert(TABLE_CLIENTI,$newCost))
		//{
		//	return 'errore';
		//}
		//$idcost=$this->db->insert_id();// id record inserito
		$metaData=array
		(
			COL_CLIENTE_METAKEY=>'',
			COL_CLIENTE_METAVALUE=>'',
			//COL_CLIENTE_META_CLIENTEID=>$idcost
		);
		echo count($data['mail']);
		foreach($data['mail']as $mail)
		{
			$metaData[COL_CLIENTE_METAKEY]=MK_MAIL;
			$metaData[COL_CLIENTE_METAVALUE]=$mail;
			
			//$this->db->insert(TABLE_CLIENTI_META,$metaData);
		}
		foreach($data['phone']as $phone)
		{
			$metaData[COL_CLIENTE_METAKEY]=MK_PHONE;
			$metaData[COL_CLIENTE_METAVALUE]=$phone;
			//$this->db->insert(TABLE_CLIENTI_META,$metaData);
		}

	}
	
}
