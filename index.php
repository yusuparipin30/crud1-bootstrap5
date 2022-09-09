<?php
  //koneksi database(1)
  $server = "localhost";
  $user = "root";
  $password = "";
  $database = "crudbarang_db";

  //buat koneksi(2)
  $koneksi = mysqli_connect($server, $user, $password, $database) or die (mysqli_error($koneksi));

  //melakukan input melalui web dan menyimpannya(5)
  //jika tombol simpan di klik
  if(isset($POST['bsimpan'])){

  //data akan di simpan baru(6)
  $simpan = mysqli_query($koneksi, "INSERT IN TO tbarang(kode, nama, asal, jumlah, satuan, tanggal_diterima)
                                    VALUE ( '$POST[tkode]',
                                            '$POST[tnama]',
                                            '$POST[tasal]',
                                            '$POST[tjumlah]',
                                            '$POST[tsatuan]',
                                            '$POST[ttanggal_diterima]')
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
        <h3 class="text-center">Mtwo Code</h3>


        <!-- start row -->
        <div class="row">
            <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-success text-light">
                    Form input data barang
                </div>
                <div class="card-body">
                   <!-- start form -->
                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="tkode" class="form-control"  placeholder="masukan kode barang">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="tnama" class="form-control"  placeholder="masukan nama barang">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asal Barang</label>
                            <select class="form-select" name="tasal">
                                <option>-Pilih-</option>
                                <option value="gudang">Gudang</option>
                                <option value="cm-silinder">Cm-silinder</option>
                            </select>
                        </div>

                        <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah</label>
                                        <input type="number" name="tjumlah" class="form-control"  placeholder="masukan jumlah barang">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Satuan</label>
                                        <select class="form-select" name="tsatuan">
                                            <option>-Pilih-</option>
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
                                        <input type="date" name="ttanggal_diterima" class="form-control"  placeholder="masukan tanggal">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <hr>
                                    <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
                                    <button class="btn btn-danger" name="bkosongksn" type="reset">Kosongkan</button>
                                </div>

                        </div>
                        

                    </form>
                   <!-- end form -->
                </div>
                <div class="card-footer bg-success">
                    
                </div>
                </div>
            </div>
        </div>
                    <!-- mt-3(margin-top) -->
        <div class="card mt-3">
                <div class="card-header bg-success text-light">
                    Data barang
                </div>
                <div class="card-body">

                <div class="col-md-6 mx-auto">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="text" name="tcari" class="form-control" placeholder="masukan kata kunci">
                            <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                            <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                        </div>
                    </form>
                </div>

                   <table class="table table-striped table-hover table-bordered">
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
                        $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang order by id_barang desc");
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
                        <td>
                            <a href="#" class="btn btn-warning">Edit</a>
                            <a href="#" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                            <!-- looping penutup meggunakan endwhile(4) -->
                    <?php endwhile; ?> 

                   </table>
                </div>
                <div class="card-footer bg-success">
                    
                </div>
                </div>
            </div>

        <!-- end row -->

    </div>

    <!-- end container -->












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>