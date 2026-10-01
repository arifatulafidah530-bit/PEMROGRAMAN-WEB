create table pelanggan (
    id_pelanggan serial primary key,
    nama varchar(100) not null,
    no_hp varchar(20) not null,
    alamat text not null,
    jenis_layanan varchar(50) not null,
    constraint pelanggan_no_hp_unique unique (no_hp)
);

create table transaksi (
    id_transaksi serial primary key,
    id_pelanggan integer not null,
    kode varchar(20) not null unique,
    layanan varchar(50) not null,
    berat numeric(5,2) not null,
    total_biaya integer not null,
    status varchar(20) not null default 'Diproses',
    foreign key (id_pelanggan) references pelanggan(id_pelanggan)
);