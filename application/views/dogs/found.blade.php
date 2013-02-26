@layout('layouts.basic')

@section('navigation')
@parent
@endsection

@section('content')
<div class="span12">
    <div class="span10">
        <p>Το Lorem Ipsum είναι απλά ένα κείμενο χωρίς νόημα για τους επαγγελματίες της τυπογραφίας και στοιχειοθεσίας. </p>
    </div>
    <div class="span2">
        <div class="button-action">
            <a class="btn btn-flat btn-success btn-medium" href="{{ URL::to_action('dogs@addfound') }} ">Προσθήκη</a>
        </div>
    </div>
    <hr/>   
</div>
<div class="row-fluid">
    <div class="span12">
        @if($total == 0)
        <div class="well widget">

            <div class="alert alert-success">Δεν βρέθηκαν καταχωρήσεις.</div>
        </div>
        @else
        <div class="span10">
            <table class="table table-hover" cellspacing="0" cellpadding="0">
                <thead>
                <th>Όνομα</th>
                <th>Ράτσα</th>
                <th>Γένος</th>
                <th>Χρώμα</th>
                <th>Tαχ.Κωδικός</th>
                <th>Προστέθηκε</th>
                 <th>Το έχουν δει</th>
                </thead>
                <tbody>
                    @foreach($dogs->results as $dog)
                    <tr>
                        <td>
                            @if(!empty($dog->dog_name))
                            {{ $dog->dog_name }}
                            @else
                            <strong>Δεν έχει οριστεί</strong>
                            @endif
                        </td>
                        <td>
                            @if(isset($dog->breed->breed_name))
                            {{ $dog->breed->breed_name }}
                            @else
                            <b>Δεν έχει οριστεί</b>
                            @if($dog->breed_description)
                            <i class="icon-info-sign tip" title="{{$dog->breed_description}}"></i>
                            @endif
                            @endif
                        </td>
                        <td>@if($dog->dog_gender == 'M')    Αρσενικό    @else   Θηλυκό  @endif</td>
                        <td>
                            @if(!empty($dog->dog_color))
                            {{ Helper::show_color($dog->dog_color)}}
                            @else
                            <b>Δεν έχει οριστεί</b>
                            @endif
                        </td>
                        <td>
                            <a href="#gmap" class="gmap" data-toggle="modal" class="tip" rel="tooltip" title="εμφάνιση χάρτη">{{ $dog->area->dog_postal }}</a>
                        </td>

                        <td>
                            <small><span class="label label-warning">{{ date('Y-m-d', strtotime($dog->created_at)) }}</label></small>
                        </td>
                         <td class="text-center">
                            {{$dog->dog_views}}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Ενέργειες
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ URL::to_action('dogs@view',array($dog->id)) }}">Προβολή</a></li>
                                    @if(isset(Auth::user()->id))
                                    @if($dog->user_id == Auth::user()->id)
                                    <li><a href="{{ URL::to_action('dogs@editfound',array($dog->id)) }}">Επεξεργασία</a></li>
                                    <li><a href="{{ URL::to_action('dogs@delete',array($dog->id,'lost')) }}">Διαγραφή</a></li>
                                    @endif
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br style="clear:both"/>
            {{ $dogs->links() }}

        </div>
        <div class="span2">
            <div class="well widget box-shadow">
                <div class="widget-header">
                    <h3 class="title">Αναζήτηση</h3>   
                </div>
                <div class="searchbox-inner">
                    {{ Form::open('search/search','POST') }}

                    <div class="control-group">
                        <label class="control-label" for="breed_id">Ράτσα</label>  

                        <div class="controls">
                            {{ Form::select('breed_id',$breeds,Input::old('breed_id'),array('id'=>'breed_id','class'=>'input-medium')) }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="dog_gender">Φύλο</label>
                        <div class="controls">
                            {{ Form::select('dog_gender', array(-1 => 'Επιλέξτε φύλο','F' => 'Θηλυκό', 'M' => 'Αρσενικό'),Input::old('dog_gender'),array('class'=>'input-medium')) }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="dog_color">Χρώμα</label>
                        <div class="controls">
                            {{ Form::select('dog_color', array(-1 => 'Επιλέξτε χρώμα','B' => 'Μαύρο', 'BR' => 'Καφέ', 'G' => 'Γκρί', 'W' => 'Άσπρο'),Input::old('dog_color'),array('class'=>'input-medium')) }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="dog_size">Μέγεθος</label>
                        <div class="controls">
                            {{ Form::select('dog_size', array(-1 => 'Επιλέξτε μέγεθος','T' => 'Toy - πολύ μικρού μεγέθους', 'S' => 'Small - μικρού μεγέθους', 'M' => 'Medium - μεσαίου μεγέθους', 'L' => 'Large - μεγάλου μεγέθους'),Input::old('dog_size'),array('class'=>'input-medium')) }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="dog_postal">Τ.Κ περιοχής</label>
                        <div class="controls">
                            {{ Form::text('dog_postal',Input::old('dog_postal'),array('class'=>'input-small')) }}
                        </div>
                    </div>
                    <input type="hidden" name="page" value="F"/>

                    <div class="control-group">
                        {{ Form::submit('αναζήτηση',array('class'=>'btn btn-success btn-medium')) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection