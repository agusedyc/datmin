<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'UTD PMI Semarang';
?>
<div class="site-index">

    <!-- <div class="jumbotron"> -->
        
        <!-- <h1>Donor Darah</h1> -->

        <!-- <p class="lead">Donor Darah Bagi Kesehatan Jantung...</p> -->

        <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
    <!-- </div> -->


    <div class="body-content">
        <div class="row">
            <div class="col-md-12" align="center">
                <?php echo Html::img('@web/uploads/images/share-blood.jpg', ['class' => 'img-responsive','id'=>'image-header']); ?>
                <!-- <img src="http://www.pmimedan.or.id/sites/default/files/top_image/share-blood.jpg" alt=""> -->
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        FAQ's
                    </div>
                    <div class="panel-body">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="">Mengapa Harus Bayar Saat Kita Butuh Darah dari PMI ?</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" style="">
                                    <div class="panel-body">
                                        Biaya yang kita keluarkan perkantong darah sebenarnya adalah biaya penggantian pemeliharaan darah, supaya kondisinya tetap sama seperti saat berada dalam tubuh kita.&nbsp;Biaya ini yang kita kenal dgn nama <b>"BPPD"</b> atau Biaya Penggantian Pengelolaan Darah.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">Mengapa Kita Perlu Donor Darah ?</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">
                                        <b>Kebutuhan yang besar :</b> Setiap delapan detik, ada satu orang yang membutuhkan transfusi darah di Indonesia. <br><b>Pemeriksaan kesehatan gratis :</b> Sebelum mendonorkan darah, petugas akan memeriksa suhu tubuh, denyut nadi, tekanan darah dan kadar hemoglobin Anda. <br><b>Tidak menyakitkan :</b> Ya Anda memang akan merasa sakit. Namun, rasa sakit itu tidak seberapa dan akan hilang dengan cepat.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed">Kenapa Ketika Membutuhkan Darah Prosesnya Lama ?</a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Proses permintaan darah transfusi di Palang Merah Indonesia (PMI) memerlukan proses <b>"Crossmatch"</b> yaitu uji serasi silang antara darah pasien dengan darah donor yang diberikan. Crossmatch ini bertujuan untuk melihat apakah darah pasien sesuai dengan darah donor sehingga tidak ada efek yang merugikan pasien transfusi darah tersebut.Secara keseluruhan darah pendonor baru siap diberikan kepada seseorang itu butuh waktu paling lama sekitar 3  jam
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class="collapsed">Apa Yang Harus Kita Persiapkan Sebelum Donor ?</a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Kita memerlukan tidur yang nyenyak di malam sebelum mendonor, sarapan pagi atau makan siang sebelum mendonor. Banyak minum seperti jus, susu sebelum mendonor. Rileks saat mendonor, dan banyak minum setelah mendonor. Kita bisa melanjutkan kegiatan setelah mendonor, asal hindari aktivitas fisik yang berat.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a href="#">
                        <img src="http://ayodonor.pmi.or.id/images/1.jpg" width="400px" height="433px" border="none">
                    </a>
                </div>

            </div>
    </div>
</div>
