namespace disklinikleriicinotomasyon
{
    partial class frmSekrerterinSayfasi
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            grpRandevuOlusturma = new GroupBox();
            mtxtRandevuSaat = new MaskedTextBox();
            lblRandevuSaati = new Label();
            cmbBransSec = new ComboBox();
            lblBransıSec = new Label();
            btnRandevuListesiYenile = new Button();
            lblRandevu = new Label();
            dgvRandevuTablosu = new DataGridView();
            btnRandevuEkle = new Button();
            lblHastaTCNo = new Label();
            txtHastaTCNo = new TextBox();
            lblRandevuTarih = new Label();
            dtpRandevuTarihi = new DateTimePicker();
            lblDoktorSecimi = new Label();
            cmbDoktorSecimi = new ComboBox();
            grpHizliHastaKaydi = new GroupBox();
            btnHastaListesiYenile = new Button();
            lblHastalar = new Label();
            dgvHastalar = new DataGridView();
            txtHastaTelNo = new TextBox();
            txtHastaTC = new TextBox();
            txtHastaSoyad = new TextBox();
            txtHastaAdi = new TextBox();
            btnHastaKaydet = new Button();
            lblHastaTelNo = new Label();
            lblHastaTC = new Label();
            lblHastaSoyad = new Label();
            lblHastaAd = new Label();
            grpGonderilecekNot = new GroupBox();
            btnGonderilenNotlariGuncelle = new Button();
            lblGonderilenNotlar = new Label();
            dgvGonderilenNotlar = new DataGridView();
            btnNotuGonder = new Button();
            rtxNotİcerigi = new RichTextBox();
            lblHangiDoktor = new Label();
            cmbDoktorSec = new ComboBox();
            btnDegisiklikleriKaydet = new Button();
            btnKaydiSil = new Button();
            btnKaydiDuzenle = new Button();
            btnKaydıSilRandevu = new Button();
            grpRandevuOlusturma.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvRandevuTablosu).BeginInit();
            grpHizliHastaKaydi.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvHastalar).BeginInit();
            grpGonderilecekNot.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvGonderilenNotlar).BeginInit();
            SuspendLayout();
            // 
            // grpRandevuOlusturma
            // 
            grpRandevuOlusturma.BackColor = SystemColors.ActiveCaption;
            grpRandevuOlusturma.Controls.Add(mtxtRandevuSaat);
            grpRandevuOlusturma.Controls.Add(lblRandevuSaati);
            grpRandevuOlusturma.Controls.Add(cmbBransSec);
            grpRandevuOlusturma.Controls.Add(lblBransıSec);
            grpRandevuOlusturma.Controls.Add(btnRandevuListesiYenile);
            grpRandevuOlusturma.Controls.Add(lblRandevu);
            grpRandevuOlusturma.Controls.Add(dgvRandevuTablosu);
            grpRandevuOlusturma.Controls.Add(btnRandevuEkle);
            grpRandevuOlusturma.Controls.Add(lblHastaTCNo);
            grpRandevuOlusturma.Controls.Add(txtHastaTCNo);
            grpRandevuOlusturma.Controls.Add(lblRandevuTarih);
            grpRandevuOlusturma.Controls.Add(dtpRandevuTarihi);
            grpRandevuOlusturma.Controls.Add(lblDoktorSecimi);
            grpRandevuOlusturma.Controls.Add(cmbDoktorSecimi);
            grpRandevuOlusturma.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            grpRandevuOlusturma.Location = new Point(34, 35);
            grpRandevuOlusturma.Name = "grpRandevuOlusturma";
            grpRandevuOlusturma.Size = new Size(487, 630);
            grpRandevuOlusturma.TabIndex = 0;
            grpRandevuOlusturma.TabStop = false;
            grpRandevuOlusturma.Text = "Randevu Oluşturma";
            // 
            // mtxtRandevuSaat
            // 
            mtxtRandevuSaat.Location = new Point(205, 220);
            mtxtRandevuSaat.Mask = "00:00";
            mtxtRandevuSaat.Name = "mtxtRandevuSaat";
            mtxtRandevuSaat.Size = new Size(150, 34);
            mtxtRandevuSaat.TabIndex = 4;
            // 
            // lblRandevuSaati
            // 
            lblRandevuSaati.AutoSize = true;
            lblRandevuSaati.BackColor = SystemColors.ButtonHighlight;
            lblRandevuSaati.Location = new Point(29, 223);
            lblRandevuSaati.Name = "lblRandevuSaati";
            lblRandevuSaati.Size = new Size(151, 28);
            lblRandevuSaati.TabIndex = 26;
            lblRandevuSaati.Text = "Randevu Saati :";
            // 
            // cmbBransSec
            // 
            cmbBransSec.FormattingEnabled = true;
            cmbBransSec.Location = new Point(205, 68);
            cmbBransSec.Name = "cmbBransSec";
            cmbBransSec.Size = new Size(182, 36);
            cmbBransSec.TabIndex = 25;
            cmbBransSec.SelectedIndexChanged += cmbBransSec_SelectedIndexChanged;
            // 
            // lblBransıSec
            // 
            lblBransıSec.AutoSize = true;
            lblBransıSec.BackColor = SystemColors.ButtonHighlight;
            lblBransıSec.Location = new Point(29, 76);
            lblBransıSec.Name = "lblBransıSec";
            lblBransıSec.Size = new Size(110, 28);
            lblBransıSec.TabIndex = 24;
            lblBransıSec.Text = "Branş Seç :";
            // 
            // btnRandevuListesiYenile
            // 
            btnRandevuListesiYenile.Location = new Point(304, 583);
            btnRandevuListesiYenile.Name = "btnRandevuListesiYenile";
            btnRandevuListesiYenile.Size = new Size(166, 34);
            btnRandevuListesiYenile.TabIndex = 23;
            btnRandevuListesiYenile.Text = "Listeyi Güncelle";
            btnRandevuListesiYenile.UseVisualStyleBackColor = true;
            btnRandevuListesiYenile.Click += btnRandevuListesiYenile_Click;
            // 
            // lblRandevu
            // 
            lblRandevu.AutoSize = true;
            lblRandevu.BackColor = SystemColors.ButtonHighlight;
            lblRandevu.Location = new Point(45, 404);
            lblRandevu.Name = "lblRandevu";
            lblRandevu.Size = new Size(124, 28);
            lblRandevu.TabIndex = 10;
            lblRandevu.Text = "Randevular :";
            // 
            // dgvRandevuTablosu
            // 
            dgvRandevuTablosu.BackgroundColor = SystemColors.ButtonHighlight;
            dgvRandevuTablosu.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgvRandevuTablosu.Location = new Point(50, 452);
            dgvRandevuTablosu.Name = "dgvRandevuTablosu";
            dgvRandevuTablosu.RowHeadersWidth = 62;
            dgvRandevuTablosu.Size = new Size(376, 125);
            dgvRandevuTablosu.TabIndex = 9;
            dgvRandevuTablosu.CellClick += dgvRandevuTablosu_CellClick;
            dgvRandevuTablosu.CellContentClick += dgvRandevuTablosu_CellContentClick;
            // 
            // btnRandevuEkle
            // 
            btnRandevuEkle.Location = new Point(331, 342);
            btnRandevuEkle.Name = "btnRandevuEkle";
            btnRandevuEkle.Size = new Size(150, 35);
            btnRandevuEkle.TabIndex = 8;
            btnRandevuEkle.Text = "Randevu Ekle";
            btnRandevuEkle.UseVisualStyleBackColor = true;
            btnRandevuEkle.Click += btnRandevuEkle_Click;
            // 
            // lblHastaTCNo
            // 
            lblHastaTCNo.AutoSize = true;
            lblHastaTCNo.BackColor = SystemColors.ButtonHighlight;
            lblHastaTCNo.Location = new Point(29, 280);
            lblHastaTCNo.Name = "lblHastaTCNo";
            lblHastaTCNo.Size = new Size(135, 28);
            lblHastaTCNo.TabIndex = 7;
            lblHastaTCNo.Text = "Hasta TC No :";
            // 
            // txtHastaTCNo
            // 
            txtHastaTCNo.Location = new Point(205, 277);
            txtHastaTCNo.Name = "txtHastaTCNo";
            txtHastaTCNo.Size = new Size(150, 34);
            txtHastaTCNo.TabIndex = 6;
            // 
            // lblRandevuTarih
            // 
            lblRandevuTarih.AutoSize = true;
            lblRandevuTarih.BackColor = SystemColors.ButtonHighlight;
            lblRandevuTarih.Location = new Point(29, 171);
            lblRandevuTarih.Name = "lblRandevuTarih";
            lblRandevuTarih.Size = new Size(156, 28);
            lblRandevuTarih.TabIndex = 5;
            lblRandevuTarih.Text = "Randevu Tarihi :";
            // 
            // dtpRandevuTarihi
            // 
            dtpRandevuTarihi.Location = new Point(205, 171);
            dtpRandevuTarihi.Name = "dtpRandevuTarihi";
            dtpRandevuTarihi.Size = new Size(276, 34);
            dtpRandevuTarihi.TabIndex = 4;
            // 
            // lblDoktorSecimi
            // 
            lblDoktorSecimi.AutoSize = true;
            lblDoktorSecimi.BackColor = SystemColors.ButtonHighlight;
            lblDoktorSecimi.Location = new Point(29, 127);
            lblDoktorSecimi.Name = "lblDoktorSecimi";
            lblDoktorSecimi.Size = new Size(151, 28);
            lblDoktorSecimi.TabIndex = 3;
            lblDoktorSecimi.Text = "Doktor Seçimi :";
            // 
            // cmbDoktorSecimi
            // 
            cmbDoktorSecimi.FormattingEnabled = true;
            cmbDoktorSecimi.Location = new Point(205, 119);
            cmbDoktorSecimi.Name = "cmbDoktorSecimi";
            cmbDoktorSecimi.Size = new Size(182, 36);
            cmbDoktorSecimi.TabIndex = 2;
            // 
            // grpHizliHastaKaydi
            // 
            grpHizliHastaKaydi.BackColor = SystemColors.ActiveCaption;
            grpHizliHastaKaydi.Controls.Add(btnHastaListesiYenile);
            grpHizliHastaKaydi.Controls.Add(lblHastalar);
            grpHizliHastaKaydi.Controls.Add(dgvHastalar);
            grpHizliHastaKaydi.Controls.Add(txtHastaTelNo);
            grpHizliHastaKaydi.Controls.Add(txtHastaTC);
            grpHizliHastaKaydi.Controls.Add(txtHastaSoyad);
            grpHizliHastaKaydi.Controls.Add(txtHastaAdi);
            grpHizliHastaKaydi.Controls.Add(btnHastaKaydet);
            grpHizliHastaKaydi.Controls.Add(lblHastaTelNo);
            grpHizliHastaKaydi.Controls.Add(lblHastaTC);
            grpHizliHastaKaydi.Controls.Add(lblHastaSoyad);
            grpHizliHastaKaydi.Controls.Add(lblHastaAd);
            grpHizliHastaKaydi.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            grpHizliHastaKaydi.Location = new Point(555, 35);
            grpHizliHastaKaydi.Name = "grpHizliHastaKaydi";
            grpHizliHastaKaydi.Size = new Size(471, 531);
            grpHizliHastaKaydi.TabIndex = 0;
            grpHizliHastaKaydi.TabStop = false;
            grpHizliHastaKaydi.Text = "Hızlı Hasta Kaydı";
            // 
            // btnHastaListesiYenile
            // 
            btnHastaListesiYenile.Location = new Point(237, 486);
            btnHastaListesiYenile.Name = "btnHastaListesiYenile";
            btnHastaListesiYenile.Size = new Size(178, 34);
            btnHastaListesiYenile.TabIndex = 11;
            btnHastaListesiYenile.Text = "Listeyi Güncelle";
            btnHastaListesiYenile.UseVisualStyleBackColor = true;
            // 
            // lblHastalar
            // 
            lblHastalar.AutoSize = true;
            lblHastalar.BackColor = SystemColors.ButtonHighlight;
            lblHastalar.Location = new Point(48, 305);
            lblHastalar.Name = "lblHastalar";
            lblHastalar.Size = new Size(96, 28);
            lblHastalar.TabIndex = 22;
            lblHastalar.Text = "Hastalar :";
            // 
            // dgvHastalar
            // 
            dgvHastalar.BackgroundColor = SystemColors.ButtonHighlight;
            dgvHastalar.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgvHastalar.Location = new Point(48, 342);
            dgvHastalar.Name = "dgvHastalar";
            dgvHastalar.RowHeadersWidth = 62;
            dgvHastalar.Size = new Size(367, 138);
            dgvHastalar.TabIndex = 20;
            dgvHastalar.CellClick += dgvHastalar_CellClick;
            dgvHastalar.CellContentClick += dgvHastalar_CellContentClick;
            // 
            // txtHastaTelNo
            // 
            txtHastaTelNo.Location = new Point(213, 220);
            txtHastaTelNo.Name = "txtHastaTelNo";
            txtHastaTelNo.Size = new Size(150, 34);
            txtHastaTelNo.TabIndex = 19;
            // 
            // txtHastaTC
            // 
            txtHastaTC.Location = new Point(213, 171);
            txtHastaTC.Name = "txtHastaTC";
            txtHastaTC.Size = new Size(150, 34);
            txtHastaTC.TabIndex = 18;
            // 
            // txtHastaSoyad
            // 
            txtHastaSoyad.Location = new Point(213, 127);
            txtHastaSoyad.Name = "txtHastaSoyad";
            txtHastaSoyad.Size = new Size(150, 34);
            txtHastaSoyad.TabIndex = 17;
            // 
            // txtHastaAdi
            // 
            txtHastaAdi.Location = new Point(213, 73);
            txtHastaAdi.Name = "txtHastaAdi";
            txtHastaAdi.Size = new Size(150, 34);
            txtHastaAdi.TabIndex = 16;
            // 
            // btnHastaKaydet
            // 
            btnHastaKaydet.Location = new Point(213, 271);
            btnHastaKaydet.Name = "btnHastaKaydet";
            btnHastaKaydet.Size = new Size(156, 34);
            btnHastaKaydet.TabIndex = 15;
            btnHastaKaydet.Text = "Hastayı Kaydet ";
            btnHastaKaydet.UseVisualStyleBackColor = true;
            btnHastaKaydet.Click += btnHastaKaydet_Click;
            // 
            // lblHastaTelNo
            // 
            lblHastaTelNo.AutoSize = true;
            lblHastaTelNo.BackColor = SystemColors.ButtonHighlight;
            lblHastaTelNo.Location = new Point(27, 220);
            lblHastaTelNo.Name = "lblHastaTelNo";
            lblHastaTelNo.Size = new Size(180, 28);
            lblHastaTelNo.TabIndex = 14;
            lblHastaTelNo.Text = "Hasta Telefon No :";
            // 
            // lblHastaTC
            // 
            lblHastaTC.AutoSize = true;
            lblHastaTC.BackColor = SystemColors.ButtonHighlight;
            lblHastaTC.Location = new Point(27, 171);
            lblHastaTC.Name = "lblHastaTC";
            lblHastaTC.Size = new Size(102, 28);
            lblHastaTC.TabIndex = 13;
            lblHastaTC.Text = "Hasta TC :";
            // 
            // lblHastaSoyad
            // 
            lblHastaSoyad.AutoSize = true;
            lblHastaSoyad.BackColor = SystemColors.ButtonHighlight;
            lblHastaSoyad.Location = new Point(27, 127);
            lblHastaSoyad.Name = "lblHastaSoyad";
            lblHastaSoyad.Size = new Size(135, 28);
            lblHastaSoyad.TabIndex = 12;
            lblHastaSoyad.Text = "Hasta Soyad :";
            // 
            // lblHastaAd
            // 
            lblHastaAd.AutoSize = true;
            lblHastaAd.BackColor = SystemColors.ButtonHighlight;
            lblHastaAd.Location = new Point(26, 71);
            lblHastaAd.Name = "lblHastaAd";
            lblHastaAd.Size = new Size(110, 28);
            lblHastaAd.TabIndex = 11;
            lblHastaAd.Text = "Hasta Adı :";
            // 
            // grpGonderilecekNot
            // 
            grpGonderilecekNot.BackColor = SystemColors.ActiveCaption;
            grpGonderilecekNot.Controls.Add(btnGonderilenNotlariGuncelle);
            grpGonderilecekNot.Controls.Add(lblGonderilenNotlar);
            grpGonderilecekNot.Controls.Add(dgvGonderilenNotlar);
            grpGonderilecekNot.Controls.Add(btnNotuGonder);
            grpGonderilecekNot.Controls.Add(rtxNotİcerigi);
            grpGonderilecekNot.Controls.Add(lblHangiDoktor);
            grpGonderilecekNot.Controls.Add(cmbDoktorSec);
            grpGonderilecekNot.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            grpGonderilecekNot.Location = new Point(283, 693);
            grpGonderilecekNot.Name = "grpGonderilecekNot";
            grpGonderilecekNot.Size = new Size(743, 292);
            grpGonderilecekNot.TabIndex = 1;
            grpGonderilecekNot.TabStop = false;
            grpGonderilecekNot.Text = "Gönderilecek Not ";
            // 
            // btnGonderilenNotlariGuncelle
            // 
            btnGonderilenNotlariGuncelle.BackColor = Color.Snow;
            btnGonderilenNotlariGuncelle.Location = new Point(602, 248);
            btnGonderilenNotlariGuncelle.Name = "btnGonderilenNotlariGuncelle";
            btnGonderilenNotlariGuncelle.Size = new Size(112, 38);
            btnGonderilenNotlariGuncelle.TabIndex = 2;
            btnGonderilenNotlariGuncelle.Text = "Güncelle";
            btnGonderilenNotlariGuncelle.UseVisualStyleBackColor = false;
            btnGonderilenNotlariGuncelle.Click += btnGonderilenNotlariGuncelle_Click;
            // 
            // lblGonderilenNotlar
            // 
            lblGonderilenNotlar.AutoSize = true;
            lblGonderilenNotlar.BackColor = SystemColors.ButtonHighlight;
            lblGonderilenNotlar.Location = new Point(418, 44);
            lblGonderilenNotlar.Name = "lblGonderilenNotlar";
            lblGonderilenNotlar.Size = new Size(186, 28);
            lblGonderilenNotlar.TabIndex = 7;
            lblGonderilenNotlar.Text = "Gönderilen Notlar :";
            // 
            // dgvGonderilenNotlar
            // 
            dgvGonderilenNotlar.BackgroundColor = SystemColors.ButtonHighlight;
            dgvGonderilenNotlar.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgvGonderilenNotlar.Location = new Point(416, 75);
            dgvGonderilenNotlar.Name = "dgvGonderilenNotlar";
            dgvGonderilenNotlar.RowHeadersWidth = 62;
            dgvGonderilenNotlar.Size = new Size(296, 167);
            dgvGonderilenNotlar.TabIndex = 6;
            // 
            // btnNotuGonder
            // 
            btnNotuGonder.Location = new Point(232, 234);
            btnNotuGonder.Name = "btnNotuGonder";
            btnNotuGonder.Size = new Size(150, 34);
            btnNotuGonder.TabIndex = 5;
            btnNotuGonder.Text = "Notu Gönder";
            btnNotuGonder.UseVisualStyleBackColor = true;
            btnNotuGonder.Click += btnNotuGonder_Click;
            // 
            // rtxNotİcerigi
            // 
            rtxNotİcerigi.Location = new Point(41, 108);
            rtxNotİcerigi.Name = "rtxNotİcerigi";
            rtxNotİcerigi.Size = new Size(341, 120);
            rtxNotİcerigi.TabIndex = 4;
            rtxNotİcerigi.Text = "";
            // 
            // lblHangiDoktor
            // 
            lblHangiDoktor.AutoSize = true;
            lblHangiDoktor.Location = new Point(41, 57);
            lblHangiDoktor.Name = "lblHangiDoktor";
            lblHangiDoktor.Size = new Size(123, 28);
            lblHangiDoktor.TabIndex = 3;
            lblHangiDoktor.Text = "Doktor Seç :";
            // 
            // cmbDoktorSec
            // 
            cmbDoktorSec.FormattingEnabled = true;
            cmbDoktorSec.Location = new Point(170, 57);
            cmbDoktorSec.Name = "cmbDoktorSec";
            cmbDoktorSec.Size = new Size(151, 36);
            cmbDoktorSec.TabIndex = 2;
            // 
            // btnDegisiklikleriKaydet
            // 
            btnDegisiklikleriKaydet.BackColor = SystemColors.ActiveCaption;
            btnDegisiklikleriKaydet.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            btnDegisiklikleriKaydet.Location = new Point(818, 572);
            btnDegisiklikleriKaydet.Name = "btnDegisiklikleriKaydet";
            btnDegisiklikleriKaydet.Size = new Size(208, 40);
            btnDegisiklikleriKaydet.TabIndex = 2;
            btnDegisiklikleriKaydet.Text = "Seçili Kaydı Düzenle";
            btnDegisiklikleriKaydet.UseVisualStyleBackColor = false;
            btnDegisiklikleriKaydet.Click += btnDegisiklikleriKaydet_Click;
            // 
            // btnKaydiSil
            // 
            btnKaydiSil.BackColor = SystemColors.ActiveCaption;
            btnKaydiSil.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            btnKaydiSil.Location = new Point(818, 618);
            btnKaydiSil.Name = "btnKaydiSil";
            btnKaydiSil.Size = new Size(208, 41);
            btnKaydiSil.TabIndex = 3;
            btnKaydiSil.Text = "Seçili Kaydı Sil";
            btnKaydiSil.UseVisualStyleBackColor = false;
            btnKaydiSil.Click += btnKaydiSil_Click;
            // 
            // btnKaydiDuzenle
            // 
            btnKaydiDuzenle.BackColor = SystemColors.ActiveCaption;
            btnKaydiDuzenle.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            btnKaydiDuzenle.Location = new Point(34, 671);
            btnKaydiDuzenle.Name = "btnKaydiDuzenle";
            btnKaydiDuzenle.Size = new Size(180, 41);
            btnKaydiDuzenle.TabIndex = 4;
            btnKaydiDuzenle.Text = "Kaydı Düzenle ";
            btnKaydiDuzenle.UseVisualStyleBackColor = false;
            btnKaydiDuzenle.Click += btnKaydiDuzenle_Click;
            // 
            // btnKaydıSilRandevu
            // 
            btnKaydıSilRandevu.BackColor = SystemColors.ActiveCaption;
            btnKaydıSilRandevu.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            btnKaydıSilRandevu.Location = new Point(34, 722);
            btnKaydıSilRandevu.Name = "btnKaydıSilRandevu";
            btnKaydıSilRandevu.Size = new Size(122, 43);
            btnKaydıSilRandevu.TabIndex = 5;
            btnKaydıSilRandevu.Text = "Kaydı Sil ";
            btnKaydıSilRandevu.UseVisualStyleBackColor = false;
            btnKaydıSilRandevu.Click += btnKaydıSilRandevu_Click;
            // 
            // frmSekrerterinSayfasi
            // 
            AutoScaleDimensions = new SizeF(10F, 25F);
            AutoScaleMode = AutoScaleMode.Font;
            BackColor = SystemColors.Control;
            ClientSize = new Size(1050, 1009);
            Controls.Add(btnKaydıSilRandevu);
            Controls.Add(btnKaydiDuzenle);
            Controls.Add(btnKaydiSil);
            Controls.Add(btnDegisiklikleriKaydet);
            Controls.Add(grpGonderilecekNot);
            Controls.Add(grpHizliHastaKaydi);
            Controls.Add(grpRandevuOlusturma);
            Name = "frmSekrerterinSayfasi";
            Text = "Sekreter Sayfası";
            Load += frmSekrerterinSayfasi_Load;
            grpRandevuOlusturma.ResumeLayout(false);
            grpRandevuOlusturma.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)dgvRandevuTablosu).EndInit();
            grpHizliHastaKaydi.ResumeLayout(false);
            grpHizliHastaKaydi.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)dgvHastalar).EndInit();
            grpGonderilecekNot.ResumeLayout(false);
            grpGonderilecekNot.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)dgvGonderilenNotlar).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private GroupBox grpRandevuOlusturma;
        private GroupBox grpHizliHastaKaydi;
        private GroupBox grpGonderilecekNot;
        private Label lblHangiDoktor;
        private ComboBox cmbDoktorSec;
        private Button btnNotuGonder;
        private RichTextBox rtxNotİcerigi;
        private DataGridView dgvGonderilenNotlar;
        private Label lblGonderilenNotlar;
        private Button btnGonderilenNotlariGuncelle;
        private Button btnRandevuEkle;
        private Label lblHastaTCNo;
        private TextBox txtHastaTCNo;
        private Label lblRandevuTarih;
        private DateTimePicker dtpRandevuTarihi;
        private Label lblDoktorSecimi;
        private ComboBox cmbDoktorSecimi;
        private DataGridView dgvRandevuTablosu;
        private Label lblRandevu;
        private DataGridView dgvHastalar;
        private TextBox txtHastaTelNo;
        private TextBox txtHastaTC;
        private TextBox txtHastaSoyad;
        private TextBox txtHastaAdi;
        private Button btnHastaKaydet;
        private Label lblHastaTelNo;
        private Label lblHastaTC;
        private Label lblHastaSoyad;
        private Label lblHastaAd;
        private Label lblHastalar;
        private Button btnRandevuListesiYenile;
        private Button btnHastaListesiYenile;
        private Button btnDegisiklikleriKaydet;
        private Button btnKaydiSil;
        private ComboBox cmbBransSec;
        private Label lblBransıSec;
        private Label lblRandevuSaati;
        private MaskedTextBox mtxtRandevuSaat;
        private Button btnKaydiDuzenle;
        private Button btnKaydıSilRandevu;
    }
}