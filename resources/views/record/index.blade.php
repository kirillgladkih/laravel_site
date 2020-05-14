@extends('app')

@section('title')Записать Клиента@endsection

@section('extend-menu')
<button type="button" class="btn btn-outline-primary record">
    Записать
</button>

@endsection

@section('content')
   
<div class="mt-4 mb-5 col-lg-8 text-center" style="margin: 0 auto;">
    <form>
    
    @csrf
    
    <div class="form-group">
        <div class="col mb-2">
            <label for="" class="">Фио родителя</label>
            <select class="custom-select parent-select">
                @foreach($parents as $item)
                    <option value="{{$item->id}}">{{$item->fio}}</option>
                @endforeach
            </select>
        </div>

        <div class="col mb-2">
            <label for="" class="form-label">Фио ребенка</label>
            <select class="custom-select child-select" >        
            </select>
        </div>
    </div>
    <div class="form-row mb-2">
        <div class="col">
            <label for="start">Дата</label>
            @php
                setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
                $begin = strftime("%Y-%m-%d");
                $end   = strftime("%Y-%m-%d", strtotime("+14 day"));
            @endphp
            <input type="date" class="date-select form-control"
                value="{{ $begin }}"
                min="{{ $begin }}" max="{{ $end }}">
        </div>
    </div>
    
    <div class="form-row mb-2">
        <div class="col">
            <label for="" class="form-label">Начало</label>
            <select class="custom-select begin-select">
                        
            </select>
        </div>

        <div class="col">
            <label for="" class="form-label">Конец</label>
            <select class="custom-select end-select">
                    
            </select>
        </div>
    </div>

</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            
            

            let inputArr = ['.parent-select',
            '.child-select', '.date-select',
            '.begin-select','.end-select'];

            function reset(){
               
               $('select').each(function(index,value){
                    $(value).val('');
               });
               

               $('.date-select').val('');               
               $('.date-select').prop('disabled', true);
            }

            function resetTime(){
                $('.begin-select').val('');
                $('.end-select').val('');
            }

            reset();

            let url = location.href;

            $('.parent-select').val('');
            $('.date-select').val('');

            $('.parent-select').change(function(){
                
                let parent_id = $(this).val();

                axios.get(url + '/' + parent_id)
                .then(function(response){
                    let data = response.data;
                    let tmp  = '';
                    
                    data.forEach(function (item){
                        tmp += "<option value='"+
                        item.id+"' data-age='"
                        +item.age+"'>"
                        +item.fio+"</option>";    
                    })
                    $('.child-select').empty();
                    $('.child-select').append(tmp);
                    $('.date-select').prop('disabled', false);
                })
            });
            $('.date-select').change(function(){
                
                let date = $(this).val();
                let age  = $('.child-select option:selected')[0].dataset.age;
                let group = 0;
   
                if(age > 6){
                    group = 2;
                }else 
                    group = 1;
                
                axios.get(url + '/gethour/'+date + '/' + group )
                .then(function(response){
                    let data = response.data;
                    let tmp = '';
                    
                    $.each(data, function(index, value){
                        tmp += "<option value='"+value.hour+"'>"
                        +value.hour.replace(/\:00$/g,'') +
                        "</option>";
                    })
                 
                    $('.begin-select').append(tmp);
                    
                    resetTime();
                });
            });

            

            $('.begin-select').change(function(){
                
                $('.end-select').empty();
                
                let begin  = $(this).val();
                let tmp    = []; 
                
                $('.begin-select > option').each(function(index, value){
                    tmp.push($(value).val());
                });

                let index  = tmp.indexOf(begin);
                let start  = Number(tmp[index].replace(/\:00\:00$/g,'')); 

                for(i = 0; i < tmp.length; i++){
                   
                    ref = Number(tmp[i].replace(/\:00\:00$/g,'')); 
                   
                    if(ref == start){
                        start +=1;

                        let str =  "<option value='"+tmp[i]+"'>"
                        +tmp[i].replace(/\:00$/g,'') +
                        "</option>";
                        $('.end-select').append(str);
                    }
                }
                $('.end-select').val('');
            });

            $('.end-select').change(function(){
                
                let begin  = $('.begin-select').val();
                let end    = $('.end-select').val();

                begin = Number(begin.replace(/\:00\:00$/g,''));
                end   = Number(end.replace(/\:00\:00$/g,''));

                let count = end - begin + 1;

                $(this).attr('data-count', count);

              
            })


            $('body').on('click', '.record', function(){
                
                let child_id  = $('.child-select').val();
                let parent_id = $('.parent-select').val();
                let date   = $('.date-select').val();
                let begin  = $('.begin-select').val();
                let end    = $('.end-select').val();
                let count  = $('.end-select')[0].dataset.count;
                let arr    = [];
                
                begin_ = Number(begin.replace(/\:00\:00$/g,''));
                end_   = Number(end.replace(/\:00\:00$/g,''));

                for(let i = begin_; i <= end_; i++){
                    arr.push(i + ':00:00');
                }

                arr = Object.assign({},arr);

                let data = {'child_id':child_id,
                'record_date':date, 'record_time' : arr};
                
               

                let res;
               
                $.each(data, function(index, value){
                    if(value == '' || value == null){
                        alert('Заполните все поля');

                        return res = false;
                    }
                })

               if(res != false){

                        axios.post(url, data)
                        .then(function(response){
                            console.log(response);
                            $('select').val('');
                            $('.end-select').empty();
                            $('.begin-select').empty();
                            $('.child-select').empty();
                            $('input').val('');
                            $('.date-select').prop('disabled', true);

                            alert("Успешно");
                        })
                        .catch(function(response){
                            console.log(response);
                            alert("Произошла ошибка");
                        })                   
               }
            });
        });
    </script>
@endsection