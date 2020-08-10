<? require_once(VIEWPATH.'layouts/copyright.php')?>
              <div class="btn-aparencia">
                <!-------------------- START - Color Scheme Toggler -------------------->
                <div class="floated-colors-btn second-floated-btn">
                  <div class="os-toggler-w">
                    <div class="os-toggler-i">
                      <div class="os-toggler-pill"></div>
                    </div>
                  </div>
                  <span>Modo Noturno </span>
                </div>
                <!-------------------- END - Color Scheme Toggler -------------------->
                <!-------------------- START - Demo Customizer -------------------->
                <div class="floated-customizer-btn third-floated-btn">
                  <div class="icon-w">
                    <i class="os-icon os-icon-ui-46"></i>
                  </div>
                  <span>Aparência</span>
                </div>
                <div class="floated-customizer-panel">
                  <div class="fcp-content">
                    <div class="close-customizer-btn">
                      <i class="os-icon os-icon-x"></i>
                    </div>
                    <div class="fcp-group">
                      <div class="fcp-group-header">
                        Configuração de Menu
                      </div>
                      <div class="fcp-group-contents">
                        <div class="fcp-field">
                          <label for="">Posição</label><select class="menu-position-selector">
                            <option value="left">
                              Esquerda
                            </option>
                            <option value="right">
                              Direita
                            </option>
                            <option value="top">
                              Topo
                            </option>
                          </select>
                        </div>
                        <div class="fcp-field">
                          <label for="">Estilo</label><select class="menu-layout-selector">
                            <option value="compact">
                              Compacto
                            </option>
                            <option value="full">
                              Completo
                            </option>
                            <option value="mini">
                              Mini
                            </option>
                          </select>
                        </div>
                        <div class="fcp-field">
                          <label for="">Cor</label>
                          <div class="fcp-colors menu-color-selector">
                            <div class="color-selector menu-color-selector color-bright"></div>
                            <div class="color-selector menu-color-selector color-dark"></div>
                            <div class="color-selector menu-color-selector color-light"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fcp-group">
                      <div class="fcp-group-header">
                        Sub Menu
                      </div>
                      <div class="fcp-group-contents">
                        <div class="fcp-field">
                          <label for="">Estilo</label><select class="sub-menu-style-selector">
                            <option value="flyout">
                              Flyout
                            </option>
                            <option value="inside">
                              Inside/Click
                            </option>
                            <option value="over">
                              Over
                            </option>
                          </select>
                        </div>
                        <div class="fcp-field">
                          <label for="">Cor</label>
                          <div class="fcp-colors">
                            <div class="color-selector sub-menu-color-selector color-dark"></div>
                            <div class="color-selector sub-menu-color-selector color-light"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fcp-group">
                      <div class="fcp-group-header">
                        Outras Configurações
                      </div>
                      <div class="fcp-group-contents">
                        <div class="fcp-field">
                          <label for="">Tela Inteira</label><select class="full-screen-selector">
                            <option value="yes">
                              Sim
                            </option>
                            <option value="no">
                              Não
                            </option>
                          </select>
                        </div>
                        <div class="fcp-field">
                          <label for="">Mostrar Barra de Topo</label><select class="top-bar-visibility-selector">
                            <option value="yes">
                              Sim
                            </option>
                            <option value="no">
                              Não
                            </option>
                          </select>
                        </div>
                        <div class="fcp-field">
                          <label for="">Menu Sobreposto</label><select class="top-bar-above-menu-selector">
                            <option value="yes">
                              Sim
                            </option>
                            <option value="no">
                              Não
                            </option>
                          </select>
                        </div>
                        <div class="fcp-field">
                          <label for="">Cor da Barra de Topo</label>
                          <div class="fcp-colors">
                            <div class="color-selector top-bar-color-selector color-bright"></div>
                            <div class="color-selector top-bar-color-selector color-dark"></div>
                            <div class="color-selector top-bar-color-selector color-light"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-------------------- END - Demo Customizer -------------------->
              </div>
            </div> <!-- end content-w -->
          </div> <!-- end layout-w -->
        </div> <!-- end all-wrapper with-side-panel solid-bg-all -->
      <!-- </div> -->
      <!-- <div class="display-type"></div> -->
    <!-- </div> -->
    <?= $this->assets->js;?>
    <script src="<?=PATH_PUBLIC_JS.'demo_customizer.js?version=4.5.0'?>"></script>
    <script src="<?=PATH_PUBLIC_JS.'main.js?version=4.5.0'?>"></script>
    <script>
    </script>
  </body>
</html>