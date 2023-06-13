using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using MySql.Data.MySqlClient;

namespace dentist_appointment_system
{
    public partial class Form2 : Form
    {
        private string connectionString;
        private int doktorlarId;
        public Form2(int doktorlarId)
        {
            InitializeComponent();
            this.doktorlarId = doktorlarId;
            connectionString = "Server=localhost;Database=dental;Uid=root;Password=;";
        }

        private void Form2_Load(object sender, EventArgs e)
        {
            using (MySqlConnection connection = new MySqlConnection(connectionString))
            {
                try
                {
                    connection.Open();

                    string sqlQuery = @"
                        SELECT randevular.id, randevular.tarih, randevular.saat, uyebilgileri_tablosu.ad, uyebilgileri_tablosu.surname, uyebilgileri_tablosu.telefon, randevular.ran_dur
                        FROM randevular
                        INNER JOIN uyebilgileri_tablosu ON randevular.user_id = uyebilgileri_tablosu.id
                        WHERE randevular.doktor_id = @doktorId";

                    MySqlCommand command = new MySqlCommand(sqlQuery, connection);
                    command.Parameters.AddWithValue("@doktorId", doktorlarId);

                    MySqlDataReader dataReader = command.ExecuteReader();

                    dataGridView1.Columns.Clear(); // Önceki sütunları temizle

                    dataGridView1.Columns.Add("idColumn", "ID"); // ID sütunu
                    dataGridView1.Columns.Add("randevuSirasiColumn", "Randevu Sırası");
                    dataGridView1.Columns.Add("telefonColumn", "Telefon");
                    dataGridView1.Columns.Add("adColumn", "Ad");
                    dataGridView1.Columns.Add("surnameColumn", "Soyad");
                    dataGridView1.Columns.Add("tarihColumn", "Tarih");
                    dataGridView1.Columns.Add("saatColumn", "Saat");
                    dataGridView1.Columns.Add("ranDurColumn", "Randevu Durumu");

                    int randevuSirasi = 1; // İlk randevu sırası

                    while (dataReader.Read())
                    {
                        int id = dataReader.GetInt32("id");
                        string ad = dataReader.GetString("ad");
                        string soyad = dataReader.GetString("surname");
                        string telefon = dataReader.GetString("telefon");

                        // Tarih değerini kontrol et ve null ise alternatif bir değer ata
                        string tarih = dataReader.IsDBNull(dataReader.GetOrdinal("tarih")) ? "NULL" : dataReader.GetDateTime(dataReader.GetOrdinal("tarih")).ToString("yyyy-MM-dd");

                        string saat = dataReader.IsDBNull(dataReader.GetOrdinal("saat")) ? "NULL" : dataReader.GetString("saat");

                        string ranDur = dataReader.GetString("ran_dur");

                        dataGridView1.Rows.Add(id, randevuSirasi, telefon, ad, soyad, tarih, saat, ranDur); // Satırı ekle

                        randevuSirasi++; // Sonraki randevu için sırayı artır
                    }

                    dataReader.Close();
                }
                catch (MySqlException ex)
                {
                    Console.WriteLine("MySQL Hatası: " + ex.Message);
                }

            }
        }

        private void gunaDataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

            if (e.RowIndex >= 0)
            {
                DataGridViewRow row = dataGridView1.Rows[e.RowIndex];
                string ran_sır = row.Cells["randevuSirasiColumn"].Value.ToString();
                string ad = row.Cells["adColumn"].Value.ToString();
                string soyad = row.Cells["surnameColumn"].Value.ToString();
                string telefon = row.Cells["telefonColumn"].Value.ToString();
                string tarih = row.Cells["tarihColumn"].Value.ToString();
                string saat = row.Cells["saatColumn"].Value.ToString();
                string id = row.Cells["idColumn"].Value.ToString();
                string ran_dur = row.Cells["ranDurColumn"].Value.ToString();

                // Değerleri ilgili kontrollere aktar
                label6.Text = ad;
                label7.Text = soyad;
                label8.Text = telefon;
                label12.Text = ran_dur;
                label14.Text = ran_sır;
                label15.Text = id;

                DateTime parsedDate;
                if (DateTime.TryParseExact(tarih, "yyyy-MM-dd", CultureInfo.InvariantCulture, DateTimeStyles.None, out parsedDate))
                {
                    gunaDateTimePicker1.Value = parsedDate;
                }

                gunaTextBox1.Text = saat;
            }
        }

        private void guncel_btn_Click(object sender, EventArgs e)
        {
            using (MySqlConnection connection = new MySqlConnection(connectionString))
            {
                connection.Open();

                int selectedPersonId = Convert.ToInt32(label15.Text);

                DateTime selectedDate = gunaDateTimePicker1.Value;
                string formattedDate = selectedDate.ToString("yyyy-MM-dd");

                string inputTime = gunaTextBox1.Text;
                string formattedTime = DateTime.Parse(inputTime).ToString("HH:mm:ss");

                string query = $"UPDATE randevular SET tarih = '{formattedDate}', saat = '{formattedTime}', ran_dur = CASE WHEN ran_dur = 'Güncellendi' THEN ran_dur ELSE 'Güncellendi' END WHERE id = {selectedPersonId}";

                using (MySqlCommand command = new MySqlCommand(query, connection))
                {
                    int rowsAffected = command.ExecuteNonQuery();

                    if (rowsAffected > 0)
                    {
                        MessageBox.Show("Randevu Güncellendi!");
                        Form2_Load(sender, e);
                    }
                    else
                    {
                        MessageBox.Show("Bu randevu zaten onaylanmış olduğu için güncellenemez.");
                    }
                }
            }
        }

        private void guna2TextBox1_TextChanged(object sender, EventArgs e)
        {

            string arananKelime = guna2TextBox1.Text.Trim().ToLower(); // Aranan kelimeyi küçük harfe dönüştürüyoruz

            // Mevcut seçimi kaldır
            dataGridView1.ClearSelection();

            foreach (DataGridViewRow row in dataGridView1.Rows)
            {
                string ad = row.Cells["adColumn"].Value.ToString().ToLower(); // Hücre değerini küçük harfe dönüştürüyoruz

                if (ad.Contains(arananKelime))
                {
                    row.Selected = true;
                    dataGridView1.FirstDisplayedScrollingRowIndex = row.Index;

                    break;
                }
            }
        }

        private void iptal_btn_Click(object sender, EventArgs e)
        {
            using (MySqlConnection connection = new MySqlConnection(connectionString))
            {
                connection.Open();

                int selectedPersonId = Convert.ToInt32(label15.Text);

                string query = $"UPDATE randevular SET tarih = NULL, saat = NULL, ran_dur = 'iptal edildi' WHERE id = {selectedPersonId}";

                using (MySqlCommand command = new MySqlCommand(query, connection))
                {
                    command.ExecuteNonQuery();
                }
                Form2_Load(sender, e);
            }
        }

        private void oany_btn_Click(object sender, EventArgs e)
        {
            using (MySqlConnection connection = new MySqlConnection(connectionString))
            {
                connection.Open();

                int selectedPersonId = Convert.ToInt32(label15.Text);

                string queryCheck = $"SELECT ran_dur FROM randevular WHERE id = {selectedPersonId}";
                string currentStatus = "";

                using (MySqlCommand checkCommand = new MySqlCommand(queryCheck, connection))
                {
                    using (MySqlDataReader dataReader = checkCommand.ExecuteReader())
                    {
                        if (dataReader.Read())
                        {
                            currentStatus = dataReader.GetString("ran_dur");
                        }
                    }
                }

                if (currentStatus != "Güncellendi" && currentStatus != "Onaylandı")
                {
                    string queryUpdate = $"UPDATE randevular SET ran_dur = 'Onaylandı' WHERE id = {selectedPersonId}";

                    using (MySqlCommand updateCommand = new MySqlCommand(queryUpdate, connection))
                    {
                        int rowsAffected = updateCommand.ExecuteNonQuery();

                        if (rowsAffected > 0)
                        {
                            MessageBox.Show("Randevu Onaylandı!");
                        }
                    }
                }
                else
                {
                    MessageBox.Show("Bu randevu güncellenmiş veya onaylanmış olduğu için tekrar onaylanamaz.");
                }

                Form2_Load(sender, e);
            }
        }

        private void degistir_btn_Click(object sender, EventArgs e)
        {
            gunaDateTimePicker1.Enabled = true; // GunaDateTimePicker'ı etkinleştir
            gunaDateTimePicker1.Focus(); // GunaDateTimePicker'a odaklan
            gunaTextBox1.Enabled = true; // GunaDateTimePicker'ı etkinleştir
            gunaTextBox1.Focus(); // GunaDateTimePicker'a odaklan
        }
    }
}
