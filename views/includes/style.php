<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<meta name="csrf-token" content="<?= csrfToken()::token() ?>">
<link rel="icon" href="<?= ASSETS ?>img/icon.ico" type="image/x-icon" />

<!-- Fonts and icons -->


<!-- CSS Files -->
<link rel="stylesheet" href="<?= ASSETS ?>css/bootstrap.min.css">
<link rel="stylesheet" href="<?= ASSETS ?>css/atlantis.min.css">

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= ASSETS ?>css/app.css">

<script src="<?= ASSETS ?>js/plugin/webfont/webfont.min.js"></script>
<script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular",
                "Font Awesome 5 Brands", "simple-line-icons"
            ],
            urls: ['<?= ASSETS ?>css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>