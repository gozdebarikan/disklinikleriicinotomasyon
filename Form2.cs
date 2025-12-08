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
    public partial class frmYeniKayitOlusturma : Form
    {
        public frmYeniKayitOlusturma()
        {
            InitializeComponent();
        }

        private void frmYeniKayitOlusturma_Load(object sender, EventArgs e)
        {

        }

        private void btnHesapOlustur_Click(object sender, EventArgs e)
        {

            string ad = txtAd.Text;
            string soyad = txtSoyad.Text;
            string tc = txtTCYeni.Text;
            string sifre = txtSifreYeni.Text;
            string rol = cmbYetkiYeni.Text;
            string brans = cmbBrans.Text;


            if (string.IsNullOrEmpty(ad) || string.IsNullOrEmpty(soyad) || string.IsNullOrEmpty(tc) || string.IsNullOrEmpty(sifre) || string.IsNullOrEmpty(rol))
            {
                MessageBox.Show("Lütfen Branş hariç tüm alanları doldurunuz.", "Eksik Bilgi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";


            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "INSERT INTO PersonelTbl (TCKimlikNo, Ad, Soyad, Sifre, Rol, Brans) VALUES (@p1, @p2, @p3, @p4, @p5, @p6)";

                    SqlCommand komut = new SqlCommand(sorgu, baglanti);

                    komut.Parameters.AddWithValue("@p1", tc);
                    komut.Parameters.AddWithValue("@p2", ad);
                    komut.Parameters.AddWithValue("@p3", soyad);
                    komut.Parameters.AddWithValue("@p4", sifre);
                    komut.Parameters.AddWithValue("@p5", rol);


                    if (string.IsNullOrEmpty(brans))
                    {
                        komut.Parameters.AddWithValue("@p6", DBNull.Value);
                    }
                    else
                    {
                        komut.Parameters.AddWithValue("@p6", brans);
                    }


                    komut.ExecuteNonQuery();

                    MessageBox.Show("Kaydınız başarıyla oluşturuldu! Giriş ekranına dönebilirsiniz.", "Kayıt Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);


                    this.Close();
                }
            }
            catch (SqlException ex)
            {

                if (ex.Number == 2627 || ex.Number == 2601)
                {
                    MessageBox.Show("Bu T.C. Kimlik Numarası zaten kayıtlı!", "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
                else
                {
                    MessageBox.Show("Veritabanı hatası: " + ex.Message, "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Bir hata oluştu: " + ex.Message, "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnGiriseDon_Click(object sender, EventArgs e)
        {
            frmGirisinPaneli giris = new frmGirisinPaneli();
            giris.Show();
            this.Close();
        }
    }
}

