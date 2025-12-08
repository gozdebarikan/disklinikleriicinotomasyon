namespace disklinikleriicinotomasyon
{
    partial class frmDoktorSayfasi
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
            grpDoktorRandevulari = new GroupBox();
            btnRandevuYenile = new Button();
            dgvDoktorRandevulari = new DataGridView();
            grpSekreterinNotlari = new GroupBox();
            btnNotlariYenile = new Button();
            dgvSekreterNotlari = new DataGridView();
            grpMuayeneKayitlari = new GroupBox();
            btnTabloDegisiklikleriniKaydet = new Button();
            btnMuayeneYenile = new Button();
            lblGecmisMuayeneListesi = new Label();
            dgvMuayeneGecmisiListesi = new DataGridView();
            btnKaydiTamamla = new Button();
            cmbTedaviDurumu = new ComboBox();
            lblTedaviDurumu = new Label();
            lblDoktorRecete = new Label();
            rtxtDoktorReçete = new RichTextBox();
            lblTani = new Label();
            txtTani = new TextBox();
            lblHastaSikayeti = new Label();
            textBox1 = new TextBox();
            lblMevcutHastalar = new Label();
            cmbMevcutHastalar = new ComboBox();
            grpDoktorRandevulari.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvDoktorRandevulari).BeginInit();
            grpSekreterinNotlari.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvSekreterNotlari).BeginInit();
            grpMuayeneKayitlari.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)dgvMuayeneGecmisiListesi).BeginInit();
            SuspendLayout();
            // 
            // grpDoktorRandevulari
            // 
            grpDoktorRandevulari.BackColor = SystemColors.ActiveCaption;
            grpDoktorRandevulari.Controls.Add(btnRandevuYenile);
            grpDoktorRandevulari.Controls.Add(dgvDoktorRandevulari);
            grpDoktorRandevulari.Font = new Font("Segoe UI Semibold", 9F, FontStyle.Bold, GraphicsUnit.Point, 162);
            grpDoktorRandevulari.Location = new Point(28, 50);
            grpDoktorRandevulari.Name = "grpDoktorRandevulari";
            grpDoktorRandevulari.Size = new Size(393, 320);
            grpDoktorRandevulari.TabIndex = 0;
            grpDoktorRandevulari.TabStop = false;
            grpDoktorRandevulari.Text = "Randevular ";
            // 
            // btnRandevuYenile
            // 
            btnRandevuYenile.Location = new Point(257, 275);
            btnRandevuYenile.Name = "btnRandevuYenile";
            btnRandevuYenile.Size = new Size(112, 34);
            btnRandevuYenile.TabIndex = 1;
            btnRandevuYenile.Text = "Yenile";
            btnRandevuYenile.UseVisualStyleBackColor = true;
            // 
            // dgvDoktorRandevulari
            // 
            dgvDoktorRandevulari.BackgroundColor = SystemColors.ButtonHighlight;
            dgvDoktorRandevulari.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgvDoktorRandevulari.Location = new Point(19, 53);
            dgvDoktorRandevulari.Name = "dgvDoktorRandevulari";
            dgvDoktorRandevulari.RowHeadersWidth = 62;
            dgvDoktorRandevulari.Size = new Size(350, 216);
            dgvDoktorRandevulari.TabIndex = 0;
            // 
            // grpSekreterinNotlari
            // 
            grpSekreterinNotlari.BackColor = SystemColors.ActiveCaption;
            grpSekreterinNotlari.Controls.Add(btnNotlariYenile);
            grpSekreterinNotlari.Controls.Add(dgvSekreterNotlari);
            grpSekreterinNotlari.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            grpSekreterinNotlari.Location = new Point(570, 50);
            grpSekreterinNotlari.Name = "grpSekreterinNotlari";
            grpSekreterinNotlari.Size = new Size(395, 320);
            grpSekreterinNotlari.TabIndex = 1;
            grpSekreterinNotlari.TabStop = false;
            grpSekreterinNotlari.Text = "Sekreterden Gelen Notlar ";
            // 
            // btnNotlariYenile
            // 
            btnNotlariYenile.Location = new Point(265, 274);
            btnNotlariYenile.Name = "btnNotlariYenile";
            btnNotlariYenile.Size = new Size(112, 34);
            btnNotlariYenile.TabIndex = 1;
            btnNotlariYenile.Text = "Yenile";
            btnNotlariYenile.UseVisualStyleBackColor = true;
            // 
            // dgvSekreterNotlari
            // 
            dgvSekreterNotlari.BackgroundColor = SystemColors.ButtonHighlight;
            dgvSekreterNotlari.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgvSekreterNotlari.Location = new Point(17, 53);
            dgvSekreterNotlari.Name = "dgvSekreterNotlari";
            dgvSekreterNotlari.RowHeadersWidth = 62;
            dgvSekreterNotlari.Size = new Size(360, 216);
            dgvSekreterNotlari.TabIndex = 0;
            // 
            // grpMuayeneKayitlari
            // 
            grpMuayeneKayitlari.BackColor = SystemColors.ActiveCaption;
            grpMuayeneKayitlari.Controls.Add(btnTabloDegisiklikleriniKaydet);
            grpMuayeneKayitlari.Controls.Add(btnMuayeneYenile);
            grpMuayeneKayitlari.Controls.Add(lblGecmisMuayeneListesi);
            grpMuayeneKayitlari.Controls.Add(dgvMuayeneGecmisiListesi);
            grpMuayeneKayitlari.Controls.Add(btnKaydiTamamla);
            grpMuayeneKayitlari.Controls.Add(cmbTedaviDurumu);
            grpMuayeneKayitlari.Controls.Add(lblTedaviDurumu);
            grpMuayeneKayitlari.Controls.Add(lblDoktorRecete);
            grpMuayeneKayitlari.Controls.Add(rtxtDoktorReçete);
            grpMuayeneKayitlari.Controls.Add(lblTani);
            grpMuayeneKayitlari.Controls.Add(txtTani);
            grpMuayeneKayitlari.Controls.Add(lblHastaSikayeti);
            grpMuayeneKayitlari.Controls.Add(textBox1);
            grpMuayeneKayitlari.Controls.Add(lblMevcutHastalar);
            grpMuayeneKayitlari.Controls.Add(cmbMevcutHastalar);
            grpMuayeneKayitlari.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            grpMuayeneKayitlari.Location = new Point(28, 447);
            grpMuayeneKayitlari.Name = "grpMuayeneKayitlari";
            grpMuayeneKayitlari.Size = new Size(937, 485);
            grpMuayeneKayitlari.TabIndex = 2;
            grpMuayeneKayitlari.TabStop = false;
            grpMuayeneKayitlari.Text = "Muayene Kaydı";
            // 
            // btnTabloDegisiklikleriniKaydet
            // 
            btnTabloDegisiklikleriniKaydet.Location = new Point(660, 422);
            btnTabloDegisiklikleriniKaydet.Name = "btnTabloDegisiklikleriniKaydet";
            btnTabloDegisiklikleriniKaydet.Size = new Size(227, 39);
            btnTabloDegisiklikleriniKaydet.TabIndex = 13;
            btnTabloDegisiklikleriniKaydet.Text = "Değişiklikleri Kaydet ";
            btnTabloDegisiklikleriniKaydet.UseVisualStyleBackColor = true;
            // 
            // btnMuayeneYenile
            // 
            btnMuayeneYenile.Location = new Point(729, 382);
            btnMuayeneYenile.Name = "btnMuayeneYenile";
            btnMuayeneYenile.Size = new Size(158, 34);
            btnMuayeneYenile.TabIndex = 3;
            btnMuayeneYenile.Text = "Listeyi Yenile ";
            btnMuayeneYenile.UseVisualStyleBackColor = true;
            // 
            // lblGecmisMuayeneListesi
            // 
            lblGecmisMuayeneListesi.AutoSize = true;
            lblGecmisMuayeneListesi.BackColor = SystemColors.ButtonHighlight;
            lblGecmisMuayeneListesi.Location = new Point(527, 107);
            lblGecmisMuayeneListesi.Name = "lblGecmisMuayeneListesi";
            lblGecmisMuayeneListesi.Size = new Size(246, 28);
            lblGecmisMuayeneListesi.TabIndex = 12;
            lblGecmisMuayeneListesi.Text = "Muayene Geçmişi Listesi :";
            // 
            // dgvMuayeneGecmisiListesi
            // 
            dgvMuayeneGecmisiListesi.BackgroundColor = SystemColors.ButtonHighlight;
            dgvMuayeneGecmisiListesi.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.AutoSize;
            dgvMuayeneGecmisiListesi.Location = new Point(527, 151);
            dgvMuayeneGecmisiListesi.Name = "dgvMuayeneGecmisiListesi";
            dgvMuayeneGecmisiListesi.RowHeadersWidth = 62;
            dgvMuayeneGecmisiListesi.Size = new Size(360, 225);
            dgvMuayeneGecmisiListesi.TabIndex = 3;
            // 
            // btnKaydiTamamla
            // 
            btnKaydiTamamla.Location = new Point(341, 416);
            btnKaydiTamamla.Name = "btnKaydiTamamla";
            btnKaydiTamamla.Size = new Size(112, 34);
            btnKaydiTamamla.TabIndex = 10;
            btnKaydiTamamla.Text = "Kaydet";
            btnKaydiTamamla.UseVisualStyleBackColor = true;
            // 
            // cmbTedaviDurumu
            // 
            cmbTedaviDurumu.DropDownStyle = ComboBoxStyle.DropDownList;
            cmbTedaviDurumu.FormattingEnabled = true;
            cmbTedaviDurumu.Items.AddRange(new object[] { "Devam ediyor.", "Tamamlandı.", "Sevk edildi.", "Beklemede ", "İptal edildi." });
            cmbTedaviDurumu.Location = new Point(262, 356);
            cmbTedaviDurumu.Name = "cmbTedaviDurumu";
            cmbTedaviDurumu.Size = new Size(182, 36);
            cmbTedaviDurumu.TabIndex = 9;
            // 
            // lblTedaviDurumu
            // 
            lblTedaviDurumu.AutoSize = true;
            lblTedaviDurumu.BackColor = SystemColors.ButtonHighlight;
            lblTedaviDurumu.Location = new Point(38, 364);
            lblTedaviDurumu.Name = "lblTedaviDurumu";
            lblTedaviDurumu.Size = new Size(161, 28);
            lblTedaviDurumu.TabIndex = 8;
            lblTedaviDurumu.Text = "Tedavi Durumu :";
            // 
            // lblDoktorRecete
            // 
            lblDoktorRecete.AutoSize = true;
            lblDoktorRecete.BackColor = SystemColors.ButtonHighlight;
            lblDoktorRecete.Location = new Point(38, 279);
            lblDoktorRecete.Name = "lblDoktorRecete";
            lblDoktorRecete.Size = new Size(89, 28);
            lblDoktorRecete.TabIndex = 7;
            lblDoktorRecete.Text = " Reçete :";
            // 
            // rtxtDoktorReçete
            // 
            rtxtDoktorReçete.Location = new Point(262, 257);
            rtxtDoktorReçete.Name = "rtxtDoktorReçete";
            rtxtDoktorReçete.Size = new Size(191, 50);
            rtxtDoktorReçete.TabIndex = 6;
            rtxtDoktorReçete.Text = "";
            // 
            // lblTani
            // 
            lblTani.AutoSize = true;
            lblTani.BackColor = SystemColors.ButtonHighlight;
            lblTani.Location = new Point(38, 202);
            lblTani.Name = "lblTani";
            lblTani.Size = new Size(59, 28);
            lblTani.TabIndex = 5;
            lblTani.Text = "Tanı :";
            // 
            // txtTani
            // 
            txtTani.Location = new Point(262, 196);
            txtTani.Name = "txtTani";
            txtTani.Size = new Size(150, 34);
            txtTani.TabIndex = 4;
            // 
            // lblHastaSikayeti
            // 
            lblHastaSikayeti.AutoSize = true;
            lblHastaSikayeti.BackColor = SystemColors.ButtonHighlight;
            lblHastaSikayeti.Location = new Point(38, 139);
            lblHastaSikayeti.Name = "lblHastaSikayeti";
            lblHastaSikayeti.Size = new Size(150, 28);
            lblHastaSikayeti.TabIndex = 3;
            lblHastaSikayeti.Text = "Hasta Şikayeti :";
            // 
            // textBox1
            // 
            textBox1.Location = new Point(262, 133);
            textBox1.Name = "textBox1";
            textBox1.Size = new Size(150, 34);
            textBox1.TabIndex = 2;
            // 
            // lblMevcutHastalar
            // 
            lblMevcutHastalar.AutoSize = true;
            lblMevcutHastalar.BackColor = SystemColors.ButtonHighlight;
            lblMevcutHastalar.Location = new Point(38, 65);
            lblMevcutHastalar.Name = "lblMevcutHastalar";
            lblMevcutHastalar.Size = new Size(199, 28);
            lblMevcutHastalar.TabIndex = 1;
            lblMevcutHastalar.Text = "İşlem Yapılan Hasta :";
            // 
            // cmbMevcutHastalar
            // 
            cmbMevcutHastalar.FormattingEnabled = true;
            cmbMevcutHastalar.Location = new Point(262, 62);
            cmbMevcutHastalar.Name = "cmbMevcutHastalar";
            cmbMevcutHastalar.Size = new Size(150, 36);
            cmbMevcutHastalar.TabIndex = 0;
            // 
            // frmDoktorSayfasi
            // 
            AutoScaleDimensions = new SizeF(10F, 25F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1050, 1009);
            Controls.Add(grpMuayeneKayitlari);
            Controls.Add(grpSekreterinNotlari);
            Controls.Add(grpDoktorRandevulari);
            Name = "frmDoktorSayfasi";
            Text = "Doktor Sayfası ";
            Load += frmDoktorSayfasi_Load;
            grpDoktorRandevulari.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgvDoktorRandevulari).EndInit();
            grpSekreterinNotlari.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)dgvSekreterNotlari).EndInit();
            grpMuayeneKayitlari.ResumeLayout(false);
            grpMuayeneKayitlari.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)dgvMuayeneGecmisiListesi).EndInit();
            ResumeLayout(false);
        }

        #endregion

        private GroupBox grpDoktorRandevulari;
        private DataGridView dgvDoktorRandevulari;
        private Button btnRandevuYenile;
        private GroupBox grpSekreterinNotlari;
        private DataGridView dgvSekreterNotlari;
        private Button btnNotlariYenile;
        private GroupBox grpMuayeneKayitlari;
        private Label lblMevcutHastalar;
        private ComboBox cmbMevcutHastalar;
        private Label lblTani;
        private TextBox txtTani;
        private Label lblHastaSikayeti;
        private TextBox textBox1;
        private RichTextBox rtxtDoktorReçete;
        private Label lblDoktorRecete;
        private Button btnKaydiTamamla;
        private ComboBox cmbTedaviDurumu;
        private Label lblTedaviDurumu;
        private Label lblGecmisMuayeneListesi;
        private DataGridView dgvMuayeneGecmisiListesi;
        private Button btnMuayeneYenile;
        private Button btnTabloDegisiklikleriniKaydet;
    }
}