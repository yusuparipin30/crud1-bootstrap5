<?php
  //koneksi database(1)
  $server = "localhost";
  $user = "root";
  $password = "";
  $database = "crudbarang_db";

  //buat koneksi(2)
  $koneksi = mysqli_connect($server, $user, $password, $database) or die (mysqli_error($koneksi));


  //membuat kode otomatis
    $q = mysqli_query($koneksi, "SELECT kode FROM tbarang order  by kode desc limit 1");
    $datax = mysqli_fetch_array($q);
    if($datax) {
        $no_terakhir = substr($datax['kode'], -3);
        $no = $no_terakhir + 1;

        if($no > 0 and $no < 10) {
            $kode = "00" . $no;
        }else if($no > 10 and $no  < 100){
            $kode = "0" . $no;
        }else if($no >100){
            $kode = $no;
        }
    }else{
            $kode = "001";
        }
        $tahun = date('Y');
        $vkode = "SFP-" . $tahun . '-' . $kode;
        //SFP-2022-001
   


  //melakukan input melalui web dan menyimpannya(5)
  //jika tombol simpan di klik
  if(isset($_POST['bsimpan'])){

    //pengujian apakah data akan di edit atau di simpan baru?(16)
    if (isset($_GET['hal']) == "edit"){
        //data akan di edit
        $edit = mysqli_query($koneksi, "UPDATE tbarang SET
                                                nama = '$_POST[tnama]',
                                                asal = '$_POST[tasal]',
                                                jumlah = '$_POST[tjumlah]',
                                                satuan = '$_POST[tsatuan]',
                                                tanggal_diterima = '$_POST[ttanggal_diterima]'
                                        WHERE id_barang = '$_GET[id]'
                                        ");
    //uji jika edit sukses
    if($edit){
        //tampilkan pesan alert menggunakan js
                    echo "<script>
                        alert('edit data sukses!');
                        document.location= 'index.php';
                        </script>";
                }else{
                    echo "<script>
                    alert('edit data gagal!');
                    document.location= 'index.php';
                </script>";
                }
    }else{
             //data akan di simpan baru(6) (17)
            $simpan = mysqli_query($koneksi, "INSERT INTO tbarang(kode, nama, asal, jumlah, satuan, tanggal_diterima)
                                                VALUE ( '$_POST[tkode]',
                                                        '$_POST[tnama]',
                                                        '$_POST[tasal]',
                                                        '$_POST[tjumlah]',
                                                        '$_POST[tsatuan]',
                                                        '$_POST[ttanggal_diterima]')
                                                    ");


            //uji jika pesan simpan sukses(7)
            //kondisi bernilai true(tersimpan)
            if($simpan){
            //tampilkan pesan alert menggunakan js
                echo "<script>
                alert('simpan data sukses!');
                document.location= 'index.php';
                </script>";
            }else{
                echo "<script>
                alert('simpan data gagal!');
                document.location= 'index.php';
                </script>";
            }


    }
 }


 //mendeklarasikan variabel yang akan di edit(13)
 $vnama = "";
 $vasal = "";
 $vjumlah = "";
 $vsatuan = "";
 $vtanggal_diterima = "";

 //pengujian apabila tombol edit atau hapus di klik(10)
 //jika halaman di set halaman $_GET hal, maka akan mengambil di url, jika ada hal maka di klik antara tombol edit atau hapus
 if (isset($_GET['hal'])){

    //pengujian jika edit data (11)
    if($_GET['hal'] == "edit"){

        //tampilkan data yang mau di edit(12)
        //tampilkan data tbarang berdasarkan id_barang berupa "id"
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang = '$_GET[id]' ");
        //tampung ke variabek $data(14)
        $data = mysqli_fetch_array($tampil);
        if($data){
            //jika data di temukan ,maka data di tampung ke variabel pendeklarasian(15)
            $vkode = $data['kode'];
            $vnama = $data['nama'];
            $vasal = $data['asal'];
            $vjumlah = $data['jumlah'];
            $vsatuan = $data['satuan'];
            $vtanggal_diterima = $data['tanggal_diterima'];
            //selanjutnya mencetak kedalam textfile database tambahkan "value di input form"
        }
        //HAPUS DATA (18)
    }else if($_GET['hal'] == "hapus"){
        //persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tbarang WHERE id_barang = '$_GET[id]' ");
        //jika pengujian hapus data sukses
        if($hapus){
            //tampilkan pesan alert menggunakan js
                echo "<script>
                alert('hapus data sukses!');
                document.location= 'index.php';
                </script>";
            }else{
                echo "<script>
                alert('hapus data gagal!');
                document.location= 'index.php';
                </script>";
            }
            //tambahkan pesan konfirmasi hapus di link a href hapus(19)---->(20)onclick konfirmasi

    }

 }

?>





<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD MYSQL & BOOTSTRAP5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body>

    <!-- start container -->
    <div class="contaiber">

        <h3 class="text-center">Data inventaris</h3>
        <h3 class="text-center">Kantor Mtwo Code</h3>


        <!-- start row -->
        <div class="row">
            <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-light">
                    Form input data barang
                </div>
                <div class="card-body">
                   <!-- start form -->
                    <form method="POST">

                    <div class="row">

                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Kode Barang</label>
                                <input type="text" name="tkode" value="<?= $vkode ?>" class="form-control"  placeholder="masukan kode barang">
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="tnama" value="<?= $vnama ?>" class="form-control"  placeholder="masukan nama barang">
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Asal Barang</label>
                                <select class="form-select" name="tasal">
                                    <option value="<?= $vasal ?>"><?= $vasal ?></option>
                                    <option value="gudang">Gudang</option>
                                    <option value="cm-silinder">Cm-silinder</option>
                                </select>
                            </div>
                        </div>
                    </div>

                        <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah</label>
                                        <input type="number" name="tjumlah" value="<?= $vjumlah ?>" class="form-control"  placeholder="masukan jumlah barang">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Satuan</label>
                                        <select class="form-select" name="tsatuan">
                                        <option value="<?= $vsatuan ?>"><?= $vsatuan ?></option>
                                            <option value="unit">Unit</option>
                                            <option value="kotak">Kotak</option>
                                            <option value="pcs">PCS</option>
                                            <option value="pak">Pak</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Di Terima</label>
                                        <input type="date" name="ttanggal_diterima" value="<?= $vtanggal_diterima ?>" class="form-control"  placeholder="masukan tanggal">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <hr>
                                    <button class="btn btn-success" name="bsimpan" type="submit">Simpan</button>
                                    <button class="btn btn-danger" name="bkosongksn" type="reset">Kosongkan</button>
                                </div>

                        </div>
                        

                    </form>
                   <!-- end form -->
                </div>
                <div class="card-footer bg-primary">
                    
                </div>
                </div>
            </div>
        </div>
                    <!-- mt-3(margin-top) -->
        <div class="card mt-3">
                <div class="card-header bg-primary text-light">
                    Data barang
                </div>
                <div class="card-body">

                <div class="col-md-6 mx-auto">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="text" name="tcari" value="<?= @$_POST['tcari'] ?>" class="form-control" placeholder="masukan kata kunci">
                            <button class="btn btn-success" name="bcari" type="submit">Cari</button>
                            <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                        </div>
                    </form>
                </div>

                   <table class="table table-striped table-hover table-bordered bg-light">
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Asal Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Di Terima</th>
                        <th>Aksi</th>
                    </tr>

                    <?php

                        //persiapan menampilkan data dari input data base(3)
                        $no = 1;

                        //UNTUK PENCARIAN DATA(21)
                        //jika tombol cari di klik
                        if(isset($_POST['bcari'])){
                            //kita tampilkan data yang di cari caranya deklarasikan dahulu variabel $keyword
                            //variabel keyword akan menampung dari stringpost tcari
                            $keyword = $_POST['tcari'];
                            //kita tamung ke variabel $q
                            $q = "SELECT * FROM tbarang WHERE kode like '%$keyword%' or nama like '%$keyword%' or asal like '%$keyword%' order by id_barang desc ";
                        }else{
                            //variabel $q untuk menapung/menampilka hasil pencarian
                            $q =  "SELECT * FROM tbarang order by id_barang desc";
                        }
                                //eksekusi cari, variabel tampil mengeksekusi variabel $q (22) tambahkan value tcari di input type
                                //lanjutan(3)
                        $tampil = mysqli_query($koneksi, $q);
                        //looping(4)
                        //looping menggunakan while,siapkan string data($data) dan siapkan (mysqli_fetch_array) dari string tampil
                        while($data = mysqli_fetch_array($tampil)) :
                    
                    ?>
                    <!-- tr adalah yang mau di looping -->
                    <tr>
                        <!-- penomoran increment -->
                        <td><?= $no++ ?></td>
                        <td><?= $data['kode'] ?></td>
                        <td><?= $data['nama'] ?></td>
                        <td><?= $data['asal'] ?></td>
                        <td><?= $data['jumlah'] ?> <?= $data['satuan'] ?></td>
                        <td><?= $data['tanggal_diterima'] ?></td>
                        <td class="text-center">
                            <!-- edit data (8) -->
                            <!-- arahkan kelink index.php perihal edit, kemudian edit berdasarkan id ,tampilkan dari $data
                                 lalu ambil dari tabel id_barang di database -->
                            <a href="index.php?hal=edit&id=<?= $data['id_barang'] ?>" class="btn btn-warning">Edit</a>
                            <!-- hapus data (9)  20-->
                            <a href="index.php?hal=hapus&id=<?= $data['id_barang'] ?>" class="btn btn-danger"
                             onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                            <!-- looping penutup meggunakan endwhile(4) -->
                    <?php endwhile; ?> 

                   </table>
                </div>
                <div class="card-footer bg-primary">
                    
                </div>
                </div>
            </div>

        <!-- end row -->

    </div>

    <!-- end container -->












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>