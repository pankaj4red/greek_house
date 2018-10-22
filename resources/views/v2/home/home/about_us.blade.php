@extends('v2.layouts.app')

@section('title', 'About us')

@section('content')
    <div class="about-us skip-header-margin tstabc">
        <div class="about__intro ">
            <h1>Greeks, who just happen to make T-Shirts.</h1>
        </div>

        <div class="about__story">
            <h2>Our Story</h2>
            <div class="section__text">
                This is us. College kids at the University of Florida. With $500 and a simple goal to make ordering custom apparel as simple as possible, we set out to change the industry. From
                selling shirts out of our fraternity house to expanding nationally, we haven't stopped since.
                In just a short time, we moved our headquarters to Los Angeles, hired our best friends, and have become one of the fastest growing
                startups in the world... The best part? We're just getting started.
            </div>
        </div>

        <div class="container about__pillars">
            <h2>Four Pillars of Greek House</h2>
            <div class="row">
                <div class="col-md-3 pillars_item reliability">
                    <h5>Reliability</h5>
                    <div class="pillar__text">
                        We were just in your shoes so we understand how important your order is. Just like a fraternity or
                        sorority, we believe that a group of a few good people can do a lot of great things.
                    </div>
                </div>
                <div class="col-md-3 pillars_item technology">
                    <h5>Technology</h5>
                    <div class="pillar__text">
                        Our platform makes design creation, payment collection, and distribution smarter and more secure.
                        For customers, this means better designs, quicker turnaround times, and lower prices.
                    </div>
                </div>
                <div class="col-md-3 pillars_item creativity">
                    <h5>Creativity</h5>
                    <div class="pillar__text">
                        We are creative problem solvers who don’t give up. No matter the circumstances, we go above and
                        beyond to meet and exceed our customer’s needs. Originality, Quality, Detail, Storytelling. It’s what we do.
                    </div>
                </div>
                <div class="col-md-3 pillars_item philantropy">
                    <h5>Philanthropy</h5>
                    <div class="pillar__text">
                        Philanthropy is a staple of Greek Life and we made it a core pillar of our company. We donate back on
                        every philanthropy order to help your chapter reach their fundraising goals.
                    </div>
                </div>
            </div>
        </div>

        <div class="about__testimonials">
            <h2>Testimonial</h2>
            <div class="testimonials owl-carousel">
                <div class="testimonial__item">
                    <div class="testimonial__avatar" style="background-image: url(images/about-us/testimonials/andrea_farr.png)"></div>
                    <div class="testimonial__text">
                        I'm pretty addicted to your services because of how easy it is to use the website and how friendly
                        everyone is! It really feels like I'm working on a team to make my apparel the best it can be.
                    </div>
                    <div class="testimonial__name">Andrea Farr</div>
                    <div class="testimonial__university">Alpha Phi, Cornell University</div>
                </div>
                <div class="testimonial__item">
                    <div class="testimonial__avatar" style="background-image: url(images/about-us/testimonials/mallory.png)"></div>
                    <div class="testimonial__text">
                        Love how dependable Greek House is and the customer service is great!
                    </div>
                    <div class="testimonial__name">Mallory Schultze</div>
                    <div class="testimonial__university">Kappa Delta, North Dakota State University</div>
                </div>
                <div class="testimonial__item">
                    <div class="testimonial__avatar" style="background-image: url(images/about-us/testimonials/senai.jpg)"></div>
                    <div class="testimonial__text">
                        I love that your site is specifically geared towards the Greek community! You know the types of designs
                        we're looking for and it makes the Greek community feel even closer! I think Greek House should be used by all Greek organizations
                    </div>
                    <div class="testimonial__name">Senai Doss</div>
                    <div class="testimonial__university">Pi Beta Phi, Montana State University</div>
                </div>
                <div class="testimonial__item">
                    <div class="testimonial__avatar" style="background-image: url(images/about-us/testimonials/rachel.jpg)"></div>
                    <div class="testimonial__text">
                        I really love working with you. It's so easy to place an order, even if I forgot and have to place
                        it at 4AM, and I wake up with a proof. It's so fast and so simple to get revisions. Every time we've gotten the product exactly right.
                    </div>
                    <div class="testimonial__name">Rachel Wells</div>
                    <div class="testimonial__university">Delta Gamma, Cornell University</div>
                </div>
                <div class="testimonial__item">
                    <div class="testimonial__avatar" style="background-image: url(images/about-us/testimonials/ellie.jpg)"></div>
                    <div class="testimonial__text">
                        Greek House changed the game for me when it comes to being in charge of apparel.
                        Greek house took the stress off of me and made this job so fun and easy!
                    </div>
                    <div class="testimonial__name">Ellie Telander</div>
                    <div class="testimonial__university">Delta Gamma, University of Missouri</div>
                </div>
            </div>
        </div>


        <div class="container about__leaders">
            <h2>Leadership Team</h2>
            <div class="section__text">
                Think of us as the Navy Seals of the custom apparel world. A small elite team that always gets the job done
                right. Way more than just a t-shirt company... a nimble unit that creates artistic, beautiful products that
                tell your chapter's unique stories.
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 leader">
                    <div class="leader__avatar" style="background-image: url(images/about-us/team/karthik.jpg)"></div>
                    <div class="leader__name">Karthik Shanadi</div>
                    <div class="leader__position">Co-Founder & CEO</div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 leader">
                    <div class="leader__avatar" style="background-image: url(images/about-us/team/luke.png)"></div>
                    <div class="leader__name">Luke McGurrin</div>
                    <div class="leader__position">Co-Founder & CMO</div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 leader">
                    <div class="leader__avatar" style="background-image: url(images/about-us/team/jordan.png)"></div>
                    <div class="leader__name">Jordan Hayes</div>
                    <div class="leader__position">Head of Growth</div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 leader">
                    <div class="leader__avatar" style="background-image: url(images/about-us/team/ian.jpg)"></div>
                    <div class="leader__name">Ian Collins</div>
                    <div class="leader__position">Head of Sales</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 leader">
                    <div class="leader__avatar" style="background-image: url(images/about-us/team/mason.png)"></div>
                    <div class="leader__name">Mason Mello</div>
                    <div class="leader__position">Head of Customer Success</div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 leader">
                    <div class="leader__avatar" style="background-image: url(images/about-us/team/camille.png)"></div>
                    <div class="leader__name">Camille Callahan</div>
                    <div class="leader__position">Director of Marketing Ops</div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 leader">
                    <div class="leader__avatar" style="background-image: url(images/about-us/team/felipe.png)"></div>
                    <div class="leader__name">Felipe Posso</div>
                    <div class="leader__position">Operations Manager</div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 leader">
                    <div class="leader__avatar" style="background-image: url(images/about-us/team/derby.jpg)"></div>
                    <div class="leader__name">Derby Hayes</div>
                    <div class="leader__position">Chief Barketing Officer</div>
                </div>
            </div>
        </div>

        <div class="about__mission">
            <h2>Our Mission</h2>
            <div class="section__text">
                Greek House wants to create the largest greek network in the country.<br><br>
                The more members that join the Greek House network, the better the designs get, the smarter our technology gets, the lower prices we can provide, and, most importantly, the more money
                we can raise for philanthropies.
            </div>
        </div>

        <div class="about__join">
            <h2>Join Us On Our Journey</h2>
            <div class="section__text text-center">
                We’ll send you all the cool ways you can get you and your chapter involved
            </div>

            <!--[if lte IE 8]>
            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
            <![endif]-->
            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
            <script>
                hbspt.forms.create({
                    css: '',
                    portalId: '2266317',
                    formId: 'dbe15614-eef0-476d-a9be-f9feafb734a2'
                });
            </script>
        </div>
    </div>
@endsection