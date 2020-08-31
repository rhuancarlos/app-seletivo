<!DOCTYPE html>
<html ng-cloak ng-app="ibnfagendamento">
  <head lang="pt-br">
    <title><?= isset($title_page) ? $title_page :  NOME_COMPLETO_SISTEMA;?></title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta charset="<?= SISTEMA_TAG_CODIFICACAO_PAGINA ?>" />
    <meta name="keywords" content="<?= NOME_CURTO_SISTEMA?>" />
    <meta name="author" content="<?= DESENVOLVEDOR_SISTEMA_NOME?>" />
    <meta name="description" content="<?= NOME_COMPLETO_SISTEMA?>" />
    <meta http-equiv="content-language" content="<?= implode(",",SISTEMA_TAG_LINGUAGENS) ?>" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="<?= URL_IMAGE_FAVICON?>" rel="shortcut icon">
    <link href="<?= URL_IMAGE_FAVICON?>" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <?= $this->assets->css ?>
    <input type="hidden" value="<?= base_url(); ?>" id="base_url" name="base_url">
    <input type="hidden" value="<?= $this->stringController;?>" id="currentcontroller" name="currentcontroller">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-105598844-6"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-105598844-6');
    </script>

  </head>
  <body id="schedules" class="schedule section-padding">