@extends('app')

@section('title')График@endsection

@section('content')
    {{-- @foreach ($days as $item)
    <h5 class="text-center mt-2 mb-2">
        @php
            setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');  
            echo strftime("%A", strtotime($item->day));
        @endphp
    </h5>
    <table class="table table-bordered text-center" id="table-{{$item->id}}">
        <tbody>
            
        </tbody>
    </table>
    @endforeach --}}
    <h3 class="text-center mt-4">График</h3>
    @foreach ($days as $item)
        <h3 class="text-center mt-4 mb-4">
            <button class="btn btn-outline-success col-6" type="button" data-toggle="collapse" data-target="#day-{{$item->id}}" aria-expanded="false"
                aria-controls="day-{{$item->id}}">
            {{$item->day}} <i class="fas fa-caret-down"></i>
            </button>
        </h3>
        
        <div class="collapse" id="day-{{$item->id}}">
            <h4 class="text-center">Выберите группу :
            <select class='group-select mt-2 mb-2 custom-select col-4 text-center' name="group-select" data-day="day-{{$item->id}}">
                <option selected value="1">4-6 лет</option>
                <option value="2">7-14 лет</option>
            </select>
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
                                <select name="active" class="active" class="custom-select text-center" data-hour_id="{{$value->id}}">
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

            $('.group-select').val('');
            $('tbody tr').hide();

            $('.group-select').change(function(){
                let table_id = "#"+$(this)[0].dataset.day;

                group_class = 'group-'+$(this).val();

                $.each($(table_id+" tbody tr"), function() {
                    _this = $(this)[0].className;

                    if(_this == group_class){
                        $(this).show(500);
                    }else{
                        $(this).hide(500);
                    }
                });
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