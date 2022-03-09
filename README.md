# Documentation

1. clone
2. import file database
3. install / update composer : php ~/composer.phar require cboden/ratchet
4. cek file di dalam folder /src 
    ada 4 hal dasar class yang dibutuhkan dalam aplikasi, 4 event yang akan di listen :
    -onOpen --> dipanggil saat ada user yang terkoneksi.
    -onMessage --> dipanggil saat pesan diterima dalam koneksi
    -onClose --> dipanggil saat koneksi ditutup
    -onError --> dipanggil saat error terjadi

5. bagian yang penting yakni server, yang berada pada folder /bin/server.php
    yang berisi kurang lebih akan seperti ini :

    <?php
        use Ratchet\Server\IoServer;
        use MyApp\Chat;

        require dirname(__DIR__) . '/vendor/autoload.php';

        $server = IoServer::factory(
            new Chat(),
            8080
        );

        $server->run();

pada file ini yang akan di run, untuk membuka server.

6. untuk membuka server bisa kita mengetikan php /bin/server.php
7. jalankan aplikasi


## Author

-[@farhan11anh](https://github.com/farhan11anh)
