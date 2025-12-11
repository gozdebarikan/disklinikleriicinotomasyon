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
    public partial class frmSekrerterinSayfasi : Form
    {
        public int sekreterID;

        int secilenHastaID = 0;
        int secilenRandevuID = 0;




        public frmSekrerterinSayfasi(int gelenID)
        {
            InitializeComponent();
            sekreterID = gelenID;
        }

        private void frmSekrerterinSayfasi_Load(object sender, EventArgs e)
        {

            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";
            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();
                    SqlCommand komut = new SqlCommand("SELECT DISTINCT Brans FROM PersonelTbl WHERE Rol='Doktor'", baglanti);
                    SqlDataReader okuyucu = komut.ExecuteReader();
                    while (okuyucu.Read())
                    {
                        cmbBransSec.Items.Add(okuyucu[0].ToString());
                    }
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Branş verileri çekilemedi: " + ex.Message);
            }


            RandevulariListele();

            HastalariListele();

            DoktorlariDuyuruIcinDoldur();


            NotlariListele();






        }

        private void cmbBransSec_SelectedIndexChanged(object sender, EventArgs e)
        {

            cmbDoktorSecimi.Items.Clear();
            cmbDoktorSecimi.Text = "";

            string secilenBrans = cmbBransSec.Text;
            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "SELECT PersonelID, Ad, Soyad FROM PersonelTbl WHERE Rol='Doktor' AND Brans=@p1";

                    SqlDataAdapter da = new SqlDataAdapter(sorgu, baglanti);
                    da.SelectCommand.Parameters.AddWithValue("@p1", secilenBrans);
                    DataTable dt = new DataTable();
                    da.Fill(dt);


                    dt.Columns.Add("AdSoyad", typeof(string), "Ad + ' ' + Soyad");


                    cmbDoktorSecimi.DataSource = dt;
                    cmbDoktorSecimi.DisplayMember = "AdSoyad";
                    cmbDoktorSecimi.ValueMember = "PersonelID";
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Doktorları listeleme hatası: " + ex.Message);
            }
        }

        private void btnRandevuEkle_Click(object sender, EventArgs e)
        {

            string hastaTC = txtHastaTCNo.Text.Trim();
            string secilenBrans = cmbBransSec.Text;

            int doktorID = 0; 

            if (cmbDoktorSecimi.SelectedValue != null)
            {
                
                int.TryParse(cmbDoktorSecimi.SelectedValue.ToString(), out doktorID);
            }

          
            if (doktorID == 0)
            {
                MessageBox.Show("Lütfen geçerli bir doktor seçiniz. Doktor ID ataması başarısız.", "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            DateTime randevuTarihi = dtpRandevuTarihi.Value;
            string saatStr = mtxtRandevuSaat.Text;
            string randevuDurumu = "Aktif";


            if (!TimeSpan.TryParse(saatStr, out TimeSpan randevuSaati))
            {
                MessageBox.Show("Saat formatı hatalı. Lütfen SS:DD formatını kullanın.", "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            DateTime tamRandevuTarihi = randevuTarihi.Date.Add(randevuSaati);


            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection connection = new SqlConnection(baglantiCumlesi))
                {
                    connection.Open();


                    string hastaKontrolSorgu = "SELECT COUNT(*) FROM HastalarınTbl WHERE TCKimlikNo = @htc";
                    SqlCommand kontrolKomut = new SqlCommand(hastaKontrolSorgu, connection);
                    kontrolKomut.Parameters.AddWithValue("@htc", hastaTC);
                    int hastaSayisi = (int)kontrolKomut.ExecuteScalar();

                    if (hastaSayisi == 0)
                    {
                        MessageBox.Show("Bu T.C. numarasına kayıtlı hasta bulunamadı. Lütfen önce hasta kaydı yapınız.", "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                        return;
                    }

                    string randevuEkleSorgusu = "INSERT INTO RandevularınTbl (HastaTC, DoktorID, Brans, RandevuTarihi, Durum) VALUES (@hTC, @dID, @brans, @tarih, @durum)";

                    SqlCommand randevuKomut = new SqlCommand(randevuEkleSorgusu, connection);
                    randevuKomut.Parameters.AddWithValue("@hTC", hastaTC);
                    randevuKomut.Parameters.AddWithValue("@dID", doktorID);
                    randevuKomut.Parameters.AddWithValue("@brans", secilenBrans);
                    randevuKomut.Parameters.AddWithValue("@tarih", tamRandevuTarihi);
                    randevuKomut.Parameters.AddWithValue("@durum", randevuDurumu);

                    randevuKomut.ExecuteNonQuery();

                    MessageBox.Show("Randevu başarıyla oluşturuldu.", "Bilgi", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    RandevulariListele();

                }
            }
            catch (Exception ex)
            {

                MessageBox.Show("Randevu kaydı sırasında hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);

            }
        }
        private void RandevulariListele()
        {
            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";



            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = @"
                SELECT 
                    R.RandevuID, 
                    R.RandevuTarihi, 
                    R.Brans,
                    CONCAT(P.Ad, ' ', P.Soyad) AS DoktorAdi,
                    CONCAT(H.Ad, ' ', H.Soyad) AS HastaAdi,
                    R.Durum
                FROM 
                    RandevularınTbl R 
                INNER JOIN 
                    PersonelTbl P ON R.DoktorID = P.PersonelID 
                INNER JOIN
                    HastalarınTbl H ON R.HastaTC = H.TCKimlikNo    
                ORDER BY R.RandevuTarihi DESC";

                    SqlDataAdapter da = new SqlDataAdapter(sorgu, baglanti);
                    DataTable dt = new DataTable();
                    da.Fill(dt);


                    dgvRandevuTablosu.DataSource = dt;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Randevular listelenirken hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnRandevuListesiYenile_Click(object sender, EventArgs e)
        {
            RandevulariListele();

        }
        private void HastalariListele()
        {
            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "SELECT HastaID, TCKimlikNo, Ad, Soyad, TelefonNo FROM HastalarınTbl ORDER BY HastaID DESC";

                    SqlDataAdapter da = new SqlDataAdapter(sorgu, baglanti);
                    DataTable dt = new DataTable();
                    da.Fill(dt);


                    dgvHastalar.DataSource = dt;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Hasta listesi çekilemedi: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnHastaKaydet_Click(object sender, EventArgs e)
        {

            string ad = txtHastaAdi.Text;
            string soyad = txtHastaSoyad.Text;
            string tc = txtHastaTC.Text;
            string telefon = txtHastaTelNo.Text;

            if (string.IsNullOrEmpty(ad) || string.IsNullOrEmpty(soyad) || string.IsNullOrEmpty(tc))
            {
                MessageBox.Show("Ad, Soyad ve T.C. Kimlik No alanları zorunludur.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();

                    string sorgu = "INSERT INTO HastalarınTbl (TCKimlikNo, Ad, Soyad, TelefonNo) VALUES (@pTC, @pAd, @pSoyad, @pTel)";

                    SqlCommand komut = new SqlCommand(sorgu, baglanti);

                    komut.Parameters.AddWithValue("@pTC", tc);
                    komut.Parameters.AddWithValue("@pAd", ad);
                    komut.Parameters.AddWithValue("@pSoyad", soyad);
                    komut.Parameters.AddWithValue("@pTel", string.IsNullOrEmpty(telefon) ? (object)DBNull.Value : telefon);

                    komut.ExecuteNonQuery();


                    MessageBox.Show($"{ad} {soyad} adlı hasta başarıyla kaydedildi.", "Kayıt Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);


                    txtHastaAdi.Clear();
                    txtHastaSoyad.Clear();
                    txtHastaTC.Clear();
                    txtHastaTelNo.Clear();

                    HastalariListele();
                }
            }
            catch (SqlException ex)
            {
                if (ex.Number == 2627 || ex.Number == 2601)
                {
                    MessageBox.Show("Bu T.C. Kimlik No zaten kayıtlıdır.", "Veri Hatası", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
                else
                {
                    MessageBox.Show("Hasta kaydı sırasında beklenmeyen bir SQL hatası oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }

        }

        private void dgvRandevuTablosu_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0)
            {
                DataGridViewRow row = dgvRandevuTablosu.Rows[e.RowIndex];


                secilenRandevuID = Convert.ToInt32(row.Cells["RandevuID"].Value);
                secilenHastaID = 0;


                DateTime tamTarih = Convert.ToDateTime(row.Cells["RandevuTarihi"].Value);

                dtpRandevuTarihi.Value = tamTarih.Date;

                mtxtRandevuSaat.Text = tamTarih.ToString("HH:mm");

                cmbBransSec.Text = row.Cells["Brans"].Value.ToString();


            }
        }

        private void btnKaydiDuzenle_Click(object sender, EventArgs e)
        {


            if (secilenRandevuID == 0)
            {
                MessageBox.Show("Lütfen listeden güncellenecek bir randevu seçiniz.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }


            string hastaTC = txtHastaTCNo.Text;
            string secilenBrans = cmbBransSec.Text;


            if (cmbDoktorSecimi.SelectedValue == null)
            {
                MessageBox.Show("Lütfen güncel randevu için bir doktor seçiniz.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }
            int doktorID = (int)cmbDoktorSecimi.SelectedValue;


            DateTime randevuTarihi = dtpRandevuTarihi.Value;
            string saatStr = mtxtRandevuSaat.Text;
            if (!TimeSpan.TryParse(saatStr, out TimeSpan randevuSaati))
            {
                MessageBox.Show("Saat formatı hatalı. Lütfen SS:DD formatını kullanın.", "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }
            DateTime tamRandevuTarihi = randevuTarihi.Date.Add(randevuSaati);

            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "UPDATE RandevularınTbl SET HastaTC=@hTC, DoktorID=@dID, Brans=@brans, RandevuTarihi=@tarih WHERE RandevuID=@rID";

                    SqlCommand komut = new SqlCommand(sorgu, baglanti);

                    komut.Parameters.AddWithValue("@hTC", hastaTC);
                    komut.Parameters.AddWithValue("@dID", doktorID);
                    komut.Parameters.AddWithValue("@brans", secilenBrans);
                    komut.Parameters.AddWithValue("@tarih", tamRandevuTarihi);
                    komut.Parameters.AddWithValue("@rID", secilenRandevuID); // Bu ID, CellClick ile hafızaya alınan ID'dir.

                    komut.ExecuteNonQuery();


                    MessageBox.Show("Randevu bilgileri başarıyla güncellendi.", "Güncelleme Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    RandevulariListele();
                    secilenRandevuID = 0;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Randevu güncelleme sırasında hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnKaydıSilRandevu_Click(object sender, EventArgs e)
        {

            if (secilenRandevuID == 0)
            {
                MessageBox.Show("Lütfen listeden silmek istediğiniz randevuyu seçiniz.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }


            DialogResult result = MessageBox.Show("Seçili randevuyu kalıcı olarak silmek istediğinize emin misiniz?", "Onay", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

            if (result == DialogResult.Yes)
            {
                string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

                try
                {
                    using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                    {
                        baglanti.Open();


                        string sorgu = "DELETE FROM RandevularınTbl WHERE RandevuID=@rID";

                        SqlCommand komut = new SqlCommand(sorgu, baglanti);


                        komut.Parameters.AddWithValue("@rID", secilenRandevuID);

                        komut.ExecuteNonQuery();


                        MessageBox.Show("Randevu kaydı başarıyla silindi.", "Silme Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);

                        RandevulariListele();
                        secilenRandevuID = 0;
                    }
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Silme sırasında hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void dgvHastalar_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

        }

        private void btnDegisiklikleriKaydet_Click(object sender, EventArgs e)
        {

            if (secilenHastaID == 0)
            {
                MessageBox.Show("Lütfen önce listeden güncellenecek bir hasta seçiniz.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }


            string ad = txtHastaAdi.Text;
            string soyad = txtHastaSoyad.Text;
            string tc = txtHastaTC.Text;
            string telefon = txtHastaTelNo.Text;

            if (string.IsNullOrEmpty(ad) || string.IsNullOrEmpty(soyad) || string.IsNullOrEmpty(tc))
            {
                MessageBox.Show("Ad, Soyad ve T.C. Kimlik No alanları zorunludur.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "UPDATE HastalarınTbl SET TCKimlikNo=@pTC, Ad=@pAd, Soyad=@pSoyad, TelefonNo=@pTel WHERE HastaID=@pID";

                    SqlCommand komut = new SqlCommand(sorgu, baglanti);

                    komut.Parameters.AddWithValue("@pTC", tc);
                    komut.Parameters.AddWithValue("@pAd", ad);
                    komut.Parameters.AddWithValue("@pSoyad", soyad);
                    komut.Parameters.AddWithValue("@pTel", string.IsNullOrEmpty(telefon) ? (object)DBNull.Value : telefon);
                    komut.Parameters.AddWithValue("@pID", secilenHastaID); // Hangi kaydı güncelleyeceğini ID ile belirliyor

                    komut.ExecuteNonQuery();

                    MessageBox.Show($"{ad} {soyad} adlı hasta bilgileri güncellendi.", "Güncelleme Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    HastalariListele();
                    secilenHastaID = 0;
                }
            }
            catch (SqlException ex)
            {

                if (ex.Number == 2627 || ex.Number == 2601)
                {
                    MessageBox.Show("Güncelleme T.C. Kimlik No çakışması nedeniyle başarısız oldu.", "Veri Hatası", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
                else
                {
                    MessageBox.Show("Güncelleme sırasında hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        private void btnKaydiSil_Click(object sender, EventArgs e)
        {
            if (secilenHastaID == 0)
            {
                MessageBox.Show("Lütfen listeden silmek istediğiniz hastayı seçiniz.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }


            DialogResult result = MessageBox.Show("Seçili hastayı kalıcı olarak silmek istediğinize emin misiniz? (Bu hastaya ait randevular da silinecektir)", "Onay", MessageBoxButtons.YesNo, MessageBoxIcon.Question);

            if (result == DialogResult.Yes)
            {
                string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

                try
                {
                    using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                    {
                        baglanti.Open();


                        string sorgu = "DELETE FROM HastalarınTbl WHERE HastaID=@pID";

                        SqlCommand komut = new SqlCommand(sorgu, baglanti);
                        komut.Parameters.AddWithValue("@pID", secilenHastaID);

                        komut.ExecuteNonQuery();

                        MessageBox.Show("Hasta kaydı başarıyla silindi.", "Silme Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);

                        HastalariListele();
                        secilenHastaID = 0;
                    }
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Silme sırasında hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }


            }
        }


        private void NotlariListele()
        {

            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "SELECT Icerik AS NotIcerigi, AliciRol AS Alıcı, TarihSaat AS Tarih FROM DuyurularTbl ORDER BY TarihSaat DESC";

                    SqlDataAdapter da = new SqlDataAdapter(sorgu, baglanti);
                    DataTable dt = new DataTable();
                    da.Fill(dt);


                    dgvGonderilenNotlar.DataSource = dt;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Notlar listelenirken hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnGonderilenNotlariGuncelle_Click(object sender, EventArgs e)
        {
            NotlariListele();
        }

        private void btnNotuGonder_Click(object sender, EventArgs e)
        {

            string icerik = rtxNotİcerigi.Text;

            if (string.IsNullOrEmpty(icerik))
            {
                MessageBox.Show("Lütfen notun içeriğini yazın.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            if (cmbDoktorSec.SelectedValue == null)
            {
                MessageBox.Show("Lütfen notu göndereceğiniz doktoru seçin.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }


            int gonderenID = sekreterID;
            string aliciAdi = cmbDoktorSec.Text;

            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "INSERT INTO DuyurularTbl (GonderenID, AliciRol, Icerik, TarihSaat) VALUES (@gID, @alici, @icerik, @tarih)";

                    SqlCommand komut = new SqlCommand(sorgu, baglanti);

                    komut.Parameters.AddWithValue("@gID", gonderenID);
                    komut.Parameters.AddWithValue("@alici", aliciAdi);
                    komut.Parameters.AddWithValue("@icerik", icerik);
                    komut.Parameters.AddWithValue("@tarih", DateTime.Now);

                    komut.ExecuteNonQuery();

                    MessageBox.Show($"Not, {aliciAdi}'a başarıyla gönderildi.", "Gönderim Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);

                    rtxNotİcerigi.Clear();


                    NotlariListele();
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Not gönderme sırasında hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void DoktorlariDuyuruIcinDoldur()
        {

            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string sorgu = "SELECT PersonelID, Ad, Soyad FROM PersonelTbl WHERE Rol='Doktor'";

                    SqlDataAdapter da = new SqlDataAdapter(sorgu, baglanti);
                    DataTable dt = new DataTable();
                    da.Fill(dt);

                    dt.Columns.Add("AdSoyad", typeof(string), "Ad + ' ' + Soyad");

                    cmbDoktorSec.DataSource = dt;
                    cmbDoktorSec.DisplayMember = "AdSoyad";
                    cmbDoktorSec.ValueMember = "PersonelID";
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Not gönderme doktor listesi çekilemedi: " + ex.Message);
            }
        }

        private void dgvHastalar_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0)
            {
                DataGridViewRow row = dgvHastalar.Rows[e.RowIndex];


                secilenHastaID = Convert.ToInt32(row.Cells["HastaID"].Value);
                secilenRandevuID = 0;

                txtHastaTC.Text = row.Cells["TCKimlikNo"].Value.ToString();
                txtHastaAdi.Text = row.Cells["Ad"].Value.ToString();
                txtHastaSoyad.Text = row.Cells["Soyad"].Value.ToString();


                if (row.Cells["TelefonNo"].Value != DBNull.Value)
                {
                    txtHastaTelNo.Text = row.Cells["TelefonNo"].Value.ToString();
                }
                else
                {
                    txtHastaTelNo.Text = "";
                }
            }
        }

        private void dgvRandevuTablosu_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0)
            {
                DataGridViewRow row = dgvRandevuTablosu.Rows[e.RowIndex];

               
                secilenRandevuID = Convert.ToInt32(row.Cells["RandevuID"].Value);
                secilenHastaID = 0; 

                
                DateTime tamTarih = Convert.ToDateTime(row.Cells["RandevuTarihi"].Value);

                dtpRandevuTarihi.Value = tamTarih.Date;
                mtxtRandevuSaat.Text = tamTarih.ToString("HH:mm");

                
                cmbBransSec.Text = row.Cells["Brans"].Value.ToString();

                
            }
        }
    }
}



