@extends('app')

@section('title')Календарь@endsection

@section('extend-menu')
    @include('layouts.menu.extend')
    <button class="btn btn-outline-primary mr-2" id='fil' type="button"
    data-toggle="collapse"
    data-target="#filters"
    aria-expanded="false"
    aria-controls="filters"
     disabled>
        <i class="fas fa-filter"></i>

    </button>

</div>
@endsection

@section('content')

<h3 class="text-center title mt-4 mb-4">Выбирете группу</h3>

<div class="col-12 mt-3 mb-3 collapse" id="filters">
    <div class="form-row">
        <div class="col-6">
            <label>Поиск по дате</label>
            <select class="custom-select search-date" id="search-date"></select>
        </div>
        <div class="col-6">
            <label>Поиск по времени</label>
            <select class="custom-select" id="search-time">
                <option value="09:00">09:00</option>
                @for($i = 10; $i <= 19; $i++)
                    <option value="{{$i}}:00">{{$i}}:00</option>
                @endfor
            </select>
        </div>
        <div class="input-group col-12 mt-4">
            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            <input type="text" class="form-control" placeholder="Поиск по таблице" id='search-table'>
            <span class="input-group-btn">
              <button class="btn btn-outline-secondary" type="button" id="search-table-btn"><i class="fas fa-search"></i></button>
            </span>
          </div>


    </div>
    <div class="form-row mt-3">
        <div class="col">
            <button class="btn btn-primary reset float-right" value=".group-item-1">Сбросить</button>
        </div>
    </div>
</div>

    <table class="table table-borderles table-responsive-sm table-md text-center" width='100%'>
        <thead>
            <tr>

                <th>
                Родитель
                </th>
                <th>
                    Ребенок
                </th>
                <th>
                    Телефон
                </th>
                <th>
                    Дата
                </th>
                <th>
                    Час
                </th>
                <th>
                  Явка
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($records as $item)
                <tr class="group group-item-{{ $item->child->group_id }}" id="item-{{ $item->id }}" >

                    <td>
                        @php
                            $m = $item->child->parent->fio;
                            $m = explode(' ', $m);
                            echo $m[0] . ' ' . substr($m[1],0,2) . '.' . substr($m[2],0,2) . '.' ;
                        @endphp
                    </td>
                    <td>
                        @php
                            $m = $item->child->fio;
                            $m = explode(' ', $m);
                            echo $m[0] . ' ' . substr($m[1],0,2) . '.' . substr($m[2],0,2) . '.' ;
                        @endphp
                    </td>
                    <td>
                        {{ $item->child->parent->phone }}
                    </td>
                    <td class="date">
                        {{ $item->record_date }}
                    </td>
                    <td>
                        @php
                            echo preg_replace('/\:00$/', '', $item->record_time);
                        @endphp
                    </td>
                    <td>
                      <select class="check" class="custom-select"
                      data-client="{{$item->id}}"
                      data-block="#item-{{ $item->id }}">
                          <option value="0">
                            Не пришел
                          </option>
                          <option value="1">
                            Пришел
                          </option>
                      </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('styles')
    <style>
        .group{
            display: none;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            let url = location.href;

            let group;

            $('.check').val('');
            $('.group-item-2').hide();
            $('.group-item-1').hide();
            $('#search-time').val('');
            $('#search-table').val('');
            $('#search-date').val('');

            function getDate(group_block){
                let block = '.search-date';

                $(block).empty();
                $(block).attr('data-group', group_block);

                let unique = $(group_block+' > .date')[0].innerText.trim();

                $(block).append('<option value="'+unique+'">'
                        + unique +'</option>')

                $(group_block+' > .date').each(function(index, value){

                    let val = $(value).text().trim();


                    if(val != unique){

                        unique = val;

                        str =  '<option value="'+unique+'">'
                        + unique +'</option>';

                        $(block).append(str);

                    }
                })

                $(block).val('');
            }

            $('.check').change(function(){

                let block = $(this)[0].dataset.block
                let id    = $(this)[0].dataset.client
                let val   = $(this).val()

                axios.put(`${url}/${id}`, {value: val})
                    .then(response => {
                        console.log(response);
                    })

                $(block).hide(500);

            });

            $('body').on('click', '#group-1', function(){
                    $('#fil').prop('disabled', false);

                    group = '.group-item-1';

                    $('.title').text('Дети 4-6 лет');
                    $('.group-item-1').show(500);
                    $('.group-item-2').hide(500);
                    $('.reset').val('.group-item-1');

                    getDate('.group-item-1');

            });

            $('body').on('click', '#group-2', function(){
                    $('#fil').prop('disabled', false);

                    group = '.group-item-2';

                    $('.title').text('Дети 7-14 лет');
                    $('.group-item-2').show(500);
                    $('.group-item-1').hide(500);

                    $('.reset').val('.group-item-2');

                    getDate('.group-item-2');
            });

            $('table').each(function(index, value){
                let _this = $(value)[0].childElementCount;
            });


            // Search block


            $('body').on('click', '.reset', function(){
                $('tbody tr').hide(500);
                $($(this).val()).show(500);
                $("#search-table").val('');
                $("#search-time").val('');
                $("#search-date").val('');
                searchObj = {date : '', time : ''};
            })

            let searchObj = {date : '', time : ''};

            $('body').on("click", "#search-table-btn", function() {
                var value = $('#search-table').val().toLowerCase();

                console.log(1);

                if(value == '')
                    return 0;

                $(`tbody ${group}`).filter(function() {
                    ref = $(this).text().toLowerCase();

                    ref.indexOf(value) > -1 ?
                        $(this).show(500) : $(this).hide(500)



                    if(searchObj.date != ''){
                        let date = $(this)[0].children[3];
                        date     = $(date).text().trim();

                        console.log(date != searchObj.date )

                        date != searchObj.date ?
                            $(this).hide() : 0;
                    }

                    if(searchObj.time != ''){
                        let time = $(this)[0].children[4];
                        time     = $(time).text().trim();

                        time != searchObj.time ?
                                $(this).hide() : 0
                    }
                });

            });


            $("#search-time").change(function (){
                let value = $(this).val().toLowerCase();

                searchObj.time = value;

                $(`tbody ${group}`).filter(function() {
                    ref = $(this).text().toLowerCase();

                    ref.indexOf(value) > -1 ?
                        $(this).show(500) : $(this).hide(500)


                    if(searchObj.date != ''){
                        let date = $(this)[0].children[3];
                        date     = $(date).text().trim();

                        date != searchObj.date ?
                                $(this).hide() : 0
                    }

                });

            });

            $("#search-date").change(function (){
                let value = $(this).val().toLowerCase();
                searchObj.date = value;
                $('#search-time').val('');
                $(`tbody ${group}`).filter(function() {
                    ref = $(this).text().toLowerCase();

                    ref.indexOf(value) > -1 ?
                        $(this).show(500) : $(this).hide(500)

                });

            });

            // End search block

        });
    </script>
@endsection
