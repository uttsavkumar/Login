@extends('navbar')

@section('dashboard')
    <div class="container mt-5">
        <h5 class="mx-auto">Logged in as: {{ Session::get('user')->name }}</h5>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="" method="post" >
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control task" placeholder="Write a Task..." name="task">

                        <button class="btn btn-success addtask" >Add Task</button>
                    </div>
                    @error('task')
                        <p class="text-danger text-small">{{ $message }}</p>
                    @enderror
                </form>
            </div>

        </div>

        {{-- table --}}
        <div class="row mt-4">
            <div class="col-md-6 mx-auto">
                <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Task</th>
                        <th class="float-end me-5">Status</th>
                    </tr>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
         $(document).ready(function() {
        
         taskData()

         function taskData(){
            $.ajax({
            type: "GET",
            url: '{{ route('getData') }}',
            data: "json",
            success: function(response) {
                $('tbody').html("");

                $.each(response.tasks, function(key, t) {
                    $('tbody').append(
                        '<tr>\
                            <th>' + t.id + '</th>\
                            <th>' + t.task + '</th>\
                            <td class="float-end d-flex"> \
                                <button value='+t.id+'  class="btn btn-success status ">Done</button>\
                                <form method="post">\
                                    @csrf\
                                    <input value='+ t.id +' class="task_id" name="task_id" hidden>\
                                    <button  class="btn btn-warning status " >Pending</button>\
                                    </form>\
                                <td>\
                        </tr>'
                    )
                })
            }
        });
        }
        

         $(document).on('click','.addtask',function(e) {
            e.preventDefault();
            var data = {
                'task' : $('.task').val()
            }
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            })
            $.ajax({
                type: 'POST',
                url: '{{ route('add') }}',
                data: data,
                dataType:'json',
                success: function(response) {
                    if(response.status == 400){
                        console.log('error')
                    }
                    else{
                        taskData()
                    }
                }
            })
           
        })

        $(document).on('click','.status',function(e) {
            e.preventDefault();
            var data = {
                'task_id' : $('.task_id').val()
            }
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            })
            $.ajax({
                type: 'POST',
                url: '{{ route('status') }}',
                data: data,
                dataType:'json',
                success: function(response) {
                    if(response.status == 400){
                        console.log('error')
                    }
                    else{
                        taskData()
                    }
                }
            })
        //    alert()
        })

 });
       
    </script>
    
@endsection
