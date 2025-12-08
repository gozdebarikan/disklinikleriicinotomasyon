namespace disklinikleriicinotomasyon
{
    partial class frmYeniKayitOlusturma
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
            lblYetkiYeni = new Label();
            cmbYetkiYeni = new ComboBox();
            label2 = new Label();
            cmbBrans = new ComboBox();
            lblAd = new Label();
            lblSoyad = new Label();
            lblTcNo = new Label();
            lblKayitSifre = new Label();
            txtSifreYeni = new TextBox();
            txtAd = new TextBox();
            txtSoyad = new TextBox();
            txtTCYeni = new TextBox();
            btnHesapOlustur = new Button();
            btnGiriseDon = new Button();
            lblYeniGiris = new Label();
            SuspendLayout();
            // 
            // lblYetkiYeni
            // 
            lblYetkiYeni.AutoSize = true;
            lblYetkiYeni.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblYetkiYeni.Location = new Point(186, 112);
            lblYetkiYeni.Name = "lblYetkiYeni";
            lblYetkiYeni.Size = new Size(67, 28);
            lblYetkiYeni.TabIndex = 0;
            lblYetkiYeni.Text = "Yetki :";
            // 
            // cmbYetkiYeni
            // 
            cmbYetkiYeni.DropDownStyle = ComboBoxStyle.DropDownList;
            cmbYetkiYeni.FormattingEnabled = true;
            cmbYetkiYeni.Items.AddRange(new object[] { "Doktor", "Sekreter" });
            cmbYetkiYeni.Location = new Point(332, 107);
            cmbYetkiYeni.Name = "cmbYetkiYeni";
            cmbYetkiYeni.Size = new Size(154, 33);
            cmbYetkiYeni.TabIndex = 1;
            // 
            // label2
            // 
            label2.AutoSize = true;
            label2.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            label2.Location = new Point(186, 182);
            label2.Name = "label2";
            label2.Size = new Size(73, 28);
            label2.TabIndex = 2;
            label2.Text = "Branş :";
            // 
            // cmbBrans
            // 
            cmbBrans.DropDownStyle = ComboBoxStyle.DropDownList;
            cmbBrans.FormattingEnabled = true;
            cmbBrans.Items.AddRange(new object[] { "Genel Diş Hekimi", "Pedodonti", "Ortodonti", "Çene Cerrahi" });
            cmbBrans.Location = new Point(332, 182);
            cmbBrans.Name = "cmbBrans";
            cmbBrans.Size = new Size(150, 33);
            cmbBrans.TabIndex = 3;
            // 
            // lblAd
            // 
            lblAd.AutoSize = true;
            lblAd.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblAd.Location = new Point(186, 251);
            lblAd.Name = "lblAd";
            lblAd.Size = new Size(48, 28);
            lblAd.TabIndex = 4;
            lblAd.Text = "Ad :";
            // 
            // lblSoyad
            // 
            lblSoyad.AutoSize = true;
            lblSoyad.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblSoyad.Location = new Point(186, 296);
            lblSoyad.Name = "lblSoyad";
            lblSoyad.Size = new Size(78, 28);
            lblSoyad.TabIndex = 5;
            lblSoyad.Text = "Soyad :";
            // 
            // lblTcNo
            // 
            lblTcNo.AutoSize = true;
            lblTcNo.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblTcNo.Location = new Point(186, 344);
            lblTcNo.Name = "lblTcNo";
            lblTcNo.Size = new Size(140, 28);
            lblTcNo.TabIndex = 6;
            lblTcNo.Text = "TC Kimlik No :";
            // 
            // lblKayitSifre
            // 
            lblKayitSifre.AutoSize = true;
            lblKayitSifre.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblKayitSifre.Location = new Point(186, 398);
            lblKayitSifre.Name = "lblKayitSifre";
            lblKayitSifre.Size = new Size(64, 28);
            lblKayitSifre.TabIndex = 7;
            lblKayitSifre.Text = "Şifre :";
            // 
            // txtSifreYeni
            // 
            txtSifreYeni.Location = new Point(332, 392);
            txtSifreYeni.Name = "txtSifreYeni";
            txtSifreYeni.Size = new Size(150, 31);
            txtSifreYeni.TabIndex = 8;
            // 
            // txtAd
            // 
            txtAd.Location = new Point(332, 248);
            txtAd.Name = "txtAd";
            txtAd.Size = new Size(150, 31);
            txtAd.TabIndex = 9;
            // 
            // txtSoyad
            // 
            txtSoyad.Location = new Point(332, 293);
            txtSoyad.Name = "txtSoyad";
            txtSoyad.Size = new Size(150, 31);
            txtSoyad.TabIndex = 10;
            // 
            // txtTCYeni
            // 
            txtTCYeni.Location = new Point(332, 341);
            txtTCYeni.Name = "txtTCYeni";
            txtTCYeni.Size = new Size(150, 31);
            txtTCYeni.TabIndex = 11;
            // 
            // btnHesapOlustur
            // 
            btnHesapOlustur.BackColor = SystemColors.ActiveCaption;
            btnHesapOlustur.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 162);
            btnHesapOlustur.Location = new Point(312, 437);
            btnHesapOlustur.Name = "btnHesapOlustur";
            btnHesapOlustur.Size = new Size(190, 41);
            btnHesapOlustur.TabIndex = 12;
            btnHesapOlustur.Text = "Hesap Oluştur";
            btnHesapOlustur.UseVisualStyleBackColor = false;
            btnHesapOlustur.Click += btnHesapOlustur_Click;
            // 
            // btnGiriseDon
            // 
            btnGiriseDon.BackColor = Color.RosyBrown;
            btnGiriseDon.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            btnGiriseDon.Location = new Point(24, 512);
            btnGiriseDon.Name = "btnGiriseDon";
            btnGiriseDon.Size = new Size(194, 43);
            btnGiriseDon.TabIndex = 13;
            btnGiriseDon.Text = "Giriş Ekranına Dön";
            btnGiriseDon.UseVisualStyleBackColor = false;
            btnGiriseDon.Click += btnGiriseDon_Click;
            // 
            // lblYeniGiris
            // 
            lblYeniGiris.AutoSize = true;
            lblYeniGiris.BackColor = SystemColors.ActiveCaption;
            lblYeniGiris.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblYeniGiris.Location = new Point(243, 41);
            lblYeniGiris.Name = "lblYeniGiris";
            lblYeniGiris.Size = new Size(306, 32);
            lblYeniGiris.TabIndex = 14;
            lblYeniGiris.Text = "YENİ HESAP OLUŞTURMA";
            // 
            // frmYeniKayitOlusturma
            // 
            AutoScaleDimensions = new SizeF(10F, 25F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(800, 567);
            Controls.Add(lblYeniGiris);
            Controls.Add(btnGiriseDon);
            Controls.Add(btnHesapOlustur);
            Controls.Add(txtTCYeni);
            Controls.Add(txtSoyad);
            Controls.Add(txtAd);
            Controls.Add(txtSifreYeni);
            Controls.Add(lblKayitSifre);
            Controls.Add(lblTcNo);
            Controls.Add(lblSoyad);
            Controls.Add(lblAd);
            Controls.Add(cmbBrans);
            Controls.Add(label2);
            Controls.Add(cmbYetkiYeni);
            Controls.Add(lblYetkiYeni);
            Name = "frmYeniKayitOlusturma";
            Text = "Yeni Kayıt Oluşturma";
            Load += frmYeniKayitOlusturma_Load;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label lblYetkiYeni;
        private ComboBox cmbYetkiYeni;
        private Label label2;
        private ComboBox cmbBrans;
        private Label lblAd;
        private Label lblSoyad;
        private Label lblTcNo;
        private Label lblKayitSifre;
        private TextBox txtSifreYeni;
        private TextBox txtAd;
        private TextBox txtSoyad;
        private TextBox txtTCYeni;
        private Button btnHesapOlustur;
        private Button btnGiriseDon;
        private Label lblYeniGiris;
    }
}