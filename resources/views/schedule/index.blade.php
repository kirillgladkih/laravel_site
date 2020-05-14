@extends('app')

@section('title')График@endsection

@section('extend-menu')
    @include('layouts.menu.extend')
@endsection


@section('content')
    <h3 class="text-center title mt-4">Дети 4-6 лет</h3>
    @foreach ($days as $item)
        <h3 class="text-center mt-4 mb-4">
            <button class="btn btn-outline-success col-6" type="button" data-toggle="collapse" data-target="#day-{{$item->id}}" aria-expanded="false"
                aria-controls="day-{{$item->id}}">
            {{$item->day}} <i class="fas fa-caret-down"></i>
            </button>
        </h3>
        
        <div class="collapse" id="day-{{$item->id}}">
            
                
            </h4>
            <table  id="day-{{$item->id}}" class="table table-bordered table-sm text-center" style="max-width: 100%; overflow: auto;">
                <thead>
                    <th>
                        Час
                    </th>
                    <th>
                        статус
                    </th>
                </thead>
                <tbody>
                    @foreach($item->hours as $value)
                        <tr class="group-{{$value->group_id}}" id="hour-{{$value->id}}" @if ($value->status === 1) style="background: whitesmoke;" @endif>
                            <td>{{date('H:i', strtotime($value->hour))}}</td>
                            <td>
                                <select name="active" class="active col-8 custom-select text-center" data-hour_id="{{$value->id}}">
                                    <option  @if ($value->status === 1) selected='selected' @endif value="1">Активен</option>
                                    <option  @if ($value->status === 0) selected='selected' @endif value="0">Не активен</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>
    @endforeach
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // let token = $('meta[name="csrf-token"]').attr('content');
            // window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            let url = location.href;
        
            $('.group-2').hide();

            $('body').on('click', '#group-1', function(){
                    $('.title').text('Дети 4-6 лет');
                    $('.group-2').hide(500);
                    $('.group-1').show(500);
                           
            });

            $('body').on('click', '#group-2', function(){
                    $('.title').text('Дети 7-14 лет');
                    $('.group-1').hide(500);
                    $('.group-2').show(500);
                         
            });

            $('.active').change(function(){

                let status =  $(this).val();
                let hour_id = $(this)[0].dataset.hour_id;
                let data = {'status' : status};
               
                axios.put(url + '/' + hour_id, data)
                .then(function(response){
                    
                    if(status == 1){
                        $('#hour-'+hour_id).css('background', 'whitesmoke');   
                    }else{
                        $('#hour-'+hour_id).css('background', 'white');
                    }
                })
                .catch(function(response){
                    console.log(response);
                });
            });
        });
    </script>
@endsection