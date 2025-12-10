using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Data.SqlClient;

namespace disklinikleriicinotomasyon
{
    public partial class frmSifremiUnuttum : Form
    {
        public frmSifremiUnuttum()
        {
            InitializeComponent();
        }

        private void frmSifremiUnuttum_Load(object sender, EventArgs e)
        {

        }

        private void lblSifreKaydet_Click(object sender, EventArgs e)
        {

            string tc = txtTCKontrol.Text;
            string yeniSifre = txtSifreGir.Text;
            string sifreTekrar = txtYineSifreGir.Text;


            if (string.IsNullOrEmpty(tc) || string.IsNullOrEmpty(yeniSifre) || string.IsNullOrEmpty(sifreTekrar))
            {
                MessageBox.Show("Lütfen tüm alanları doldurunuz.", "Eksik Bilgi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }


            if (yeniSifre != sifreTekrar)
            {
                MessageBox.Show("Girdiğiniz şifreler birbiriyle uyuşmuyor! Lütfen tekrar deneyiniz.", "Şifre Hatası", MessageBoxButtons.OK, MessageBoxIcon.Error);

                txtSifreGir.Clear();
                txtYineSifreGir.Clear();
                return;
            }


            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "UPDATE PersonelTbl SET Sifre = @yeni WHERE TCKimlikNo = @tc";

                    SqlCommand komut = new SqlCommand(sorgu, baglanti);
                    komut.Parameters.AddWithValue("@yeni", yeniSifre);
                    komut.Parameters.AddWithValue("@tc", tc);

                    int sonuc = komut.ExecuteNonQuery();

                    if (sonuc > 0)
                    {
                        MessageBox.Show("Şifreniz başarıyla değiştirildi. Yeni şifrenizle giriş yapabilirsiniz.", "Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        this.Close();
                    }
                    else
                    {
                        MessageBox.Show("Bu T.C. Kimlik Numarasına ait bir kullanıcı bulunamadı.", "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Hata oluştu: " + ex.Message, "Sistem Hatası", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnGirisEkraninaDon_Click(object sender, EventArgs e)
        {
            frmGirisinPaneli giris = new frmGirisinPaneli();
            giris.Show();
            this.Close();
        }
    }
}
