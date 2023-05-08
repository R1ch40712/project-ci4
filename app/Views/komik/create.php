<?= $this->extend('templates/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-2">Form Tambah Data Komik</h2>

            <form action="/komik/save" method="post" enctype="multipart/form-data">
                <!--untuk menjaga form hanya dapat diisi dihalaman ini saja  -->
                <?= csrf_field(); ?>
                <!-- end -->
                <div class="form-group row mb-2">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (validation_show_error('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= old('judul'); ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('judul'); ?>
                        </div>

                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (validation_show_error('penulis')) ? 'is-invalid' : ''; ?>" id="penulis" name="penulis" value="<?= old('penulis'); ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('penulis'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (validation_show_error('penerbit')) ? 'is-invalid' : ''; ?>" id="penerbit" name="penerbit" value="<?= old('penerbit'); ?>">
                        <div class="invalid-feedback">
                            <?= validation_show_error('penerbit'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="row">
                        <label for="sampul" class="col-sm-2 col-form-label sampul-label">Sampul</label>
                        <div class="col d-flex">
                            <div class="col-sm-2">
                                <img src="/assets/image/default.png" class="img-thumbnail img-preview" alt="">
                            </div>
                            <div class="col-sm-10 mx-4">
                                <input class="form-control <?= (validation_show_error('sampul')) ? 'is-invalid' : ''; ?>" type="file" id="sampul" name="sampul" onchange="preview()">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('sampul'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>