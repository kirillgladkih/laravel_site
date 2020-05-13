@extends('app')

@section('title')Места@endsection
@section('extend-menu')
    <div class="float-right">
        @include('layouts.menu.extend-client')  
        @include('layouts.menu.extend')
    </div>
@endsection

@section('content')
    {{ dd($places) }}
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