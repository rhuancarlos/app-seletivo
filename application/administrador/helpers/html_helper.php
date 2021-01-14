<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('geraElementHeaderPage')):
  function geraElementHeaderPage($arrayDados){
		$ci = &get_instance();
    $base_url = $ci->config->base_url();
    $base_url_segment = $ci->uri->segment(1);
    
    if(empty($arrayDados) && (!is_array($arrayDados))) {
      return false;
    }
    $html = '<h6 class="element-header">';
    if(count($arrayDados) == 1) {
      $html .= '<a href="'.$base_url.$base_url_segment.'" style="color: #000;">'.mb_strtoupper($arrayDados[0]).'</a>';
    } else {
      foreach($arrayDados as $key => $dados ) {
        if($key == 0){
          // $html .= '<a href="'.$base_url.$base_url_segment.'" style="color: #000;">'.mb_strtoupper($dados).'</a>';
          $html .= '<a style="color: #000;">'.mb_strtoupper($dados).'</a>';
        } else {
          // $html .= ' / '. '<span class="ultimo-nivel-pagina">'.mb_strtoupper($dados).'</span>';
          $html .= ' / '. '<a href="'.$base_url.$base_url_segment.'/'.$ci->uri->segment($key+1).'" class="ultimo-nivel-pagina">'.mb_strtoupper($dados).'</a>';
        }
      }
    }
    $html .= '</h6>';
    return $html;
  }
endif;