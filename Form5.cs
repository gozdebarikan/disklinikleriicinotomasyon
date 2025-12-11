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
    public partial class frmDoktorSayfasi : Form
    {
        public int doktorID;
        int secilenRandevuID = 0;
        string secilenHastaTCNo = "";
        public frmDoktorSayfasi(int gelenID)
        {
            InitializeComponent();

            doktorID = gelenID;
        }

        private void frmDoktorSayfasi_Load(object sender, EventArgs e)
        {
            DoktorRandevulariListele();
            HastalariDoldur();
            GelenNotlariListele();
        }

        private void dgvDoktorRandevulari_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0)
            {
                DataGridViewRow row = dgvDoktorRandevulari.Rows[e.RowIndex];

                secilenRandevuID = Convert.ToInt32(row.Cells["RandevuID"].Value);
                string tcNo = row.Cells["HastaTCNo"].Value.ToString();
                secilenHastaTCNo = tcNo;
                secilenHastaTCNo = tcNo.Trim();


                txtİslemYapilanDis.Clear();
                txtTani.Clear();
                rtxtDoktorReçete.Clear();



                MuayeneGecmisiniListele(tcNo);
            }
        }


        private void HastalariDoldur()
        {
            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    SqlDataAdapter da = new SqlDataAdapter("SELECT TCKimlikNo, CONCAT(Ad, ' ', Soyad) AS AdSoyad FROM HastalarınTbl ORDER BY AdSoyad", baglanti);
                    DataTable dt = new DataTable();
                    da.Fill(dt);


                    cmbMevcutHastalar.DataSource = dt;
                    cmbMevcutHastalar.DisplayMember = "AdSoyad";
                    cmbMevcutHastalar.ValueMember = "TCKimlikNo";
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Hasta listesi doldurulamadı: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }


















        private void DoktorRandevulariListele()
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
                CONCAT(H.Ad, ' ', H.Soyad) AS HastaAdi, -- Randevu listesinde görünecek
                R.Durum,
                R.HastaTC AS HastaTC -- Tıklayınca veri çekmek için gerekli
            FROM 
                RandevularınTbl R  
            INNER JOIN
                HastalarınTbl H ON R.HastaTC = H.TCKimlikNo  -- Randevu ve Hasta tablolarını birleştir
            WHERE 
                R.DoktorID = @dID  -- <-- SADECE GİRİŞ YAPAN DOKTORUN RANDDEVULARI
               AND LTRIM(RTRIM(R.Durum)) IN ('Aktif', 'Bekliyor') -- <--- Randevu Durumu kontrolü eklendi
            ORDER BY R.RandevuTarihi DESC";

                    SqlDataAdapter da = new SqlDataAdapter(sorgu, baglanti);
                    da.SelectCommand.Parameters.AddWithValue("@dID", doktorID);

                    DataTable dt = new DataTable();
                    da.Fill(dt);


                    dgvDoktorRandevulari.DataSource = dt;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Randevular listelenirken hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }


        private void GelenNotlariListele()
        {
            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";
            string doktorAdi = "";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    SqlCommand komutAdi = new SqlCommand("SELECT CONCAT(Ad, ' ', Soyad) FROM PersonelTbl WHERE PersonelID = @id", baglanti);
                    komutAdi.Parameters.AddWithValue("@id", doktorID);
                    doktorAdi = komutAdi.ExecuteScalar()?.ToString();

                    if (string.IsNullOrEmpty(doktorAdi)) return;


                    string sorgu = @"
                SELECT 
                    TarihSaat, 
                    Icerik
                FROM 
                    DuyurularTbl -- <--- DÜZELTİLDİ
                WHERE 
                    AliciRol = @alici -- AliciRol, doktorun Ad Soyadını tutar
                ORDER BY TarihSaat DESC";

                    SqlDataAdapter da = new SqlDataAdapter(sorgu, baglanti);
                    da.SelectCommand.Parameters.AddWithValue("@alici", doktorAdi);

                    DataTable dt = new DataTable();
                    da.Fill(dt);


                    dgvSekreterNotlari.DataSource = dt;
                }
            }
            catch (Exception ex)
            {

                MessageBox.Show("Sekreterden gelen notlar listelenirken hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }






        private void MuayeneGecmisiniListele(string hastaTC)
        {
            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();
                    string sorgu = @"
                        SELECT
                            M.Tarih,
                            M.Tani,
                            M.TedaviDurumu,
                            M.Recete,
                            M.IslemYapilanDis
                        FROM
                            MuayeneTbl M
                        WHERE
                            M.HastaTCNo = @hTC
                        ORDER BY M.Tarih DESC";

                    SqlDataAdapter da = new SqlDataAdapter(sorgu, baglanti);
                    da.SelectCommand.Parameters.AddWithValue("@hTC", hastaTC);

                    DataTable dt = new DataTable();
                    da.Fill(dt);


                    dgvMuayeneGecmisiListesi.DataSource = dt;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Muayene geçmişi listelenirken hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }









        private void btnRandevuYenile_Click(object sender, EventArgs e)
        {
            DoktorRandevulariListele();
        }

        private void cmbMevcutHastalar_SelectedIndexChanged(object sender, EventArgs e)
        {

            if (cmbMevcutHastalar.SelectedValue != null)
            {

                string tcNo = cmbMevcutHastalar.SelectedValue.ToString();
                secilenHastaTCNo = tcNo;



                MuayeneGecmisiniListele(tcNo);
            }

        }

        private void btnKaydiTamamla_Click(object sender, EventArgs e)
        {

            
            if (string.IsNullOrEmpty(secilenHastaTCNo) || string.IsNullOrEmpty(txtTani.Text) || string.IsNullOrEmpty(cmbTedaviDurumu.Text))
            {
                MessageBox.Show("Lütfen önce bir hasta seçiniz ve Tanı ile Tedavi Durumu alanlarını doldurunuz.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            string islemYapilanDis = txtİslemYapilanDis.Text;
            string tani = txtTani.Text;
            string recete = rtxtDoktorReçete.Text;
            string tedaviDurumu = cmbTedaviDurumu.Text;

            int randevuID = 0;
            string baglantiCumlesi = "Data Source=.; Initial Catalog=klinikotomasyon; Integrated Security=True";

            try
            {
                using (SqlConnection baglanti = new SqlConnection(baglantiCumlesi))
                {
                    baglanti.Open();


                    string randevuBulSorgu = "SELECT TOP 1 RandevuID FROM RandevularınTbl WHERE LTRIM(RTRIM(HastaTC)) = @hTC AND DoktorID = @dID AND Durum != 'Tamamlandı' ORDER BY RandevuTarihi ASC";
                    SqlCommand randevuBulKomut = new SqlCommand(randevuBulSorgu, baglanti);


                    randevuBulKomut.Parameters.AddWithValue("@hTC", secilenHastaTCNo.Trim());
                    randevuBulKomut.Parameters.AddWithValue("@dID", doktorID); 

                    object randevuIDResult = randevuBulKomut.ExecuteScalar();

                    if (randevuIDResult == null)
                    {
                        MessageBox.Show("Bu hastanın size ait aktif (tamamlanmamış) bir randevusu bulunamadı.", "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                        return;
                    }

                    randevuID = Convert.ToInt32(randevuIDResult);

                    SqlTransaction transaction = baglanti.BeginTransaction();

                    try
                    {
                       
                        string muayeneSorgu = "INSERT INTO MuayeneTbl (RandevuID, HastaTCNo, DoktorID, IslemYapilanDis, Tani, Recete, TedaviDurumu, Tarih) " +
                                               "VALUES (@rID, @hTC, @dID, @dis, @tani, @recete, @durum, @tarih)";

                        SqlCommand muayeneKomut = new SqlCommand(muayeneSorgu, baglanti, transaction);
                        muayeneKomut.Parameters.AddWithValue("@rID", randevuID);
                        muayeneKomut.Parameters.AddWithValue("@hTC", secilenHastaTCNo);
                        muayeneKomut.Parameters.AddWithValue("@dID", doktorID);
                        muayeneKomut.Parameters.AddWithValue("@dis", islemYapilanDis);
                        muayeneKomut.Parameters.AddWithValue("@tani", tani);
                        muayeneKomut.Parameters.AddWithValue("@recete", string.IsNullOrEmpty(recete) ? (object)DBNull.Value : recete);
                        muayeneKomut.Parameters.AddWithValue("@durum", tedaviDurumu);
                        muayeneKomut.Parameters.AddWithValue("@tarih", DateTime.Now);
                        muayeneKomut.ExecuteNonQuery();


                       
                        string randevuGuncelleSorgu = "UPDATE RandevularınTbl SET Durum = @yeniDurum WHERE RandevuID = @rID";

                        SqlCommand randevuKomut = new SqlCommand(randevuGuncelleSorgu, baglanti, transaction);
                        randevuKomut.Parameters.AddWithValue("@yeniDurum", "Tamamlandı");
                        randevuKomut.Parameters.AddWithValue("@rID", randevuID);
                        randevuKomut.ExecuteNonQuery();

                        transaction.Commit();

                        MessageBox.Show("Muayene ve Randevu kaydı başarıyla tamamlandı.", "Başarılı", MessageBoxButtons.OK, MessageBoxIcon.Information);

                       
                        txtİslemYapilanDis.Clear();
                        txtTani.Clear();
                        rtxtDoktorReçete.Clear();
                        cmbTedaviDurumu.Text = "";

                        DoktorRandevulariListele();
                        MuayeneGecmisiniListele(secilenHastaTCNo);
                    }
                    catch (Exception ex)
                    {
                        transaction.Rollback();
                        MessageBox.Show("Muayene kaydı sırasında bir hata oluştu: " + ex.Message, "SQL Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Veritabanı bağlantı hatası: " + ex.Message, "Hata", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }


        }

        private void btnMuayeneYenile_Click(object sender, EventArgs e)
        {

            if (!string.IsNullOrEmpty(secilenHastaTCNo))
            {
                MuayeneGecmisiniListele(secilenHastaTCNo);
            }
            else
            {
                MessageBox.Show("Lütfen önce bir hasta seçiniz.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

        private void btnTabloDegisiklikleriniKaydet_Click(object sender, EventArgs e)
        {

            MessageBox.Show("Bu fonksiyon şu an için sadece yenileme yapmaktadır.", "Bilgi", MessageBoxButtons.OK, MessageBoxIcon.Information);

            if (!string.IsNullOrEmpty(secilenHastaTCNo))
            {

                DoktorRandevulariListele();
                MuayeneGecmisiniListele(secilenHastaTCNo);
            }
            else
            {
                MessageBox.Show("Lütfen önce bir hasta seçiniz.", "Uyarı", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }



        }

        private void dgvMuayeneGecmisiListesi_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0)
            {
                DataGridViewRow row = dgvMuayeneGecmisiListesi.Rows[e.RowIndex];

                
                if (row.Cells["Tani"].Value != DBNull.Value)
                {
                    txtTani.Text = row.Cells["Tani"].Value.ToString();
                }
                else
                {
                    txtTani.Clear();
                }

                
                if (row.Cells["IslemYapilanDis"].Value != DBNull.Value)
                {
                    txtİslemYapilanDis.Text = row.Cells["IslemYapilanDis"].Value.ToString();
                }
                else
                {
                    txtİslemYapilanDis.Clear();
                }

                
                if (row.Cells["TedaviDurumu"].Value != DBNull.Value)
                {
                    cmbTedaviDurumu.Text = row.Cells["TedaviDurumu"].Value.ToString();
                }
                else
                {
                    cmbTedaviDurumu.Text = "";
                }

               
                if (row.Cells["Recete"].Value != DBNull.Value)
                {
                    rtxtDoktorReçete.Text = row.Cells["Recete"].Value.ToString();
                }
                else
                {
                    rtxtDoktorReçete.Clear();
                }

                
            }
        }
    }
}
