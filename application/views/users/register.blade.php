@layout('layouts.basic')

@section('navigation')
@parent
@endsection

@section('content')
<div class="row-fluid">
    <div class="span8">
        <div class="well widget">
            <div class="widget-header">
                <p><small>Εγγραφή νέου χρήστη.Τα στοιχεία 
                        σας είναι απαραίτητα για την επικοινωνία με άλλα άτομα.</small></p>
            </div>
            <div id="frm-registeracc">
                {{ Form::open('users/register','POST') }}
                @if($errors)
                {{ Helper::errors($errors)}}
                @endif
                @if(Session::has('error_register'))
                <div class="alert alert-error"> <a class="close" data-dismiss="alert" href="#">×</a>Παρουσιάστηκε πρόβλημα κατά την δημιουργία του λογαριασμού. Παρακαλώ δοκιμάστε ξανά.</div>
                @endif
                @if(Session::has('error_password_confirm'))
                <div class="alert alert-error"> <a class="close" data-dismiss="alert" href="#">×</a>Oι κωδικοι δεν ταιριάζουν. Παρακαλώ δοκιμάστε ξανά.</div>
                @endif
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="first_name">Όνομα</label>
                            <div class="controls">
                                {{ Form::text('first_name',Input::old('first_name'),array('class'=>'input-medium','placeholder'=>'το όνομα σας')) }}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="last_name">Επίθετο</label>
                            <div class="controls">
                                {{ Form::text('last_name',Input::old('last_name'),array('class'=>'input-medium','placeholder'=>'το επίθετο σας')) }}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="username">Email&nbsp;<span class="required">*</span></label>
                            <div class="controls">
                                {{ Form::text('username',Input::old('username'),array('class'=>'input-medium','placeholder'=>'το email σας')) }}
                                <span class="help-block">το email σας δεν θα δημοσιευτεί.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="password">Κωδικός&nbsp;<span class="required">*</span></label>
                            <div class="controls">
                                {{ Form::text('password','',array('class'=>'input-medium','placeholder'=>'ο κωδικός σας')) }}   
                                <span class="help-block">είσαγετε τον κωδικός που θέλετε να έχετε.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="password_confirmation">Επαλήθευση κωδικού&nbsp;<span class="required">*</span></label>
                            <div class="controls">
                                {{ Form::text('password_confirmation','',array('class'=>'input-medium','placeholder'=>'επαλήθευση κωδικού')) }}  
                                <span class="help-block">είσαγετε ξανά τον κωδικός σας για επαλήθευση.</span>
                            </div>
                        </div>
                        <br style="clear:both"/>
                        <div class="row-fluid">
                            <div class="span2">
                            {{ Form::submit('Εγγραφή',array('class'=>'btn btn-success btn-medium')) }}  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

