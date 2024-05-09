<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .oval {
            height: 150px;
            border-radius: 100%;
            border: 1px solid gray;

        }

        .red {
            background-color: red;
        }

        .yellow {
            background-color: yellow;
        }

        .green {
            background-color: green;
        }

        .error {
            color: red !important;
        }
    </style>
</head>

<body class="antialiased">
    <div class="container p-5">
        <div class="alert"></div>
        <form method="post" action="" name="signalForm" id="signalForm">
            @csrf
            <div class="card">
                <div class="card-header p-3">
                    <h3>SignalLights</h3>
                </div>
                <div class="card-body">
                    <div class="row justify-content-md-center mb-5">


                        <div class="col-2 text-center">
                            <div class="oval red" id="div-a">

                            </div>
                            <label for="a">A</label>
                            <input type="text" name="a" id="a" class="form-control" required
                                value="{{ $setting->a }}">
                        </div>
                        <div class="col-2 text-center">
                            <div class="oval red" id="div-b">

                            </div>
                            <label for="b">B</label>
                            <input type="text" name="b" id="b" class="form-control" required
                                value="{{ $setting->b }}">
                        </div>
                        <div class="col-2 text-center">
                            <div class="oval red" id="div-c">

                            </div>
                            <label for="c">C</label>
                            <input type="text" name="c" id="c" class="form-control" required
                                value="{{ $setting->c }}">
                        </div>
                        <div class="col-2 text-center">
                            <div class="oval red" id="div-d">

                            </div>
                            <label for="d">D</label>
                            <input type="text" name="d" id="d" class="form-control" required
                                value="{{ $setting->d }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="green_interval" class="col-md-6 text-right">Green Light Intervals</label>
                        <div class="col-md-6">
                            <input type="text" name="green_interval" id="green_interval" class="form-control"
                                value="{{ $setting->green_interval }}" required>
                        </div>
                        <label for="yellow_interval" class="col-md-6 text-right">Yellow Light Intervals</label>
                        <div class="col-md-6">
                            <input type="text" name="yellow_interval" id="yellow_interval" class="form-control"
                                value="{{ $setting->yellow_interval }}" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">

                    <button class="btn btn-sm btn-primary" id="start" onclick ="startt()">Start</button>
                    <button type="button" class="btn btn-sm btn-danger" id="stop" onclick ="stopp()">Stop</button>
                </div>
            </div>
    </div>
    <script type="text/javaScript">
        $("#signalForm").validate({
                rules:{
                    a:{
                        required:true,
                        number:true,
                    },
                    b:{
                        required:true,
                        number:true,
                    },
                    c:{
                        required:true,
                        number:true,
                    },
                    d:{
                        required:true,
                        number:true,
                    },

                },
                submitHandler:function (form) {
                    
                    console.log('asdf');
                    $.ajax({
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type:'POST',
                        url:"{{ route('setting') }}",
                        data: $(form).serialize(),
                        success:function(response) {
                            if(response.status){
                               $('.alert').addClass('alert-success');
                               $('.alert').text(response.message);
                               //start();
                            }else{
                                $('.alert').addClass('alert-danger');
                                $('.alert').text(response.message);
                            }
                        },
                        error:function (error){
                            $('.alert').addClass('alert-danger');
                                $('.alert').text(error);
                        },
                    })
                }
            });  
           var interval = '';      
           function startt(){
               var a = $("#a").val();
               var b = $("#b").val();
               var c = $("#c").val();
               var d = $("#d").val();
               var gi = $("#green_interval").val();
               var yi = $("#yellow_interval").val();

               const seq = [
                    { "id": "#div-a" , 'value':a },
                    { "id": "#div-b" , 'value':b },
                    { "id": "#div-c" , 'value':c },
                    { "id": "#div-d" , 'value':d },
               ];

               var sortedSeq = seq.sort(function (a,b){
                return a.value -b.value
               });
               console.log(sortedSeq);
              
              var  i=0;
              
              interval = setInterval(() => {
                   if(i <= sortedSeq.length-1){
                        gii=gi;
                        console.log(sortedSeq[i].id);
                        $('.green').removeClass('green')
                        $(sortedSeq[i].id).addClass('green');
                        if(i > 0 ){                           
                            let a = i-1;
                            $(sortedSeq[a].id).addClass('yellow');
                            setTimeout(() => {
                                $('.yellow').removeClass('yellow')
                            }, yi*1000);
                        }                       
                        i++; 
                   }
                   
                   else{
                       
                        if(i == sortedSeq.length ){
                            let a = i-1;
                            $(sortedSeq[a].id).removeClass('green');
                            $(sortedSeq[a].id).addClass('yellow');
                            setTimeout(() => {
                                $('.yellow').removeClass('yellow')
                            }, yi*1000);
                        }
                        i=0; 
                                     
                   }
                          
              }, gi*1000);



           }
           function stopp(){
            clearInterval(interval);
           }
        </script>
</body>

</html>
