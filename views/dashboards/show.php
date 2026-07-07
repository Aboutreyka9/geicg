

if (strtolower($_SESSION['role']) == ADMIN):

  $today = date("Y-m-d");

  // Dates par défaut
  $start = (new DateTime('first day of this month'))->format('Y-m-d');
  $end = (new DateTime('today'))->format('Y-m-d');

  $dateD = (new DateTime('first day of this month'))->format('d-m-Y');
  $dateF = (new DateTime('today'))->format('d-m-Y');
  $entrepot = $_SESSION['id_entrepot'] ?? null;

  $totalAchatAttente = Soutra::getTotauxAchatEnAttente(); // méthode adaptée que l'on a créée

  $totalVenteAttente = Soutra::getTotauxVenteEnAttenteAdmin(); // méthode adaptée que l'on a créée

  $stockDispo = Soutra::getTotauxViewStockProduit();

  $stockAlert = Soutra::getCountStockAlert();


  ?>
  <!-- DASHBOARD ADMIN  -->

  <header class="page-title-bar container">
    <input type="hidden" id="canvas_page_dashbord" value="123">
    <div class="header-dashboard d-flex align-items-center mb-4">
      <i class="fas fa-chart-line mr-3 me-3" style="font-size:20px;"></i>
      <div>
        <h4 class="mb-0">Tableau de bord</h4>
        <small>Vue globale de l’activité</small>
      </div>
    </div>
  </header><!-- /.page-title-bar -->




  <!-- CARDS -->
  <div class="row g-3 dashboard_admin">

    <div class="col-md-12 mb-4 mt-2">

      <div class="stats-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

        <!-- Titre -->


        <!-- Activité -->
        <div class="activity text-md-center">
          <h4 style="font-weight: bold;" id="activityDateRange">
            Activité du <?php // // echo $dateD . ' au ' . $dateF; ?>
          </h4>
        </div>

        <!-- Filtre -->
        <div class="input-group w-100 w-md-auto filter-box">
          <span class="input-group-text">
            <i class="fa fa-calendar"></i>
          </span>
          <input type="text" id="filterDashboardAdmin" class="form-control" placeholder="Sélectionner la période">
          <button id="filterBtn" class="btn btn-primary">
            <i class="fa fa-filter"></i>
          </button>
        </div>

      </div>

    </div>
    <!-- STATS -->
    <div style="font-weight: bold;" class="row g-3 mb-1">


      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div style="cursor: pointer;" class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-primary mr-2">
                <i class="fas fa-dollar-sign"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title montan-title">DETTE FOURNISSEURS</span> (<span id="nombre_dette_fournisseur">
                  0 </span>)</h6>
            </div>
            <h5 class="montan-value"><span id="montant_dette_fournisseur"> 0 </span>
            </h5>
          </div>
        </div>
      </div>


      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-info mr-2">
                <i class="fas fa-dollar-sign"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">DETTE CLIENTS</span> (<span id="nombre_dette_client"> 0 </span>)
              </h6>
            </div>
            <h5 class="montan-value"><span id="montant_dette_client"> 0 </span> </h5>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-danger mr-2">
                <i class="fas fa-dollar-sign"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">DÉPENSES</span> (<span id="nombre_depense"> 0 </span>)</h6>
            </div>
            <h5 class="montan-value"><span id="montant_depense"> 0 </span> </h5>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-primary mr-2">
                <i class="fas fa-arrow-alt-circle-up"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">RÉAPPRO </span> (<span id="nombre_reapprovisionnement"> 0
                </span>)</h6>
            </div>
            <h5 class="montan-value"><span id="montant_reapprovisionnement"> 0 </span> </h5>
          </div>
        </div>
      </div>


      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-info mr-2">
                <i class="fas fa-arrow-alt-circle-down"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">VENTES</span> (<span id="nombre_vente"> 0 </span>)</h6>
            </div>
            <h5 class="montan-value"><span id="montant_vente"> 0 </span> </h5>
          </div>
        </div>
      </div>


      <div class="col-md-4">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-dark mr-2">
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">CAISSE</span> </h6>
            </div>
            <h5 class="montan-value"><span id="montant_tresorerie"> 0 </span> </h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-orange mr-2">
                <i class="fas fa-box"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">ACHAT EN ATTENTE ( <?php // // $totalAchatAttente['article'] ?>
                  )</span> </h6>
            </div>
            <h5 class="montan-value"><span id=""> <?php // // $totalAchatAttente['total'] ?>
              </span> </h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-orange mr-2">
                <i class="fas fa-box"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">VENTE EN ATTENTE (
                  <?php // // $totalVenteAttente['article'] ?>
                  )
                </span> </h6>
            </div>
            <h5 class="montan-value"><span id=""> <?php // // $totalVenteAttente['total'] ?> </span> </h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-info mr-2">
                <i class="fas fa-exchange-alt"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">STOCK DISPO</span> (<span id="">
                  <?php // // $stockDispo['total_quantite'] ?> </span>)
              </h6>
            </div>
            <h5 class="montan-value"><span id=""> <?php // // number_format($stockDispo['total_montant'] ?? 0, 0, '.', ' ') ?> </span> </h5>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card custom-card-detail">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="icon bg-danger mr-2">
                <i class="far fa-share-square"></i>
              </div>
              <h6><span class="text-muted text-uppercase montan-title">STOCK ALERT</span></h6>
            </div>
            <h5 class="montan-value"><span id=""> <?php // // $stockAlert ?> </span> </h5>
          </div>
        </div>
      </div>


    </div>

    <!-- CARD -->

  </div>

  <!-- .page-section -->
  <div class="page-section container ">


    <div class="row mt-5">
      <!-- grid column -->
      <div class="col-12 col-lg-12 col-xl-12">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .d-flex -->
            <div class="d-flex justify-content-between  align-items-center mb-4 col-12 col-md-12 col-lg-12">
              <h3 class="card-title mb-0"> Montant des ventes de la Semaine</h3><!-- .card-title-control -->
              <button class="btn btn-sm btn-info toggle-btn " type="button" data-toggle="collapse"
                data-target="#week_chart" aria-expanded="true">+</button>
            </div><!-- /.d-flex -->
            <div id="week_chart" class="collapse show col-12 col-md-12 col-lg-12">
              <div class="chartjs">
                <canvas id="week_canvas"></canvas>
              </div>
            </div>
          </div><!-- /.card-body -->
        </section><!-- /.card -->
      </div><!-- /grid column -->
    </div><!-- /grid row -->

    <hr>

    <!-- section-deck -->
    <div class="row mt-5">
      <!-- grid column -->
      <div class="col-12 col-lg-12 col-md-12">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .d-flex -->
            <div class="d-flex align-items-center mb-4">
              <h3 class="card-title mb-0"> Montant des ventes par mois</h3><!-- .card-title-control -->
              <div class="card-title-control ml-auto">


                <div class="d-flex">
                  <select style="width: 15em;" class="form-control select_year" name="" id="select_year_dashboard">

                  </select> &nbsp; &nbsp;
                  <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                  <button class="btn btn-sm btn-info toggle-btn ml-2" type="button" data-toggle="collapse"
                    data-target="#month_chart" aria-expanded="true">+</button>

                </div>

              </div><!-- /.card-title-control -->
            </div><!-- /.d-flex -->
            <div id="month_chart" class="collapse show">
              <div class="chartjs">
                <canvas id="month_canvas"></canvas>
              </div>
            </div>
          </div><!-- /.card-body -->
        </section><!-- /.card -->
      </div><!-- /grid column -->
    </div><!-- /row -->
    <hr>
    <!-- section-deck -->
    <div class="row mt-5">
      <!-- grid column -->
      <div class="col-12 col-lg-12 col-md-12">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .d-flex -->
            <div class="d-flex align-items-center mb-4">
              <h3 class="card-title mb-0"> Montant des achats par mois</h3><!-- .card-title-control -->
              <div class="card-title-control ml-auto">
                <div class="d-flex">
                  <select style="width: 15em;" class="form-control select_year" name="" id="select_year_dashboard_achat">

                  </select> &nbsp; &nbsp;
                  <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                  <button class="btn btn-sm btn-info toggle-btn ml-2" type="button" data-toggle="collapse"
                    data-target="#month_achat_chart" aria-expanded="true">+</button>
                </div>

              </div><!-- /.card-title-control -->
            </div><!-- /.d-flex -->
            <div id="month_achat_chart" class="collapse show">
              <div class="chartjs">
                <canvas id="month_achat_canvas"></canvas>
              </div>
            </div>
          </div><!-- /.card-body -->
        </section><!-- /.card -->
      </div><!-- /grid column -->
    </div><!-- /row -->
    <!-- section-deck -->
  </div><!-- /.page-section -->

  <!-- CARDS -->
  <div class="row g-3 mt-5">
    <div class="col-md-12">
      <h4>APERCU GENERAL</h4>
    </div>
    <!-- CARD -->



    <div class="col-md-4 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-info"><i class="fas fa-chart-bar"></i></div>
        <h6 class="montan-title">PRODUITS </h6>
        <h5><?php // echo Soutra::getCompterArticleEntrepot($_SESSION['id_entrepot']); ?> </h5>
      </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-purple"><i class="fas fa-user-friends"></i></div>
        <h6 class="montan-title">CLIENTS</h6>
        <h5> <span> <?php // echo Soutra::getCompterClientEntrepot($_SESSION['id_entrepot']); ?></span></h5>
      </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-dark"><i class="fas fa-user-friends"></i></div>
        <h6 class="montan-title">FOURNISSEURS</h6>
        <h5> <span> <?php // echo Soutra::getCompterFournisseurEntrepot($_SESSION['id_entrepot']); ?></span></h5>
      </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xl-3">
      <div class="card stat-card">
        <div class="icon bg-dark"><i class="fas fa-user-cog"></i></div>
        <h6 class="montan-title">EMPLOYERS</h6>
        <h5><span><?php // echo Soutra::getCompterEmployeEntrepot($_SESSION['id_entrepot']); ?></span></h5>
      </div>
    </div>

  </div>




  <script>
    // Script réutilisable pour tous les boutons toggle
    document.querySelectorAll('.toggle-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        setTimeout(() => {
          if (this.getAttribute('aria-expanded') === 'true') {
            this.textContent = '−';
          } else {
            this.textContent = '+';
          }
        }, 200); // petit délai pour que bootstrap mette à jour aria-expanded
      });
    });
  </script>

