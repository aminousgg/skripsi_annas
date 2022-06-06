
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title><?= $title ?></title>

    <!-- Bootstrap -->
    <link href="<?= base_url('assets') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url('assets') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url('assets') ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?= base_url('assets') ?>/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?= base_url('assets') ?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?= base_url('assets') ?>/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="<?= base_url('assets') ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="<?= base_url('assets') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets') ?>/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets') ?>/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url('assets') ?>/build/css/custom.min.css" rel="stylesheet">


</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <!-- sidebar menu -->
                <?php $this->load->view("layout/sidebar") ?>
                <!-- //sidebar menu -->
            </div>

            <!-- top navigation -->
            <?php $this->load->view("layout/navbar") ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3><?= $title ?></h3>
						</div>

					</div>
					<div class="clearfix"></div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12  ">
                            <div class="x_panel tile overflow_hidden">
                                <div class="x_title">
                                    <h2><?= $sub_title ?></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="display: block;">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Pengajuan Barang</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <?= form_open('pengajuan/create') ?>
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Nama Barang</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" class="form-control" name="nama_barang" >
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Jumlah Barang</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="jumlah" class="form-control" name="jumlah">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Satuan Barang</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" class="form-control" name="satuan">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Harga Satuan Barang</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" class="form-control" name="harga_barang">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Pegawai yang mengajukan</label>
                                                            </div>
                                                            <?php if($this->session->userdata('sesi')['user_id']!="1"){ ?>
                                                                <div class="col-md-8 form-group">
                                                                    <select name="pegawai_id" class="form-control s_pegawai">
                                                                        <option value="">-- Pilih --</option>
                                                                        <?php $pegawais = $this->db->get('pegawai')->result(); ?>
                                                                        <?php foreach($pegawais as $pegawai){ ?>
                                                                            <option value="<?= $pegawai->pegawai_id ?>"><?= $pegawai->nama_pegawai ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            <?php }else{ $pgw = $this->db->get_where('pegawai', ['user_id'=>$this->session->userdata('sesi')['user_id']])->row_array() ?>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" class="form-control" value="<?= $pgw['nama_pegawai'] ?>" disabled>
                                                                    <input type="hidden" name="pegawai_id" value="<?= $pgw['pegawai_id'] ?>">
                                                                </div>
                                                            <?php } ?>
                                                            <div class="col-md-4">
                                                                <label>Keterangan</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <textarea name="keterangan" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                            </div>
                                                            <div class="col-sm-12 d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-primary me-1 mb-1">Kirim</button>
                                                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?= form_close() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

				</div>
			</div>
            <!-- /page content -->

            <!-- footer content -->
            <?php $this->load->view("layout/footer") ?>
            <!-- /footer content -->
        </div>
    </div>
    <!-- jQuery -->
    <script src="<?= base_url('assets') ?>/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url('assets') ?>/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url('assets') ?>/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url('assets') ?>/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?= base_url('assets') ?>/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?= base_url('assets') ?>/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?= base_url('assets') ?>/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?= base_url('assets') ?>/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?= base_url('assets') ?>/vendors/skycons/skycons.js"></script>

    <script src="<?= base_url('assets') ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?= base_url('assets') ?>/build/js/custom.min.js"></script>

    <script>
        $( document ).ready(function() {
            $(".s_pegawai").select2();
        });
    </script>

</body>

</html>
