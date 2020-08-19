<<<<<<< HEAD
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
=======

    <!-- Footer Section Start -->
    <footer class="footer-area section-padding">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.2s">
            <h3><img src="<?= base_url('public'); ?>/img/logo.png" alt=""></h3>
            <p>
              Aorem ipsum dolor sit amet elit sed lum tempor incididunt ut labore el dolore alg minim veniam quis nostrud ncididunt.
            </p>
          </div>
          <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.4s">
            <h3>QUICK LINKS</h3>
            <ul>
              <li><a href="#">About Conference</a></li>
              <li><a href="#">Our Speakers</a></li>
              <li><a href="#">Event Shedule</a></li>
              <li><a href="#">Latest News</a></li>
              <li><a href="#">Event Photo Gallery</a></li>
            </ul>
          </div>
          <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.6s">
            <h3>RECENT POSTS</h3>
            <ul class="image-list">
              <li>
                <figure class="overlay">
                  <img class="img-fluid" src="<?= base_url('public'); ?>/img/art/a1.jpg" alt="">
                </figure>
                <div class="post-content">
                  <h6 class="post-title"> <a href="blog-single.html">Lorem ipsm dolor sumit.</a> </h6>
                  <div class="meta"><span class="date">October 12, 2018</span></div>
                </div>
              </li>
              <li>
                <figure class="overlay">
                  <img class="img-fluid" src="<?= base_url('public'); ?>/img/art/a2.jpg" alt="">
                </figure>
                <div class="post-content">
                  <h6 class="post-title"><a href="blog-single.html">Lorem ipsm dolor sumit.</a></h6>
                  <div class="meta"><span class="date">October 12, 2018</span></div>
                </div>
              </li>
            </ul>
          </div>
          <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.8s">
            <h3>SUBSCRIBE US</h3>
            <div class="widget">
              <div class="newsletter-wrapper">
                <form method="post" id="subscribe-form" name="subscribe-form" class="validate">
                  <div class="form-group is-empty">
                    <input type="email" value="" name="Email" class="form-control" id="EMAIL" placeholder="Your email" required="">
                    <button type="submit" name="subscribe" id="subscribes" class="btn btn-common sub-btn"><i class="lni-pointer"></i></button>
                    <div class="clearfix"></div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.widget -->
            <div class="widget">
              <h5 class="widget-title">FOLLOW US ON</h5>
              <ul class="footer-social">
                <li><a class="facebook" href="#"><i class="lni-facebook-filled"></i></a></li>
                <li><a class="twitter" href="#"><i class="lni-twitter-filled"></i></a></li>
                <li><a class="linkedin" href="#"><i class="lni-linkedin-filled"></i></a></li>
                <li><a class="google-plus" href="#"><i class="lni-google-plus"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer Section End -->

    <div id="copyright">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="site-info">
              <p>© Designed and Developed by <a href="http://uideck.com" rel="nofollow">UIdeck</a></p>
            </div>      
          </div>
        </div>
      </div>
    </div>

    <!-- Go to Top Link -->
    <a href="#" class="back-to-top">
    	<i class="lni-chevron-up"></i>
    </a>

    <div id="preloader">
      <div class="sk-circle">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>
    </div>
    <?= $this->assets->js; ?>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCsa2Mi2HqyEcEnM1urFSIGEpvualYjwwM"></script>
      
>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
  </body>
</html>