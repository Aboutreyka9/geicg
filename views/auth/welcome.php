


<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="">G-STOCK</a>
      <?php if(auth()->check()):  ?>
      <a href="<?= route('page1',['val' =>25]) ?>" class="btn btn-outline-primary text-white"> Mon Espace  </a>
      <?php else: ?>
      <a href="<?= route('login')?>" class="btn btn-outline-primary text-white"> Espace connexion </a>
      <?php endif ?>
      

      
    </div>
  </nav>
</header>
<main>

<div id="carouselExampleFade" class="carousel slide carousel-fade image-back" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img height="720" src="<?= ASSETS ?>guest/images/h1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img height="720" src="<?= ASSETS ?>guest/images/h2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img height="720" src="<?= ASSETS ?>guest/images/h3.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
 
</div> 


<div class="container mt-5">
 
 <div class="row">
  <?php 
  if ($q->rowCount() > 0) {
    while($categorie = $q->fetch()){ ?>
      <div class="card col-md-4">
    <img src="assets/images/categorie/<?= $categorie['image_categorie']?>" class="card-img-top" alt="...">
    <div class="card-body text-center">
      <h5 class="card-title"><?= $categorie['libelle_categorie']?> 
      <span>*</span>
      <span>*</span>
      <span>*</span>
    </h5>
    <p class="m-0"> <?= number_format($categorie['prix_categorie'],2)?> FCFA</p>
      <p class="card-text text-muted">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>
    <?php }
  }
  ?>
</div>
 </div>


</main>