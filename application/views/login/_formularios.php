<!-- form login -->
<form id="formLogin" name="formLogin" action="<?= base_url('login/autenticacao') ?>" method="post" ng-if="typeForm == 1" ng-class="{typeFormLogin: typeForm == 1}">
  <div class="form-group">
    <label for="">E-mail</label><input class="form-control" name="email" placeholder="Insira seu email" type="email" required>
    <div class="pre-icon os-icon os-icon-user-male-circle"></div>
  </div>
  <div class="form-group">
    <label for="">Senha</label><input class="form-control" name="senha" placeholder="Insira sua senha" type="password" required>
    <div class="pre-icon os-icon os-icon-fingerprint"></div>
  </div>
  <div class="buttons-w">
    <button class="btn btn-primary" ng-if="typeForm == 1">Entrar</button>
    <a href="#" ng-if="typeForm == 1" ng-click="changeForm(2)">Recuperar senha</a>
  </div>
</form>
<!-- form cadastro usuário -->
<form id="formCadastro" name="formCadastro" action="#" method="post" ng-if="typeForm == 2" ng-class="{typeFormLogin: typeForm == 2}">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="">E-mail</label>
        <input class="form-control" name="email" placeholder="Insira seu email" type="email" required>
        <div class="pre-icon os-icon os-icon-user-male-circle"></div>
      </div>
    </div>
  </div>
  <div class="buttons-w">
    <button class="btn btn-success" ng-if="typeForm == 2">Enviar</button>
    <button class="btn btn-success" ng-click="changeForm(1)" ng-if="typeForm == 2">Acessar</button>
  </div>
</form>