<!-- Contact Us Section -->
<div ng-controller="LoginController">
  <section id="" class="">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="section-title-header text-center">
            <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">PAINEL ADMINISTRATIVO</h1>
          </div>
        </div>
        <!-- {{allData}} -->
        <div class="col-lg-7 col-md-12 col-xs-12" id="boxStages" >
          <div class="container-form wow fadeInLeft" data-wow-delay="0.2s">
          <?php if(isset($_SESSION['erro_SLTV']) && (!empty($_SESSION['erro_SLTV']))) { ?>
          <div class="alert alert-danger" role="alert" data-auto-dismiss="3000">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <?= $_SESSION['erro_SLTV'] ?>
          </div>
          <?php } $this->rsession->delete("erro")?>
            <form name="formLogin" action="<?= base_url('administrador.php/login/autenticacao')?>" method="POST">
              <div class="form-wrapper animate-if">
                <div class="row">
                  <div class="content-section">
                    <div class="form-group">
                      <label for="email">EMAIL *</label>
                      <input type="text" name="email" id="email" class="form-control" placeholder="exemplo@exemplo.com" required ng-model="dadosLogin.email" style="text-transform:none;">
                      <!-- <span class="error" ng-show="!formLogin.email.$valid && !formLogin.email.$error.required">e-mail inválido</span>
                      <span class="error" ng-show="formLogin.email.$error.required">preenchimento obrigatório!</span> -->
                    </div>
                    <div class="form-group">
                      <label for="senha">SENHA *</label>
                      <input type="password" name="senha" id="senha" class="form-control" placeholder="sua senha" required ng-model="dadosLogin.senha" style="text-transform:none;">
                      <!-- <span class="error" ng-show="formLogin.senha.$error.required">preenchimento obrigatório!</span> -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="content-section" style="width: 100%;">
                    <div class="text-center">
                      <button ng-click="finishScheduling(dadosLogin)" class="btn btn-info btn-large" id="btnFinishStage">Acessar</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Contact Us Section End -->