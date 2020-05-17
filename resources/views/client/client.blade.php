@extends('app')

@section('title')Клиенты@endsection
@section('extend-menu')
    @include('layouts.menu.extend-client')
@endsection

@section('content')
<!-- Button trigger modal -->

  
  <!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Добавить клиента</h5>
                <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert-danger modal-alert"></div>
                <form action="#">
                    <div class="form-group">
                        <label for="" class="form-label">Фио родителя</label>
                        <input type="text" id="parent_fio" class="form-control" placeholder="Иванов Иван Иванович">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Фио ребенка</label>
                        <input type="text" id="child_fio" class="form-control" placeholder="Иванов Иван Иванович">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Номер телефона</label>
                        <input type="text" id="phone" class="form-control" placeholder="+79001010100">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Возраст ребенка</label>
                        <input type="number" id="age" class="form-control" min="4" max="14">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary save">Сохранить</button>
            </div>
        </div>
    </div>
</div> 

<table class="table table-borderles table-responsive-sm table-md text-center " width='100%'>
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
            Возраст
        </th>
    </thead>
    <tbody>
        @foreach ($clients as $item)
            <tr>
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
                <td>{{ $item->child->parent->phone }}</td>
                <td>{{ $item->child->age }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        jQuery.noConflict();
        
        let url = location.href;

       
        function initials(str) {
            return str.split(/\s+/).map((w,i) => i ? w.substring(0,1).toUpperCase() + '.' : w).join(' ');
        }

        $('body').on('click','.close-btn', function(){
            $('.modal-alert').empty(); 
        })

        $('body').on('click','.save', function(){
            let data = {
                'parent_fio' : $('#parent_fio').val(),
                'child_fio'  : $('#child_fio').val(),
                'phone'      : $('#phone').val(),
                'age'        : $('#age').val(),

            };

            axios.post(url , data)
            .then(function(response){
                $('#addModal').modal('hide');

                $('.form-control').val('');

                alert('Успешно');

                let str = '<tr>';
                
                data.child_fio  = initials(data.child_fio);
                data.parent_fio = initials(data.parent_fio);

                $.each(data, function(index, value){

                    str += '<td>' + value + '</td>';
                });

                str += '</tr>';

                $('tbody').append(str);

            }).catch(function(error){

                $('.modal-alert').empty();
                
                let errors = error.response.data.errors;

                let str = '';

                $.each(errors, function(index, value){
                    $.each(value, function(index, value){
                        str += '<strong>' + value +'</strong><br>';
                    });
                });

                $('.modal-alert').prepend(str);

                console.log(errors); 
            })
        });
    });
</script>
@endsection