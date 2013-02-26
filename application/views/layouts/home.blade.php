<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="Dog Hound! - δωρεάν εφαρμογή για τους αγαπημένους μας φίλους!"/>
        <meta property="og:image" content=""/>
        <title>{{ $title }}</title>
        <meta name="viewport" content="width=device-width"/>
        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/bootstrap-responsive.css') }}
        {{ HTML::style('css/jquery-ui-1.9.2.custom.css') }}
        {{ HTML::style('css/theme/styles.css') }}
        {{ HTML::style('css/custom.css') }}
        {{ HTML::script('js/jquery-1.8.3.js') }}
        {{ HTML::script('js/jquery-ui-1.9.2.custom.js') }}
        {{ HTML::script('js/bootstrap.js') }}
        {{ HTML::script('js/bootstrap-lightbox.js') }}
        {{ HTML::script('js/validation.js') }}
        {{ HTML::script('js/modals.js') }}
        {{ HTML::script('js/common.js') }}
        {{ HTML::script('js/ajax.js') }}
        {{ HTML::script('js/jquery.qtip-1.0.0-rc3.min.js') }}  
    </head>
    <body>
        <!-- header -->
        <div id="header" class="navbar">
            <div class="messages"></div>
            <div class="navbar-inner">
                <a class="brand hidden-phone" href="{{ URL::base() }}">DogFinder!</a>
                <ul class="nav">
                    <li class="visible-phone">
                        <a href="#"><i class="icon-large icon-search"></i></a>
                        <a href="#"><i class="icon-large icon-globe"></i></a>
                        <a href="#"><i class="icon-large icon-envelope"></i></a>
                        <a href="#"><i class="icon-large icon-cog"></i></a>
                    </li>
                </ul>
                <ul class="nav pull-right">
                    @section('profile')
                    @if(Auth::guest())
                    <li><a class="s-acc" rel="tooltip" title="χρησιμοποιήστε τα στοιχεία σας για να συνδεθείτε." href="#signin" data-toggle="modal">Σύνδεση</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-large icon-user"></i></a>
                        <ul class="dropdown-menu dropdown-user-account">
                            <li class="account-img-container">
                                <img class="thumb account-img" src="{{ URL::base() }}/img/default_profile.png" />
                            </li>
                            <li class="account-info">
                                <h3>Ο Λογαριασμός σας</h3>

                                <p>
                                    <a href="{{ URL::to_action('users@edit',array(Auth::user()->id)) }}">Επεξεργασία</a>
                                </p>
                            </li>

                            <li class="account-footer">
                                <div class="row-fluid">

                                    <div class="span4 align-right">
                                        <a class="btn btn-small btn-danger btn-flat" href="{{ URL::to_action('users@signout') }}">Αποσύνδεση</a>
                                    </div>

                                </div>									
                            </li>

                        </ul>
                    </li>
                    @endif
                    @yield_section
                </ul>
            </div>
        </div>
        <!-- /header -->
        <div id="left_layout">
            <!-- main content -->
            <div id="main_content" class="container-fluid">

                <!-- page heading -->
                <div class="page-heading">
                    <h2 class="page-title muted">
                        <i class="icon-home"></i> Αρχική
                    </h2>
                    @if(Session::has('error_signin'))
                    <div class="alert alert-error span4">Παρουσιάστηκε πρόβλημα κατά την σύνδεση σας.</div>
                    @endif
                    @if(Session::has('error_not_exists'))
                    <div class="alert alert-error span4"><b>Πρόβλημα!</b>O χρήστης δεν βρέθηκε στο σύστημα.</div>
                    @endif
                    <div class="page-info hidden-phone">
                        <ul class="stats">
                            <li>
                                <span class="large text-error">{{ $stats['lost'] }}</span>
                                <span class="mini muted">έχουν χαθεί</span>
                            </li>
                            <li>
                                <span class="large text-success">{{ $stats['found'] }}</span>
                                <span class="mini muted">έχουν βρεθεί</span>
                            </li>
                            <li>
                                <span class="large text-info">{{ $stats['users'] }}</span>
                                <span class="mini muted">εγγεγραμμένοι χρήστες</span>
                            </li>

                        </ul>
                    </div>

                </div>
                <!-- ./ page heading -->

                <!-- post wrapper -->				
                <div class="row-fluid">
                    @yield('content')
                </div>
            </div>
            <!-- /main -->

            <!-- sidebar -->
            <ul id="sidebar" class="nav nav-pills nav-stacked">
                <!--<li class="avatar hidden-phone">
                    <a href="#"></a>
                </li>-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="micon-plus"></i>
                        <span class="hidden-phone">Προσθήκη</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ URL::to_action('dogs@addlost') }}">
                                <i class="micon-arrow-left-6"></i> Έχασα τον σκύλο μου
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to_action('dogs@addfound') }}">
                                <i class="micon-arrow-right-6"></i> Βρήκα έναν σκύλο
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="tip-right" rel="tooltip" title="Δείτε τα σκυλάκια που χάθηκαν." href="{{ URL::to_action('dogs@lost') }}">
                        <i class="micon-location"></i>
                        <span class="hidden-phone">Χάθηκαν</span>
                    </a>
                </li>
                <li>
                    <a class="tip-right" rel="tooltip" title="Δείτε τα σκυλάκια που βρέθηκαν." href="{{ URL::to_action('dogs@found') }}">
                        <i class="micon-checkbox"></i>
                        <span class="hidden-phone">Βρέθηκαν</span>
                    </a>
                </li>

            </ul>
            <!-- /sidebar -->
        </div>


        <!------------- END THEME ------------------------------>





        <div id="footer">
            <div class="container">
                <ul>
                    <li><a href="#privacy" data-toggle="modal">Πολιτική Προστασίας</a></li>
                    <li><a href="#terms" data-toggle="modal">Όροι Χρήσης</a></li>
                    <li><a href="#contact" data-toggle="modal">Επικοινωνία</a></li>
                    <li><a href="http://designtunes.gr" target="_blank">designtunes.gr</a></li>
                </ul> 
            </div>
        </div>
        <!-- end content -->

        <!-- Modals -->
        <div id="signin" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="signinLabel" aria-hidden="true">
            <div class="modal-header">
                <button  type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="signinLabel">Σύνδεση χρήστη</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error msg-alert" style="display:none"> 
                    <!--<a class="close" data-dismiss="alert" href="#">×</a>-->
                    <span></span>
                </div>
                {{ Form::open('signin','POST') }}
                <label for="username_login">Email&nbsp;<span class="required">*</span></label>
                {{ Form::text('username_login','',array('placeholder'=>'το email σας')) }}
                <label for="password_login">Κωδικός&nbsp;<span class="required">*</span></label>
                {{ Form::password('password_login',array(),'') }}
                <br style="clear:both"/>
                {{ Form::submit('Σύνδεση',array('id'=>'btn-signin','class'=>'btn btn-success','placeholder'=>'ο κωδικός σας')) }}
                {{ Form::close() }}

                <hr/>
                <p>Δημιουργήστε έναν λογαριασμό. ΔΩΡΕΑΝ!&nbsp;
                    <a class="r-acc" href="{{ URL::to_action('users@register')}}">Εγγραφή</a>
                </p>   
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
            </div>
        </div>

        <div id="contact" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
            <div class="modal-header">
                <button  type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="contactLabel">Επικοινωνία</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error msg-alert modal_result_failure hide" style="display:none"> 
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <span></span>
                </div>
                <div class="alert alert-success msg-alert modal_result_success hide"> 
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <span></span>
                </div>
                {{ Form::open('','POST',array('class'=>'frm-contact')) }}
                <label for="modal_first_name">Όνομα</label>
                {{ Form::text('modal_first_name','',array('class'=>'input-medium','placeholder'=>'το όνομα σας')) }}
                <label for="modal_last_name">Επίθετο</label>
                {{ Form::text('modal_last_name','',array('class'=>'input-medium','placeholder'=>'το επίθετο σας')) }}
                <label for="modal_email">Email&nbsp;<span class="required">*</span></label>
                {{ Form::text('modal_email','',array('class'=>'input-medium','placeholder'=>'το email σας')) }}
                <label for="modal_message">Το μήνυμα σας&nbsp;<span class="required">*</span></label>
                {{ Form::textarea('modal_message','',array('class'=>'span4 h70','placeholder'=>'το μήνυμα σας')) }}
                <br style="clear:both"/>
                {{ Form::submit('Aποστολή',array('id'=>'btn-contact','class'=>'btn btn-success')) }}
                {{ Form::close() }}

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
            </div>
        </div>

        <div id="privacy" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="privacyLabel" aria-hidden="true">
            <div class="modal-header">
                <button  type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="privacyLabel">Πολιτική Προστασίας Προσωπικών Δεδομένων</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error msg-alert" style="display:none"> 
                    <!--<a class="close" data-dismiss="alert" href="#">×</a>-->
                    <span></span>
                </div>
                <p>Το Lorem Ipsum είναι απλά ένα κείμενο χωρίς νόημα για τους επαγγελματίες της τυπογραφίας και στοιχειοθεσίας. 
                    Το Lorem Ipsum είναι το επαγγελματικό πρότυπο όσον αφορά το κείμενο χωρίς νόημα, από τον 15ο αιώνα.</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
            </div>
        </div>

        <div id="terms" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
            <div class="modal-header">
                <button  type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="termsLabel">Όροι Χρήσης</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-error msg-alert" style="display:none"> 
                    <!--<a class="close" data-dismiss="alert" href="#">×</a>-->
                    <span></span>
                </div>
                <p>Το Lorem Ipsum είναι απλά ένα κείμενο χωρίς νόημα για τους επαγγελματίες της τυπογραφίας και στοιχειοθεσίας. 
                    Το Lorem Ipsum είναι το επαγγελματικό πρότυπο όσον αφορά το κείμενο χωρίς νόημα, από τον 15ο αιώνα.</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
            </div>
        </div>

        <!-- lightbox -->
        <!--<div id="demoLightbox" class="lightbox hide fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class='lightbox-header'>
                <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
            </div>
            <div class='lightbox-content'>
                <img src="{{ URL::base() }}/pictures/{{$lts['img']}}">
                <div class="lightbox-caption"><p>Your caption here</p></div>
            </div>
        </div>-->

        <!-- /modals -->
        <script type="text/javascript">
            var BASE = "<?php echo URL::base() . '/index.php/'; ?>";
        </script>
        <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyDKDkB_2KF3fCoveNT5fBMY7OoIGYMP6Cw&sensor=false" type="text/javascript"></script>
    </body>
</html>

