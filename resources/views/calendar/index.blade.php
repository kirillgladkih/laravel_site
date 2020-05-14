@extends('app')

@section('title')Календарь@endsection

@section('extend-menu')
    @include('layouts.menu.extend')
@endsection

@section('content')

<h3 class="text-center title mt-4 mb-4">Выбирете группу</h3>

<div class="form-group">
    <label>Поиск по дате</label>
    <select class="custom-select col-4 search-date"></select>
</div>
<div class="form-group">
    <button class="btn btn-primary reset" value=".group-item-1">Сбросить</button>
</div>

<table class="table table-bordered table-sm text-center" style="max-width: 100%; overflow: auto;">
    <thead>
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
            Действие
        </th>
    </thead>
    <tbody>

      
        @foreach($records as $item)
           
            <tr class="group-item-{{ $item->child->group_id }}" id="item-{{ $item->id }}">
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
                    <button class="btn btn-danger del"
                    value='{{ $item->id }}' data-block="#item-{{ $item->id }}">
                        -
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table> 

    
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
           
            let url = location.href;

            $('.group-item-2').hide();

            

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

         

            $('body').on('click', '#group-1', function(){


                    $('.title').text('Дети 4-6 лет');
                    $('.group-item-1').show(500);
                    $('.group-item-2').hide(500);           
                    $('.reset').val('.group-item-1');

                    getDate('.group-item-1');
                   
            });

            $('body').on('click', '#group-2', function(){
                    
                    
                    $('.title').text('Дети 7-14 лет');
                    $('.group-item-2').show(500);
                    $('.group-item-1').hide(500);   

                    $('.reset').val('.group-item-2');

                    getDate('.group-item-2');           
            });

            $('.search-date').change(function(){
                let ref = $(this).val();
                let group_class = $(this)[0].dataset.group;

                $(group_class).each(function(index, value){
                    let id   = "#"+$(value)[0].id;
                    let date = $(id + ' .date').text().trim(); 
                   
                    if(date != ref){
                        $(value).hide();
                    }else{
                        $(value).show();
                    }
                });
            })

            $('table').each(function(index, value){
                let _this = $(value)[0].childElementCount;
            });


            $('body').on('click', '.del', function(){
                
                let block = $(this)[0].dataset.block;
                
                let id = $(this).val();

                axios.delete(url + '/' + id)
                .then(function(res){
                    console.log(res);
                })
                .catch(function(res){
                    console.log(res);
                });
                
                $(block).remove();
            });

            $('body').on('click', '.reset', function(){
                $('tbody tr').hide(500);
                $($(this).val()).show(500);
            })
        });
    </script>
@endsection