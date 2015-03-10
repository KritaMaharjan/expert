@extends('frontend.layouts.main')

@section('content')


    <section id="content">
       
        <div class="white-section contact">
            
            <div class="container">

                <div class="row">

                    <div class="span6 show-at-center text-center">
                        
                        <h4>Retrieve you app url</h4>
                        @include('flash::message')
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid consequuntur unde quae totam recusandae laborum saepe eveniet accusamus tempora. Lorem ipsum.</p>

                    </div><!-- span6 end -->
                    
                   

                </div><!-- row end -->

                <div class="row">

                    <div class="span6 show-at-center">

                        <form method='post' name='' id='retrieve-section' method="POST" action="">
                        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p>Email address:</p>
                            <input type="email" class="input-box" name="email" placeholder="Please enter your email address.">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-padding">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach 
                                    </ul>
                                </div>
                            @endif
                            
                            <button type='submit' class='myinputbtn' name='submitf' id="submitf">Send</button>
                            <div id='message_post'></div>
                        </form>

                    </div><!-- span12 end -->
                
                </div><!-- row end -->

            </div><!-- container end -->

        </div><!-- white-section end -->

    </section><!-- content end -->

@stop
