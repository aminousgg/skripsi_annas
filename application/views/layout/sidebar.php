<?php $sesi = $this->session->userdata('sesi') ?>
<div class="left_col scroll-view">
    <div class="navbar nav_title my-3 hidden-small" style="border: 0; padding-top: 10px;">
        <img src="<?= base_url('assets/images/user.png') ?>" alt="..." class="profile_img"
        style="max-width: 100px; margin-left: 0px !important; margin: auto !important; border-radius: 10px">
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="mt-3 hidden-small">
        <div class="profile_info" style="text-align: center; margin: auto !important; float: none !important;">
            <h6 style="m-0">
                <?php $pg = $this->db->get_where('pegawai', ['user_id'=>$this->session->userdata('sesi')['user_id']])->row_array(); ?>
                <?= $pg['nama_pegawai'] ?>
            </h6>
            <b class="text-light"><?= $this->session->userdata('sesi')['nama_role'] ?></b>
        </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">

            <ul class="nav side-menu">
                <li>
                    <a href="<?= base_url() ?>"><i class="fa fa-home"></i> Dashboard </a>
                </li>
                <!-- <li>
                    <a href="<?= base_url('data_assets') ?>"><i class="fa fa-folder"></i> Input Assets Barang </a>
                </li> -->
                <?php if($this->session->userdata('sesi')['role_id'] == 1){ ?>
                    <li>
                        <a href="<?= base_url('barang') ?>"><i class="fa fa-folder"></i> Data Assets Barang </a>
                    </li>
                    <li>
                        <a><i class="fa fa-folder"></i> Nilai Depresiasi  <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?= base_url('nilai/gol_1') ?>">Golongan I - II</a></li>
                            <li><a href="<?= base_url('nilai/gol_up') ?>">Golongan III - V</a></li></li>
                        </ul>
                    </li>
                <?php } ?>
                <li>
                    <a href="<?= base_url('pengajuan') ?>"><i class="fa fa-folder"></i> Data Pengajuan </a>
                </li>
                <li>
                    <a href="<?= base_url('pengajuan/input') ?>"><i class="fa fa-folder"></i> Input Pengajuan </a>
                </li>
                <li>
                    <a href="<?= base_url('main/logout') ?>"><i class="fa fa-sign-in"></i> Logout </a>
                </li>
            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>
