<!DOCTYPE html>
<html ng-app="ibnfsistema">
	<head>
	<title><?= NOME_COMPLETO_SISTEMA?></title>
		<meta content="ie=edge" http-equiv="x-ua-compatible">
		<meta charset="<?= SISTEMA_TAG_CODIFICACAO_PAGINA ?>">
		<meta content="<?= NOME_CURTO_SISTEMA?>" name="keywords">
		<meta content="<?= DESENVOLVEDOR_SISTEMA_NOME?>" name="author">
		<meta content="<?= NOME_COMPLETO_SISTEMA?>" name="description">
		<meta content="<?= implode(",",SISTEMA_TAG_LINGUAGENS) ?>" http-equiv="content-language"/>
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<link href="<?= URL_IMAGES_ESTATICAS.'favicon/favicon-32x32.png'?>" rel="shortcut icon">
		<link href="<?= URL_IMAGES_ESTATICAS.'favicon/apple-touch-icon.png'?>" rel="apple-touch-icon">
		<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
		<?= $this->assets->css ?>
		<link rel="stylesheet" href="<?= PATH_PUBLIC_CSS.'main.css?version=4.4.0'?>" type="text/css">
		<input type="hidden" value="<?= base_url(); ?>" id="base_url" name="base_url">
		<input type="hidden" value="<?= $this->stringController;?>" id="currentcontroller" name="currentcontroller">
	</head>
	<body class="auth-wrapper">