create table data_pekerja(
  username varchar(30) unique not null,
  nama_pekerja varchar(64),
  password varchar(72),
  date_created datetime,
  tipe_pekerja varchar(16),
  cookie_login varchar(72),
  primary key (username)
);


insert into data_pekerja values("adika", "Adika Firjatullah", "tester_1234", CURRENT_TIMESTAMP, "admin", NULL);

insert into data_pekerja values("jono_123", "Jono Joni", "joni_1234", CURRENT_TIMESTAMP, "pegawai_normal", NULL);

insert into data_pekerja values("susi_23", "Susi Yono", "susi_1234", CURRENT_TIMESTAMP, "pegawai_normal", NULL);

insert into data_pekerja values("sulis", "Sulistyowati", "sulis_1234", CURRENT_TIMESTAMP, "manager", NULL);


create table pelanggaran_pekerja(
  id_pelanggaran int not null AUTO_INCREMENT,
  user_id varchar(30),
  alasan_pelanggaran text,
  tanggal_pelanggaran datetime not null default CURRENT_TIMESTAMP,
  primary key (id_pelanggaran)
);

insert into pelanggaran_pekerja values(1, "adika", "Datang tidak tepat waktu.", default);

insert into pelanggaran_pekerja values(2, "susi_23", "Datang tidak tepat waktu.", default);