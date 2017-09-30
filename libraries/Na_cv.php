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
	//********************************prefix dei nome delle metakey**************************
	const PREFIX_IP='ip';
	const PREFIX_CP='cp';
	const PREFIX_PR='pr';
	const PREFIX_EP='ep';
	//*********************************icons metakey****************************************
    private $icons=['ip_name'=>'fa-user','ip_address'=>'fa-map-marker',
        'ip_tel'=>'fa-phone','ip_mail'=>'fa-envelope',
        'ip_www'=>'fa-globe'];
	
	//************************** metakey utilizzate nel db************************************
	//meta_key sezione informazioni personali
	private $meta_key_ip=[self::PREFIX_IP.'_name'=>'nome',self::PREFIX_IP.'_address'=>'indirizzo',self::PREFIX_IP.'_tel'=>'telefono',self::PREFIX_IP.'_mail'=>'mail',self::PREFIX_IP.'_www'=>'www'];
	//meta_key sezione capacita personali
	private $meta_key_cp=[self::PREFIX_CP.'_c_comunicative'=>'capacita comunicativa',self::PREFIX_CP.'_c_org'=>'capacita organizzative',self::PREFIX_CP.'_c_professionali'=>'competenze professionali',
													self::PREFIX_CP.'_c_digit'=>'competenze digitali',self::PREFIX_CP.'_altro'=>'altre competenze',self::PREFIX_CP.'_patente'=>'patente guida'];
	
	//meta_key sezione istruzione e formazione
	private $meta_key_if=[self::PREFIX_CP.'_data_range'=>'data',self::PREFIX_CP.'_titolo'=>'titolo',self::PREFIX_CP.'_sede'=>'sede',self::PREFIX_CP.'_competenze'=>'competenze aquisite'];
	//meta_key sezione esperienza professionale
	private $meta_key_ep=[self::PREFIX_CP.'_data_range'=>'data',self::PREFIX_CP.'_occupazione'=>'occupazione',self::PREFIX_CP.'_sede'=>'sede',self::PREFIX_CP.'_ruolo'=>'ruolo'];
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
		
	}
	public function set_cv_id($id)
	{
		
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

    public function get_icons()
    {
        return $this->icons;
	}
}


