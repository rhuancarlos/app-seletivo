<div class="element-box-content">
  <button class="mr-2 mb-2 btn btn-sm btn-white" data-target="#onboardingWideSlideModal" data-toggle="modal" ng-click="inicarCompeticao()"><i class="fa fa-tachometer"></i> Iniciar Competição</button>
  <button class="mr-2 mb-2 btn btn-sm btn-white" ng-click="changeForm(2)"><i class="fa fa-puzzle-piece"></i> Provas em curso</button>
  <button class="mr-2 mb-2 btn btn-sm btn-white" ng-click="changeForm(3)"><i class="fa fa-low-vision"></i> Apuração de provas</button>
  <button class="mr-2 mb-2 btn btn-sm btn-white" ng-click="changeForm(4)"><i class="fa fa-handshake-o"></i> Reuniões e Ocorrências</button>
  <button class="mr-2 mb-2 btn btn-sm btn-white" ng-click="changeForm(5)"><i class="fa fa-bar-chart"></i> Resultados</button>
  <button ng-click="handleAction()">teste chamada service</button>
  <span ng-if="dados">{{dados}}</span>
  <div class="form-group">
    <label for="">Período de Realização</label>
    <input type="text" name="periodo_competicao" id="periodo_competicao" class="multi-daterange form-control">
  </div>
</div>