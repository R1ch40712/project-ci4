<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/style2.css">
</head>

<body id="home">
    <?= $this->include('templates/navbar'); ?>
    <!-- mencetak section yang diambil dari halaman yang menggunakan content  -->
    <?= $this->renderSection('content'); ?>
    <!-- end section -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function preview() {
            const sampul = document.querySelector('#sampul');
            const sampulLabel = document.querySelector('.sampul-label');
            const imgPreview = document.querySelector('.img-preview');

            // untuk tulisan label,mengambil dari file yang diupload
            sampulLabel.textContent = sampul.files[0].name;

            // mengambil file yang di upload
            // readasdataurl mengambil alamat data penyimpanannya
            const fileSampul = new FileReader();
            fileSampul.readAsDataURL(sampul.files[0]);

            fileSampul.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>
</body>

</html>