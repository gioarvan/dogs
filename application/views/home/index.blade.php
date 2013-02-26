@layout('layouts.home')
@section('navigation')
@parent
@endsection

@section('content')
<div class="row-fluid">
    <div class="span12">
        <div class="hero-unit">
            <div class="c-alert">
                <div class="alert-message primary">
                    <h1>Title</h1>
                    <p>είναι απλά ένα κείμενο χωρίς νόημα για τους επαγγελματίες της τυπογραφίας και στοιχειοθεσίας. </p>
                    <p> Το Lorem Ipsum είναι το επαγγελματικό πρότυπο όσον αφορά το κείμενο χωρίς νόημα, από τον 15ο αιώνα, όταν ένας ανώνυμος τυπογράφος πήρε ένα δοκίμιο και ανακάτεψε τις λέξεις για να δημιουργήσει ένα δείγμα βιβλίου.
                        Το Lorem Ipsum είναι το επαγγελματικό πρότυπο όσον αφορά το κείμενο χωρίς νόημα, από τον 15ο αιώνα, όταν ένας ανώνυμος τυπογράφος πήρε ένα δοκίμιο και ανακάτεψε τις λέξεις για να δημιουργήσει ένα δείγμα βιβλίου.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<hr/>
<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Τελευταίες καταχωρήσεις</h3>
            <div class="row-fluid">
                <div class="span12">
                    @if(!empty($latest))
                    @foreach($latest as $lts)
                    @if(!empty($lts['dog_name']))
                    <?php $dog_name = $lts['dog_name'] ?>
                    @else
                    <?php $dog_name = $lts['dog_code'] ?>
                    @endif 
                    <div class="span4">
                        <div class="well widget">
                            <div class="widget-header">
                                <p class="meta uppercase large">
                                    @if($lts['status'] == 'F')
                                    <span class="label label-success"><strong>Βρεθηκε</strong></span>
                                    @else
                                    <span class="label label-important"><strong>Χαθηκε</strong></span>
                                    @endif
                                    <span class="tags lower" style="float:right !important;margin-right:5px;cursor: pointer;">                                        
                                        <span class="tip" data-placement="bottom" title="προβολές του {{$dog_name}}.">  
                                            <i class="icon-comments"></i>
                                            {{$lts['dog_views']}} </a> 
                                        </span>
                                    </span>
                                    <span class="date" style="margin-right:100px;">
                                        {{ date("d-m-Y",strtotime($lts['dog_date'])) }}
                                    </span>
                                </p>
                            </div>
                            <div class="widget-content">
                                <div class="span12">
                                    <div class="span6">
                                        <a href="{{ URL::to_action('dogs@view',array($lts['dog_id']))}}">                                
                                            {{$dog_name}}                                 
                                        </a> 
                                        @if(!empty($lts['img']))
                                        <!--<a class="thumbnail" href="#demoLightbox" data-toggle="lightbox">-->
                                        <img style="width:150px;height:150px" class="img-featured" src="{{ URL::base() }}/pictures/{{$lts['img']}}" alt=""/>
                                        <!--</a>-->
                                        @else
                                        <img style="width:150px;height:150px" class="img-featured" src="{{ URL::base() }}/img/no_photo.jpg" alt=""/>
                                        @endif
                                    </div>
                                    <div class="span6">
                                        <table class="table-fluid table-condensed">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Ράτσα:</strong></td>
                                                    <td>
                                                        @if($lts['breed_id'] == -2)
                                                        @if(!empty($lts['breed_descr']))
                                                            {{ $lts['breed_descr'] }}
                                                        @else
                                                        <strong>Δεν έχει οριστεί</strong>
                                                        @endif
                                                        @endif
                                                        @if($lts['breed_id'] > 0)
                                                        {{ $lts['breed_name'] }}
                                                        @endif
                                                        @if($lts['breed_id'] == -1)
                                                        <strong>Δεν έχει οριστεί</strong>
                                                        @endif

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Φύλο:</strong></td>
                                                    <td>{{Helper::show_gender($lts['dog_gender']) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <hr/>

                                <br/>
                                {{ $lts['dog_area'] }}&nbsp;<i class="micon-help-2 tip" title="Η περιοχή που χάθηκε ο σκύλος." ></i>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @else
                    <div class="alert alert-success">Δεν βρέθηκαν καταχωρήσεις.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

