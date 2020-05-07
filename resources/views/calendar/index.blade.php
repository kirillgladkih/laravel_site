@extends('app')

@section('title')Календарь@endsection

@section('extend-menu')
    @include('layouts.menu.extend')
@endsection

@section('content')
   
<h3 class="text-center title mt-4">Дети 4-6 лет</h3>
 
    @foreach ($days as $item)
        <div class="day-group">
            <h5 class="text-center mt-3">{{ $item->date }}</h5>
            <table  id="day-{{$item->id}}" class="table table-sm text-center">   
                @foreach($item->hours as $value)     
                        @if ($value->status == 1)
                        <tr class="group-{{$value->group_id}}" id="hour-{{$value->id}}">
                            <td>{{$value->hour}}</td>
                        </tr>
                        @endif
                    
                @endforeach
            </table>
        </div>
    @endforeach
    
    
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            
            $('.group-2').hide();

            $('body').on('click', '#group-1', function(){
                    $('.title').text('Дети 4-6 лет');
                    $('.group-1').show();
                    $('.group-2').hide();           
            });

            $('body').on('click', '#group-2', function(){
                    $('.title').text('Дети 7-14 лет');
                    $('.group-2').show();
                    $('.group-1').hide();
                         
            });
            $('table').each(function(index, value){
                let _this = $(value)[0].childElementCount;
                
               

            });
        });
    </script>
@endsection