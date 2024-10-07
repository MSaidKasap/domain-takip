
<style>
.brand-link {
    display: flex;
    justify-content: center;
    align-items: center;
}

.logo {
    width: 100px;
    height: auto;
}

.nav-treeview {
    padding-left: 15px;
}

.session-container {
    border: 2px solid #007bff;
    border-radius: 25px;
    padding: 10px;
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: rgb(128, 128, 128);
    
}
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
    <div style="display: flex; justify-content: center; align-items: center;">
    <img src="assets/img/logo.png" alt="Wm" style="width: 100px; height: auto;">
</div>

    </a>
    <div class="session-container">
        <?php require_once 'components/session.php';
        require_once 'components/header.php'; ?>

    </div>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview menu-open">
                    <a href="index.php" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Panel
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            Web Siteleri
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="list_websites.php" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Web Sitelerini Listele</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="add_website.php" class="nav-link">
                                <i class="nav-icon fas fa-plus-circle"></i>
                                <p>Web Sitesi Ekle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="plesk-api.php" class="nav-link">
                                <i class="nav-icon fas fa-link"></i>
                                <p>Plesk Site Çek</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cpanel_api.php" class="nav-link">
                                <i class="nav-icon fas fa-link"></i>
                                <p>Cpanel Site Çek</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Müşteriler
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="list_customers.php" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Müşterileri Listele</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="add_customer.php" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Müşteri Ekle</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-building"></i> <!-- Firma simgesi -->
                        <p>
                            Firmalar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="registrars.php" class="nav-link">
                                <i class="nav-icon fas fa-list"></i> <!-- Liste simgesi -->
                                <p>Listele</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="registrars_add.php" class="nav-link">
                                <i class="nav-icon fas fa-plus-circle"></i> <!-- Yeni ekle simgesi -->
                                <p>Yeni Ekle</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Ayarlar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="panel_settings.php" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>Panel Ayarları</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="edit_users.php" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Kullanıcı Profili</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="api_settings.php" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Api Ayarları</p>
                            </a>
                        </li>
                    </ul>

                </li>
                <form action="logout.php" method="post">
                    <p style="text-align: center;">
                        <!-- Butonu ortalamak için p etiketi ekledik -->
                        <button type='submit' class='btn btn-danger' name='save_domains'
                            style='padding: 5px 5px; font-size: 12px;'>Çıkış Yap</button>
                    </p>
                </form>
            </ul>
        </nav>
    </div>
</aside>

<script>
$(document).ready(function() {
    $('.nav-item.has-treeview > a').on('click', function(e) {
        e.preventDefault();
        var $parent = $(this).parent();
        if ($parent.hasClass('menu-open')) {
            $parent.removeClass('menu-open');
            $parent.find('.nav-treeview').slideUp();
        } else {
            $parent.addClass('menu-open');
            $parent.find('.nav-treeview').slideDown();
        }
    });
});

</script>