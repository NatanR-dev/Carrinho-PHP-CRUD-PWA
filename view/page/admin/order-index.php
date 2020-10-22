<div class="container">
    <div class="row">
        <div class="col s12 m4 l3 m-b-1">
            <a class="waves-effect waves-light btn blue lighten-2 btn-block" href="<?=baseurl('admin/product')?>">
                <i class="material-icons left">assignment</i>Produtos
            </a>
        </div>
        <div class="col s12 m4 l3 m-b-1">
            <a class="waves-effect waves-light btn blue lighten-2 btn-block" href="<?=baseurl('admin/category')?>">
                <i class="material-icons left">border_all</i>Categorias
            </a>
        </div>
        <div class="col s12 m4 l3 m-b-1">
            <a class="waves-effect waves-light btn blue lighten-2 btn-block" href="<?=baseurl('admin/order')?>">
                <i class="material-icons left">receipt</i>Lista de Pedidos
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <?php if (count($orders) > 0) : ?>
                <h5 class="grey-text">Lista de Pedidos</h5>
                <ul class="collection">
                    <?php foreach($orders as $key => $order) : ?>
                        <li class="collection-item">
                            <div class="secondary-content">
                                <a href="<?=baseurl('admin/order/'.$order['id'])?>" class="materialize-tooltip" data-position="right" data-tooltip="Order Detail"><i class="material-icons blue-text text-lighten-1">chevron_right</i></a>
                            </div>
                            <small class="order-date bold"><?=date('d F Y', strtotime($order['created_at']))?></small>
                            <br>
                            <div>Nome : <span class="order-name bold"><?=$order['name']?></span></div>
                            <div>Endereço : <span class="order-address"><?=$order['address']?></span></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <h5 class="grey-text">Nenhuma Lista de Pedido</h5>
            <?php endif; ?>
        </div>
    </div>
</div>