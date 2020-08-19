<h6 class="element-header" style="margin-top: 10px;">Itens de Menu <i ng-click="getMenu()" title="Atualizar" class="icon-feather-repeat icons-size-2" style="margin-left: 5px;"></i></h6>
<div class="row">
  <div class="col-md-12 col-sm-12" style="overflow: auto;height: 300px;">
    <ul class="main-menu" style="padding-left: 5px;">
      <li style="list-style:none;" ng-repeat="(key_s, secao) in menus.secao track by $index">
        <span style="font-weight: bold;">{{key_s}}</span> <span class="acoes_btn"><i class="icon-feather-edit" ng-click="editItem(1, secao)"></i> <i class="icon-feather-trash-2" ng-click="deleteItem()"></i></span>
        <ul style="padding-left: 10px;" ng-repeat="(key_p, menu_pai) in secao">
          <li style="list-style:none;">
            <i class="icon-feather-home"></i>  {{key_p}} <span class="acoes_btn"><i class="icon-feather-edit" ng-click="editItem(2, menu_pai)"></i> <i class="icon-feather-trash-2" ng-click="deleteItem()"></i></span>
              <ul ng-repeat="(key_i, menu_item) in menu_pai" style="padding-left: 10px;">
                <li style="list-style:none;">
                  &nbsp;<i class="icon-feather-chevrons-right"></i> {{menu_item.descricao}} <span class="acoes_btn"><i class="icon-feather-edit" ng-click="editItem(3, menu_item.id)"></i> <i class="icon-feather-trash-2" ng-click="deleteItem()"></i></span>
                </li>
              </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div>