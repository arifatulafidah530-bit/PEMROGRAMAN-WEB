CREATE TABLE IF NOT EXISTS pengambilan_laundry (
    id_pengambilan SERIAL PRIMARY KEY,
    id_transaksi INTEGER NOT NULL UNIQUE REFERENCES transaksi(id_transaksi),
    id_pelanggan INTEGER NOT NULL REFERENCES pelanggan(id_pelanggan),
    tanggal_masuk DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_diambil DATE,
    status VARCHAR(20) NOT NULL DEFAULT 'aktif',
    CONSTRAINT pengambilan_status_check CHECK (status IN ('aktif', 'selesai'))
);

CREATE INDEX IF NOT EXISTS idx_pengambilan_status
    ON pengambilan_laundry(status);
