namespace disklinikleriicinotomasyon
{
    partial class frmGirisinPaneli
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
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
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(frmGirisinPaneli));
            lblYetki = new Label();
            cmbKullaniciTipi = new ComboBox();
            lblTCKimlikNo = new Label();
            lblSifre = new Label();
            btnGirisYap = new Button();
            txtTC = new TextBox();
            txtSifre = new TextBox();
            linklblYeniHesapOlustur = new LinkLabel();
            linklblSifremiUnuttum = new LinkLabel();
            lblGirisBaslik = new Label();
            pctrDis = new PictureBox();
            ((System.ComponentModel.ISupportInitialize)pctrDis).BeginInit();
            SuspendLayout();
            // 
            // lblYetki
            // 
            lblYetki.AutoSize = true;
            lblYetki.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblYetki.Location = new Point(197, 135);
            lblYetki.Name = "lblYetki";
            lblYetki.Size = new Size(67, 28);
            lblYetki.TabIndex = 0;
            lblYetki.Text = "Yetki :";
            // 
            // cmbKullaniciTipi
            // 
            cmbKullaniciTipi.DropDownStyle = ComboBoxStyle.DropDownList;
            cmbKullaniciTipi.FormattingEnabled = true;
            cmbKullaniciTipi.Items.AddRange(new object[] { "Doktor", "Sekreter" });
            cmbKullaniciTipi.Location = new Point(333, 130);
            cmbKullaniciTipi.Name = "cmbKullaniciTipi";
            cmbKullaniciTipi.Size = new Size(182, 33);
            cmbKullaniciTipi.TabIndex = 1;
            // 
            // lblTCKimlikNo
            // 
            lblTCKimlikNo.AutoSize = true;
            lblTCKimlikNo.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblTCKimlikNo.Location = new Point(197, 201);
            lblTCKimlikNo.Name = "lblTCKimlikNo";
            lblTCKimlikNo.Size = new Size(140, 28);
            lblTCKimlikNo.TabIndex = 2;
            lblTCKimlikNo.Text = "TC Kimlik No :";
            // 
            // lblSifre
            // 
            lblSifre.AutoSize = true;
            lblSifre.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblSifre.Location = new Point(197, 274);
            lblSifre.Name = "lblSifre";
            lblSifre.Size = new Size(64, 28);
            lblSifre.TabIndex = 3;
            lblSifre.Text = "Şifre :";
            // 
            // btnGirisYap
            // 
            btnGirisYap.BackColor = SystemColors.ActiveCaption;
            btnGirisYap.Font = new Font("Segoe UI", 11F, FontStyle.Bold, GraphicsUnit.Point, 162);
            btnGirisYap.Location = new Point(360, 351);
            btnGirisYap.Name = "btnGirisYap";
            btnGirisYap.Size = new Size(130, 41);
            btnGirisYap.TabIndex = 4;
            btnGirisYap.Text = "GİRİŞ YAP";
            btnGirisYap.UseVisualStyleBackColor = false;
            btnGirisYap.Click += btnGirisYap_Click;
            // 
            // txtTC
            // 
            txtTC.Location = new Point(337, 195);
            txtTC.MaxLength = 11;
            txtTC.Name = "txtTC";
            txtTC.Size = new Size(178, 31);
            txtTC.TabIndex = 5;
            // 
            // txtSifre
            // 
            txtSifre.Location = new Point(337, 271);
            txtSifre.Name = "txtSifre";
            txtSifre.PasswordChar = '*';
            txtSifre.Size = new Size(178, 31);
            txtSifre.TabIndex = 6;
            // 
            // linklblYeniHesapOlustur
            // 
            linklblYeniHesapOlustur.AutoSize = true;
            linklblYeniHesapOlustur.LinkColor = Color.MediumBlue;
            linklblYeniHesapOlustur.Location = new Point(541, 455);
            linklblYeniHesapOlustur.Name = "linklblYeniHesapOlustur";
            linklblYeniHesapOlustur.Size = new Size(170, 25);
            linklblYeniHesapOlustur.TabIndex = 7;
            linklblYeniHesapOlustur.TabStop = true;
            linklblYeniHesapOlustur.Text = "Yeni Hesap OLuştur ";
            linklblYeniHesapOlustur.LinkClicked += linklblYeniHesapOlustur_LinkClicked;
            // 
            // linklblSifremiUnuttum
            // 
            linklblSifremiUnuttum.AutoSize = true;
            linklblSifremiUnuttum.LinkColor = Color.MediumBlue;
            linklblSifremiUnuttum.Location = new Point(184, 455);
            linklblSifremiUnuttum.Name = "linklblSifremiUnuttum";
            linklblSifremiUnuttum.Size = new Size(142, 25);
            linklblSifremiUnuttum.TabIndex = 8;
            linklblSifremiUnuttum.TabStop = true;
            linklblSifremiUnuttum.Text = "Şifremi Unuttum";
            linklblSifremiUnuttum.LinkClicked += linklblSifremiUnuttum_LinkClicked;
            // 
            // lblGirisBaslik
            // 
            lblGirisBaslik.AutoSize = true;
            lblGirisBaslik.BackColor = SystemColors.ActiveCaption;
            lblGirisBaslik.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblGirisBaslik.Location = new Point(270, 48);
            lblGirisBaslik.Name = "lblGirisBaslik";
            lblGirisBaslik.Size = new Size(315, 32);
            lblGirisBaslik.TabIndex = 9;
            lblGirisBaslik.Text = "DİŞ KLİNİK OTOMASYONU";
            // 
            // pctrDis
            // 
            pctrDis.Image = (Image)resources.GetObject("pctrDis.Image");
            pctrDis.Location = new Point(620, 130);
            pctrDis.Name = "pctrDis";
            pctrDis.Size = new Size(136, 162);
            pctrDis.SizeMode = PictureBoxSizeMode.StretchImage;
            pctrDis.TabIndex = 10;
            pctrDis.TabStop = false;
            // 
            // frmGirisinPaneli
            // 
            AutoScaleDimensions = new SizeF(10F, 25F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(882, 769);
            Controls.Add(pctrDis);
            Controls.Add(lblGirisBaslik);
            Controls.Add(linklblSifremiUnuttum);
            Controls.Add(linklblYeniHesapOlustur);
            Controls.Add(txtSifre);
            Controls.Add(txtTC);
            Controls.Add(btnGirisYap);
            Controls.Add(lblSifre);
            Controls.Add(lblTCKimlikNo);
            Controls.Add(cmbKullaniciTipi);
            Controls.Add(lblYetki);
            Name = "frmGirisinPaneli";
            Text = "Giriş ";
            Load += frmGirisinPaneli_Load;
            ((System.ComponentModel.ISupportInitialize)pctrDis).EndInit();
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label lblYetki;
        private ComboBox cmbKullaniciTipi;
        private Label lblTCKimlikNo;
        private Label lblSifre;
        private Button btnGirisYap;
        private TextBox txtTC;
        private TextBox txtSifre;
        private LinkLabel linklblYeniHesapOlustur;
        private LinkLabel linklblSifremiUnuttum;
        private Label lblGirisBaslik;
        private PictureBox pctrDis;
    }
}
