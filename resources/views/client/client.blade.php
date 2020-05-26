@extends('app')

@section('title')Клиенты@endsection
@section('extend-menu')
    @include('layouts.menu.extend-client')
@endsection

@section('content')

  
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
                <div class="alert-danger modal-alert-child"></div>
                <form action="#">
                    <div class="form-group">
                        <label for="" class="form-label">Фио родителя</label>
                        <select id="procreator-id" class="custom-select">
                            @foreach ($parents as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->fio }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Фио ребенка</label>
                        <input type="text" id="child-fio" class="form-control" placeholder="Иванов Иван Иванович">
                    </div> 
                    <div class="form-group">
                        <label for="" class="form-label">Возраст ребенка</label>
                        <input type="number" id="age-child" class="form-control" min="4" max="14">
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
        <th>
            Удл./Ред.
        </th>
    </thead>
    <tbody>
        @php
            $i = 0;
        @endphp
        @foreach ($clients as $item)
            <tr>
                <td>{{ ++$i }}</td>
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
                <td width='150px' style="padding: 13px 0 0 0">
                    <button class="btn btn-outline-danger del pr-2"
                    value='{{ $item->id }}' data-block="#item-{{ $item->id }}">
                    <i class="fas fa-user-times"></i>
                    </button>
                    <button class="btn btn-outline-primary m-0 edit" data-id="{{ $item->id }}" data-child="{{ $item->child->fio }}"
                    data-parent="{{  $item->child->parent->fio }}"    
                    data-phone = "{{ $item->child->parent->phone }}"
                    data-age="{{ $item->child->age }}"
                    data-child_id="{{ $item->child->id }}"
                    data-parent_id="{{ $item->child->parent->id }}"
                    ><i class="far fa-edit"></i></button>
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

        //Инициалы
        function initials(str) {
            return str.split(/\s+/).map((w,i) => i ? w.substring(0,1).toUpperCase() + '.' : w).join(' ');
        }
        
        // Удаление клиента
        $('body').on('click','.del', function(){

            let id = $(this).val();

            if(confirm('Удалить?'))
                axios.delete(url + '/' + id).then(function(response){
                
                alert('Успешно');
                
                location.reload();
                
             
            })
        });

        $('body').on('click','#add-client', function(){
            $('.save').attr('data-action', 'save');
            $('.modal-title').text('Добавить клиента');
            console.log( $('.save'));
        });

        //Редактирование
        $('body').on('click','.edit', function(){
            let obj  = $(this)[0].dataset;

            $('.modal-title').text('Редактировать клиента');

            $('.save').attr('data-action', 'edit');
            $('.save').attr('data-client_id', obj.id);

            $('#parent_fio').val(obj.parent);
            $('#child_fio').val(obj.child);
            $('#phone').val(obj.phone);
            $('#age').val(obj.age);

            $('#addClient').modal('show');
          
        });

        //Добавить ребенка
        $('body').on('click','.saveChild', function(){
            let sub_url = url + '/child';
            let data = {
                'procreator_id' : $('#procreator-id').val(),
                'fio' : $('#child-fio').val(),
                'age'       : $('#age-child').val()
            };

            console.log(data);

            axios.post(sub_url, data)
            .then(function (res){
                
                $('.form-control').val('');

                alert('Успешно');

                location.reload();
            }).catch(function(error){

            $('.modal-alert-child').empty();

            let errors = error.response.data.errors;

            let str = '';

           

            $.each(errors, function(index, value){
                str += '<strong>' + value[0] +'</strong><br>';
            });

            $('.modal-alert-child').prepend(str);
               
            });



        });

        function saveForEdit(data, id)
        {
            let Url = url + '/' + id;
           

            axios.put(Url , data)
            .then(function(response){
                $('#addModal').modal('hide');

                $('.form-control').val('');

                alert('Успешно');

                location.reload();

            }).catch(function(error){

                $('.modal-alert').empty();
                
                let errors = error.response.data.errors;

                let str = '';

               

                $.each(errors, function(index, value){
                    str += '<strong>' + value[0] +'</strong><br>';
                });

                $('.modal-alert').prepend(str);

               
            })
        }

        //Добавить клиента
        $('body').on('click','.save', function(){

            let action = $(this)[0].dataset.action;
            let phone  =  $('#phone').val();

            phone = phone.replace(/^\+*/i,'');
            phone = phone.replace(/^7/i,'8');

            let data = {
                'parent_fio' : $('#parent_fio').val(),
                'child_fio'  : $('#child_fio').val(),
                'phone'      :  phone,
                'age'        : $('#age').val(),

            };

            if(action == 'save'){
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

                  

                    $.each(errors, function(index, value){
                        str += '<strong>' + value[0] +'</strong><br>';
                    });

                    $('.modal-alert').prepend(str);

                    
                })
            }else{
                let id = $(this)[0].dataset.client_id;

                console.log($(this));

                saveForEdit(data, id);

                return false;
            } 
        });
    });
</script>
@endsection