@extends('layouts_fe.default')

@section('content')

<section id="home-section" class="hero">
        <h3 class="vr">Welcome to Church Software</h3>
          <div class="home-slider js-fullheight owl-carousel">
          <div class="slider-item js-fullheight">
            <div class="overlay"></div>
            <div class="container-fluid p-0">
              <div class="row d-md-flex no-gutters slider-text js-fullheight align-items-center justify-content-end" data-scrollax-parent="true">
                <div class="one-third order-md-last img js-fullheight" 
                style="background-image:url({{ URL::asset('assets/fe/images/bg_1.jpg') }});">
                    <div class="overlay"></div>
                </div>
                  <div class="one-forth d-flex js-fullheight align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                    <div class="text">
                        <span class="subheading">Welcome to the Church Software</span>
                        <h1 class="mb-4 mt-3"><span>Love your church management software</span></h1>
                        <p>Software designed to help you find freedom to focus on what matters in your ministry</p>
                        
                        <p><a href="#" class="btn btn-primary px-5 py-3 mt-3">Get in touch</a></p>
                    </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="slider-item js-fullheight">
            <div class="overlay"></div>
            <div class="container-fluid p-0">
              <div class="row d-flex no-gutters slider-text js-fullheight align-items-center justify-content-end" data-scrollax-parent="true">
                <div class="one-third order-md-last img js-fullheight" 
                style="background-image:url({{ URL::asset('assets/fe/images/bg_2.jpg') }});">
                    <div class="overlay"></div>
                </div>
                  <div class="one-forth d-flex js-fullheight align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                    <div class="text">
                        <span class="subheading">Welcome to the Church Software</span>
                        <h1 class="mb-4 mt-3"><span>Tools for Every Ministry</span></h1>
                        <p>Church Software is a set of seven online applications you can subscribe to individually or use together as a full Church Management System.</p>
                        
                        <p><a href="#" class="btn btn-primary px-5 py-3 mt-3">Get in touch</a></p>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </section>
        

    <section class="ftco-section ftco-no-pb ftco-no-pt ftco-services bg-light" id="services-section">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-md-4 ftco-animate py-5 nav-link-wrap">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link px-4 active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true"><span class="mr-3 flaticon-ideas"></span> Check-ins</a>

              <a class="nav-link px-4" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false"><span class="mr-3 flaticon-flasks"></span> Giving</a>

              <a class="nav-link px-4" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false"><span class="mr-3 flaticon-analysis"></span> Groups</a>

              <a class="nav-link px-4" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false"><span class="mr-3 flaticon-web-design"></span> Registrations</a>

              <a class="nav-link px-4" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-7" role="tab" aria-controls="v-pills-4" aria-selected="false"><span class="mr-3 flaticon-ux-design"></span> Resources</a>

              <a class="nav-link px-4" id="v-pills-5-tab" data-toggle="pill" href="#v-pills-5" role="tab" aria-controls="v-pills-5" aria-selected="false"><span class="mr-3 flaticon-innovation"></span> Services</a>

              <a class="nav-link px-4" id="v-pills-6-tab" data-toggle="pill" href="#v-pills-6" role="tab" aria-controls="v-pills-6" aria-selected="false"><span class="mr-3 flaticon-idea"></span> Creative</a>
            </div>
          </div>
          <div class="col-md-8 ftco-animate p-4 p-md-5 d-flex align-items-center">
            
            <div class="tab-content pl-md-5" id="v-pills-tabContent">

              <div class="tab-pane fade show active py-5" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                <span class="icon mb-3 d-block flaticon-ideas"></span>
                <h2 class="mb-4">Check-ins</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                <p><a href="#" class="btn btn-primary px-4 py-3">Learn More</a></p>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                <span class="icon mb-3 d-block flaticon-flasks"></span>
                <h2 class="mb-4">Giving</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                <p><a href="#" class="btn btn-primary px-4 py-3">Learn More</a></p>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                <span class="icon mb-3 d-block flaticon-analysis"></span>
                <h2 class="mb-4">Groups</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                <p><a href="#" class="btn btn-primary px-4 py-3">Learn More</a></p>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
                <span class="icon mb-3 d-block flaticon-web-design"></span>
                <h2 class="mb-4">Registrations</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                <p><a href="#" class="btn btn-primary px-4 py-3">Learn More</a></p>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-7" role="tabpanel" aria-labelledby="v-pills-4-tab">
                <span class="icon mb-3 d-block flaticon-ux-design"></span>
                <h2 class="mb-4">Resources</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                <p><a href="#" class="btn btn-primary px-4 py-3">Learn More</a></p>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-5-tab">
                <span class="icon mb-3 d-block flaticon-innovation"></span>
                <h2 class="mb-4">Services</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                <p><a href="#" class="btn btn-primary px-4 py-3">Learn More</a></p>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-6-tab">
                <span class="icon mb-3 d-block flaticon-idea"></span>
                <h2 class="mb-4">Creative Solution</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt voluptate, quibusdam sunt iste dolores consequatur</p>
                <p>Inventore fugit error iure nisi reiciendis fugiat illo pariatur quam sequi quod iusto facilis officiis nobis sit quis molestias asperiores rem, blanditiis! Commodi exercitationem vitae deserunt qui nihil ea, tempore et quam natus quaerat doloremque.</p>
                <p><a href="#" class="btn btn-primary px-4 py-3">Learn More</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section-2 img" style="background-image: url({{ URL::asset('assets/fe/images/bg_3.jpg') }});">
        <div class="container">
            <div class="row d-md-flex justify-content-end">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="services-wrap ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="ion-ios-arrow-back"></span>
                                    <span class="ion-ios-arrow-forward"></span>
                                </div>
                                <h2>Market Research</h2>
                                <p>Even the all-powerful Pointing has no control about the blind.</p>
                            </a>
                            <a href="#" class="services-wrap ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="ion-ios-arrow-back"></span>
                                    <span class="ion-ios-arrow-forward"></span>
                                </div>
                                <h2>Financial Services</h2>
                                <p>Even the all-powerful Pointing has no control about the blind.</p>
                            </a>
                            <a href="#" class="services-wrap ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="ion-ios-arrow-back"></span>
                                    <span class="ion-ios-arrow-forward"></span>
                                </div>
                                <h2>Online Marketing</h2>
                                <p>Even the all-powerful Pointing has no control about the blind.</p>
                            </a>
                            <a href="#" class="services-wrap ftco-animate">
                                <div class="icon d-flex justify-content-center align-items-center">
                                    <span class="ion-ios-arrow-back"></span>
                                    <span class="ion-ios-arrow-forward"></span>
                                </div>
                                <h2>24/7 Help &amp; Support</h2>
                                <p>Even the all-powerful Pointing has no control about the blind.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-project bg-light" id="projects-section">
        <div class="container px-md-5">
            <div class="row justify-content-center pb-5">
          <div class="col-md-12 heading-section text-center ftco-animate">
            <span class="subheading">Accomplishments</span>
            <h2 class="mb-4">Our Projects</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
          </div>
        </div>
            <div class="row">
                <div class="col-md-12 testimonial">
            <div class="carousel-project owl-carousel">
                <div class="item">
                    <div class="project">
                                <div class="img">
                                    <img src="{{ URL::asset('assets/fe/images/project-1.jpg')}}" class="img-fluid" alt="Colorlib Template">
                                    <div class="text px-4">
                                        <h3><a href="#">Work Name</a></h3>
                                        <span>Web Design</span>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="item">
                    <div class="project">
                                <div class="img">
                                    <img src="{{ URL::asset('assets/fe/images/project-2.jpg')}}" class="img-fluid" alt="Colorlib Template">
                                    <div class="text px-4">
                                        <h3><a href="#">Work Name</a></h3>
                                        <span>Web Design</span>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="item">
                    <div class="project">
                                <div class="img">
                                    <img src="{{ URL::asset('assets/fe/images/project-3.jpg')}}" class="img-fluid" alt="Colorlib Template">
                                    <div class="text px-4">
                                        <h3><a href="#">Work Name</a></h3>
                                        <span>Web Design</span>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="item">
                    <div class="project">
                                <div class="img">
                                    <img src="{{ URL::asset('assets/fe/images/project-4.jpg')}}" class="img-fluid" alt="Colorlib Template">
                                    <div class="text px-4">
                                        <h3><a href="#">Work Name</a></h3>
                                        <span>Web Design</span>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="item">
                    <div class="project">
                                <div class="img">
                                    <img src="{{ URL::asset('assets/fe/images/project-5.jpg')}}" class="img-fluid" alt="Colorlib Template">
                                    <div class="text px-4">
                                        <h3><a href="#">Work Name</a></h3>
                                        <span>Web Design</span>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="item">
                    <div class="project">
                                <div class="img">
                                    <img src="{{ URL::asset('assets/fe/images/project-6.jpg')}}" class="img-fluid" alt="Colorlib Template">
                                    <div class="text px-4">
                                        <h3><a href="#">Work Name</a></h3>
                                        <span>Web Design</span>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
          </div>
            </div>
        </div>
    </section>
        

        <section class="ftco-counter img ftco-section ftco-no-pt ftco-no-pb" id="about-section">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-6 col-lg-5 d-flex">
                    <div class="img d-flex align-self-stretch align-items-center" style="background-image:url({{ URL::asset('assets/fe/images/about.jpg') }});">
                    </div>
                </div>
                <div class="col-md-6 col-lg-7 pl-lg-5 py-5">
                    <div class="py-md-5">
                        <div class="row justify-content-start pb-3">
                      <div class="col-md-12 heading-section ftco-animate">
                        <span class="subheading">Welcome to Church Software</span>
                        <h2 class="mb-4" style="font-size: 34px; text-transform: capitalize;">We Love Our Churches</h2>
                        <p>We are driven entirely by our customer’s needs. What we do, we do only for the church, and that will never change.</p>
                        <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                        <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
                      </div>
                    </div>
                  <div class="counter-wrap ftco-animate d-flex mt-md-3">
                  <div class="text p-4 bg-primary">
                    <p class="mb-0">
                        <span class="number" data-number="20">0</span>
                        <span>Years of experience</span>
                    </p>
                  </div>
                  </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="ftco-section" style="display: none;">
        <div class="container">
            <div class="row justify-content-center pb-5">
          <div class="col-md-6 heading-section text-center ftco-animate">
            <span class="subheading">About Us</span>
            <h2 class="mb-4">Our Staff</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
          </div>
        </div>
        <div class="row">
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="staff">
                            <div class="img-wrap d-flex align-items-stretch">
                                <div class="img align-self-stretch" style="background-image: url({{ URL::asset('assets/fe/images/staff-1.jpg') }});"></div>
                            </div>
                            <div class="text d-flex align-items-center pt-3 text-center">
                                <div>
                                    <h3 class="mb-2">Lloyd Wilson</h3>
                                    <span class="position mb-4">CEO, Founder</span>
                                    <div class="faded">
                                        <ul class="ftco-social text-center">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                          </ul>
                      </div>
                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="staff">
                            <div class="img-wrap d-flex align-items-stretch">
                                <div class="img align-self-stretch" style="background-image: url({{ URL::asset('assets/fe/images/staff-2.jpg') }});"></div>
                            </div>
                            <div class="text d-flex align-items-center pt-3 text-center">
                                <div>
                                    <h3 class="mb-2">Rachel Parker</h3>
                                    <span class="position mb-4">Web Designer</span>
                                    <div class="faded">
                                        <ul class="ftco-social text-center">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                          </ul>
                      </div>
                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="staff">
                            <div class="img-wrap d-flex align-items-stretch">
                                <div class="img align-self-stretch" style="background-image: url({{ URL::asset('assets/fe/images/staff-3.jpg') }});"></div>
                            </div>
                            <div class="text d-flex align-items-center pt-3 text-center">
                                <div>
                                    <h3 class="mb-2">Ian Smith</h3>
                                    <span class="position mb-4">Web Developer</span>
                                    <div class="faded">
                                        <ul class="ftco-social text-center">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                          </ul>
                      </div>
                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="staff">
                            <div class="img-wrap d-flex align-items-stretch">
                                <div class="img align-self-stretch" style="background-image: url({{ URL::asset('assets/fe/images/staff-4.jpg') }});"></div>
                            </div>
                            <div class="text d-flex align-items-center pt-3 text-center">
                                <div>
                                    <h3 class="mb-2">Alicia Henderson</h3>
                                    <span class="position mb-4">Graphic Designer</span>
                                    <div class="faded">
                                        <ul class="ftco-social text-center">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                          </ul>
                      </div>
                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>

        <section class="ftco-section testimony-section" id="testimony-section">
      <div class="container">
        <div class="row justify-content-center pb-3">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2 class="mb-4">Happy Clients</h2>
            <p>Church Software is trusted by over 80,000 churches.</p>
          </div>
        </div>
        <div class="row ftco-animate justify-content-center">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <div class="item">
                <div class="testimony-wrap text-center py-4 pb-5">
                  <div class="user-img" style="background-image: url({{ URL::asset('assets/fe/images/person_1.jpg') }})">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text px-4 pb-5">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">John Fox</p>
                    <span class="position">Businessman</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap text-center py-4 pb-5">
                  <div class="user-img" style="background-image: url({{ URL::asset('assets/fe/images/person_2.jpg') }})">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text px-4 pb-5">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">John Fox</p>
                    <span class="position">Businessman</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap text-center py-4 pb-5">
                  <div class="user-img" style="background-image: url({{ URL::asset('assets/fe/images/person_3.jpg') }})">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text px-4 pb-5">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">John Fox</p>
                    <span class="position">Businessman</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap text-center py-4 pb-5">
                  <div class="user-img" style="background-image: url({{ URL::asset('assets/fe/images/person_4.jpg') }})">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text px-4 pb-5">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">John Fox</p>
                    <span class="position">Businessman</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap text-center py-4 pb-5">
                  <div class="user-img" style="background-image: url({{ URL::asset('assets/fe/images/person_3.jpg') }})">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text px-4 pb-5">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">John Fox</p>
                    <span class="position">Businessman</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light" id="blog-section" style="display:none;">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <span class="subheading">Blog</span>
            <h2 class="mb-4">Our Blog</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
          </div>
        </div>
        <div class="row d-flex">
          <div class="col-md-4 d-flex ftco-animate">
            <div class="blog-entry justify-content-end">
              <a href="single.html" class="block-20" style="background-image: url({{ URL::asset('assets/fe/images/image_1.jpg') }});">
              </a>
              <div class="text mt-3 float-right d-block">
                <div class="d-flex align-items-center pt-2 mb-4 topp">
                    <div class="one mr-2">
                        <span class="day">12</span>
                    </div>
                    <div class="two">
                        <span class="yr">2019</span>
                        <span class="mos">March</span>
                    </div>
                </div>
                <h3 class="heading"><a href="single.html">Why Lead Generation is Key for Business Growth</a></h3>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                <div class="d-flex align-items-center mt-4 meta">
                    <p class="mb-0"><a href="#" class="btn btn-primary">Read More <span class="ion-ios-arrow-round-forward"></span></a></p>
                    <p class="ml-auto mb-0">
                        <a href="#" class="mr-2">Admin</a>
                        <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                    </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 d-flex ftco-animate">
            <div class="blog-entry justify-content-end">
              <a href="single.html" class="block-20" style="background-image: url({{ URL::asset('assets/fe/images/image_2.jpg') }});">
              </a>
              <div class="text mt-3 float-right d-block">
                <div class="d-flex align-items-center pt-2 mb-4 topp">
                    <div class="one mr-2">
                        <span class="day">10</span>
                    </div>
                    <div class="two">
                        <span class="yr">2019</span>
                        <span class="mos">March</span>
                    </div>
                </div>
                <h3 class="heading"><a href="single.html">Why Lead Generation is Key for Business Growth</a></h3>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                <div class="d-flex align-items-center mt-4 meta">
                    <p class="mb-0"><a href="#" class="btn btn-primary">Read More <span class="ion-ios-arrow-round-forward"></span></a></p>
                    <p class="ml-auto mb-0">
                        <a href="#" class="mr-2">Admin</a>
                        <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                    </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 d-flex ftco-animate">
            <div class="blog-entry">
              <a href="single.html" class="block-20" style="background-image: url({{ URL::asset('assets/fe/images/image_3.jpg') }});">
              </a>
              <div class="text mt-3 float-right d-block">
                <div class="d-flex align-items-center pt-2 mb-4 topp">
                    <div class="one mr-2">
                        <span class="day">05</span>
                    </div>
                    <div class="two">
                        <span class="yr">2019</span>
                        <span class="mos">March</span>
                    </div>
                </div>
                <h3 class="heading"><a href="single.html">Why Lead Generation is Key for Business Growth</a></h3>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                <div class="d-flex align-items-center mt-4 meta">
                    <p class="mb-0"><a href="#" class="btn btn-primary">Read More <span class="ion-ios-arrow-round-forward"></span></a></p>
                    <p class="ml-auto mb-0">
                        <a href="#" class="mr-2">Admin</a>
                        <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                    </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section ftco-no-pb" id="contact-section">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <span class="subheading">Contact</span>
            <h2 class="mb-4">Contact Us</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
          </div>
        </div>
        <div class="row d-flex contact-info mb-5">
          <div class="col-md-6 col-lg-3 d-flex ftco-animate">
            <div class="align-self-stretch box p-4 text-center">
                <div class="icon d-flex align-items-center justify-content-center">
                    <span class="icon-map-signs"></span>
                </div>
                <h3 class="mb-4">Address</h3>
                <p>198 West 21th Street, Suite 721 New York NY 10016</p>
              </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex ftco-animate">
            <div class="align-self-stretch box p-4 text-center">
                <div class="icon d-flex align-items-center justify-content-center">
                    <span class="icon-phone2"></span>
                </div>
                <h3 class="mb-4">Contact Number</h3>
                <p><a href="tel://1234567920">+ 1235 2355 98</a></p>
              </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex ftco-animate">
            <div class="align-self-stretch box p-4 text-center">
                <div class="icon d-flex align-items-center justify-content-center">
                    <span class="icon-paper-plane"></span>
                </div>
                <h3 class="mb-4">Email Address</h3>
                <p><a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
              </div>
          </div>
          <div class="col-md-6 col-lg-3 d-flex ftco-animate">
            <div class="align-self-stretch box p-4 text-center">
                <div class="icon d-flex align-items-center justify-content-center">
                    <span class="icon-globe"></span>
                </div>
                <h3 class="mb-4">Website</h3>
                <p><a href="#">yoursite.com</a></p>
              </div>
          </div>
        </div>
        <div class="row no-gutters block-9">
          <div class="col-md-6 order-md-last d-flex">
            <form action="#" class="bg-light p-5 contact-form">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Your Name">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Your Email">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Subject">
              </div>
              <div class="form-group">
                <textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
              </div>
            </form>
          
          </div>

          <div class="col-md-6 d-flex">
            <div id="map" class="bg-white"></div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section sign-up ftco-no-pb" id="sign-up">
      <div class="container">
        <div class="row justify-content-center "> <!--mb-5 pb-3-->
          <div class="col-md-7 heading-section text-center ftco-animate">
            <span class="subheading">Register</span>
            <h2 class="mb-4">Set Up Your Account</h2>
            <!-- <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p> -->
          </div>
        </div> 
        <div class="row no-gutters block-9">
          <div class="col-md-6 order-md-last d-flex">
           <!--  @if ($errors->any())
            <div class="error">
                <ul style="list-style: none;padding: 0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif -->
            
            <!-- 
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif -->
            
            {!! Form::open(array('id'=>'organizationCreateForm','name'=>'organizationCreateForm','method' => 'post', 'url' => url('org_register'), 'class' => 'bg-light p-5 signup-form')) !!}
            @csrf
              <div class="form-group">
                <input id="orgName" type="text" class="form-control @error('orgName') is-invalid @enderror" name="orgName" value="{{ old('orgName') }}" placeholder="Organization/Church Name"    autofocus required >
              </div>
              <div class="form-group">
                <input id="orgDomain" type="text" class="form-control @error('orgDomain') is-invalid @enderror" name="orgDomain" value="{{ old('orgDomain') }}" placeholder="Organization/Church Sub Domain Name"    autofocus required >
              </div>
              <div class="form-group">
                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"    autofocus required placeholder="Name">
              </div>
              <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"    autofocus required placeholder="Email">
              </div>
              <div class="form-group">
                <input class="form-control" name="password" id="password" type="password" value="" placeholder="Password" required>
              </div>
              <div class="form-group">
              <input class="form-control" name="confirm_password" id="confirm_password" type="password" value="" placeholder="Confirm Password" required>
              </div>

              <div class="form-group">
                    {!! $dateTimezone !!}
                
                </div>

            

                <div class="form-group">
                    <div class="col-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label font-weight-normal" for="customCheck1">I accept <a href="#" class="text-muted">Terms and Conditions</a></label>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center m-t-20">
                    <div class="col-12">
                        <button class="btn btn-info btn-block waves-effect waves-light" id="btnCreateOrg" type="button">Register</button>
                    </div>
                </div>

                <div  class="bg-white">&nbsp;<div id="organizationLoginDetails"></div></div>
<!--              <div class="form-group">
                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
              </div>-->
            </form>
          
          </div>

          <div class="col-md-6 d-flex organizationLoginDetails">
            <!-- <div  class="bg-white">&nbsp;<div id="organizationLoginDetails"></div></div> -->
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section sign-in ftco-no-pb" id="sign-in">
      <div class="container">
        <div class="row justify-content-center "> <!--mb-5 pb-3-->
          <div class="col-md-7 heading-section text-center ftco-animate">
            <span class="subheading">SignIn</span>
            <h2 class="mb-4">Sign In to Your Account</h2>
            
          </div>
        </div> 
        <div class="row no-gutters block-12">
          <div class="col-md-10 order-md-last d-flex">
           
            
            {!! Form::open(array('id'=>'siteLoginForm','name'=>'siteLoginForm','method' => 'post', 'url' => url('site_login'), 'class' => 'bg-light p-12 signin-form')) !!}
            @csrf
               
              <div class="form-group">
                <input autocomplete="off" id="email" type="email" class="form-control" name="email"     autofocus required placeholder="Email">
              </div>
              <div class="form-group">
                <input class="form-control" name="password" id="password" type="password" value="" placeholder="Password" required>
              </div> 
              <div class="form-group text-center m-t-20">
                    <div class="col-12">
                        <button class="btn btn-info btn-block waves-effect waves-light" id="btnSignIn" type="button">SignIn</button>
                    </div>
                </div>
            </form>
          
          </div>

           
        </div>
      </div>
    </section>

<script src="{{ URL:: asset('js/custom/org_register.js')}}"></script>

@endsection
