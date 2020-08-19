<h6 class="element-header" style="margin-top: 10px;">Menu</h6>
<div class="row">
	<div class="col-md-12 col-sm-12" style="overflow: auto;height: 300px;">
		<div class="form-group">
			<label for="manutencao_menu_descricao">Tipo</label>
			<select class="form-control" name="manutencao_menu_descricao" ng-value="dadosManutencao.menu_tipo" id="manutencao_menu_descricao_1" ng-model="dadosManutencao.menu_tipo" ng-change="getOpcoesMenus(dadosManutencao.menu_tipo)" required>
				<option value="" selected> --</option>
				<option value="1">Seção de Menu</option>
				<option value="2">Menu</option>
				<option value="3">Item de Menu</option>
			</select>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
		<span ng-if="dadosManutencao.menu_tipo == 2">
			<div class="form-group">
				<label for="manutencao_menu_descricao">Seção de menu</label>{{secao_menu}}
				<!-- <select class="form-control" name="manutencao_menu_rotulomenu" id="manutencao_menu_rotulomenu" ng-selected="secao_menu" ng-model="dadosManutencao.secao_menu" required ng-options="item as item.descricao for item in secoesMenus track by item.id">
				</select> -->
				<select class="form-control" name="manutencao_menu_rotulomenu" id="manutencao_menu_rotulomenu" ng-model="dadosManutencao.secao_menu" ng-init="secao_menu" required>
					<option value="{{item.id}}" ng-repeat="(idx, item) in secoesMenus track by item.id">
						{{item.descricao}}
					</option>
				</select>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</span>
		<span ng-if="dadosManutencao.menu_tipo == 3">
			<div class="form-group">
				<label for="manutencao_menu_vinculo">Menu de vínculo</label>
				<!-- <select class="form-control" name="manutencao_menu_vinculo" id="manutencao_menu_vinculo" ng-model="dadosManutencao.menu_vinculo" required ng-options="item as item.descricao for item in menuVinculo track by item.id">
				</select> -->
				<select class="form-control" name="manutencao_menu_vinculo" id="manutencao_menu_vinculo" ng-model="dadosManutencao.menu_vinculo" ng-init="itemMenu" required>
					<option value="{{item.id}}" ng-repeat="item in menuVinculo track by item.id">
						{{item.descricao}}
					</option>
				</select>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</span>
		<span ng-if="dadosManutencao.menu_tipo == 1">
			<div class="form-group">
				<label for="manutencao_menu_descricao">Descrição</label>
				<input class="form-control" placeholder="Participante" required="required" type="texto" id="manutencao_menu_descricao" name="manutencao_menu_descricao" maxlength="100" 
				ng-model="dadosManutencao.descricao" >
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
			<div class="form-group">
				<label for="manutencao_menu_sigla">Sigla</label>
				<input class="form-control" placeholder="PTCP" type="texto" id="manutencao_menu_sigla" name="manutencao_menu_sigla" maxlength="4" 
				ng-model="dadosManutencao.sigla">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
		</span>
		<span ng-if="dadosManutencao.menu_tipo == 2 || dadosManutencao.menu_tipo == 3">
			<div class="form-group">
				<label for="manutencao_menu_descricao">Descrição</label>
				<input class="form-control" placeholder="Novo(s) Cadastro(s)" required="required" type="texto" id="manutencao_menu_descricao" name="manutencao_menu_descricao" maxlength="30" 
				ng-model="dadosManutencao.descricao">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
			<div class="form-group">
				<label for="manutencao_menu_descricao_completa">Descrição completa</label>
				<input class="form-control" placeholder="Permite realizar novas inscrições de participantes" type="texto" id="manutencao_menu_descricao_completa" 
				name="manutencao_menu_descricao_completa" maxlength="100" ng-model="dadosManutencao.descricao_completa">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
			<div class="form-group" ng-if="dadosManutencao.menu_tipo == 3">
				<label for="manutencao_menu_repositorio_link">Path repositório <small>(caminho no servidor)</small></label>
				<input class="form-control" placeholder="PTCP" required="required" type="texto" id="manutencao_menu_repositorio_link" name="manutencao_menu_repositorio_link" maxlength="50" 
				ng-model="dadosManutencao.path_servidor" value="dadosManutencao.menu_vinculo.descricao">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
			<div class="form-group" ng-if="dadosManutencao.menu_tipo == 3">
				<label for="manutencao_menu_target">Target</label><br>
				<select class="form-control" name="manutencao_menu_target" id="manutencao_menu_target" ng-model="dadosManutencao.target">
					<option value="" selected> --</option>
					<option value="_blank">_blank</option>
					<option value="_felf">_felf</option>
					<option value="_top">_top</option>
					<option value="_parent">_parent</option>
				</select>
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div>
			<!-- <div class="form-group">
				<label for="manutencao_menu_status">Icone</label><br>
				<input type="text" class="form-control" name="manutencao_menu_icone" id="manutencao_menu_icone" ng-model="dadosManutencao.icone" required maxlength="40">
				<div class="help-block form-text with-errors form-control-feedback"></div>
			</div> -->
		</span>
		<div class="form-group" ng-if="dadosManutencao.menu_tipo">
			<label for="manutencao_menu_status">Status</label><br>
			<select class="form-control" name="manutencao_menu_status" id="manutencao_menu_status" ng-model="dadosManutencao.status" required>
				<option value="" selected> --</option>
				<option value="1">Ativado</option>
				<option value="2">Desativado</option>
			</select>
			<div class="help-block form-text with-errors form-control-feedback"></div>
		</div>
		<div class="col-md-12 col-sm-12" style="margin-top: 5px;" ng-if="dadosManutencao.menu_tipo && (dadosManutencao.menu_tipo !== '')">
			<button class="btn btn-primary" type="button" ng-click="salvarMenu(dadosManutencao, dadosManutencao.menu_tipo)">Gravar</button>
			<button class="btn btn-danger" type="reset">Cancelar</button>
		</div>
	</div>
</div>