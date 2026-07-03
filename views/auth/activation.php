<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="text-center mt-5 mb-3">
                <img src="<?= ASSETS?>img/logo.svg" alt="Logo" class="img-fluid my-4"
                    style="max-width: 150px;">
            </div>
        </div>

        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body text-center mt-5">
                    <?php if(isset($type['success'])): ?>
                    <h1>
                        <?= $title; ?>
                    </h1>
                    
                    <4>
                        <a href=""> Click here to login </a>
                    </4>
                    <div class=" mb-3 alert alert-<?= $type ?>">
                        <h3> <?= $message; ?> </h3>
                    </div>


                    <?php else: ?>

                    <h2> <?= $title; ?></h2>

                    <div class="alert alert-<?= $type ?>" >
                        <h3> <?= $message; ?> </h3>
                    </div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>