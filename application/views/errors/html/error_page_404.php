<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<div class="main_container">
    <!-- page content -->
    <div class="col-md-12">
        <div class="col-middle">
            <div class="text-center text-center">
                <h1 class="error-number">404</h1>
                <h2>Maaf kami tidak bisa menemukan halaman yang anda cari</h2>
                <p>
                    Halaman yang anda cari tidak ada <a href="<?php echo base_url('administrator/home'); ?>">Kembali</a>
                </p>
                <div class="mid_center">
                    <h3>Cari</h3>
                    <form>
                        <div class="col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Tulis Pencarian...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Cari!</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
</div>