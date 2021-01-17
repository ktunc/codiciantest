@extends('app')

@section('content')
    {{--    {{dd($company)}}--}}
    <div class="container">
        <div class="row mb-2">
            <div class="col-12">
                <h1 class="text-primary text-center">Persons Of {{$company->name}}</h1>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <button type="button" class="btn btn-success float-right" onclick="FuncPersonInfo({{$company->id}}, 0)">Add Person</button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr class="bg-primary text-white">
                        <th width="5%">Person ID</th>
                        <th width="5%">Company ID</th>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Title</th>
                        <th>E-Mail Address</th>
                        <th>Phone Number</th>
                        <th width="5%">Update</th>
                        <th width="5%">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($persons as $person)
                        <tr>
                            <td>{{$person->id}}</td>
                            <td>{{$person->company_id}}</td>
                            <td>{{$person->first_name}}</td>
                            <td>{{$person->last_name}}</td>
                            <td>{{$person->title}}</td>
                            <td>{{$person->email}}</td>
                            <td>{{$person->phone}}</td>
                            <td class="text-center"><button type="button" class="btn btn-sm btn-warning" onclick="FuncPersonInfo({{$company->id}}, {{$person->id}})">Update</button></td>
                            <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="FuncPersonDelete({{$company->id}}, {{$person->id}})">Delete</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var comJC;
        $(document).ready(function () {
            $(document).on('submit', 'form#PersonForm', function (event) {
                event.preventDefault();
                var formdata = new FormData($('form#PersonForm').get(0));
                $.ajax({
                    type:'POST',
                    url:"{{url('/personsave')}}",
                    data:formdata,
                    dataType:'json',
                    processData: false,
                    contentType: false,
                    cache:false,
                    beforeSend:function () {
                        comJC.showLoading(false);
                    }
                }).done(function (data) {
                    if(data){
                        $.alert({
                            theme:'modern',
                            type:'green',
                            icon:'fa fa-check',
                            title:'Success',
                            content:'',
                            onClose: function () {
                                window.location.reload();
                            }
                        });
                    }else{
                        $.alert({
                            theme:'modern',
                            type:'red',
                            icon:'fa fa-close',
                            title:'Error',
                            content:'An error has occurred. Please try again.',
                            onClose: function () {
                                comJC.hideLoading();
                            }
                        });
                    }
                }).fail(function () {
                    $.alert({
                        theme:'modern',
                        type:'red',
                        icon:'fa fa-close',
                        title:'Error',
                        content:'An error has occurred. Please try again.',
                        onClose: function () {
                            comJC.hideLoading();
                        }
                    });
                });
            })
        });

        function FuncPersonInfo(cid, pid) {
            if(pid > 0){
                $.ajax({
                    type:'POST',
                    url:"{{url('/personinfo')}}",
                    data:{'cid':cid, 'pid':pid},
                    dataType:'json',
                }).done(function (data) {
                    if(data){
                        comJC = $.dialog({
                            columnClass: 'l',
                            closeIcon:false,
                            type:'blue',
                            title:'Update Person',
                            content:'<div class="container"><form id="PersonForm">' +
                                '<input type="hidden" name="cid" value="'+cid+'"/>'+
                                '<input type="hidden" name="pid" value="'+pid+'"/>'+
                                '<div class="form-group row">\n' +
                                '    <label class="col-3 col-form-label text-right">First Name:</label>\n' +
                                '    <div class="col-9">\n' +
                                '      <input type="text" class="form-control" name="first_name" required value="'+data.first_name+'"/>\n' +
                                '    </div>\n' +
                                '  </div>' +
                                '<div class="form-group row">\n' +
                                '    <label class="col-3 col-form-label text-right">Last Name:</label>\n' +
                                '    <div class="col-9">\n' +
                                '      <input type="text" class="form-control" name="last_name" required value="'+data.last_name+'"/>\n' +
                                '    </div>\n' +
                                '  </div>' +
                                '<div class="form-group row">\n' +
                                '    <label class="col-3 col-form-label text-right">Title:</label>\n' +
                                '    <div class="col-9">\n' +
                                '      <input type="text" class="form-control" name="title" required value="'+data.title+'"/>\n' +
                                '    </div>\n' +
                                '  </div>' +
                                '<div class="form-group row">\n' +
                                '    <label class="col-3 col-form-label text-right">E-Mail Address:</label>\n' +
                                '    <div class="col-9">\n' +
                                '      <input type="email" class="form-control" name="email" required value="'+data.email+'">\n' +
                                '    </div>\n' +
                                '  </div>' +
                                '<div class="form-group row">\n' +
                                '    <label class="col-3 col-form-label text-right">Phone Number:</label>\n' +
                                '    <div class="col-9">\n' +
                                '      <input type="tel" class="form-control" name="phone" required value="'+data.phone+'">\n' +
                                '    </div>\n' +
                                '  </div>' +
                                '<div class="form-group row">\n' +
                                '    <div class="col-12">' +
                                '       <button type="button" class="btn btn-outline-secondary" onclick="comJC.close();">Close</button>' +
                                '    <button type="submit" class="btn btn-outline-success float-right">Save</button>' +
                                '    </div>\n' +
                                '  </div>' +
                                '</form></div>',
                        });
                    }else{
                        $.alert({
                            theme:'modern',
                            type:'red',
                            icon:'fa fa-close',
                            title:'Error',
                            content:'An error has occurred. Please try again.',
                            onClose: function () {
                                window.location.reload();
                            }
                        });
                    }
                }).fail(function () {
                    $.alert({
                        theme:'modern',
                        type:'red',
                        icon:'fa fa-close',
                        title:'Error',
                        content:'An error has occurred. Please try again.',
                        onClose: function () {
                            window.location.reload();
                        }
                    });
                });
            }else{
                comJC = $.dialog({
                    columnClass: 'l',
                    closeIcon:false,
                    type:'blue',
                    title:'New Person',
                    content:'<div class="container"><form id="PersonForm">' +
                        '<input type="hidden" name="cid" value="'+cid+'"/>'+
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">First Name:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="text" class="form-control" name="first_name" required/>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">Last Name:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="text" class="form-control" name="last_name" required/>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">Title:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="text" class="form-control" name="title" required/>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">E-Mail Address:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="email" class="form-control" name="email" required>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">Phone Number:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="tel" class="form-control" name="phone" required>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <div class="col-12">' +
                        '       <button type="button" class="btn btn-outline-secondary" onclick="comJC.close();">Close</button>' +
                        '    <button type="submit" class="btn btn-outline-success float-right">Save</button>' +
                        '    </div>\n' +
                        '  </div>' +
                        '</form></div>',
                });
            }
        }

        function FuncPersonDelete(cid, pid) {
            $.confirm({
                theme:'modern',
                columnClass: 'l',
                closeIcon:false,
                type:'orange',
                icon:'fa fa-question fa-lg',
                title:'Delete Person',
                content:'',
                buttons:{
                    close:{
                        text:'Close'
                    },
                    delete:{
                        text:'Delete',
                        btnClass:'btn-danger',
                        action: function () {
                            $.ajax({
                                type:'POST',
                                url:"{{url('/persondelete')}}",
                                data:{'cid':cid, 'pid':pid},
                                dataType:'json',
                            }).done(function (data) {
                                if(data){
                                    $.alert({
                                        theme:'modern',
                                        type:'green',
                                        icon:'fa fa-check',
                                        title:'Success',
                                        content:'',
                                        onClose: function () {
                                            window.location.reload();
                                        }
                                    });
                                }else{
                                    $.alert({
                                        theme:'modern',
                                        type:'red',
                                        icon:'fa fa-close',
                                        title:'Error',
                                        content:'An error has occurred. Please try again.',
                                        onClose: function () {
                                            window.location.reload();
                                        }
                                    });
                                }
                            }).fail(function () {
                                $.alert({
                                    theme:'modern',
                                    type:'red',
                                    icon:'fa fa-close',
                                    title:'Error',
                                    content:'An error has occurred. Please try again.',
                                    onClose: function () {
                                        window.location.reload();
                                    }
                                });
                            });
                        }
                    }
                }
            });
        }
    </script>
@endsection