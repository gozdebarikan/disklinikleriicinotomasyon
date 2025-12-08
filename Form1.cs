

using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;




namespace disklinikleriicinotomasyon
{
    public partial class frmGirisinPaneli : Form
    {


        public frmGirisinPaneli()
        {
            InitializeComponent();
        }

        private void frmGirisinPaneli_Load(object sender, EventArgs e)
        {




        }

        private void btnGirisYap_Click(object sender, EventArgs e)
        {

            string tc = txtTC.Text;
            string sifre = txtSifre.Text;
            string rolSecimi = cmbKullaniciTipi.Text;

            if (string.IsNullOrEmpty(tc) || string.IsNullOrEmpty(sifre) || string.IsNullOrEmpty(rolSecimi))
            {
                MessageBox.Show("Lütfen tüm alanlarý doldurunuz.", "Uyarý", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }


            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection connection = new SqlConnection(baglantiCumlesi))
                {
                    connection.Open();


                    string sorgu = "SELECT PersonelID, Rol FROM PersonelTbl WHERE TCKimlikNo = @tc AND Sifre = @sifre AND Rol = @rol";

                    SqlCommand komut = new SqlCommand(sorgu, connection);


                    komut.Parameters.AddWithValue("@tc", tc);
                    komut.Parameters.AddWithValue("@sifre", sifre);
                    komut.Parameters.AddWithValue("@rol", rolSecimi);

                    SqlDataReader reader = komut.ExecuteReader();

                    if (reader.Read())
                    {
                        int personelID = Convert.ToInt32(reader["PersonelID"]);
                        string gercekRol = reader["Rol"].ToString();

                        this.Hide();


                        if (gercekRol == "Doktor")
                        {
                            frmDoktorSayfasi doktorPanel = new frmDoktorSayfasi(personelID);
                            doktorPanel.Show();
                        }
                        else if (gercekRol == "Sekreter")
                        {
                            frmSekrerterinSayfasi sekreterPanel = new frmSekrerterinSayfasi(personelID);
                            sekreterPanel.Show();
                        }
                    }
                    else
                    {
                        MessageBox.Show("Giriþ bilgileri hatalý veya kullanýcý tipi eþleþmiyor.", "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("SQL baðlantý veya sorgu hatasý: " + ex.Message, "Kritik SQL Hatasý", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }


        }

        private void linklblYeniHesapOlustur_LinkClicked(object sender, LinkLabelLinkClickedEventArgs e)
        {
            frmYeniKayitOlusturma kyt = new frmYeniKayitOlusturma();
            kyt.Show();
        }

        private void linklblSifremiUnuttum_LinkClicked(object sender, LinkLabelLinkClickedEventArgs e)
        {
            frmSifremiUnuttum fr = new frmSifremiUnuttum();
            fr.Show();
        }
    }
}

