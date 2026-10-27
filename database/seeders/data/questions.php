<?php

/*
| Daftar pertanyaan kuesioner capability level COBIT 2019.
| Sumber: file Excel di database/seeders/data/excel (2. APO, 3. BAI, 4. DSS).
| Struktur: [kode proses => [level => [kode praktik => [pertanyaan, ...]]]]
*/

return [
    'APO07' => [
        2 => [
            'APO07.01' => [
                'Apakah perusahaan telah mengevaluasi kebutuhan staf secara teratur ?. Dan apakah sudah dipastikan bahwa perusahaan memiliki sumber daya yang memadai untuk mendukung tujuan dan sasaran perusahaan, proses pengendalian bisnis, serta inisiatif yang mendukung IT secara tepat.',
                'Perusahaan menjaga proses rekrutmen personel bisnis agar sejalan dengan kebijakan dan prosedur perusahaan.',
                'Perusahaan menetapkan pengaturan sumber daya yang fleksibel, seperti penggunaan transfer, kontraktor eksternal, dan pengaturan layanan pihak ketiga, untuk mendukung perubahan kebutuhan bisnis.',
            ],
            'APO07.02' => [
                'Sebagai tindakan pencegahan keamanan, perusahaan telah memberikan pedoman mengenai waktu minimum libur tahunan yang harus diambil oleh masing-masing karyawan.',
                'Adanya tindakan yang dilakukan perusahaan terkait perubahan pekerjaan, terutama pemutusan hubungan kerja.',
                'Perusahaan mampu meminimalkan ketergantungan pada satu individu yang melakukan pekerjaan penting. Seperti menggunakan inisiatif pengumpulan pengetahuan (dokumentasi), berbagi pengetahuan, perencanaan suksesi, pencadangan staf, pelatihan silang, dan rotasi pekerjaan.',
            ],
            'APO07.03' => [
                'Perusahaan telah mengidentifikasi keterampilan dan kompetensi sumber daya internal dan eksternal yang tersedia saat ini.',
                'Perusahaan mengidentifikasi kesenjangan antara keterampilan yang dibutuhkan dan keterampilan yang tersedia, sekaligus mengembangkan rencana aksi, seperti pelatihan (keterampilan teknis dan perilaku), perekrutan, penempatan kembali dan perubahan strategi pengadaan, untuk mengatasi kesenjangan tersebut.',
            ],
            'APO07.04' => [
                'Perusahaan mempertimbangkan tujuan fungsional/perusahaan sebagai konteks untuk menetapkan tujuan individu.',
                'Perusahaan menetapkan tujuan individu yang selaras dengan tujuan IT perusahaan yang relevan, penetapan ini dilandasi oleh tujuan yang spesifik, terukur, dapat dicapai, relevan, dan terikat waktu (SMART) yang mencerminkan kompetensi inti, nilai-nilai perusahaan, dan keterampilan yang diperlukan untuk peran tersebut.',
                'Adanya umpan balik dari perusahaan terhadap kinerja individu.',
                'Perusahaan memberi instruksi khusus pada karyawan terkait penggunaan dan penyimpanan informasi pribadi, sesuai dengan undang-undang data pribadi dan ketenagakerjaan yang berlaku.',
            ],
            'APO07.05' => [
                'Perusahaan mampu Membuat dan memelihara inventaris (daftar) sumber daya manusia bisnis dan TI',
            ],
            'APO07.06' => [
                'Perusahaan menetapkan kebijakan dan prosedur staf kontrak.',
                'Pada awal kontrak, staff tersebut menyetujui bahwa mereka diwajibkan untuk mematuhi kerangka pengendalian IT perusahaan, seperti kebijakan izin keamanan, kontrol akses fisik dan logis, penggunaan fasilitas, persyaratan kerahasiaan informasi, dan perjanjian kerahasiaan.',
                'Adanya pemberitahuan kepada staff kontrak bahwa manajemen berhak memantau dan memeriksa semua penggunaan sumber daya TI, termasuk email, komunikasi suara, dan semua program serta file data.',
                'Perusahaan memberikan definisi yang jelas kepada staff kontrak mengenai peran dan tanggung jawab mereka, termasuk persyaratan eksplisit untuk mendokumentasikan pekerjaan mereka sesuai standar dan format yang disepakati.',
                'Adanya peninjauan pekerjaan staff kontrak dan persetujuan pembayaran hasil.',
            ],
        ],
        3 => [
            'APO07.01' => [
                'Diterapkannya pemeriksaan latar belakang dalam proses rekrutmen TI untuk karyawan, kontraktor, dan vendor. Luas dan frekuensinya pemeriksaan ini harus bergantung pada sensitivitas dan/atau kekritisan fungsi.',
            ],
            'APO07.02' => [
                'Adanya pengujian rencana cadangan staff yang dilakukan secara teratur.',
            ],
            'APO07.03' => [
                'Perusahaan melakukan peninjauan materi dan program pelatihan secara teratur untuk dapat memastikan bahwa aktivitas pelatihan selalu sesuai dengan kebutuhan perusahaan, keterampilan dan kemampuan yang dibutuhkan perusahaan.',
                'Perusahaan telah memberikan akses gudang pengetahuan untuk mendukung pengembangan keterampilan dan kompetensi karyawannya.',
                'Adanya penyampaian program pelatihan berdasarkan persyaratan organisasi, persyaratan pengetahuan, pengendalian internal, perilaku etis, keamanan dan privasi.',
            ],
            'APO07.04' => [
                'Perusahaan memiliki hasil evaluasi kinerja karyawan dengan metode 360 derajat ( metode penilaian kerja yang memungkinkan karyawan memperoleh penilaian dari segala arah, dari atasan bawahan dan rekan kerjanya).',
                'Perusahaan telah memberikan pelatihan karyawan mengenai kinerja dan perilaku kerja, pengembangan profesional dan perencanaan karir karyawan, dengan maksud agar dapat mendorong SDM menjadi lebih berkompeten dan mandiri.',
                'Perusahaan menerapkan proses pengakuan yang menghargai komitmen, pengembangan kompetensi sesuai keberhasilan pencapaian tujuan kinerja, serta memastikan proses tersebut diterapkan secara konsisten.',
                'Sudah adanya penerapan dan proses disipliner.',
            ],
            'APO07.05' => [
                'Perusahaan mampu memahami permintaan sumber daya manusia saat ini maupun masa depan untuk mendukung pencapaian tujuan IT, memberikan layanan dan solusi berdasarkan portofolio inisiatif IT, portofolio investasi masa depan, dan kebutuhan operasional.',
                'Perusahaan mampu melakukan identifikasi kekurangan dan memberikan solusi rencana pengadaan serta proses TI.',
            ],
            'APO07.06' => [
                'Perusahaan memiliki kontrak formal berisikan tentang penentuan semua pekerjaan yang dilakukan oleh pihak eksternal.',
            ],
        ],
        4 => [
            'APO07.03' => [
                'Adanya tinjauan rutin untuk menilai evolusi keterampilan dan kompetensi sumber daya internal dan eksternal. Contohnya berupa tinjauan perencanaan suksesi.',
            ],
            'APO07.05' => [
                'Perusahaan memiliki informasi yang memadai tentang waktu yang dihabiskan untuk berbagai tugas, penugasan, layanan, atau proyek.',
            ],
            'APO07.06' => [
                'Perusahaan melakukan tinjauan berkala untuk memastikan bahwa staf kontrak telah menandatangani dan menyetujui semua perjanjian yang diperlukan.',
                'Perusahaan melakukan tinjauan berkala untuk memastikan bahwa peran dan hak akses kontraktor sudah tepat dan sejalan dengan perjanjian.',
            ],
        ],
    ],
    'APO12' => [
        2 => [
            'APO12.01' => [
                'Menetapkan dan memelihara metode untuk mengumpulkan, mengklasifikasikan, dan menganalisis data yang berkaitan dengan risiko Informasi dan Teknologi (I&T).',
                'Mencatat data risiko I&T yang relevan dan signifikan yang berasal dari lingkungan operasional internal maupun eksternal organisasi.',
            ],
            'APO12.03' => [
                'Melakukan inventarisasi proses bisnis dan mendokumentasikan ketergantungannya terhadap proses manajemen layanan TI serta sumber daya infrastruktur TI. Selain itu, mengidentifikasi personel, aplikasi, infrastruktur, fasilitas, dokumen manual penting, vendor, pemasok, dan pihak outsourcing yang mendukung proses tersebut.',
                'Menentukan dan menyepakati layanan TI serta sumber daya infrastruktur TI yang sangat penting untuk menjaga keberlangsungan operasional proses bisnis. Menganalisis hubungan ketergantungan dan mengidentifikasi titik-titik lemah.',
                'Mengumpulkan dan mengelompokkan skenario risiko yang ada berdasarkan kategori risiko, lini bisnis, dan area fungsi organisasi.',
            ],
            'APO12.05' => [
                'Memelihara inventaris (daftar) aktivitas pengendalian yang telah diterapkan untuk mengurangi risiko serta memastikan bahwa risiko yang diambil tetap sesuai dengan tingkat selera risiko (risk appetite) dan toleransi risiko (risk tolerance) organisasi. Selanjutnya, mengklasifikasikan aktivitas pengendalian tersebut dan memetakannya ke skenario risiko I&T tertentu maupun kelompok skenario risiko I&T.',
            ],
        ],
        3 => [
            'APO12.01' => [
                'Apakah perusahaan telah menentukan taksonomi risiko untuk mendefinisikan skenario risiko serta kategori dampak risiko?.',
                'Apakah setiap kejadian risiko yang menyebabkan dampak bisnis sesuai kategori dampak yang ditentukan dalam taksonomi risiko telah dicatat?.',
            ],
            'APO12.02' => [
                'Sudahkah perusahaan menentukan ruang lingkup upaya analisis risiko yang tepat, dengan mempertimbangkan semua faktor risiko dan kepentingan bisnis?.',
                'Apakah perusahaan selalu membangun dan memperbarui skenario risiko IT secara rutin? termasuk identifikasi eksposur kerugian terkait IT, skenario mengenai risiko reputasi, skenario peristiwa ancaman yang terjadi secara kebetulan?.',
                'Apakah perusahaan sudah memperkirakan frekuensi (atau kemungkinan) dan besarnya kerugian maupun keuntungan terkait dengan skenario risiko IT?.',
                'Apakah perusahaan sudah membandingkan risiko saat ini (paparan kerugian terkait IT) dengan selera risiko dan toleransi risiko yang dapat diterima dan yang tidak dapat diterima?.',
                'Adakah usulan respons risiko untuk risiko yang melebihi tingkat selera risiko dan toleransi perusahaan?.',
                'Adakah penentuan persyaratan tingkat tinggi untuk proyek yang akan menerapkan respons risiko?. Dan mampukah perusahaan mengidentifikasi persyaratan pengendalian utama yang tepat untuk respons mitigasi risiko?.',
            ],
            'APO12.03' => [
                'Apakah ada pencatatan profil risiko secara berkala yang dilakukan oleh perusahaan?.',
                'Apakah informasi tentang status rencana tindakan risiko dimasukkan dalam profil risiko IT perusahaan?.',
            ],
            'APO12.04' => [
                'Apakah ada pelaporan hasil analisis risiko kepada seluruh stakeholder yang terkena dampak dalam bentuk yang berguna untuk mendukung keputusan perusahaan?. Dan apakah pelaporan tersebut menyertakan probabilitas dan kisaran kerugian atau keuntungan serta tingkat keyakinan, untuk memungkinkan manajemen menyeimbangkan keuntungan dan risiko yang ada?.',
                'Apakah perusahaan memberikan pemahaman kepada stakeholder tentang skenario terburuk dan paling mungkin terjadi, paparan kerugian terkait TI, pertimbangan hukum dan peraturan, atau kategori dampak lainnya sesuai taksonomi risiko?.',
                'Apakah perusahaan selalu memberikan laporan terkait profil risiko terkini kepada seluruh pemangku kepentingan?. Laporan profil risiko ini berisikan informasi mengenai efektivitas proses manajemen risiko, efektivitas pengendalian, kesenjangan, inkonsistensi, redundansi, status remediasi dan dampaknya terhadap profil risiko.',
                'Apakah perusahaan telah mengidentifikasi peluang terkait IT yang memungkinkan penerimaan risiko lebih besar serta disisi lain dapat meningkatkan pertumbuhan dan keuntungan bagi perusahaan?.',
            ],
            'APO12.05' => [
                'Apakah setiap entitas perusahaan telah memantau risiko dan menerima akuntabilitas untuk beroperasi dalam tingkat toleransi individu dan portofolionya?.',
                'Apakah perusahaan telah menetapkan serangkaian proyek yang seimbang yang dirancang untuk mengurangi risiko yang dialami perusahaan, dengan mempertimbangkan biaya, manfaat, dampak terhadap peraturan saat ini.',
            ],
            'APO12.06' => [
                'Apakah perusahaan telah mempersiapkan, memelihara, dan menguji rencana langkah-langkah spesifik yang harus diambil ketika peristiwa risiko terjadi sehingga dapat menyebabkan permasalahan yang merugikan operasional atau pengembangan yang signifikan dengan dampak bisnis yang serius.',
                'Perusahaan sudah merencanakan respons yang tepat untuk meminimalkan dampak ketika risiko terjadi.',
            ],
        ],
        4 => [
            'APO12.01' => [
                'Adanya survey dan analisis data historis risiko IT dan pengalaman kerugian dari data sebelumnya.',
                'Apakah sudah dilakukan pengaturan data yang dikumpulkan dan penentuan faktor-faktor yang berkontribusi secara umum pada berbagai peristiwa risiko TI?.',
                'Sudah adanya penentuan kondisi spesifik yang ada atau tidak ada ketika peristiwa risiko terjadi dan bagaimana kondisi tersebut mempengaruhi frekuensi peristiwa dan besarnya kerugian yang dialami perusahaan.',
                'Melakukan analisis peristiwa dan faktor risiko secara berkala untuk mengidentifikasi masalah risiko baru yang muncul dan untuk mendapatkan pemahaman tentang faktor risiko internal dan eksternal.',
            ],
            'APO12.02' => [
                'Validasi hasil analisis risiko dan analisis dampak bisnis (BIA) sebelum menggunakannya dalam pengambilan keputusan.',
            ],
            'APO12.03' => [
                'Berdasarkan seluruh data profil risiko, tentukan serangkaian indikator risiko yang memungkinkan identifikasi dan pemantauan risiko saat ini dan tren risiko secara cepat.',
                'Menangkap informasi mengenai peristiwa risiko IT yang telah terwujud untuk dimasukkan dalam profil risiko TI perusahaan.',
            ],
            'APO12.04' => [
                'Adanya proses peninjauan hasil penilaian pihak ketiga yang obyektif dan audit internal serta tinjauan jaminan kualitas. Serta adanya tinjauan kesenjangan yang teridentifikasi dan kerugian terkait IT, tujuannya untuk menentukan perlunya analisis risiko tambahan.',
            ],
            'APO12.06' => [
                'Perusahaan telah mengkategorikan insiden dan eksposur kerugian terkait IT dengan ambang batas toleransi risiko. Dan dilakukan komunikasi dampak bisnis kepada pengambil keputusan sebagai bagian dari pelaporan profil risiko.',
                'Apakah sudah dilakukan pemeriksaan peristiwa/kerugian di masa lalu dan peluang yang terlewatkan serta menelaah akar penyebabnya?.',
            ],
        ],
        5 => [
            'APO12.02' => [
                'Perusahaan sudah melakukan analisis biaya/manfaat dari opsi respons risiko potensial seperti menghindari, mengurangi/mitigasi, mentransfer/membagi, dan menerima dan mengeksploitasi/merebut.',
            ],
            'APO12.06' => [
                'Perusahaan mengkomunikasikan akar masalah, persyaratan respons risiko tambahan, dan perbaikan proses kepada pihak pengambil keputusan yang tepat. Serta memastikan penyebab, persyaratan respons, dan perbaikan proses disertakan dalam proses tata kelola risiko.',
            ],
        ],
    ],
    'APO13' => [
        2 => [
            'APO13.01' => [
                'Perusahaan telah menentukan ruang lingkup dan batasan sistem manajemen keamanan informasi (SMKI) dalam hal karakteristik perusahaan, organisasi, lokasi, aset, dan teknologi.',
                'Adanya pendefinisian SMKI(Sistem Manajemen Keamanan Informasi) sesuai dengan kebijakan perusahaan dan konteks di mana perusahaan beroperasi.',
                'SMKI perusahaan telah diselaraskan dengan pendekatan perusahaan secara keseluruhan terhadap manajemen keamanan.',
                'Perusahaan memiliki otorisasi manajemen untuk menerapkan dan mengoperasikan atau mengubah SMKI.',
                'Adanya pernyataan penerapan yang menggambarkan ruang lingkup SMKI.',
                'Perusahaan telah menentukan peran dan tanggung jawab manajemen keamanan informasi.',
                'Adanya komunikasi pendekatan SMKI.',
            ],
        ],
        3 => [
            'APO13.02' => [
                'Perusahaan memastikan bahwa rencana penanganan risiko mampu mengidentifikasi praktik manajemen dan solusi keamanan yang tepat dan optimal, hal yang ada pada rencana tersebut adalah sumber daya, tanggung jawab dan prioritas untuk mengelola risiko keamanan informasi yang teridentifikasi.',
                'Perusahaan menetapkan pemeliharaan sebagai bagian dari arsitektur perusahaan untuk mengelola keamanan.',
                'Sudah adanya proposal untuk menerapkan rencana penanganan risiko keamanan informasi, didukung oleh kasus bisnis yang sesuai, mencakup pertimbangan pendanaan dan alokasi peran tanggung jawab.',
                'Adanya masukan terhadap desain dan pengembangan praktik manajemen dari rencana penanganan risiko keamanan informasi.',
                'Perusahaan mengadakan pelatihan keamanan informasi dan privasi serta program kesadaran.',
                'Apakah perencanaan, desain, penerapan dan pemantauan prosedur keamanan informasi dan privasi serta pengendalian lainnya telah terintegrasi dengan baik.',
            ],
        ],
        4 => [
            'APO13.02' => [
                'Perusahaan mampu menentukan cara mengukur efektivitas praktik pengelolaan yang dipilih serta bagaimana pengukuran ini akan digunakan untuk menilai efektivitas agar menghasilkan hasil yang sebanding dan dapat direproduksi.',
            ],
            'APO13.03' => [
                'Apakah sudah dilakukan secara rutin tinjauan terhadap efektivitas SMKI. Termasuk memenuhi kebijakan dan tujuan SMKI serta meninjau praktik keamanan dan privasi.',
                'Perusahaan telah melakukan audit SMKI pada interval yang direncanakan.',
                'Sudah dilaksanakan tinjauan manajemen terhadap SMKI secara teratur untuk memastikan bahwa ruang lingkupnya tetap memadai dan perbaikan dalam proses SMKI teridentifikasi.',
                'Adanya pencatatan tindakan dan peristiwa yang dapat berdampak pada efektivitas atau kinerja SMKI.',
            ],
        ],
        5 => [
            'APO13.03' => [
                'Sudah diterapkannya pemeliharaan rencana keamanan untuk mempertimbangkan temuan kegiatan pemantauan dan peninjauan.',
            ],
        ],
    ],
    'APO14' => [
        2 => [
            'APO14.01' => [
                'Apakah perusahaan mampu menetapkan fungsi pengelolaan data dengan tanggung jawab untuk mengelola aktivitas yang mendukung tujuan perusahaan?.',
                'Apakah perusahaan sudah menetapkan pembagian peran dan tanggung jawab untuk mendukung pengelolaan data?.',
            ],
            'APO14.02' => [
                'Apakah ketentuan bisnis standar telah tersedia dan dikomunikasikan kepada pemangku kepentingan terkait?.',
                'Apakah setiap istilah bisnis yang ditambahkan ke glosarium bisnis memiliki nama dan definisi unik?.',
                'Apakah perusahaan menggunakan istilah dan definisi bisnis industri standar dalam glosarium bisnis?.',
            ],
            'APO14.03' => [
                'Sudahkah perusahaan menetapkan proses manajemen metadata?.',
                'Apakah dokumentasi metadata menangkap saling ketergantungan data?.',
                'Sudahkah perusahaan mengikuti kategori, properti, dan standar metadata?.',
            ],
            'APO14.07' => [
                'Apakah perusahaan memiliki pemeliharaan kebijakan pembersihan data?.',
            ],
            'APO14.08' => [
                'Sudahkah perusahaan memetakan dan menyelaraskan kebutuhan konsumen dan produsen data?.',
            ],
            'APO14.09' => [
                'Apakah terdapat kebijakan yang mengamanatkan pengelolaan riwayat data, termasuk persyaratan retensi, pemusnahan, dan jejak audit?.',
                'Adakah metode pasti yang menjamin aksesibilitas terhadap data historis yang diperlukan untuk mendukung kebutuhan bisnis perusahaan?.',
                'Apakah perusahaan telah menggunakan kebijakan dan proses untuk mengontrol akses, pengiriman, dan modifikasi terhadap data historis dan arsip?.',
            ],
            'APO14.10' => [
                'Adakah jadwal untuk memastikan pencadangan yang benar untuk semua data penting perusahaan?.',
                'Apakah perusahaan telah menetapkan persyaratan untuk penyimpanan data cadangan di dalam dan di luar lokasi, dengan mempertimbangkan volume, kapasitas, dan periode penyimpanan?.',
                'Apakah perusahaan sudah menetapkan jadwal pengujian untuk data cadangan?, dalam hal ini perlu dipastikan bahwa data dapat dipulihkan dengan benar tanpa berdampak besar pada kegiatan operasional bisnis.',
            ],
        ],
        3 => [
            'APO14.01' => [
                'Apakah bisnis dan teknologi secara kolaboratif mampu mengembangkan strategi pengelolaan data perusahaan?.',
                'Sudahkah perusahaan mengkomunikasikan tujuan, prioritas, dan ruang lingkup pengelolaan data berdasarkan umpan balik?.',
            ],
            'APO14.02' => [
                'Apakah perusahaan telah menetapkan, mendokumentasikan, dan mengikuti proses untuk mendefinisikan, mengelola, menggunakan, dan memelihara glosarium bisnis?, tujuan dari penetapan ini nantinya adalah membantu mencapai keterbandingan konten dan memfasilitasi pembagian data di seluruh lapisan perusahaan.',
                'Apakah perusahaan telah memastikan upaya pengembangan baru, integrasi data, dan konsolidasi data menerapkan persyaratan bisnis standar sebagai bagian dari proses definisi persyaratan data?.',
                'Apakah perusahaan telah mengintegrasikan glosarium bisnis ke dalam repositori metadata organisasi, dengan izin akses yang sesuai?.',
            ],
            'APO14.03' => [
                'Adakah upaya perusahaan mengembangkan metadata untuk melakukan analisis dampak terhadap potensi perubahan data?.',
                'Apakah penyimpanan metadata organisasi telah berisikan kategori dan klasifikasi metadata tambahan sesuai dengan rencana implementasi?.',
                'Apakah sudah dilakukan validasi terhadap metadata dan perubahan apa pun pada metadata terhadap arsitektur yang ada?.',
                'Apakah perusahaan telah mengembangkan metamodel terintegrasi yang diterapkan di semua platform?.',
                'Apakah sudah dapat dipastikan bahwa jenis metadata dan definisi data mampu mendukung praktik impor, langganan, dan konsumsi yang konsisten?.',
            ],
            'APO14.04' => [
                'Apakah perusahaan telah menentukan strategi kualitas data dengan pemangku kepentingan bisnis?, yang mana strategi tersebut harus dapat memfasilitasi peralihan dari kondisi saat ini ke kondisi target dan selaras dengan tujuan bisnis.',
                'Apakah dapat dipastikan bahwa strategi kualitas data diikuti di seluruh aspek perusahaan dan disertai dengan kebijakan, proses, dan pedoman yang sesuai?.',
                'Apakah perusahaan telah mengimplementasikan proses yang sesuai dalam metodologi siklus hidup pengembangan sistem data perusahaan?.',
                'Apakah perusahaan telah mengembangkan, memantau, dan memelihara rencana berurutan untuk upaya peningkatan kualitas data?.',
            ],
            'APO14.05' => [
                'Apakah perusahaan telah menentukan standarisasi metodologi, proses, praktik, alat, dan templat hasil pembuatan profil data?, dengan tetap memastikan pembuatan profil data nantinya dapat digunakan kembali dan dimanfaatkan di beberapa penyimpanan data dan repositori data bersama.',
            ],
            'APO14.07' => [
                'Sudahkah perusahaan menjaga riwayat perubahan data melalui aktivitas pembersihan?.',
            ],
            'APO14.08' => [
                'Sudahkah perusahaan menentukan pemetaan proses bisnis ke data dengan mempertahankan kepatuhannya secara berkala?.',
                'Apakah ada perjanjian kolaboratif sehubungan dengan data bersama dan penggunaan data dalam proses bisnis perusahaan?.',
                'Apakah perusahaan telah menerapkan aliran data dan peta siklus hidup data secara lengkap untuk setiap proses bisnis utama perusahaan?.',
                'Apakah perubahan pada kumpulan data bersama atau data target dikelola oleh struktur tata kelola data, dengan keterlibatan stakeholder yang relevan.',
            ],
            'APO14.09' => [
                'Perusahaan memiliki repositori gudang yang menyediakan akses ke data historis untuk analitik guna mendukung proses bisnis.',
            ],
        ],
        4 => [
            'APO14.01' => [
                'Sudahkah perusahaan menggunakan metrik untuk menilai dan memantau pencapaian tujuan pengelolaan data?.',
                'Apakah perusahaan telah memantau rencana urutan implementasi strategi pengelolaan data, memperbarui sesuai kebutuhan berdasarkan kemajuan ulasan?.',
                'Sudahkah perusahaan menggunakan teknik statistik dan kuantitatif untuk mengevaluasi efektivitas tujuan pengelolaan data strategis dalam mencapai tujuan bisnis?.',
            ],
            'APO14.03' => [
                'Sudahkah perusahaan menggunakan ukuran dan metrik untuk mengevaluasi keakuratan dan penerapan metadata?.',
            ],
            'APO14.04' => [
                'Adakah aktivitas pemantauan rencana untuk memenuhi tujuan dan sasaran strategi kualitas data?.',
                'Adanya pengumpulan laporan para stakeholder mengenai masalah kualitas data, yang berisikan ekspektasi mereka terhadap peningkatan kualitas data dalam strategi kualitas data.',
            ],
            'APO14.05' => [
                'Sudahkah perusahaan melibatkan manajemen data untuk mengidentifikasi kumpulan data inti bersama yang diprofilkan dan dipantau secara berkala?.',
                'Apakah sudah disertakan evaluasi kesesuaian konten data dengan metadata dan standar yang disetujui pada pembuatan profil data perusahaan?.',
                'Selama aktivitas pembuatan profil data, sudahkah dilakukan perbandingan masalah aktual dengan masalah yang diprediksi secara statistik, berdasarkan hasil pembuatan profil historis?.',
                'Apakah dapat dipastikan bahwa hasil data disimpan secara terpusat, dipantau dan dianalisis secara sistematis sehubungan dengan statistik dan metrik?.',
            ],
            'APO14.06' => [
                'Apakah perusahaan telah melakukan penilaian kualitas data secara berkala, sesuai dengan frekuensi yang disetujui terkait kebijakan penilaian kualitas data?.',
                'Adakah rekomendasi perbaikan, dengan dasar pemikiran yang mendukung, dalam hasil penilaian kualitas data?.',
                'Terkait penilaian data, apakah perusahaan menggunakan ambang batas dan target yang ditetapkan untuk setiap dimensi kualitas yang dipilih?.',
                'Adakah laporan pengukuran kualitas data secara sistematis, berdasarkan kekritisan atribut dan volatilitas data?.',
            ],
            'APO14.07' => [
                'Apakah perusahaan telah menetapkan metode untuk mengoreksi data dan menentukan metode tersebut dalam sebuah rencana?. Metode ini dapat mencakup perbandingan beberapa repositori, verifikasi terhadap sumber yang valid, pemeriksaan logika, integritas referensial, atau toleransi rentang.',
                'Dalam perjanjian tingkat layanan, apakah sudah disertakan kriteria kualitas data untuk meminta pertanggungjawaban penyedia data atas data yang dibersihkan?.',
            ],
            'APO14.08' => [
                'Apakah perusahaan menggunakan metrik untuk memperluas penggunaan data bersama yang disetujui dan menghilangkan proses yang berulang(redudansi).',
            ],
        ],
        5 => [
            'APO14.01' => [
                'Perusahaan meneliti proses bisnis inovatif dan persyaratan peraturan yang muncul untuk memastikan bahwa program pengelolaan data kompatibel dengan kebutuhan bisnis di masa depan.',
                'Adanya kontribusi pada praktik terbaik industri untuk pengembangan dan implementasi strategi manajemen data.',
            ],
            'APO14.03' => [
                'Terdapat evaluasi perubahan data yang direncanakan untuk mengetahui dampaknya pada repositori metadata. Selalu ada peningkatan proses pengambilan, perubahan, dan penyempurnaan metadata.',
            ],
            'APO14.05' => [
                'Sudah adanya laporan pembuatan profil otomatis real-time atau hampir real-time untuk semua feed data dan repositori penting.',
            ],
            'APO14.06' => [
                'Perusahaan terus melakukan peninjauan dan peningkatan proses penilaian dan pelaporan kualitas data.',
            ],
        ],
    ],
    'BAI09' => [
        2 => [
            'BAI09.01' => [
                'Apakah perusahaan sudah mengidentifikasi semua aset yang dimiliki dalam daftar aset yang mencatat status saat ini?. Identifikasi semua aset perusahaan ini harus dapat dipertahankan keselarasan dengan proses manajemen perubahan dan manajemen konfigurasi, sistem manajemen konfigurasi, dan catatan akuntansi keuangan.',
                'Apakah sudah dilakukan proses identifikasi persyaratan hukum, peraturan, atau kontrak yang perlu ditangani saat mengelola aset?.',
                'Sudahkah dilakukan proses verifikasi bahwa aset tersebut telah berjalan sesuai dengan tujuannya (yaitu, dalam kondisi berguna)?.',
            ],
            'BAI09.02' => [
                'Sudahkah dilakukan identifikasi aset yang penting dalam menyediakan kemampuan layanan di perusahaan dengan merujuk pada persyaratan dalam definisi layanan, SLA, dan sistem manajemen konfigurasi?.',
                'Secara teratur sudahkah perusahaan melakukan pertimbangan risiko kegagalan atau perlunya penggantian setiap aset penting yang dimilikinya?.',
                'Apakah ada aktivitas komunikasi dari perusahaan kepada pelanggan dan pengguna yang terkena dampak mengenai dampak yang diharapkan (misalnya pembatasan kinerja) dari aktivitas pemeliharaan?.',
            ],
            'BAI09.03' => [
                'Sudahkah dilakukan pengadanan semua aset berdasarkan permintaan yang disetujui dan sesuai dengan kebijakan dan praktik pengadaan perusahaan?.',
                'Apakah sudah dilakukan proses mencari, menerima, memverifikasi, menguji, dan mencatat semua aset dengan cara yang terkendali, termasuk pelabelan fisik sesuai kebutuhan perusahaan?.',
                'Apakah perusahaan sudah menyetujui pembayaran dan menyelesaikan proses dengan pemasok aset sesuai dengan ketentuan kontrak yang disepakati?.',
            ],
            'BAI09.05' => [
                'Apakah sudah dilakukan penyimpanan terhadap daftar semua lisensi aset perangkat lunak yang dibeli dan perjanjian lisensi terkait?.',
            ],
        ],
        3 => [
            'BAI09.01' => [
                'Sudahkah perusahaan memastikan adanya akuntansi untuk semua aset yang dimilikinya?.',
            ],
            'BAI09.02' => [
                'Apakah ada penggabungan waktu henti yang direncanakan dalam jadwal produksi secara keseluruhan (libur penggunaan aset)?. Jika belum lakukan penjadwalan kegiatan pemeliharaan aset untuk meminimalkan dampak buruk dampaknya terhadap proses bisnis perusahaan.',
                'Sudahkah perusahaan menjaga ketahanan aset kritis dengan menerapkan pemeliharaan preventif terhadap aset secara berkala?.',
                'Sudahkah perusahaan menetapkan rencana pemeliharaan preventif untuk semua perangkat keras, dengan mempertimbangkan analisis biaya/manfaat, rekomendasi vendor, dan risiko pemadaman listrik, personel yang berkualifikasi dan faktor relevan lainnya?.',
                'Sudahkah perusahaan menetapkan perjanjian pemeliharaan aset yang melibatkan akses pihak ketiga ke fasilitas IT organisasi untuk aktivitas di dalam dan di luar lokasi (misalnya, outsourcing)?. Dan sudahkah ditetapkan kontrak layanan formal yang berisi atau mengacu pada semua kondisi keamanan dan privasi yang diperlukan, termasuk prosedur otorisasi akses, untuk memastikan kepatuhan terhadap kebijakan dan standar keamanan/privasi organisasi?.',
                'Apakah dapat dipastikan bahwa layanan akses jarak jauh dan profil pengguna (atau cara lain yang digunakan untuk pemeliharaan atau diagnosis) hanya aktif bila diperlukan?.',
            ],
            'BAI09.03' => [
                'Sudahkah perusahaan menerapkan aset yang dimilikinya dengan mengikuti siklus hidup penerapan standar, termasuk manajemen perubahan dan pengujian penerimaan?.',
                'Sudahkah dilakukan pengalokasian aset kepada pengguna, dengan penerimaan tanggung jawab dan persetujuan, jika diperlukan?.',
                'Apakah perusahaan akan melakukan alokasi kembali aset ketika aset tersebut tidak lagi diperlukan karena perubahan peran pengguna, redundansi dalam layanan, atau penghentian layanan?.',
                'Sudahkah perusahaan merencanakan, mengizinkan, dan melaksanakan aktivitas terkait pensiun, menyimpan catatan yang sesuai untuk memenuhi kebutuhan bisnis dan peraturan yang sedang berlangsung?.',
                'Apakah perusahaan melakukan pembuangan aset dengan aman, dengan mempertimbangkan, misalnya, penghapusan permanen semua data yang tercatat pada perangkat media dan potensi kerusakan terhadap lingkungan?.',
            ],
            'BAI09.04' => [
                'Secara teratur sudahkah perusahaan melakukan peninjauan keseluruhan basis aset, serta mempertimbangkan apakah sudah selaras dengan kebutuhan bisnis?.',
            ],
            'BAI09.05' => [
                'Secara teratur sudahkah perusahaan melakukan audit untuk mengidentifikasi semua perangkat lunak berlisensi yang diinstal?.',
            ],
        ],
        4 => [
            'BAI09.01' => [
                'Sudahkah perusahaan memverifikasi keberadaan seluruh aset yang dimiliki dengan melakukan pemeriksaan inventaris fisik dan logis serta rekonsiliasi secara berkala?.',
                'Sudahkah perusahaan menentukan apakah setiap aset secara terus menerus mampu memberikan nilai/value sesuai dengan yang diharapkan?.',
            ],
            'BAI09.02' => [
                'Sudahkah perusahaan melakukan aktivitas pemantauan kinerja aset penting dengan memeriksa tren insiden aset?.',
            ],
            'BAI09.03' => [
                'Apakah perusahaan mampu bertanggung jawab terhadap aset-aset yang dibuang ketika aset tersebut tidak memiliki kegunaan karena penghentian semua layanan terkait, teknologi yang ketinggalan jaman, atau kurangnya pengguna sehubungan dengan dampak lingkungan?.',
            ],
            'BAI09.04' => [
                'Mampukah perusahaan menilai biaya pemeliharaan aset, mempertimbangkan kewajaran, dan mengidentifikasi opsi berbiaya lebih rendah?.',
            ],
            'BAI09.05' => [
                'Dapatkah perusahaan membandingkan jumlah perangkat lunak yang diinstal dengan jumlah lisensi yang dimiliki?.',
                'Jika jumlah mesin virtual lebih sedikit dari jumlah yang dimiliki, mampukah perusahaan memutuskan apa saja kebutuhan untuk mempertahankan atau menghentikan lisensi, dengan mempertimbangkan potensi penghematan biaya pemeliharaan, pelatihan, dan biaya lainnya yang tidak diperlukan?.',
                'Jika jumlah instans lebih tinggi dari jumlah yang dimiliki, mampukah perusahaan mempertimbangkan terlebih dahulu peluang untuk menghapus instalan instans yang tidak lagi diperlukan atau dibenarkan?.',
            ],
        ],
        5 => [
            'BAI09.04' => [
                'Perusahaan telah melakukan peninjauan jaminan dan pertimbangan strategi nilai uang dan penggantian untuk menentukan opsi berbiaya terendah.',
                'Perusahaan telah menggunakan statistik kapasitas dan pemanfaatan untuk mengidentifikasi aset yang kurang dimanfaatkan atau berlebihan yang dapat dipertimbangkan untuk dibuang atau digantikan agar dapat mengurangi biaya.',
                'Perusahaan telah meninjau dasar keseluruhan untuk mengidentifikasi peluang standardisasi, sumber tunggal, dan strategi lain yang mungkin lebih rendah biaya pengadaan, dukungan dan pemeliharaan.',
                'Perusahaan telah meninjau keadaan secara keseluruhan untuk mengidentifikasi peluang memanfaatkan teknologi baru atau strategi sumber alternatif untuk melakukan pengurangan biaya atau meningkatkan nilai uang.',
            ],
            'BAI09.05' => [
                'Perusahaan telah mempertimbangkan apakah nilai yang lebih baik dapat diperoleh dengan meningkatkan produk dan lisensi terkait secara rutin dan berkala.',
            ],
        ],
    ],
    'DSS05' => [
        2 => [
            'DSS05.01' => [
                'Apakah perusahaan sudah melakukan penginstalan alat perlindungan perangkat lunak berbahaya di semua fasilitas pemrosesan ?',
                'Apakah ada filterisasi lalu lintas masuk, seperti email dan unduhan, untuk melindungi dari informasi yang tidak diminta pada sistem layanan perusahaan ? (misalnya, spyware, email phishing)',
            ],
            'DSS05.02' => [
                'Apakah perusahaan membatasi hanya perangkat resmi yang memiliki akses ke informasi perusahaan dan jaringan perusahaan ?',
                'Apakah perusahaan menerapkan mekanisme penyaringan jaringan, seperti firewall dan perangkat lunak pendeteksi intrusi ? Serta menerapkan kebijakan yang tepat untuk mengendalikan lalu lintas masuk dan keluar ?',
                'Apakah perusahaan menetapkan protokol keamanan yang disetujui ke konektivitas jaringan ?',
                'Apakah perusahaan mengkonfigurasikan peralatan jaringan dengan cara yang aman ?',
            ],
            'DSS05.03' => [
                'Apakah perusahaan mengkonfigurasikan sistem operasi dengan cara yang aman ?',
                'Apakah perusahaan menerapkan mekanisme penguncian perangkat lunak/keras ?',
                'Apakah ada pengelolaan akses dan kontrol jarak jauh yang diterapkan perusahaan ? (misalnya, perangkat seluler, kerja jarak jauh).',
                'Apakah ada pengelolaan konfigurasi jaringan dengan cara yang aman ?',
                'Apakah perusahaan menerapkan pemfilteran lalu lintas jaringan pada perangkat titik akhir ?',
                'Apakah perusahaan mampu melindungi integritas sistem ?',
                'Apakah perusahaan memberikan perlindungan pada fisik perangkat titik akhir ?',
                'Apakah perusahaan membuang perangkat titik akhir dengan aman ?',
                'Apakah perusahaan mengelola akses berbahaya melalui email dan browser web ? Misalnya, memblokir situs web tertentu dan menonaktifkan klik-tayang pada tautan untuk ponsel cerdas ?',
            ],
            'DSS05.04' => [
                'Mampukah perusahaan menjaga hak akses pengguna layanannya sesuai dengan fungsi bisnis, persyaratan proses dan kebijakan keamanan IT ?',
            ],
            'DSS05.05' => [
                'Apakah perusahaan melakukan pencatatan dan pemantauan semua titik masuk ke situs TI ? Dengan mendaftarkan semua pengunjung, termasuk kontraktor dan vendor, ke situs layanan perusahaan ?',
                'Apakah perusahaan mampu memastikan semua personel menunjukkan identifikasi yang disetujui dengan benar setiap saat ?',
                'Apakah perusahaan mewajibkan seluruh pengunjung perusahaan untuk selalu dikawal saat berada di lokasi ?',
                'Apakah perusahaan membatasi dan memantau akses ke situs TI sensitif dengan menetapkan batasan perimeter, seperti pagar, tembok, dan keamanan perangkat lainnya ?',
            ],
            'DSS05.06' => [
                'Apakah perusahaan menetapkan prosedur untuk mengatur aktivitas penerimaan, penggunaan, penghapusan, pembuangan dokumen sensitif, perangkat yang masuk kedalam dan luar perusahaan ?',
                'Apakah perusahaan mampu memastikan kontrol kriptografi yang diterapkan untuk melindungi informasi sensitif yang disimpan secara elektronik ?',
            ],
            'DSS05.07' => [
                'Apakah perusahaan selalu menggunakan portofolio teknologi, layanan, dan aset yang didukung untuk mengidentifikasi kerentanan keamanan informasi ? (misalnya pemindai kerentanan, fuzzer, dan sniffer, penganalisis protokol)',
                'Apakah perusahaan mampu mengkomunikasikan skenario risiko, sehingga skenario tersebut dapat dengan mudah dikenali, dan kemungkinan serta dampaknya dapat dipahami ?',
                'Adakah peninjauan log peristiwa secara berkala untuk mengetahui potensi insiden ?',
                'Apakah dapat dipastikan bahwa tiket insiden terkait keamanan TI dibuat tepat waktu ketika pemantauan identifikasi potensi insiden ?',
            ],
        ],
        3 => [
            'DSS05.01' => [
                'Sudahkah perusahaan mengkomunikasikan kepada seluruh komponen internal tentang kesadaran perangkat lunak berbahaya dan menerapkan prosedur serta tanggung jawab pencegahan serangan perangkat lunak?.',
                'Sudahkah perusahaan mendistribusikan semua perangkat lunak perlindungan secara terpusat (versi dan tingkat patch) menggunakan konfigurasi terpusat dan manajemen perubahan TI?.',
            ],
            'DSS05.02' => [
                'Sudahkah perusahaan memberikan enkripsi informasi dalam perjalanan penggunaan TI sesuai dengan klasifikasinya?.',
                'Berdasarkan penilaian risiko dan kebutuhan bisnis, apakah perusahaan sudah menetapkan dan mempertahankan kebijakan untuk keamanan konektivitas data IT?.',
                'Apakah perusahaan membangun mekanisme terpercaya untuk mendukung transmisi dan penerimaan informasi layanan yang aman?.',
            ],
            'DSS05.03' => [
                'Sudahkah perusahaan memberikan enkripsi informasi dalam penyimpanan sesuai dengan klasifikasinya?.',
            ],
            'DSS05.04' => [
                'Mampukah perusahaan mengelola semua perubahan hak akses (pembuatan, modifikasi, dan penghapusan) secara tepat waktu hanya berdasarkan transaksi layanan yang disetujui dan terdokumentasi yang disahkan?.',
                'Apakah perusahaan memisahkan dan mengelola akun pengguna yang memiliki hak istimewa terhadap layanan secara aktif?. Dan apakah perusahaan selalu melakukan pemantauan semua aktivitas di akun tersebut?.',
                'Sudahkah perusahaan melakukan identifikasi terhadap semua aktivitas pemrosesan informasi berdasarkan peran fungsional?. Hal ini ditunjukkan dengan adanya komunikasi pada unit bisnis untuk memastikan bahwa semua peran didefinisikan secara konsisten, termasuk peran yang ditentukan oleh bisnis itu sendiri dalam aplikasi proses bisnis.',
                'Apakah perusahaan telah melakukan otentikasi semua akses ke aset informasi berdasarkan peran individu atau aturan bisnis?. Dan sudahkah dilakukan koordinasi dengan unit bisnis yang mengelola otentikasi dalam aplikasi yang digunakan pada layanan untuk memastikan bahwa kontrol otentikasi telah dikelola dengan benar?.',
                'Apakah semua pengguna layanan perusahaan dan aktivitas mereka pada sistem TI (aplikasi bisnis, infrastruktur TI, pengoperasian sistem, pengembangan, dan pemeliharaan) dapat diidentifikasi?.',
            ],
            'DSS05.05' => [
                'Apakah perusahaan sudah mengelola permintaan untuk mengizinkan akses resmi yang sesuai ke fasilitas komputasi layanan?.',
                'Apakah perusahaan mampu memastikan bahwa profil akses terhadap layanan tetap terkini / terupdate?. Dan apakah akses ke situs TI perusahaan seperti ruang server, gedung, area atau zona telah sesuai fungsi dan tanggung jawab pekerjaan?.',
                'Apakah perusahaan secara rutin memberikan pelatihan kesadaran keamanan informasi fisik kepada seluruh staf internalnya?.',
            ],
            'DSS05.06' => [
                'Apakah perusahaan telah menetapkan hak akses ke dokumen sensitif dan perangkat keluaran berdasarkan prinsip hak istimewa paling rendah, dengan menyeimbangkan risiko dan kebutuhan bisnis perusahaan?.',
                'Apakah perusahaan memiliki dokumen inventaris sensitif, perangkat keluaran, dan lakukan rekonsiliasi yang dibuat secara berkala?.',
                'Apakah perusahaan telah melakukan pengamanan fisik yang sesuai terhadap dokumen sensitif perusahaan?.',
            ],
            'DSS05.07' => [
                'Sudahkah perusahaan mencatat seluruh peristiwa terkait keamanan informasi TI dan menyimpan catatan tersebut untuk periode yang sesuai selanjutnya?.',
            ],
        ],
        4 => [
            'DSS05.01' => [
                'Apakah perusahaan sudah melakukan peninjauan dan evaluasi informasi secara berkala mengenai potensi ancaman baru (misalnya, meninjau saran keamanan produk dan layanan vendor)?.',
            ],
            'DSS05.02' => [
                'Sudahkah perusahaan melakukan pengujian penetrasi(peretasan etis) secara berkala untuk menentukan kecukupan perlindungan jaringan?.',
                'Apakah perusahaan sudah melakukan pengujian keamanan sistem secara berkala untuk menentukan kecukupan perlindungan sistem?.',
            ],
            'DSS05.04' => [
                'Sudahkah perusahaan mempertahankan jejak audit akses terhadap informasi tergantung pada sensitivitas dan persyaratan peraturan?.',
                'Apakah perusahaan sudah melakukan tinjauan manajemen rutin terhadap semua akun dan hak istimewa terkait?.',
            ],
        ],
    ],
];
