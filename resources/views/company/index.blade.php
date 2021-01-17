@extends('app')

@section('content')
{{--    {{dd($company)}}--}}
<div class="container">
    <div class="row mb-2">
        <div class="col-12">
            <button type="button" class="btn btn-success float-right" onclick="FuncCompanyInfo(0)">Add Company</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="bg-primary text-white">
                        <th width="5%">Compnay ID</th>
                        <th>Copmany Name</th>
                        <th>Copmany Web Site</th>
                        <th width="10%">Thumbnail</th>
                        <th width="10%">Copmany Persons</th>
                        <th width="10%">Copmany Addresses</th>
                        <th width="5%">Update</th>
                        <th width="5%">Delete</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{$company->id}}</td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->internet_address}}</td>
                        <td class="text-center"><img src="{{ asset('/storage/company/'.$company->id.'.jpg') }}" class="rounded img-thumbnail" style="max-height: 100px;" onclick="FuncOpenImage('{{ asset('/storage/company/'.$company->id.'.jpg') }}','{{$company->name}}')"></td>
                        <td class="text-center"><a href="{{url('/person/'.$company->id)}}" class="btn btn-sm btn-primary">Person</a></td>
                        <td class="text-center"><a href="{{url('/address/'.$company->id)}}" class="btn btn-sm btn-primary">Address</a></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-warning" onclick="FuncCompanyInfo({{$company->id}})">Update</button></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="FuncCompanyDelete({{$company->id}})">Delete</button></td>
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
    $(document).on('submit', 'form#CompanyForm', function (event) {
        event.preventDefault();
        var formdata = new FormData($('form#CompanyForm').get(0));
        $.ajax({
            type:'POST',
            url:"{{url('/companysave')}}",
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

function FuncCompanyInfo(cid) {
    if(cid > 0){
        $.ajax({
            type:'POST',
            url:"{{url('/companyinfo')}}",
            data:{'cid':cid},
            dataType:'json',
        }).done(function (data) {
            if(data){
                comJC = $.dialog({
                    columnClass: 'l',
                    closeIcon:false,
                    type:'blue',
                    title:'Update Company',
                    content:'<div class="container"><form id="CompanyForm">' +
                        '<input type="hidden" name="cid" value="'+data.id+'"/>'+
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">Name:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="text" class="form-control" name="name" required value="'+data.name+'"/>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">Internet Address:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="url" class="form-control" name="internet_address" required value="'+data.internet_address+'">\n' +
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
            title:'New Company',
            content:'<div class="container"><form id="CompanyForm">' +
                // '<input type="hidden" name="cid" value="0"/>'+
                '<div class="form-group row">\n' +
                '    <label class="col-3 col-form-label text-right">Name:</label>\n' +
                '    <div class="col-9">\n' +
                '      <input type="text" class="form-control" name="name" required/>\n' +
                '    </div>\n' +
                '  </div>' +
                '<div class="form-group row">\n' +
                '    <label class="col-3 col-form-label text-right">Internet Address:</label>\n' +
                '    <div class="col-9">\n' +
                '      <input type="url" class="form-control" name="internet_address" required>\n' +
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

function FuncCompanyDelete(cid) {
    $.confirm({
        theme:'modern',
        columnClass: 'l',
        closeIcon:false,
        type:'orange',
        icon:'fa fa-question fa-lg',
        title:'Delete Company',
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
                        url:"{{url('/companydelete')}}",
                        data:{'cid':cid},
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

function FuncOpenImage(image, cname) {
    $.alert({
        theme:'modern',
        columnClass: 'l',
        type:'blue',
        title: cname,
        content:'<div class="container-fluid"><div class="row"><div class="col-12"><img src="'+image+'"/></div></div></div>',
    });
}
</script>
@endsection