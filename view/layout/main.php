<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title><?= $_VIEW['title'] ?></title>
    <link rel="shortcut icon" href="<?= baseurl('public/icon.ico') ?>" type="image/x-icon" />
    <meta name="robots" content="noindex, nofollow">
    <link href="<?= baseurl('public/assets/materialize/icon.css?family=Material+Icons') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= baseurl('public/assets/materialize/materialize.min.css') ?>">
    <link rel="stylesheet" href="<?= baseurl('public/assets/w3/w3.css') ?>">
    <link rel="stylesheet" href="<?= baseurl('public/assets/style.css') ?>">
    <link rel="manifest" href="pwa/manifest.json" />
    <script src="pwa/pwa.dev.min.js"></script>
    <script>
        if (navigator.serviceWorker) {
            navigator.serviceWorker.register('pwa/sw.js')
        }
    </script>
</head>

<body>
    <!-- Menu de Navegação -->
    <nav class="blue accent-3 text-space" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="<?= baseurl() ?>" class="brand-logo">Sua Loja</a>
            <!-- Main Menu -->
            <ul class="right hide-on-med-and-down">
                <li>
                    <a href="<?= baseurl('admin/product') ?>">
                        <span class="material-icons">store</span>
                    </a>
                </li>
                <li><a href="<?= baseurl('cart') ?>"><i class="material-icons">shopping_cart</i></a></li>
            </ul>
            <!-- Mobile Menu -->
            <ul id="nav-mobile" class="sidenav">
                <li><a href="<?= baseurl('cart') ?>">Carrinho <i class="material-icons">shopping_cart</i></a></li>
                <li><a href="<?= baseurl('admin/product') ?>">Admin <i class="material-icons">people</i></a></li>
            </ul>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <!-- Final - Menu de Navegação -->
    <div class="main-container">
        <!-- Main Content começa aqui -->
        <?php include($_VIEW['page']) ?>
        <!-- Final do Main  Content termina aqui -->
    </div>

    <!-- Footer começa aqui... -->

    <footer class="page-footer blue darken-4">
        <div class="container">
            <div class="row">
                <div class="col l8 s12">
                    <h5 class="white-text text-space">PHP CRUD | Sua Loja</h5>
                    <p class="grey-text text-lighten-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis urna nibh, sit amet maximus nisl semper at.</p>
                </div>
                <div class="col l4 s12 text-space">
                    <h5 class="white-text">Menu</h5>
                    <ul class="menu-footer">
                        <li><a class="white-text" href="<?= baseurl('admin/product') ?>">Produto</a></li>
                        <li><a class="white-text" href="<?= baseurl('admin/category') ?>">Categoria</a></li>
                        <li><a class="white-text" href="<?= baseurl('admin/order') ?>">Pedido</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <div class="icons8-github"></div><a link href="http://github.com/NatanR-dev" target=”_blank”>NatanR-dev</a> © 2020 | Todos os Direitos Reservados
            </div>
        </div>
    </footer>

    <!-- Footer termina aqui... -->

    <!-- Scripts-->
    <script type="text/javascript" src="<?= baseurl('public/assets/jquery/jquery-3.4.1.min.js') ?>"></script>
    <script type="text/javascript" src="<?= baseurl('public/assets/materialize/materialize.min.js') ?>"></script>
    <script type="text/javascript" src="<?= baseurl('public/assets/main.js') ?>"></script>
    <!--Scripts-->
</body>

</html>
