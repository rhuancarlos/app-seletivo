
<!DOCTYPE html>
<html>
    <head>
        <title><?= NOME_COMPLETO_SISTEMA; ?></title>
        <link rel="SHORTCUT ICON" href="favicon.ico">
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="shortcut icon" href="<?= base_url('public/imagens/favicon/apple-icon-144x144.png') ?>">
        <link rel="apple-touch-icon" href="<?= base_url('public/imagens/favicon/favicon.ico') ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('public/imagens/favicon/apple-icon-72x72.png') ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('public/imagens/favicon/apple-icon-144x144.png') ?>">
        <meta charset="utf-8">
        <meta name="description" content="<?= NOME_COMPLETO_SISTEMA; ?>">
        <meta name="author" content="<?= DESENVOLVEDOR_SISTEMA; ?>">
        <?= $this->assets->css ?>
    </head>
    <body class="">
        <section class="site-signup overlay bg-default">
            <form id="login" method="post" class="form-signup z-up form-default"id="login" action="<?= base_url('login/verificaInstituicao') ?>">
                <input name="csrfmiddlewaretoken" value="peCzMwDHAt6Gehhf3ynLLViuNhy0ysCo" type="hidden">
                <div class="wrap-form">
                    <div class="col-md-12 bd-b pd-b-s bd-gray-light">
                        <img style="display: block; margin-left: auto; margin-right: auto; margin-top: 10px;" src="<?= URL_IMAGES.idetificar_logo_sub_dominio(NOME_CURTO_SISTEMA); ?>"  alt="Logomarca do sistema">
                    </div>
                    <br>
                    <h2 class="title-m c-blue-dark text-center pd-t-m pd-b-s">Bem-vindo ao <?= ucfirst(NOME_CURTO_SISTEMA); ?></h2>
                    
                    <ul class="list-form m-b-m">
                        <li>
                            <label for="id_username">Matricula:</label>
                            <input id="matricula" name="matricula" placeholder="Matrícula:" type="text" required>
                        </li>
                        <li>
                            <label for="password">Senha:</label>
                            <input id="password" name="senha" placeholder="Senha:" value="" type="password" required onkeypress="capLock(event)">
                            <input id="criptografado" name="criptografado" type="hidden" value="0" >
                        </li>
                        <?php if(isset($erro) && !empty($erro)){?>
                        <div class="alert alert-danger">
                            <?= $erro ?>
                        </div>
                        <?php }
                        
                        if( isset($sucesso) && !empty($sucesso) ){ ?>
                        <div class="alert alert-success">
                            <?= $sucesso ?>
                        </div>
                        <?php }?>
                        <div id="divMayus"  class="alert alert-warning">A tecla CAPS LOCK está ativa.</div>
                        <li class="clearfix">
                            <button type="submit" value="entrar"class="btn btn-orange btn-bd-orange pull-right btn-sm-lg">Entrar</button>
                        </li>
                    </ul>
                    


                    <div class="wrap-security bg-blue text-right clearfix" >
                        <p class="medium c-white pull-left ib mt-13">
                            <span class="fa fa-lock"></span>
                            <span class="ib"  data-placement="top" data-toggle="popover" title="Como saber se posso confiar nesse site?" data-content="Se você vir um botão de cadeado ao lado do endereço de um site, isso significa que o que você envia e recebe do site é criptografado, tornando difícil para qualquer pessoa acessar essas informações. O site é verificado, o que significa que a empresa que administra o site tem um certificado que comprova que ela o possui. Clique no botão de cadeado para ver quem é o proprietário do site e quem o verificou. Enquanto um cadeado cinza significa que o site é criptografado e verificado, um cadeado verde significa que o navegador considera o site autêntico. Isso é porque ele está usando um certificado de Validação Estendida (EV), que requer um processo de verificação de identidade mais rigoroso.">Ambiente seguro</span>
                        </p>

                        <img class="help pull-right c-white ib logo-login" src="<?= base_url('public/imagens/igbee.svg') ?>">
                    </div>
                </div>

            </form>

        </section>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <span class="copyright">  &copy; 2005 - <?= date('Y'); ?> <?= ucfirst(NOME_CURTO_SISTEMA); ?> 
                        </span>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline social-buttons">
                            <li><a href="https://www.twitter.com/inforgeneses" target='_blank'><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.facebook.com/inforgeneses" target='_blank'><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://www.instagram.com/inforgeneses" target='_blank'><i class="fa fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline quicklinks">
                            <li><a  href="#">Termos de Uso</a>
                            </li>
                            <li><a  href="http://igbee.com.br">IGBee</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <img src="<?= URL_IMAGES; ?>loader.gif" style="display:none;" height="11" width="16">

        <!--modal-->
        <?= $this->assets->js ?>
         <script src="<?= base_url('public/js/login/capslock.js')?>"></script>
    </body>
</html>