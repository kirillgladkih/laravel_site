@extends('app')

@section('title')Места@endsection
@section('extend-menu')
    <div class="float-right">
        @include('layouts.menu.extend-client')  
        @include('layouts.menu.extend')
    </div>
@endsection

@section('content')


<div class="modal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Добавить место</h5>
                <button type="button" class="close close_" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="form-group">
                        <label for="start">Дата</label>
                        @php
                            setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
                            $begin = strftime("%Y-%m-%d");
                            $end   = strftime("%Y-%m-%d", strtotime("+14 day"));
                        @endphp
                        <input type="date" id="date" class="form-control"
                            value="{{ $begin }}"
                            min="{{ $begin }}" max="{{ $end }}"
                            data-group="1">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Количество мест</label>
                        <input type="number" id="count" class="form-control"
                        min="1">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Час</label>
                        <select id="hour" class="custom-select" disabled='true'>
                            
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary save" data-group="1">Сохранить</button>
            </div>
        </div>
    </div>
</div> 


<h3 class="text-center title mt-4 mb-4">Дети 4-6 лет</h3>
    <table class="table table-bordered text-center">
        <thead>
            <th>
                Дата
            </th>
            <th>
                Час
            </th>
            <th>
                Записались
            </th>
            <th>
                Всего мест
            </th>
            <th>
                Действие
            </th>
        </thead>
        <tbody>
            @foreach($places as $item)
                <tr class="group-{{ $item->group_id }}" id="item-{{ $item->id }}">
                    <td>
                        {{ $item->place_date }}
                    </td>
                    <td>
                        @php
                            echo preg_replace('/:00$/','', $item->place_time);
                        @endphp
                    </td>
                    <td>
                        {{ $item->count }}
                    </td>
                    <td>
                        {{ $item->max_count }}
                    </td>
                    <td>
                        <button class="btn btn-outline-primary m-0 edit" data-id="{{ $item->id }}" 
                        data-group="{{ $item->group_id }}" data-block="#item-{{ $item->id }}"><i class="far fa-edit"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // let token = $('meta[name="csrf-token"]').attr('content');
            // window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            let url = location.href;
            let blockData;

            jQuery.noConflict();

            function reset(){
                $('select').val('');
                $('input').val('');
                $('#hour').attr('disabled', true);
                $('#count').attr('disabled', true);
                $('#count').val(8);
            }

            function getData(){
                return {
                    'place_time'  : $('#hour').val(),
                    'max_count'   : $('#count').val(),
                    'place_date'  : $('#date').val()
                };
            }

            function getHour(this_){
                
                let group = $(this_)[0].dataset.group;
                let date  = $(this_).val();
                let url_       = url.replace(/place/, 'record')

                axios.get(url_ + '/gethour/'+date + '/' + group )
                .then(function(response){
                    
                    let data = response.data;
                    
                    let tmp = '';
                    
                    if(data.length > 0){
                        $.each(data, function(index, value){
                            tmp += "<option value='"+value.hour+"'>"
                            +value.hour.replace(/\:00$/g,'') +
                            "</option>";
                        })
                    
                        $('#hour').append(tmp);
                        $('#hour').attr('disabled', false);
                        $('#count').attr('disabled', false);
                    }
                })
            }

            function saveRequest(obj){
                let group = $(obj)[0].dataset.group;
                let data = getData();
                let response;

                data.group_id = group;
                
                axios.post(url, data)
                .then(function(response){
                    
                    console.log(response);
                    
                    response = response;

                    $('#addModal').modal('hide');
                    location.reload();
                    reset();
                    
                })
                .catch(function(response){
                    console.log(response);
                    
                })  

                return response;               
            }

            reset();

            $('.group-2').hide();

            $('body').on('click', '#group-1', function(){
                    $('.title').text('Дети 4-6 лет');
                    $('.group-2').hide(500);
                    $('.group-1').show(500);
                    $('.save').attr('data-group', 1);
                    $('#date').attr('data-group', 1);
            });

            $('body').on('click', '#group-2', function(){
                    $('.title').text('Дети 7-14 лет');
                    $('.group-1').hide(500);
                    $('.group-2').show(500);
                    $('.save').attr('data-group', 2);
                    $('#date').attr('data-group', 2);
            });

            $('body').on('click', '.save', function(){
                
                let data = saveRequest(this);
        
            });

            $('body').on('click', '.edit', function(){
                
               
                let item  =  $(this)[0].dataset.block;
                let items = $(item)[0].children; 
    
                getHour(this);

                $('#date').val(items[0].innerText);
                $('#hour').val(items[1].innerText);
                
                $('#hour').attr('disabled', false);
                $('#count').attr('disabled', false);
                
                $('#count').val(items[3].innerText);


                $('#addModal').modal('show');


                console.log($(item)[0].children);
                console.log()
               
                // saveRequest(this);
               
            });
            
            $('body').on('click', '.close_', function(){
                console.log($(this)[0].dataset.group);
                
                reset();
            });

            $('#date').change(function(){
                $(this).empty();
                getHour(this);
            })

        });
    </script>
@endsection