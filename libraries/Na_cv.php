<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Na_cv  //classe per gestire il curriculum vitae

{
	//******************************nomi delle sezioni del curriculum***********************
	const IP='Informazioni personali';
	const CP='competenze personali';
	const PR='posizione richiesta';
	const EP='esperienza professionale';
	const IFO='istruzione e formazione';
	const UI='ulteriori informazioni';
	const AL='allegati';
	const LI='lingue';
	
	const PREFIX_IP='ip';
	const PREFIX_CP='cp';
	const PREFIX_PR='pr';
	const PREFIX_EP='ep';
	const PREFIX_oo='jj';
	private static $CV_ID=0;
	//************************** metakey utilizzate nel db************************************
	//meta_key sezione informazioni personali
	private $meta_key_ip=['ip_name'=>'nome','ip_address'=>'indirizzo','ip_tel'=>'telefono','ip_mail'=>'mail','ip_www'=>'www'];
	//meta_key sezione capacita personali
	private $meta_key_cp=['cp_c_comunicative'=>'capacita comunicativa','cp_c_org'=>'capacita organizzative','cp_c_professionali'=>'competenze professionali',
													'cp_c_digit'=>'competenze digitali','cp_altro'=>'altre competenze','cp_patente'=>'patente guida'];
	
	//meta_key sezione istruzione e formazione
	private $meta_key_if=['if_data_range'=>'data','if_titolo'=>'titolo','if_sede'=>'sede','if_competenze'=>'competenze aquisite'];
	//meta_key sezione esperienza professionale
	private $meta_key_ep=['ep_data_range'=>'data','ep_occupazione'=>'occupazione','ep_sede'=>'sede','ep_ruolo'=>'ruolo'];
	//************************** array sezioni cv ************************************
  private $sections=array();//sezioni del cv
	public $informazioni_personali=array(); //sezione informazioni personali
  private $esperienza_professionale=array(); //sezione esperienza professionale
	public $istruzione_formazione=array();// sezione istruzione e formazione
	private $competenze_personali=array();
	private $posizione_richiesta=''; //posizione richiesta
	private $allegati=array(); //elenco allegati
	private $altre_info=array(); //informazioni aggiuntive
	//*********************************************************************************
	public function __construct()
	{
		//*********************inizializza gli array***************
		//sezione informazioni personali
		foreach($this->meta_key_ip as $item)
		{
			$this->informazioni_personali[$item]='-';
		}
		$this->sections[self::IP]=&$this->informazioni_personali;
		// sezione competenze personali
		foreach($this->meta_key_cp as $item)
		{
			$this->competenze_personali[$item]='-';
		}
		$this->sections[self::CP]=&$this->competenze_personali;
		// sezione istruzione e formazione
		foreach($this->meta_key_if as $item)
		{
			$this->istruzione_formazione[$item]='-';
		}
		$this->sections[self::IFO]=&$this->istruzione_formazione;
		// sezione esperienza professionale
		foreach($this->meta_key_ep as $item)
		{
			$this->esperienza_professionale[$item]='-';
		}
		$this->sections[self::EP]=&$this->esperienza_professionale;
		//sezione altre informazioni
		$this->sections[self::UI]=&$this->altre_info;
		//sezione allegati
		$this->sections[self::AL]=&$this->allegati;
	}
	
	public function get_cv_id()
	{
		return self::$CV_ID;
	}
	public function set_cv_id($id)
	{
		self::$CV_ID=$id;
	}
	public function get_sections()
	{
		return $this->sections;
	}
	public function set_sections($cv)
	{
		foreach($cv['result'] as $item)
		{
			$key=$item[$cv['metakey']];
			$prefix=strstr($key,'_',true);
			switch ($prefix)
			{
				case self::PREFIX_IP:
					$this->informazioni_personali[$this->meta_key_ip[$key]]=$item[$cv['metavalue']];
					break;
				case self::PREFIX_CP:
					$this->competenze_personali[$this->meta_key_cp[$key]]=$item[$cv['metavalue']];
					break;
			}
		}
	}
	public function set_lingue($lingua,$livello)
	{
			$this->competenze_personali['lingue'][$lingua]=$livello;
	
	}
	public function set_informazioni_personali($data)
	{
		$keys=array_keys($data);
		foreach($keys as $key)
		{
				$this->informazioni_personali[$this->meta_key_ip[$key]]=$data[$key];
		}
		
	}
	public function set_esperienza_lavorativa($date,$job)
	{
			$this->esperienza_lavorativa[]=['data'=>$date,'occupazione'=>$job];
	}
	public function get_lingue()
	{
			return $this->capacita_personali['lingue'];
	}
	public function get_esperienza_lavorativa()
	{
			return $this->esperienza_lavorativa;
	}
	public function get_capacita_personali()
	{
			return $this->capacita_personali;
	}
	public function get_titolo_studio()
	{
			return $this->titolo;
	}
	public function get_info()
	{
			return $this->altre_info;
	}
	public function get_informazioni_personali()
	{
			return $this->informazioni_personali;
	}
	public function get_metakey_ip()
	{
		return $this->meta_key_ip;   
	}
	public function get_metakey_ep()
	{
		return $this->meta_key_ep;   
	}
	public function get_metakey_cp()
	{
		return $this->meta_key_cp;   
	}
	public function get_metakey_if()
	{
		return $this->meta_key_if;   
	}
}
?>