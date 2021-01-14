<div class="logo-w">
  <a class="logo" href="<?= base_url() ?>">
    <div class="logo-element"></div> <!-- class call img logo -->
    <div class="logo-label">
      <?= NOME_CURTO_SISTEMA.' '.date('Y')?>
    </div>
  </a>
</div>
<div class="logged-user-w avatar-inline">
  <div class="logged-user-i">
    <?php include(VIEWPATH.'layouts/perfil_usuario.php'); ?>
  </div>
</div>
<h1 class="menu-page-header">
  Page Header
</h1>
  <!--------------------
  START - Menu List
  -------------------->
  <?= $this->rsession->get('menu_completo'); ?>
  <!--------------------
  END - Menu List
  -------------------->