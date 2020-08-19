<?= geraElementHeaderPage(array($titulo_pagina)); ?>
<div class="element-box"> 
    <!-- <form id="formValidate"> -->
    <form id="formCadastroUsuario" name="formCadastroUsuario" class="formValidate" enctype="multipart/form-data" method="POST">
        <legend>
            <span>Informações do Usuário</span>
        </legend>
        <!-- Inputs Form@dados_pessoais -->
        <?php include(VIEW_MODULO_USUARIOS.'r_inputs_usuario.php')?>
    </form>
</div>