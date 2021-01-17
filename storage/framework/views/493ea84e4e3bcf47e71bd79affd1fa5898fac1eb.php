

<?php $__env->startSection('content'); ?>
    
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1 class="text-primary text-center">Persons Of <?php echo e($company->name); ?></h1>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <button type="button" class="btn btn-success float-right" onclick="FuncPersonInfo(<?php echo e($company->id); ?>, 0)">Add Person</button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Person ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Title</th>
                        <th>E-Mail Address</th>
                        <th>Phone Number</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($person->id); ?></td>
                            <td><?php echo e($person->first_name); ?></td>
                            <td><?php echo e($person->last_name); ?></td>
                            <td><?php echo e($person->title); ?></td>
                            <td><?php echo e($person->email); ?></td>
                            <td><?php echo e($person->phone); ?></td>
                            <td><button type="button" class="btn btn-warning" onclick="FuncPersonInfo(<?php echo e($company->id); ?>, <?php echo e($person->id); ?>)">Update</button></td>
                            <td><button type="button" class="btn btn-danger">Delete</button></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    url:"<?php echo e(url('/personsave')); ?>",
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
                        console.log(data);
                        window.location.reload();
                    }else{
                        console.log(data);
                    }
                }).fail(function () {
                    comJC.hideLoading();
                });
            })
        });

        function FuncPersonInfo(cid, pid) {
            if(pid > 0){
                $.ajax({
                    type:'POST',
                    url:"<?php echo e(url('/personinfo')); ?>",
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
                        console.log(data);
                    }
                }).fail(function () {

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
        // $(document).ready(function () {
        //     $.alert({
        //         columnClass: 'm',
        //         // containerFluid: true,
        //         theme:'material',
        //         type:'blue',
        //         title:'test',
        //         content:'pest',
        //         buttons:{
        //             tamam:{
        //                 text:'Tamam',
        //                 btnClass:'pull-left'
        //             },
        //             yyy:{
        //                 text:'Tamam'
        //             }
        //         }
        //     });
        // });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\test-app\resources\views/company/person.blade.php ENDPATH**/ ?>