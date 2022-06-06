
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
                                    <table class="table table-hovered t_pengajuan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Pegawai</th>
                                                <th>Divisi</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <?php if($this->session->userdata('sesi')['user_id']!="1"){ ?>
                                                    <th>&nbsp;</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($this->session->userdata('sesi')['user_id']!="1")
                                                {
                                                    $pengajuan = $this->db->select('*')
                                                    ->from('pengajuan p')
                                                    ->join('barang b','p.kode_barang = b.kode_barang','left')
                                                    ->join('pegawai pg','p.pegawai_id = pg.pegawai_id','left')
                                                    ->join('divisi d', 'pg.divisi_id = d.divisi_id', 'left')
                                                    ->get()->result();
                                                }
                                                else
                                                {
                                                    $pengajuan = $this->db->select('*')
                                                    ->from('pengajuan p')
                                                    ->join('barang b','p.kode_barang = b.kode_barang','left')
                                                    ->join('pegawai pg','p.pegawai_id = pg.pegawai_id','left')
                                                    ->join('divisi d', 'pg.divisi_id = d.divisi_id', 'left')
                                                    ->where('pg.user_id', $this->session->userdata('sesi')['user_id'])
                                                    ->get()->result();
                                                }
                                            ?>
                                            <?php $i = 1; foreach($pengajuan as $row){ ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $row->tanggal ?></td>
                                                    <td><?= $row->kode_barang ?></td>
                                                    <td><?= $row->nama_barang ?></td>
                                                    <td><?= $row->nama_pegawai ?></td>
                                                    <td><?= $row->nama_divisi ?></td>
                                                    <td><?= $row->jumlah ?> <?= $row->satuan ?></td>
                                                    <td><?= "Rp " . number_format((int)$row->harga,2,',','.'); ?></td>
                                                    <?php
                                                    $t_status = "";
                                                    if($row->status == "Active"){
                                                        $t_status = "success";
                                                        $s = "Terima";
                                                    }elseif($row->status == "Pengajuan"){
                                                        $t_status = "warning";
                                                        $s = "Pengajuan";
                                                    }elseif($row->status == "In Active"){
                                                        $t_status = "danger";
                                                        $s = "Tolak";
                                                    }
                                                    ?>
                                                    <td><span class="badge badge-<?= $t_status ?>"><?= $s ?></span></td>
                                                    <?php if($this->session->userdata('sesi')['user_id']!="1"){ ?>
                                                        <td>
                                                            <?php if($row->status == "Active" || $row->status == "In Active"){ ?>
                                                                
                                                            <?php }else{ ?>
                                                                <button data-toggle="modal" data-target="#m_terima" data-id="<?= $row->barang_id ?>" class="btn btn-outline-success btn-sm t_terima">Terima</button>
                                                                <button data-toggle="modal" data-target="#m_tolak" data-id="<?= $row->barang_id ?>" class="btn btn-outline-danger btn-sm t_tolak">Tolak</button>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php $i++; } ?>
                                        </tbody>
                                    </table>
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
            <div class="modal fade" id="m_terima" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <?= form_open('pengajuan/terima') ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Terima Barang ini?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label>Masukan Kode Barang Sebagai Asset</label>
                                <input type="text" class="form-control" name="kode_barang" required>
                                <label>Set Golongan</label>
                                <select name="golongan_id" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach($this->db->get('golongan')->result() as $gol){ ?>
                                        <option value="<?= $gol->golongan_id ?>"><?= $gol->nama_golongan ?></option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" name="status" value="Active">
                                <input type="hidden" id="id_barang" name="id" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="m_tolak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <?= form_open('pengajuan/tolak') ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tolak Pengajuan Barang ini?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="status" value="In Active">
                                <input type="hidden" id="id_barang_tolak" name="id" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
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

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url('assets') ?>/build/js/custom.min.js"></script>

    <script>
        $( document ).ready(function() {
            $(".t_pengajuan").dataTable({
                ordering : false
            });
            $(document).on('click', '.t_terima', function(){
                var id = $(this).data('id');
                // alert(id);
                $("#id_barang").val(id);
            });
            $(document).on('click', '.t_tolak', function(){
                var id = $(this).data('id');
                $("#id_barang_tolak").val(id);
            });
        });
    </script>

</body>

</html>
