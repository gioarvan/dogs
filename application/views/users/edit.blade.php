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
                {{ Form::open('users/edit','POST') }}
                @if($errors)
                {{ Helper::errors($errors)}}
                @endif
                @if(Session::has('error_edit'))
                <div class="alert alert-error"> <a class="close" data-dismiss="alert" href="#">×</a>Παρουσιάστηκε πρόβλημα κατά την δημιουργία του λογαριασμού. Παρακαλώ δοκιμάστε ξανά.</div>
                @endif
                @if(Session::has('success_edit'))
                <div class="alert alert-success"> <a class="close" data-dismiss="alert" href="#">×</a>Τα στοιχεία σας αποθηκεύτηκαν με επιτυχία.</div>
                @endif
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="first_name">Όνομα</label>
                            <div class="controls">
                                {{ Form::text('first_name',$user->first_name,array('class'=>'input-medium','placeholder'=>'')) }}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="last_name">Επίθετο</label>
                            <div class="controls">
                                {{ Form::text('last_name',$user->last_name,array('class'=>'input-medium','placeholder'=>'')) }}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="username">Email&nbsp;<span class="required">*</span></label>
                            <div class="controls">
                                {{ Form::text('username',$user->username,array('class'=>'input-medium','placeholder'=>'')) }}
                                
                            </div>
                        </div>
                       
                        <br style="clear:both"/>
                        <div class="row-fluid">
                            <div class="span2">
                            {{ Form::submit('Αποθήκευση',array('class'=>'btn btn-success btn-medium')) }}  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

