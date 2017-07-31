<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * My sidebar di navigazione(dashboard)  Helpers
 *
 */

// ------------------------------------------------------------------------

if ( ! function_exists('menu_items'))
{
	/**
	 * Menu Items
	 *
	 * menu di navigazione della dashboard
	 *
	 * return array
	 * 
	 */
	function menu_items()
	{
		
		$menu=[['title'=>'Elenco Fatture','method'=>'elenco_fatture','ddm'=>'0','parent'=>'Fatture','icon'=>'fa-list','order'=>1],
					['title'=>'Nuova Fattura','method'=>'nuova_fattura','ddm'=>'0','parent'=>'Fatture','icon'=>'fa-plus-square-o','order'=>2],
					['title'=>'Fatture','method'=>'','ddm'=>1,'parent'=>'','icon'=>'fa-table','order'=>2],
					['title'=>'Curriculum','method'=>'view_cv','ddm'=>0,'parent'=>'','icon'=>'fa-university','order'=>3],
					['title'=>'Dashboard','method'=>'home','ddm'=>0,'parent'=>'','icon'=>'fa-dashboard','order'=>1],
					['title'=>'ECM','method'=>'home','ddm'=>0,'parent'=>'','icon'=>'fa-graduation-cap','order'=>4],
					['title'=>'Clienti','method'=>'','ddm'=>1,'parent'=>'','icon'=>'fa-users','order'=>5],
					['title'=>'Elenco Clienti','method'=>'elenco_clienti','ddm'=>0,'parent'=>'Clienti','icon'=>'fa-list','order'=>2],
					['title'=>'Nuovo Cliente','method'=>'nuovo_cliente','ddm'=>0,'parent'=>'Clienti','icon'=>'fa-plus-square-o','order'=>1],
					['title'=>'Video Corsi','method'=>'home','ddm'=>0,'parent'=>'','icon'=>'fa-play','order'=>6],
					['title'=>'Profilo','method'=>'home','ddm'=>0,'parent'=>'','icon'=>'fa-user','order'=>7],
					['title'=>'Settings','method'=>'home','ddm'=>0,'parent'=>'','icon'=>'fa-wrench','order'=>8]];
		/*-- sort the data with order ascendig--*/
		foreach ($menu as $key => $row)
		{
			$order[$key]  = $row['order'];
		}

		// Sort
		array_multisort($order, SORT_ASC, $menu);
		return $menu;
	}
}

