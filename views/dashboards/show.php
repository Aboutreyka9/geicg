<h4>Dashboard</h4>

<div class="row">
    <div class="col-md-4">
        <div class="card text-bg-success">
            <div class="card-body">
                <h6>Ventes du jour</h6>
                <h3><?= number_format($data['totalSales']) ?> FCFA</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h6>Total produits</h6>
                <h3><?= $data['totalProducts'] ?></h3>
            </div>
        </div>
    </div>
</div>

<h5 class="mt-4">Produits en stock faible</h5>
<table class="table table-bordered">
    <tr>
        <th>Produit</th>
        <th>Stock</th>
    </tr>
    <?php foreach ($data['lowStock'] as $p): ?>
        <tr>
            <td><?= $p['name'] ?></td>
            <td class="text-danger"><?= $p['stock'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>