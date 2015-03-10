@extends('frontend.layouts.main')

@section('content')


                             <div class="container">

                                 <div class="row">

                                     <div class="span6">

                                         <h4>We would love to hear from you</h4>
                                         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid consequuntur unde quae totam recusandae laborum saepe eveniet accusamus tempora. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis nisi fugiat dolores quidem non voluptatum laboriosam dolore modi vitae et officials aliquam voluptas ipsa impedit nemo qui autem quaerat quod eius obcaecati consequuntur minus aperiam odit? </p>

                                         <h4>Contact info</h4>

                                         <ul>
                                             <li><i class="icon-briefcase"></i> Cloud Hoster Ltd.</li>
                                             <li><i class="icon-map-marker"></i> 01234 Main Street, New York 45678</li>
                                             <li><i class="icon-phone"></i> Phone: 555-555-5555 Fax: 444-444-4444</li>
                                             <li><i class="icon-envelope-alt"></i> Email: <a href="mailto:info@domain.com">info@domain.com</a></li>
                                         </ul>

                                     </div><!-- span6 end -->

                                     <div class="span6">

                                         <div id="map"></div>

                                     </div><!-- span6 end -->

                                 </div><!-- row end -->

                                 <div class="row">

                                     <div class="span12">

                                         <form method='post' name='ContactForm' id='contactForm'>
                                             <p>Your name:</p>
                                             <input type="text" class="input-box" name="user-name" placeholder="Please enter your name.">
                                             <p>Email address:</p>
                                             <input type="text" class="input-box" name="user-email" placeholder="Please enter your email address.">
                                             <p>Subject:</p>
                                             <input type="text" class="input-box" name="user-subject" placeholder="Purpose of this message.">
                                             <p class="right-message-box">Message:</p>
                                             <textarea class="input-box right-message-box message-box" name="user-message" placeholder="Your message."></textarea>
                                             <button type='submit' class='myinputbtn' name='submitf' id="submitf">Send your message</button>
                                             <div id='message_post'></div>
                                         </form>

                                     </div><!-- span12 end -->

                                 </div><!-- row end -->

                             </div><!-- container end -->



@stop