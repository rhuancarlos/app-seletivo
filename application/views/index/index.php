        <h6 class="element-header"> Participantes por Equipes </h6>
        <div class="element-content"> <?// require_once(VIEWPATH.'widgets/_total_equipes.php');?> </div>
        </div>
    <div class="row">
      <div class="col-sm-12">      
        <div class="element-wrapper">
          <h6 class="element-header"> Avisos / Lembretes </h6>
          <div class="element-content">
            <div class="element-box default-avisos-lembretes avisos">
              <? if(isset($_SESSION['acesso_negado']) && !empty($_SESSION['acesso_negado'])) { ?>
                <div class="alert alert-danger" role="alert">
                  <?= $_SESSION['acesso_negado'] ?>
                  <? unset($_SESSION['acesso_negado']); ?>
                </div>
              <? } else { ?>
                <?= 'Nenhum aviso até o momento' ?>
              <? } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>