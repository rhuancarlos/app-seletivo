<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->load->library("assets", array(
			'header' => array('titulo' => "Página Principal", 'subtitulo' => null)
		));
		$this->stringController = "index";
		$this->permissoes->verificaLogado();
		$this->load->model(array('menus_m', 'equipes_m'));
	}

	public function index() {
		$this->data_view['equipes'] = $this->equipes_m->getAll(false, false, array("widget_tela_inicial" => true), true);
		$this->data_view['menus'] = $this->getMenu($this->rsession->get('usuario_logado'));
		$dados_usuario = getDadosUsuario($this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']));
		$this->data_view['primeiro_acesso'] = $dados_usuario->acessos > 1 ? true : false;
		$this->loadView($this->data_view);
	}

	private function getMenu($dados_usuario_logado) {
		if((!is_array($dados_usuario_logado)) || (empty($dados_usuario_logado))) {
			return false;
		}
		#$this->data['title_sessao_menus'] = $this->menus_m->getMenuAncora($this->seguranca->dec($dados_usuario_logado['id_usuario']));
		$this->data['title_sessao_menus'] = $this->menus_m->getMenuAncora();
		$this->data['menus_ancoras'] = $this->menus_m->getSubMenusGrupoUsuario($this->seguranca->dec($dados_usuario_logado['grupo_usuario_id']));
		$this->montaMenuCompleto();
	}

	private function getItensSubMenus($id_menu_pai, $id_grupo_usuario){
		return $this->data['itens_submenus'] = $this->menus_m->getItensSubMenus($id_menu_pai,$id_grupo_usuario);
	}
	
	private function montaMenuCompleto() {
		$is_mobile = $this->agent->is_mobile();
		$html = null;
		$ext 	= null;
		$html .= '<ul class="main-menu">';
		if(!$is_mobile){
			foreach ($this->data['title_sessao_menus'] as $key => $ma) { // GERA TITULOS DE MENUS
				$html .= '<li class="sub-header">';
					$html .= '<span>'.$ma->descricao.'</span>';
				$html .= '</li>';
				foreach ($this->data['menus_ancoras'] as $key => $sm) { // GERA MENUS ÂNCORAS
					$sub_menu_itens = $this->getItensSubMenus($sm->id,$this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id'])); // CONSULTA OS ITENS DO SUB-MENU
					if($ma->id == $sm->menu_id  && ($sm->sub_menu == 1)) {
						$ext = count($sub_menu_itens) > 0 ? 'has-sub-menu' : ''; // VERIFICA SE O SUB-MENU POSSUI ITENS COMO OPÇÕES, SE SIM SETA A CLASS 'has-sub-menu' E GERA UM ARROW NO MENU
						$html .= '<li class="selected '.$ext.'">';
						if(!empty($sm->repositorio_link)) {
							$html .= '<a href="'.base_url($sm->repositorio_link).'" title="'.$sm->descricao_completa.'">';
						} else {
							$html .= '<a href="#" title="'.$sm->descricao_completa.'">';
						}
						$html .= '<div class="icon-w">';
						$html .= '<div class="'.$sm->icone.'"></div>';
						$html .= '</div>';
						$html .= '<span>'.$sm->descricao.'</span>';
						$html .= '</a>';
						$html .= '<div class="sub-menu-i">';
							$html .= '<ul class="sub-menu">';
						 
						// GERA OS ITENS DO SUB-MENU 1º NIVEL
						foreach ($sub_menu_itens as $key => $sm_item) {
							if($sm_item->iditem_sub_menu == $sm->id){
								$html .= '<li>';
									$html .= '<a href="'.base_url($sm_item->repositorio_link).'" title="'.$sm_item->descricao_completa	.'" target="'.$sm_item->target.'">'.$sm_item->descricao.'</a>';
									$sub_menu_nivel_2 = $this->getItensSubMenus($sm_item->id,$this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id'])); // CONSULTA OS ITENS DO SUB-MENU

									//GERA ITENS DE SUB-MENU 2º NIVEL
									foreach($sub_menu_nivel_2 as $key => $m_nivel2) {
										if($m_nivel2->iditem_sub_menu == $sm_item->id) {
											$html .= '<li style="margin-left: 10px;">';
												$html .= '<a href="'.base_url($m_nivel2->repositorio_link).'" title="'.$m_nivel2->descricao_completa	.'" target="'.$m_nivel2->target.'">'.$m_nivel2->descricao.'</a>';
											$html .= '</li>';	
										}
									}
								$html .= '</li>';	
							}
						}
							$html .= '</ul>';
						$html .= '</div>';
					}
				}
			}
			#$html .= '</u>';
		} else {
			#$html .= '<ul class="main-menu">';
			foreach ($this->data['title_sessao_menus'] as $key => $ma) { // GERA TITULOS DE MENUS
				$html .= '<li class="has-sub-menu">';
					$html .= '<span>'.$ma->descricao.'</span>';
				$html .= '</li>';
				foreach ($this->data['menus_ancoras'] as $key => $sm) { // GERA MENUS ÂNCORAS
				$sub_menu_itens = $this->getItensSubMenus($sm->id, true); // CONSULTA OS ITENS DO SUB-MENU
				if($ma->id == $sm->menu_id  && ($sm->sub_menu == 1)) {
						$ext = count($sub_menu_itens) > 0 ? 'has-sub-menu' : ''; // VERIFICA SE O SUB-MENU POSSUI ITENS COMO OPÇÕES, SE SIM SETA A CLASS 'has-sub-menu' E GERA UM ARROW NO MENU
						$html .= '<li class="'.$ext.'">';
						if(!empty($sm->repositorio_link)) {
							$html .= '<a href="'.base_url($sm->repositorio_link).'" title="'.$sm->descricao_completa.'">';
						} else {
							$html .= '<a href="#" title="'.$sm->descricao_completa.'">';
						}
						$html .= '<div class="icon-w">';
						$html .= '<div class="'.$sm->icone.'"></div>';
						$html .= '</div>';
						$html .= '<span class="font-sub-menu">'.$sm->descricao.'</span>';
						$html .= '</a>';
						#$html .= '<div class="sub-menu-i">';
							$html .= '<ul class="sub-menu">';
						foreach ($sub_menu_itens as $key => $sm_item) { // GERA OS ITENS DO SUB-MENU
							if($sm_item->iditem_sub_menu == $sm->id){
										$html .= '<li>';
											$html .= '<a href="'.base_url($sm_item->repositorio_link).'" title="'.$sm_item->descricao_completa	.'" class="font-sub-itens-menu">'.$sm_item->descricao.'</a>';
										$html .= '</li>';	
									}
								}
								$html .= '</ul>';
							#$html .= '</div>';
					}
				}
			}
		}
		$html .= '</u>';
		$this->rsession->set('menu_completo', $html);
	}
}
