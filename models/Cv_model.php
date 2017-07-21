<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cv_model extends CI_Model
{
	
	
	const IP=1;
	public function __construct()
	{
		parent::__construct();
		/*		
		|--------------------------------------------------------------------------
		| Nomi tabelle e colonne
		|--------------------------------------------------------------------------
		|definizine dei nomi delle tabelle e colonne del DB
		|
		*/
		//tabella na_cv
		define ('TABLE_CV','na_cv');
		define('COL_NACV_ID','id');
		define('COL_NACV_USERID','user_id');
		//tabella sezioni
		define('TABLE_SECTIONS','na_cv_sections');
		define('COL_SECTIONS_TITOLO','titolo');
		define('COL_SECTIONS_DESCR','descrizione');
		define('COL_SECTIONS_ID','id');
		//tabella na_cv_meta
		define('TABLE_NACV_META','na_cv_meta');
		define('COL_CVMETA_KEY','meta_key');
		define('COL_CVMETA_VALUE','meta_value');
		define('COL_CVMETA_ID','na_cv_id');
		define('COL_CVMETA_SECTIONSID','na_cv_sections_id');		 
		/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
		$this->load->database();
		
	}
	public function get_sections()
	{
		$user=wp_get_current_user();
		$sec_id=array();
		//get id curriculum
		$query="select ".COL_NACV_ID." from ".TABLE_CV." where ".COL_NACV_USERID."={$user->ID}";
		$sql=$this->db->query($query);
		$result=$sql->row();
		if(isset($result))
		{
			$cv_id=$result->id;
			//get informazioni personali - first section
			$this->na_cv->set_cv_id($cv_id);
			echo $this->na_cv->get_cv_id();
			$query="select * from ".TABLE_NACV_META." where ".COL_CVMETA_ID."={$cv_id}";
			$sql=$this->db->query($query);
			$result=$sql->result_array();
			$c=count($result);
			if($c>0)
			{
				$result_array=array(
					'result'=>$result,
					'metakey'=>COL_CVMETA_KEY,
					'metavalue'=>COL_CVMETA_VALUE
				);
				return $result_array;
			}
		}
		
	}
	public function update($data,$id)
	{
		$user=wp_get_current_user();
		$query=$this->db->query('select * from '.TABLE_CV.' where '.COL_NACV_USERID.'='.$user->ID);
		$row=$query->row();
		
		if(isset($row))
		{
			$insert_data=array();
			foreach(array_keys($data) as $key)
			{
				//$insert_data[COL_CVMETA_KEY]=$key;
				$insert_data[COL_CVMETA_VALUE]=$data[$key];
				$this->db->where(COL_CVMETA_ID,$row->id);
				$this->db->where(COL_CVMETA_KEY,$key);
				$this->db->update(TABLE_NACV_META,$insert_data);
				echo $this->db->last_query();
			}
			
		}
		else
		{
			if(! $this->db->insert(TABLE_CV,[COL_NACV_USERID=>$user->ID]))
			{
				return 'errore';
			}
			$this->na_cv->cv_id=$this->db->insert_id();
			$keys=array_keys($data);
			foreach($keys as $key)
			{
				if(! $this->db->insert(TABLE_NACV_META,[COL_CVMETA_KEY=>$key,COL_CVMETA_VALUE=>$data[$key],COL_CVMETA_ID=>$this->na_cv->cv_id,COL_CVMETA_SECTIONSID=>0]))
				{
					return 'errore db';
				}
			}
			
		}
	}
	
}