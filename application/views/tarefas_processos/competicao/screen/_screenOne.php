  <!-- <button class="mr-2 mb-2 btn btn-primary" data-target="#onboardingWideSlideModal" data-toggle="modal" type="button">Multistep modal with slider</button> -->
  <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideSlideModal" role="dialog" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-lg-12 modal-centered" role="document">
      <div class="modal-content text-center">
        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
          <span class="close-label">Fechar</span>
          <!-- <span class="os-icon os-icon-close"></span> -->
          <i class="os-icon os-icon-x-circle"></i>
        </button>
        <div class="onboarding-slider-w">
          <div class="onboarding-slide">
            <div class="onboarding-side-by-side">
              <!-- <div class="onboarding-media">
                <img alt="" src="<?//= base_url('public/img/avatar4.jpg')?>" width="200px">
              </div> -->
              <div class="onboarding-content with-gradient">
                <h4 class="onboarding-title">
                  Iniciar Competição
                </h4>
                <div class="onboarding-text">
                  <!-- In this example you can see a form where you can request some additional information from the customer when they land on the app page. -->
                  Forneça abaixo os dados para começar a competição.
                </div>
                <form>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Nome da competição</label>
                        <input class="form-control" placeholder="Ex: Retiro espiritual 2021..." type="text" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Período de Realização</label>
                        <input type="text" name="periodo_competicao" id="periodo_competicao" class="multi-daterange form-control">
                      </div>

                      <div class="daterangepicker_input">
                        <input class="input-mini form-control active" type="text" name="daterangepicker_start" value="">
                        <i class="fa fa-calendar glyphicon glyphicon-calendar"></i>
                        <div class="calendar-time" style="display: none;">
                          <div></div><i class="fa fa-clock-o glyphicon glyphicon-time"></i>
                        </div>
                      </div>
                      <div class="form-group"><label for="">Date Range Picker</label><input class="multi-daterange form-control" value="03/31/2017 - 04/06/2017"></div>

                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="onboarding-slide">
            <div class="onboarding-side-by-side">
              <div class="onboarding-media">
                <img alt="" src="img/bigicon6.png" width="200px">
              </div>
              <div class="onboarding-content with-gradient">
                <h4 class="onboarding-title">
                  Showcase App Features
                </h4>
                <div class="onboarding-text">
                  In this example you can showcase some of the features of your application, it is very handy to make new users aware of your hidden features. You can use boostrap columns to split them up.
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <ul class="features-list">
                      <li>
                        Fully Responsive design
                      </li>
                      <li>
                        Pre-built app layouts
                      </li>
                      <li>
                        Incredible Flexibility
                      </li>
                    </ul>
                  </div>
                  <div class="col-sm-6">
                    <ul class="features-list">
                      <li>
                        Boxed & Full Layouts
                      </li>
                      <li>
                        Based on Bootstrap 4
                      </li>
                      <li>
                        Developer Friendly
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="onboarding-slide">
            <div class="onboarding-side-by-side">
              <div class="onboarding-media">
                <img alt="" src="img/bigicon2.png" width="200px">
              </div>
              <div class="onboarding-content with-gradient">
                <h4 class="onboarding-title">
                  Example of onboarding screen!
                </h4>
                <div class="onboarding-text">
                  This is an example of a multistep onboarding screen, you can use it to introduce your customers to your app, or collect additional information from them before they start using your app.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>