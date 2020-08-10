<!DOCTYPE html>
<html >
<head lang="pt-br">
  <title><?= isset($title_page) ? $title_page :  NOME_COMPLETO_SISTEMA;?></title>
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <meta charset="<?= SISTEMA_TAG_CODIFICACAO_PAGINA ?>" />
  <meta name="keywords" content="<?= NOME_CURTO_SISTEMA?>" />
  <meta name="author" content="<?= DESENVOLVEDOR_SISTEMA_NOME?>" />
  <meta name="description" content="<?= NOME_COMPLETO_SISTEMA?>" />
  <meta http-equiv="content-language" content="<?= implode(",",SISTEMA_TAG_LINGUAGENS) ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="<?= URL_IMAGES_ESTATICAS.'favicon/favicon-32x32.png'?>" rel="shortcut icon">
  <link href="apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
  <?= $this->assets->css ?>
  <?php #Jamais mudar este arquivo de posição no código pois resultará na estilização da página de forma errada ?>
  <link rel="stylesheet" href="<?= PATH_PUBLIC_CSS.'main.css?version=4.4.0'?>" type="text/css">
  <input type="hidden" value="<?= base_url(); ?>" id="base_url" name="base_url">
  <input type="hidden" value="<?= $this->stringController;?>" id="currentcontroller" name="currentcontroller">
</head>
  <body class="menu-position-side menu-side-left full-screen with-content-panel">
    <div class="all-wrapper with-side-panel solid-bg-all">
      <? if(isset($primeiro_acesso) && (!$primeiro_acesso)) { ?>
        <?php require_once(VIEWPATH.'layouts/primeiro_acesso.php');?>
      <? } ?>

      <div class="layout-w">

        <!-------------------- START - Mobile Menu -------------------->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
          <?php require_once(VIEWPATH.'layouts/menu_mobile.php'); ?>
        </div>
        <!-------------------- END - Mobile Menu -------------------->
        
        <!-------------------- START - Main Menu -------------------->
        <div class="menu-w menu-activated-on-hover menu-has-selected-link">
          <?php require_once(VIEWPATH.'layouts/menu_computador.php'); ?>
        </div>
        <!-------------------- END - Main Menu -------------------->

        <div class="content-w">
          <!-------------------- START - Top Bar -------------------->
          <div class="top-bar color-scheme-dark">

            <!-------------------- START - Top Menu Controls -------------------->
              <div class="top-menu-controls">
                <!-------------------- START - User avatar and menu in secondary top menu -------------------->
                <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-left">
                  <i class="os-icon os-icon-ui-46"></i>
                  <div class="os-dropdown">
                    <div class="icon-w">
                      <i class="os-icon os-icon-ui-46"></i>
                    </div>
                    <ul>
                      <li><a href="<?= base_url('usuario/perfil'); ?>"><i class="os-icon os-icon-user-male-circle2"></i><span>Meu Perfil</span></a></li>
                      <li><a href="<?= base_url('usuario/alterar_senha'); ?>"><i class="os-icon os-icon-lock"></i><span>Alterar Senha</span></a></li>
                      <li><a href="<?= base_url('login/sair'); ?>"><i class="os-icon os-icon-signs-11"></i><span>Sair</span></a></li>
                    </ul>
                  </div>
                </div>
                <!-------------------- END - User avatar and menu in secondary top menu -------------------->
              </div>
            <!-------------------- END - Top Menu Controls -------------------->
          </div>
          <!-------------------- END - Top Bar -------------------->

          <!-------------------- START - Breadcrumbs -------------------->
            <?= create_breadcrumb('home'); ?>
          <!-------------------- END - Breadcrumbs -------------------->
          <div class="content-panel-toggler">
            <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
          </div>
          <div class="content-i">
            <div class="content-box">
                  <div class="element-wrapper">
     