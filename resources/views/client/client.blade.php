@extends('app')

@section('title')Клиенты@endsection
@section('extend-menu')
    @include('layouts.menu.extend-client')
@endsection

@section('content')
<!-- Button trigger modal -->

  
  <!-- Modal -->
<div class="modal fade" id="addClient" tabindex="-1" role="dialog"  aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Добавить клиента</h5>
                <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body for-child">
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
                        <label for="" class="form-label">Телефон</label>
                        <input type="text" id="phone" class="form-control" placeholder="+79008080600">
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

<div class="modal fade" id="addChild" tabindex="-1" role="dialog"  aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Добавить ребенка</h5>
                <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert-danger modal-alert"></div>
                <form action="#">
                    <div class="form-group">
                        <label for="" class="form-label">Фио родителя</label>
                        <select id="parent_fio" class="custom-select">
                            @foreach ($parents as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->fio }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Фио ребенка</label>
                        <input type="text" id="child_fio" class="form-control" placeholder="Иванов Иван Иванович">
                    </div> 
                    <div class="form-group">
                        <label for="" class="form-label">Возраст ребенка</label>
                        <input type="number" id="age" class="form-control" min="4" max="14">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary saveChild">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<h1 class="text-center mt-4 mb-4">Клиенты</h1>

<table class="table table-borderles table-responsive-sm table-md text-center" width='100%'>
    <thead>
        <th>
            #
        </th>
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
                <td><a href="">{{ $item->id }}</a></td>
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
                <td width='20px'>{{ $item->child->age }}</td>
                <td>
                    <button class="btn btn-outline-danger del"
                    value='{{ $item->id }}' data-block="#item-{{ $item->id }}">
                    <i class="fas fa-user-times"></i>
                    </button>
                </td>
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
        
        $('body').on('click','#add-client', function(){
            $('.modal-alert').empty(); 
        })

        $('body').on('click','.close-btn', function(){
            $('.modal-alert').empty(); 
        })

        $('body').on('click','.del', function(){

            let id = $(this).val();

            if(confirm('Удалить?'))
                axios.delete(url + '/' + id).then(function(response){
                
                alert('Успешно');
                
                location.reload();
                
             
            })
        });

        $('body').on('click','.saveChild', function(){
            let sub_url = url + '/child';
            let data = {
                'parent_fio' : 'ff'
            };

            axios.post(sub_url, {hello:'hello'})
            .then(function (res){
                console.log(res);
            })
        });

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

                location.reload();

            }).catch(function(error){

                $('.modal-alert').empty();
                
                let errors = error.response.data.errors;

                let str = '';

                console.log(errors);

                $.each(errors, function(index, value){
                    str += '<strong>' + value[0] +'</strong><br>';
                });

                $('.modal-alert').prepend(str);

                console.log(errors); 
            })
        });
    });
</script>
@endsection