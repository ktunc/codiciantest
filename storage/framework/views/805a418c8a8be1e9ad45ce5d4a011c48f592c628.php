

<?php $__env->startSection('content'); ?>
<script src="http://sehirharitasi.ibb.gov.tr/api/map2.js"></script>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div id="harita" style="width:100%; height:500px">
                <iframe id="mapFrame" src="http://sehirharitasi.ibb.gov.tr" style="height:100%; width:100%;"></iframe>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var ibbMAP = new SehirHaritasiAPI({mapFrame:"mapFrame",apiKey:"a69bec3fd6514d4a8d7b3967122b5afc"},function(){
        ibbMAP.Map.OnClick(function (lat, lon, zoom, clickDirection, pixelX, pixelY) {
            console.log(lat);
            console.log(lon);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\test-app\resources\views/map.blade.php ENDPATH**/ ?>