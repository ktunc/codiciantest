

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="text-primary text-center">Addresses Of <?php echo e($company->name); ?></h1>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <button type="button" class="btn btn-success float-right" onclick="FuncAddressInfo(<?php echo e($company->id); ?>, 0)">Add Address</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <table class="table table-hover table-bordered">
                <thead>
                <tr class="bg-primary text-white">
                    <th width="5%">Address ID</th>
                    <th width="5%">Company ID</th>
                    <th>Address</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th width="5%">NearBy</th>
                    <th width="5%">Update</th>
                    <th width="5%">Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($address->id); ?></td>
                        <td><?php echo e($address->company_id); ?></td>
                        <td><?php echo e($address->address); ?></td>
                        <td><?php echo e($address->latitude); ?></td>
                        <td><?php echo e($address->longitude); ?></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-primary" onclick="FuncAddressNearby(<?php echo e($address->latitude); ?>, <?php echo e($address->longitude); ?>)">NearBy</button></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-warning" onclick="FuncAddressInfo(<?php echo e($company->id); ?>, <?php echo e($address->id); ?>)">Update</button></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="FuncAddressDelete(<?php echo e($company->id); ?>, <?php echo e($address->id); ?>)">Delete</button></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="http://sehirharitasi.ibb.gov.tr/api/map2.js"></script>
<script type="text/javascript">
var comJC,ibbMAP;
$(document).ready(function () {
    $(document).on('submit', 'form#AddressForm', function (event) {
        event.preventDefault();
        var formdata = new FormData($('form#AddressForm').get(0));
        $.ajax({
            type:'POST',
            url:"<?php echo e(url('/addresssave')); ?>",
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

function FuncAddressInfo(cid, aid) {
    if(aid > 0){
        $.ajax({
            type:'POST',
            url:"<?php echo e(url('/addressinfo')); ?>",
            data:{'cid':cid, 'aid':aid},
            dataType:'json',
        }).done(function (data) {
            if(data){
                comJC = $.dialog({
                    columnClass: 'xl',
                    closeIcon:false,
                    type:'blue',
                    title:'Update Address',
                    content:'<div class="container"><form id="AddressForm">' +
                        '<input type="hidden" name="cid" value="'+cid+'"/>'+
                        '<input type="hidden" name="aid" value="'+aid+'"/>'+
                        '<div class="form-group row">' +
                        '<div class="col-12">' +
                        '<div style="width:100%; height:400px">\n' +
                        '                <iframe id="mapFrame" src="http://sehirharitasi.ibb.gov.tr" style="height:100%; width:100%;"></iframe>\n' +
                        '            </div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">Address:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <textarea rows="4" class="form-control" name="address" required >'+data.address+'</textarea>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">Latitude:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="text" class="form-control" readonly name="latitude" required value="'+data.latitude+'"/>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <label class="col-3 col-form-label text-right">Longitude:</label>\n' +
                        '    <div class="col-9">\n' +
                        '      <input type="text" class="form-control" readonly name="longitude" required value="'+data.longitude+'"/>\n' +
                        '    </div>\n' +
                        '  </div>' +
                        '<div class="form-group row">\n' +
                        '    <div class="col-12">' +
                        '       <button type="button" class="btn btn-outline-secondary" onclick="comJC.close();">Close</button>' +
                        '    <button type="submit" class="btn btn-outline-success float-right">Save</button>' +
                        '    </div>\n' +
                        '  </div>' +
                        '</form></div>',
                    onOpenBefore: function(){
                        $.alert({
                            type:'blue',
                            icon:'fa fa-info fa-2x',
                            title:'',
                            content:'Select the location of the address on the map.'
                        });
                    },
                    onContentReady: function () {
                        ibbMAP = new SehirHaritasiAPI({mapFrame:"mapFrame",apiKey:"<?php echo e(env('IBB_API_KEY')); ?>"},function(){
                            ibbMAP.Map.Toolbar({
                                print: false,
                                clear: false,
                                measure: false,
                                traffic: false,
                                layers: false,
                                network: false
                            });

                            ibbMAP.Map.Goto({
                                lat: data.latitude,
                                lon: data.longitude,
                                zoom: 15,
                                effect: true
                            });

                            ibbMAP.Nearby.Open({
                                lat: data.latitude,
                                lon: data.longitude,
                                type: ""
                            });
                            ibbMAP.Map.OnClick(function (lat, lon, zoom, clickDirection, pixelX, pixelY) {
                                $('form#AddressForm input[name="latitude"]').val(lat);
                                $('form#AddressForm input[name="longitude"]').val(lon);
                            });
                        });
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
    }else{
        comJC = $.dialog({
            columnClass: 'xl',
            closeIcon:false,
            type:'blue',
            title:'New Address',
            content:'<div class="container"><form id="AddressForm">' +
                '<input type="hidden" name="cid" value="'+cid+'"/>'+
                '<div class="form-group row">' +
                '<div class="col-12">' +
                '<div style="width:100%; height:400px">\n' +
                '                <iframe id="mapFrame" src="http://sehirharitasi.ibb.gov.tr" style="height:100%; width:100%;"></iframe>\n' +
                '            </div>' +
                '</div>' +
                '</div>' +
                '<div class="form-group row">\n' +
                '    <label class="col-3 col-form-label text-right">Address:</label>\n' +
                '    <div class="col-9">\n' +
                '      <textarea rows="4" class="form-control" name="address" required ></textarea>\n' +
                '    </div>\n' +
                '  </div>' +
                '<div class="form-group row">\n' +
                '    <label class="col-3 col-form-label text-right">Latitude:</label>\n' +
                '    <div class="col-9">\n' +
                '      <input type="text" class="form-control" readonly name="latitude" required/>\n' +
                '    </div>\n' +
                '  </div>' +
                '<div class="form-group row">\n' +
                '    <label class="col-3 col-form-label text-right">Longitude:</label>\n' +
                '    <div class="col-9">\n' +
                '      <input type="text" class="form-control" readonly name="longitude" required />\n' +
                '    </div>\n' +
                '  </div>' +

                '<div class="form-group row">\n' +
                '    <div class="col-12">' +
                '       <button type="button" class="btn btn-outline-secondary" onclick="comJC.close();">Close</button>' +
                '    <button type="submit" class="btn btn-outline-success float-right">Save</button>' +
                '    </div>\n' +
                '  </div>' +
                '</form></div>',
            onOpenBefore: function(){
                $.alert({
                    type:'blue',
                    icon:'fa fa-info fa-2x',
                    title:'',
                    content:'Select the location of the address on the map.'
                });
            },
            onContentReady: function () {
                ibbMAP = new SehirHaritasiAPI({mapFrame:"mapFrame",apiKey:"<?php echo e(env('IBB_API_KEY')); ?>"},function(){
                    ibbMAP.Map.Toolbar({
                        print: false,
                        clear: false,
                        measure: false,
                        traffic: false,
                        layers: false,
                        network: false
                    });

                    ibbMAP.Nearby.Open({
                        lat: 31.01371789571470,
                        lon: 39.95547972584920,
                        type: ""
                    });
                    ibbMAP.Map.OnClick(function (lat, lon, zoom, clickDirection, pixelX, pixelY) {
                        $('form#AddressForm input[name="latitude"]').val(lat);
                        $('form#AddressForm input[name="longitude"]').val(lon);
                    });
                });
            }
        });
    }
}

function FuncAddressDelete(cid, aid) {
    $.confirm({
        theme:'modern',
        columnClass: 'l',
        closeIcon:false,
        type:'orange',
        icon:'fa fa-question fa-lg',
        title:'Delete Address',
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
                        url:"<?php echo e(url('/addressdelete')); ?>",
                        data:{'cid':cid, 'aid':aid},
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

function FuncAddressNearby(lat, lon) {
    $.alert({
        columnClass: 'xl',
        theme:'modern',
        type:'blue',
        title:'',
        content:'<div class="container">' +
            '<div class="row mb-2">' +
            '<div class="col-12">' +
            '<div style="width:100%; height:450px">\n' +
            '<iframe id="mapFrame" src="http://sehirharitasi.ibb.gov.tr" style="height:100%; width:100%;"></iframe>\n' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>',
        onContentReady: function () {
            ibbMAP = new SehirHaritasiAPI({mapFrame:"mapFrame",apiKey:"<?php echo e(env('IBB_API_KEY')); ?>"},function(){
                ibbMAP.Map.Toolbar({
                    network: false,
                    panorama: false,
                    layers: false,
                    menu: false,
                    search: false,
                    language: false,
                    traffic: false,
                    mapSwitch: false,
                    rightMenu: false,
                    print: false,
                    clear: false,
                    measure: false
                });

                ibbMAP.Map.Goto({
                    lat: lat,
                    lon: lon,
                    zoom:15,
                    effect: true
                });

                ibbMAP.Nearby.Open({
                    lat: lat,
                    lon: lon,
                    type: ""
                });
            });
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\test-app\resources\views/company/address.blade.php ENDPATH**/ ?>