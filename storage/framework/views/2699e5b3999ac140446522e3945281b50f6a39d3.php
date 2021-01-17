<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Styles -->
        <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/jquery-confirm.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">

        <!-- Scripts -->
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
        <script src="<?php echo e(asset('js/jquery-confirm.min.js')); ?>"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <style>
            .col-form-label{
                color: #3490dc !important;
                font-weight: 700 !important;
            }
            .jconfirm .jconfirm-box div.jconfirm-title-c{
                text-align: center;
                font-weight: 700 !important;
            }
        </style>

    </head>
    <body>
        <header class="container mb-4">
            <nav class="navbar navbar-expand-lg navbar-dark bg-info rounded">
                <a class="navbar-brand mb-0 h1" href="<?php echo e(url('/')); ?>">Codician Test</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">Companies</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <main class="page-content">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </body>
</html>
<?php /**PATH E:\xampp\htdocs\test-app\resources\views/app.blade.php ENDPATH**/ ?>