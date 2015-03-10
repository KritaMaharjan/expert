<div class="main-page-wrapper">

            <div class="top-background">

                <div class="top-menu-wrapper">

                    <nav class="top-menu container">

                        <ul>
                            <li><a><i class="icon-phone"></i><strong> Phone support:</strong> 1-234-567-890</a></li>
                            <!-- <li><a href="#"><i class="icon-comment"></i><strong> Live chat</strong> support</a></li> -->
                            <!-- <li><a href="#"><i class="icon-envelope-alt"></i><strong> Submit</strong> a ticket</a></li> -->
                            <li><a href="#" id="mobile-nav-button"><i class="icon-list-ul"></i><strong> Show/Hide</strong> a menu</a></li>
                            <!-- <li><a href="#customer-login" data-toggle="modal"><i class="icon-user"></i><strong> Customer</strong> login</a></li> -->
                            <li><a href="{{url('login')}}" data-toggle="modal"><i class="icon-user"></i><strong> Customer</strong> login</a></li>
                        </ul>

                    </nav> <!-- end top-menu -->

                </div> <!-- end top-menu-wrapper -->

                <div class="mobile-nav off"></div><!-- mobile-nav end -->

                <header class="container">
                    
                    <div class="row">

                        <div class="span4">
                            <h1 class="logo clearfix">
                                <a href="{{ url('/')}}" title="FastBooks">FastBooks
                                    <span class="slogan">All your business in one space</span>
                                </a>                                
                            </h1>
                        </div> <!-- end span4 -->
                    
                        <div class="span8">
                            
                            <nav class="main-menu">
                                <ul>
                                    <li><a href="{{url('/')}}" data-description="welcome" class="current-menu-item">Home</a></li>
                                    <li><a href="{{url('features')}}" data-description="we offer">Features</a>
                                        <ul>
                                            <li><a href="{{url('features')}}#1">Online Invoice</a></li>
                                            <li><a href="{{url('features')}}#2">Accounting Automation</a></li>
                                            <li><a href="{{url('features')}}#3">Dispute Handling</a></li>
                                            <li><a href="{{url('features')}}#4">Inventory Management</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{url('about')}}" data-description="our company">About</a></li>
                                    <li><a href="{{url('contact')}}" data-description="and quotes">Contact</a></li>
                                </ul>
                            </nav> <!-- end main-menu -->

                        </div> <!-- end span8 -->

                    </div> <!-- end row -->

                    <hr />

                    <div id="slider-container" class="clearfix">

                        <div class="sequence-theme">
                            <div id="sequence">

                                <img class="sequence-prev" src="img/bt-prev.png" alt="Previous Frame" />
                                <img class="sequence-next" src="img/bt-next.png" alt="Next Frame" />

                                <ul class="sequence-canvas">
                                    <li class="animate-in">
                                        <h2 class="title">User friendly</h2>
                                        <h3 class="subtitle"><strong>FastBooks</strong> Makes your accounting tasks easy, fast, and secure. Start sending invoices and capturing expenses in minutes.</h3>
                                        {{ Session::get('message') or ''}}

                                        <ul class="slider-info custom-content">
                                            <li>
                                                {!! Form::open(array('route' => 'register', 'method'=>'POST', 'id' => 'register')) !!}

                                                        <div class="form-group two-inputs">
                                                        {!!Form::text('company','',array('placeholder' => 'Company Name', 'id' => 'company'))!!}
                                                        <span class='company-error' style="color:red"></span>                                                        
                                                        <p><span>Your domain : <span class="domain-suggestion">name</span>.fastbooks.com</span></p>
                                                        {!!Form::email('email','',array('placeholder' => 'Email', 'id' => 'email'))!!} 
                                                        <span class='email-error' style="color:red"></span>                                                         
                                                        </div>
                                                    @if (count($errors) > 0)
                                                        <div class="alert alert-danger alert-padding">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach 
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="slider-cta custom-btn-block">
                                                        {!! Form::button('<strong>Sign up »</strong>', array('class'=>'button no-border', 'id'=>'submit-btn', 'type'=>'submit')) !!}
                                                    </div>

                                            {!! Form::close() !!}
                                            </li>
                                        </ul>


                                       
                                        <img class="slider-image" src="img/page-images/slider-image1.png" alt="Server">
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div> <!-- slider-container end -->
               
                </header> <!-- end container -->

            </div><!-- top-background end -->