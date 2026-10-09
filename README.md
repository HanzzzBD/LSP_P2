# Pemesanan Alat Tulis Kantor

## Deskripsi Program

Program ini digunakan untuk mencatat pemesanan alat tulis kantor. Pengguna harus mengisi nama pelanggan, nomor HP, jenis barang, dan jumlah barang. Program akan menghitung total biaya dan menyimpan pesanan ke file JSON.

Program dibuat menggunakan PHP, HTML, CSS, dan Bootstrap. Data disimpan di `data/data_pemesanan.json`, sehingga tidak membutuhkan database.

## Cara Menjalankan

1. Siapkan Laragon/xampp yang sudah memiliki PHP.
2. Simpan folder program di `C:\laragon\www\PemesananAlatTulisKantor` atau di `C:\xampp\htdocs\PemesananAlatTulisKantor` .
3. Buka Laragon, lalu klik **Start All**.
4. Buka `http://localhost/PemesananAlatTulisKantor/` di browser.

## Cara Menggunakan

1. Isi **Nama Pelanggan** dan **No Hp**.
2. Pilih **Jenis Barang** yang ingin dipesan.
3. Masukkan **Jumlah Barang**.
4. Klik tombol **Kirim Pemesanan**.
5. Rincian pesanan dan total tagihan akan ditampilkan. Pesanan yang tersimpan dapat dilihat pada tabel **Data Pemesanan**.

## Fitur

- Pilihan barang berupa buku, pulpen, pensil, dan penghapus.
- Pilihan jenis barang diurutkan berdasarkan abjad atau ascending.
- Total biaya dihitung dari harga satuan dikali jumlah barang.
- Diskon 10% jika total biaya sebelum diskon lebih dari Rp 50.000.
- Pesanan disimpan ke file JSON setelah tombol **Kirim Pemesanan** ditekan.
- Tabel menampilkan daftar pesanan dan jumlah pesanan yang tersimpan.
- Jika belum ada pesanan, tabel menampilkan tulisan **Belum ada pemesanan.**

## Harga Barang

| Barang | Harga Satuan |
| --- | ---: |
| Buku | Rp 5.000 |
| Pulpen | Rp 3.000 |
| Pensil | Rp 2.000 |
| Penghapus | Rp 1.500 |

## Contoh Perhitungan

Pemesanan 12 buku memiliki total awal 12 × Rp 5.000 = Rp 60.000. Karena totalnya lebih dari Rp 50.000, pesanan mendapat diskon 10% sebesar Rp 6.000. Jadi, total tagihannya adalah **Rp 54.000**.
# LSP_P2
