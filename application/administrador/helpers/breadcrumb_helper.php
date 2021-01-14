<?php

if (!function_exists('create_breadcrumb')) {
	function create_breadcrumb($initial_crumb = '', $initial_crumb_url = '') {
		$ci =& get_instance();
		$open_tag = '<ul class="breadcrumb">';
		$close_tag = '</ul>';
		$crumb_open_tag = '<li>';
		$active_crumb_open_tag = '<li>';
		$crumb_close_tag = '</li>';
		$separator = '&nbsp;<i class="fa fa-chevron-right"></i>&nbsp;';

		$total_segments = $ci->uri->total_segments();
		$breadcrumbs = $open_tag;
		if ($initial_crumb != '') {
			$breadcrumbs .= $crumb_open_tag;
			$breadcrumbs .= create_crumb_href($initial_crumb, false, true) . $separator;
		}
		
		$segment = '';
		$crumb_href = '';
		
		for ($i = 1; $i <= $total_segments; $i++) {
			$segment = $ci->uri->segment($i);
			$crumb_href .= $ci->uri->segment($i) . '/';
			if ($total_segments > $i) {
					$breadcrumbs .= $crumb_open_tag;
					// REMOVING ARROW ON LAST SEGMENT
					if($segment == "editar") {
						$separator = '';
					}
					$breadcrumbs .= create_crumb_href($segment, $crumb_href);
					$breadcrumbs .= $separator;
				}else{
					//CHECK IF THE LAST SEGMENT IS INTEGER, IF TRUE REMOVE FROM BREADCRUMB
					#echo (strlen($segment));exit;
					if(strlen($segment) >= 35) {
						continue;
					}
				$breadcrumbs .= $active_crumb_open_tag;
				$breadcrumbs .= create_crumb_href($segment, $crumb_href);
				$breadcrumbs .= $separator = '';
			}
			$breadcrumbs .= $crumb_close_tag;
		}
		$breadcrumbs .= $close_tag;
		return $breadcrumbs;
	}
}

if (!function_exists('create_crumb_href')) {
	function create_crumb_href($uri_segment, $crumb_href = false, $initial = false) {
		$ci = &get_instance();
		$base_url = $ci->config->base_url();
		
		$crumb_href = rtrim($crumb_href, '/');
		if($initial) {
			return '<b>Você está aqui</b>: ' . '<a href="' . $base_url . '" data-original-title="' .  ucfirst($uri_segment) .'" data-placement="bottom" data-toggle="tooltip">' . 
			ucfirst(str_replace(array('-', '_'), ' ',  ucfirst($uri_segment))) .  '</a>';
		}else{
			return '<a href="' . $base_url . $crumb_href . '" data-original-title="' . ucfirst($uri_segment) .'" data-placement="bottom" data-toggle="tooltip">' . 
			ucfirst(str_replace(array('-', '_'), ' ',  ucfirst($uri_segment))) .  '</a>';
		}   
	}
}