@extends('app')

@section('title')Клиенты@endsection
@section('extend-menu')
    @include('layouts.menu.extend-client')
@endsection

@section('content')
<!-- Button trigger modal -->

  
  <!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Добавить клиента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary save">Сохранить</button>
            </div>
        </div>
    </div>
</div> 

<table class="table table-bordered table-sm text-center mt-4" style="max-width: 100%; overflow: auto;">
    <thead>
        <th>
            Фио родителя
        </th>
        <th>
            Фио ребенка
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
                <td>{{ $item->child->parent->fio }}</td>
                <td>{{ $item->child->fio }}</td>
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
        
        let url = location.href;

        $('body').on('click','.save', function(){
            let data = {
                'parent_fio' : $('#parent_fio').val(),
                'child_fio'  : $('#child_fio').val(),
                'phone'      : $('#phone').val(),
                'age'        : $('#age').val(),

            };

            axios.post(url , data)
            .then(function(response){
                console.log(response);
            }).catch(function(response){
                console.log(response); 
            })
        });
    });
</script>
@endsection