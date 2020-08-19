<!-- Contact Us Section -->
<div ng-app="IbnfAgendamento" ng-controller="AgendamentoController">
  <section id="schedules" class="schedule section-padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="section-title-header text-center">
            <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">Agendamento de Culto</h1>
            <p class="wow fadeInDown" data-wow-delay="0.2s">Global Grand Event on Digital Design</p>
          </div>
        </div>
        <div class="col-lg-7 col-md-12 col-xs-12">
          <div class="container-form wow fadeInLeft" data-wow-delay="0.2s">
            <div class="form-wrapper">{{nome}}
              <form role="form" method="post" id="contactForm" name="contact-form" data-toggle="validator">
                <div class="row">
                  <div class="col-md-6 form-line">
                    <div class="form-group">
                      <input type="text" class="form-control" id="name" name="email" placeholder="First Name" required data-error="Please enter your name">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6 form-line">
                    <div class="form-group">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email" required data-error="Please enter your Email">
                      <div class="help-block with-errors"></div>
                    </div> 
                  </div>
                  <div class="col-md-12 form-line">
                    <div class="form-group">
                      <input type="tel" class="form-control" id="msg_subject" name="subject" placeholder="Subject" required data-error="Please enter your message subject">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea class="form-control" rows="4" id="message" name="message" required data-error="Write your message"></textarea>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-submit">
                      <button type="submit" class="btn btn-common" id="form-submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Send Us Now</button>
                      <div id="msgSubmit" class="h3 text-center hidden"></div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Contact Us Section End -->