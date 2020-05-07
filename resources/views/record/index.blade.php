@extends('app')

@section('title')Записать Клиента@endsection

@section('content')
   
    <form action="#">
    @csrf
        <div class="form-group">
            <label for="" class="form-label">Фио родителя</label>
            
            <select class="custom-select parent-select">
                @foreach($parents as $item)
                    <option value="{{$item->id}}">{{$item->fio}}</option>
                @endforeach
            </select>
            <select class="custom-select">
                
            </select>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){

            let url = location.href;

            $('.parent-select').change(function(){
                let parent_id = $(this).val();

                axios.get(url + '/' + parent_id)
                .then(function(response){
                    console.log(response);
                })
            });
        });
    </script>
@endsection