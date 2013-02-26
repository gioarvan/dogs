@layout('layouts.basic')
@section('navigation')
@parent
@endsection
@section('content')
<div class="row-fluid">
    <div class="span8">
        <div class="well widget">
            <div class="widget-header">
                <p><small>Επεξεργαστείτε τα στοιχεία του σκύλου που καταχωρήσατε.</small></p>
            </div>
            <div id="frm-addlost">
                {{ Form::open_for_files('dogs/editfound','POST',array('id'=>'editfound','enctype'=>'multipart/form-data')) }}
                @if(Session::has('not_auth'))
                <div class="alert alert-error"> <a class="close" data-dismiss="alert" href="#">×</a>Δεν έχετε κάνει σύνδεση. Παρακαλώ&nbsp;<a class="s-acc" rel="tooltip" title="χρησιμοποιήστε τα στοιχεία σας για να συνδεθείτε." href="#signin" data-toggle="modal">συνδεθείτε</a>.</div>
                @endif
                @if($errors)
                {{ Helper::errors($errors)}}
                @endif
                <div class="alert alert-error alert-postal hide"> <a class="close" data-dismiss="alert" href="#">×</a>Παρακαλώ συμπληρώστε τον Τ.Κ της περιοχής που χάθηκε.</div>
                @if(Session::has('success_editfound'))
                <div class="alert alert-success"> <a class="close" data-dismiss="alert" href="#">×</a>Η επεξεργασία έγινε με επιτυχία.</div>
                @endif
                <div class="row-fluid">
                    <div class="span4">
                        <div class="control-group">
                            <label class="control-label" for="dog_name">Όνομα</label>
                            <div class="controls">
                                {{ Form::text('dog_name',$dog->dog_name,array('class'=>'input-medium tip','placeholder'=>'','rel'=>'tooltip','title'=>'Εαν έχει TAG NAME συμπληρώστε το όνομα του. Αλλιώς αφήστε το κενό.')) }}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="dog_date">Πότε χάθηκε&nbsp;<span class="required">*</span></label>
                            <div class="controls">
                                <div rel="tooltip" title="Επιλέξτε την ημερομηνία." class="input-append date tip" id="dog_date" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
                                    <input name="dog_date" id="dog_date" class="span6" size="16" type="text" value="{{ $dog->area->dog_date}}">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                       
                        <div class="control-group">
                            <label class="control-label" for="dog_gender">Φύλο&nbsp;<span class="required">*</span></label>
                            <div class="controls">
                                {{ Form::select('dog_gender',array(-1 => 'Επιλέξτε φύλο','F' => 'Θηλυκό', 'M' => 'Αρσενικό'),$dog->dog_gender,array('class'=>'input-medium tip','rel'=>'tooltip','title'=>'Επιλέξτε το φύλο του.')) }}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="dog_color">Χρώμα</label>
                            <div class="controls">
                                {{ Form::select('dog_color',array(-1 => 'Επιλέξτε χρώμα','B' => 'Μαύρο', 'BR' => 'Καφέ', 'G' => 'Γκρί', 'W' => 'Άσπρο'),$dog->dog_color,array('class'=>'input-medium tip','rel'=>'tooltip','title'=>'Επιλέξτε το χρώμα του.')) }}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label tip" for="breed_id">Ράτσα</label>
                            <div class="controls">
                                {{ Form::select('breed_id',$breeds,$dog->breed_id,array('id'=>'breed_id','class'=>'input-medium tip','rel'=>'tooltip','title'=>'Επιλέξτε την ράτσα του, στην περίπτωση που δεν γνωρίζετε τι ράτσα είναι, επιλέξτε Αλλο και εισάγετε μια περιγραφή του.')) }}
                                <br/>
                                <textarea name="o-breed" id="o-breed" rows="4" cols="50" placeholder="σε περίπτωση που δεν ανήκει σε κάποια από τις ράτσες, δώσε περιγραφή του σκύλου." style="display:none"></textarea>   
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label tip" for="dog_size">Μέγεθος</label>
                            <div class="controls">
                                {{ Form::select('dog_size',array(-1 => 'Επιλέξτε μέγεθος','T' => 'Toy - πολύ μικρού μεγέθους', 'S' => 'Small - μικρού μεγέθους', 'M' => 'Medium - μεσαίου μεγέθους', 'L' => 'Large - μεγάλου μεγέθους'),$dog->dog_size,array('class'=>'input-medium tip','rel'=>'tooltip','title'=>'Επιλέξτε το μέγεθος του.')) }}
                            </div>
                        </div>
                       
                        <br style="clear:both"/>
                        <input type="hidden" name="dog_id" value="{{ $dog->id }}"/>
                        <input type="hidden" name="status"/>
                        <input type="hidden" name="dog_status" value="{{ $dog->dog_status }}"/>
                        <input type="hidden" name="lat"/>
                        <input type="hidden" name="long"/>
                        <input type="hidden" name="area"/>

                    </div>
                    <div class="span4">
                        
                            <div class="control-group">
                                <label for="dog_postal" class="control-label">Ταχ.κωδικός</label>
                                <div class="controls">
                                    {{ Form::text('dog_postal',$dog->area->dog_postal,array('class'=>'input-medium tip','placeholder'=>'','title'=>'Eισάγετε τον ταχυδρομικό κωδικό της περιοχής που χάσατε τον σκύλο.&nbsp;Για να δείτε τον χάρτη πατήστε προβολή.')) }}<br/><a href="#" class="s-map">προβολή χάρτη</a>
                                </div>
                            </div>

                        <br style="clear:both"/>
                        <div class="span4">
                            <p class="formatted-addr"></p>
                            <div id="map_canvas"></div>
                        </div>

                    </div>
                    <div class="span4">
                         @if(isset($img))
                            
                                <img src="{{ URL::base() }}/pictures/{{$img}}" alt="" style="width:200px;height:200px"/>
                            
                            @endif
                    </div>
                    <br style="clear:both"/>
                    <div class="row-fluid">
                        <div class="span2">
                            {{ Form::submit('Καταχώρηση',array('class'=>'btn btn-success btn-medium')) }}  
                        </div>
                        <!--<div class="span1 offset1">
                            <input type="button" value="Καθαρισμός" class="btn btn-success btn-medium frm-clear"/> 
                        </div>-->

                    </div>

                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="span4">
        @if(Auth::guest())
        <div class="alert alert-danger">
            <p>
                Για να ολοκληρώσετε την καταχώρηση σας θα χρειαστεί να δημιουργήσετε έναν λογαριασμό. Στην περίπτωση που έχετε ήδη λογαριασμό πατήστε <b>σύνδεση.</b>
                <br/><br/><a class="btn btn-primary btn-small s-acc" rel="tooltip" title="χρησιμοποιήστε τα στοιχεία σας για να συνδεθείτε." href="#signin" data-toggle="modal">Σύνδεση</a>
                &nbsp;<a class="btn btn-primary btn-small r-acc" href="{{ URL::to_action('users@register')}}">Εγγραφή</a>
            </p>    
        </div>
        @endif
        <div class="info">            
            <p><i class="micon-help-2"></i>&nbsp;Το Lorem Ipsum είναι το επαγγελματικό πρότυπο όσον αφορά το κείμενο χωρίς νόημα, από τον 15ο αιώνα.Το Lorem Ipsum είναι το επαγγελματικό πρότυπο όσον αφορά το κείμενο χωρίς νόημα, από τον 15ο αιώνα.</p>
        </div>
        <div class="button-action">

            <a data-toggle="modal" class="btn btn-large btn-danger" href="#postals">
                <span><i class="icon-large icon-picture"></i></span> Τ.Κ Περιοχών <span class="right"><i class="icon-large icon-ok"></i></span>
            </a>

            <a class="btn btn-large btn-primary" href="#">
                <span><i class="icon-large icon-sitemap"></i></span> Βοήθεια για τις ράτσες <span class="right"><i class="icon-large icon-info-sign"></i></span>
            </a>

        </div>
    </div>

</div>

@endsection


