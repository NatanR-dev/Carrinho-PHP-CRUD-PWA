<div class="container">
    <div class="row">
        <div class="col s12 m4 l3 m-b-1">
            <a class="waves-effect waves-light btn blue lighten-2 btn-block" href="<?=baseurl('admin/product/create')?>">
                <i class="material-icons left">add</i>Novo Produto
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
            <?php if (count($products) > 0) : ?>
                <h5 class="grey-text">Lista de Produtos</h5>
                <ul class="collection">
                    <?php foreach($products as $key => $product) : ?>
                        <li class="collection-item avatar">
                            <img src="<?=getImage($product['images'])?>" alt="<?=$product['slug']?>" class="circle">
                            <b><span class="title bold"><?=$product['name']?></span></b>
                            <br/>
                            <small class="category">Categoria : <b><?=$product['category_name']?></b></small>
                            <br>
                            <small class="quantity">Estoque : <b><?=number_format($product['quantity'])?></b></small>
                            <br>
                            <small class="price">Preço : <b>R$ <?=number_format($product['price'])?></b></small>
                            <div class="secondary-content">
                                <a href="<?=baseurl('admin/product/edit/'.$product['id'])?>"><i class="material-icons blue-text text-lighten-1">edit</i></a>
                                <a href="<?=baseurl('admin/product/delete/'.$product['id'])?>"><i class="material-icons red-text text-lighten-2">delete</i></a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <h5 class="grey-text">Não há nenhuma Lista de Produtos</h5>
            <?php endif; ?>
        </div>
    </div>
</div>