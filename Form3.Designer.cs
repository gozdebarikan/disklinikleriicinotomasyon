namespace disklinikleriicinotomasyon
{
    partial class frmSifremiUnuttum
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
            label1 = new Label();
            lblSifreOlusturma = new Label();
            lblSifreTekrar = new Label();
            lblTCKimlik = new Label();
            lblSifreKaydet = new Button();
            btnGirisEkraninaDon = new Button();
            txtTCKontrol = new TextBox();
            txtSifreGir = new TextBox();
            txtYineSifreGir = new TextBox();
            SuspendLayout();
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.BackColor = SystemColors.ActiveCaption;
            label1.Font = new Font("Segoe UI", 12F, FontStyle.Bold, GraphicsUnit.Point, 162);
            label1.Location = new Point(403, 111);
            label1.Name = "label1";
            label1.Size = new Size(206, 32);
            label1.TabIndex = 0;
            label1.Text = "ŞİFRE YENİLEME ";
            // 
            // lblSifreOlusturma
            // 
            lblSifreOlusturma.AutoSize = true;
            lblSifreOlusturma.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblSifreOlusturma.Location = new Point(264, 338);
            lblSifreOlusturma.Name = "lblSifreOlusturma";
            lblSifreOlusturma.Size = new Size(64, 28);
            lblSifreOlusturma.TabIndex = 1;
            lblSifreOlusturma.Text = "Şifre :";
            // 
            // lblSifreTekrar
            // 
            lblSifreTekrar.AutoSize = true;
            lblSifreTekrar.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblSifreTekrar.Location = new Point(264, 437);
            lblSifreTekrar.Name = "lblSifreTekrar";
            lblSifreTekrar.Size = new Size(125, 28);
            lblSifreTekrar.TabIndex = 2;
            lblSifreTekrar.Text = "Şifre Tekrar :";
            // 
            // lblTCKimlik
            // 
            lblTCKimlik.AutoSize = true;
            lblTCKimlik.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblTCKimlik.Location = new Point(264, 242);
            lblTCKimlik.Name = "lblTCKimlik";
            lblTCKimlik.Size = new Size(140, 28);
            lblTCKimlik.TabIndex = 3;
            lblTCKimlik.Text = "TC Kimlik No :";
            // 
            // lblSifreKaydet
            // 
            lblSifreKaydet.BackColor = SystemColors.ActiveCaption;
            lblSifreKaydet.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            lblSifreKaydet.Location = new Point(431, 528);
            lblSifreKaydet.Name = "lblSifreKaydet";
            lblSifreKaydet.Size = new Size(169, 42);
            lblSifreKaydet.TabIndex = 4;
            lblSifreKaydet.Text = "Şifreyi Güncelle";
            lblSifreKaydet.UseVisualStyleBackColor = false;
            lblSifreKaydet.Click += lblSifreKaydet_Click;
            // 
            // btnGirisEkraninaDon
            // 
            btnGirisEkraninaDon.BackColor = Color.RosyBrown;
            btnGirisEkraninaDon.Font = new Font("Segoe UI Semibold", 10F, FontStyle.Bold, GraphicsUnit.Point, 162);
            btnGirisEkraninaDon.Location = new Point(43, 818);
            btnGirisEkraninaDon.Name = "btnGirisEkraninaDon";
            btnGirisEkraninaDon.Size = new Size(224, 40);
            btnGirisEkraninaDon.TabIndex = 5;
            btnGirisEkraninaDon.Text = "Giriş Ekranına Dön ";
            btnGirisEkraninaDon.UseVisualStyleBackColor = false;
            btnGirisEkraninaDon.Click += btnGirisEkraninaDon_Click;
            // 
            // txtTCKontrol
            // 
            txtTCKontrol.Location = new Point(440, 242);
            txtTCKontrol.Name = "txtTCKontrol";
            txtTCKontrol.Size = new Size(150, 31);
            txtTCKontrol.TabIndex = 6;
            // 
            // txtSifreGir
            // 
            txtSifreGir.Location = new Point(440, 349);
            txtSifreGir.Name = "txtSifreGir";
            txtSifreGir.PasswordChar = '*';
            txtSifreGir.Size = new Size(150, 31);
            txtSifreGir.TabIndex = 7;
            // 
            // txtYineSifreGir
            // 
            txtYineSifreGir.Location = new Point(440, 437);
            txtYineSifreGir.Name = "txtYineSifreGir";
            txtYineSifreGir.PasswordChar = '*';
            txtYineSifreGir.Size = new Size(150, 31);
            txtYineSifreGir.TabIndex = 8;
            // 
            // frmSifremiUnuttum
            // 
            AutoScaleDimensions = new SizeF(10F, 25F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1050, 914);
            Controls.Add(txtYineSifreGir);
            Controls.Add(txtSifreGir);
            Controls.Add(txtTCKontrol);
            Controls.Add(btnGirisEkraninaDon);
            Controls.Add(lblSifreKaydet);
            Controls.Add(lblTCKimlik);
            Controls.Add(lblSifreTekrar);
            Controls.Add(lblSifreOlusturma);
            Controls.Add(label1);
            Name = "frmSifremiUnuttum";
            Text = "Şifre Yenileme";
            Load += frmSifremiUnuttum_Load;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label label1;
        private Label lblSifreOlusturma;
        private Label lblSifreTekrar;
        private Label lblTCKimlik;
        private Button lblSifreKaydet;
        private Button btnGirisEkraninaDon;
        private TextBox txtTCKontrol;
        private TextBox txtSifreGir;
        private TextBox txtYineSifreGir;
    }
}