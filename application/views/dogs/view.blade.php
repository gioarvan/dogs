@layout('layouts.basic')
<?php Section::start('scripts'); ?>
    <script src="{{ URL::base() }}/js/maps.js"></script>
<?php Section::stop(); ?>
@section('navigation')
@parent
@endsection
@section('content')
@if(Session::has('success_add'))
<div class="alert alert-success myfixed"> <a class="close" data-dismiss="alert" href="#">×</a>Η καταχώρηση έγινε με επιτυχία.</div>
@endif
<div class="span12">
    <div class="span6">
        <div class="span12">
            <div class="span6">               
                <div class="img-d">
                    @if(!is_null($img))
                    <img class="img-rounded" src="{{ URL::base() }}/pictures/{{$img}}"/>
                    <!--<img class="img-rounded" src="http://localhost/dogfinder/storage/pictures/{{$img}}"/>-->
                    @else
                    <img class="img-rounded" src="{{ URL::base() }}/img/no_photo.jpg"/> 
                    <!--<img class="img-rounded" src="http://localhost/dogfinder/public/img/no_photo.png"/> -->
                    @endif    
                </div>
            </div>
            <div class="span6">
                <table class="table-fluid table-condensed">
                    <tbody>
                        <tr>
                            <td><strong>Όνομα:</strong></td>
                            <td>
                                @if(!empty($dog->dog_name))
                                {{ $dog->dog_name }}
                                @else
                                Δεν έχει οριστεί
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Κατάσταση:</strong></td>
                            <td>
                                @if(isset($msg_found) && $msg_found == true)
                                <span class="label label-success">Βρέθηκε</span>
                                @else
                                <span class="label label-important">Χάθηκε</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Περιοχή:</strong></td>
                            <td>{{ $dog->area->area }}</td>
                        </tr>
                        <tr>
                            <td><strong>Ημερομηνία:</strong></td>
                            <td>{{ $dog->area->dog_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Ράτσα:</strong></td>
                            <td>
                                @if($dog->breed_id == -2)
                                @if(!empty($dog->breed_description))
                                {{ $dog->breed_description }}
                                @else
                                Δεν έχει οριστεί
                                @endif
                                @endif
                                @if($dog->breed_id > 0)
                                {{ $dog->breed->breed_name }}
                                @endif
                                @if($dog->breed_id == -1)
                                Δεν έχει οριστεί
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td><strong>Φύλο:</strong></td>
                            <td>{{Helper::show_gender($dog->dog_gender) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Μέγεθος:</strong></td>
                            <td>
                                @if(!empty($dog->dog_size))
                                {{Helper::show_size($dog->dog_size) }}
                                @else
                                Δεν έχει οριστεί
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Χρώμα:</strong></td>
                            <td> 
                                @if(!empty($dog->dog_color))
                                {{Helper::show_color($dog->dog_color) }}
                                @else
                                Δεν έχει οριστεί
                                @endif
                            </td>
                        </tr>
                        @if(isset($msg_found) && $msg_found == false)
                        <tr>
                            <td><strong>Αμοιβή:</strong></td>
                            <td>
                                <span class="red">{{$dog->dog_reward}}&euro;
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
                <hr/>
                @if(isset(Auth::user()->id))
                @if($dog->user_id == Auth::user()->id)
                @if($dog->dog_status == 'L')
                <a class="btn btn-info btn-medium" href="{{ URL::to_action('dogs@editlost',array($dog->id))}}">Επεξεργασία</a>
                @else
                <a class="btn btn-info btn-medium" href="{{ URL::to_action('dogs@editfound',array($dog->id))}}">Επεξεργασία</a>
                @endif
                @endif
                @endif
            </div>

            <div class="span12 spacer20">
                <div class="span8">
                    <h3>Επικοινωνία</h3>
                    <div class="btn-circle-panel large">
                        <ul class="btn-circle">
                            <li class="warning">
                                @if(isset($msg_finder) && $msg_finder == true)
                                <a class="tip-bottom" title="Επικοινωνήστε με το άτομο που βρήκε τον σκύλο." href="#" data-original-title="">
                                    <i class="micon-mail"></i>
                                </a>
                                @else
                                <a class="tip-bottom" title="Επικοινωνήστε με τον ιδιοκτήτη." href="#" data-original-title="">
                                    <i class="micon-mail"></i>
                                </a>
                                @endif
                            </li>
                            <li class="default">
                                <a class="tip-bottom" title="Αναρτήστε το στο facebook." href="#" data-original-title="">
                                    <i class="micon-facebook-2"></i>
                                </a>
                            </li>
                            <li class="primary">
                                <a class="tip-bottom" title="Αναρτήστε το στο twitter." href="#" data-original-title="">
                                    <i class="micon-twitter-2"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- gmap -->
    <div class="span6">
        <p class="formatted-addr">{{ $dog->area->area }}</p>
        <div id="map_canvas"></div>
        <span class="postal" style="display:none">{{ $dog->area->dog_postal}}</span>
    </div>
</div>
@endsection
