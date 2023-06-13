using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using MySql.Data.MySqlClient;
using static System.Windows.Forms.VisualStyles.VisualStyleElement;

namespace dentist_appointment_system
{
    public partial class Form3 : Form
    {
        private string connectionString;
      
        public Form3(int doktorlarId)
        {
            InitializeComponent();
           
            connectionString = "Server=localhost;Database=dental;Uid=root;Password=;";
        }

        private void Form3_Load(object sender, EventArgs e)
        {
            panel1.BackColor = Color.FromArgb(80, 0, 0, 0);
            // Panel1'in kenarlık yuvarlama (border radius) özelliğini ayarlayalım
            int borderRadius = 20; // Yuvarlama yarıçapını burada belirleyebilirsiniz
            SetPanelBorderRadius(panel1, borderRadius);
            Email_txt.Padding = new Padding(0, 10, 0, 0);
        }
        private void SetPanelBorderRadius(Panel panel, int borderRadius)
        {
            // Panelin kenarlık yuvarlama (border radius) özelliğini ayarlayan metod
            Rectangle bounds = new Rectangle(0, 0, panel.Width, panel.Height);
            int diameter = borderRadius * 5;
            GraphicsPath path = new GraphicsPath();
            path.AddArc(bounds.X, bounds.Y, diameter, diameter, 180, 90);
            path.AddArc(bounds.Width - diameter, bounds.Y, diameter, diameter, 270, 90);
            path.AddArc(bounds.Width - diameter, bounds.Height - diameter, diameter, diameter, 0, 90);
            path.AddArc(bounds.X, bounds.Height - diameter, diameter, diameter, 90, 90);
            panel.Region = new Region(path);
        }


        private void Login_btn_Click(object sender, EventArgs e)
        {
            // Form1'i gizle
            this.Hide();

            // Form2'yi aç
            Form1 form1 = new Form1();//
            form1.ShowDialog();

            // Form2 kapandıktan sonra Form1'i göster
            this.Show();
            this.Close();
        }

        private void Register_btn_Click(object sender, EventArgs e)
        {
            using (MySqlConnection connection = new MySqlConnection(connectionString))
            {
                try
                {
                    connection.Open();

                    // Kullanıcıdan alınan ID'yi doktorlar tablosundaki ID'lerle kontrol et
                    string query = "SELECT COUNT(*) FROM doktorlar WHERE id = @id";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    command.Parameters.AddWithValue("@id", textBox1.Text);

                    int count = Convert.ToInt32(command.ExecuteScalar());

                    if (count > 0)
                    {
                        // Doğrulama başarılı, doktor bilgilerini al
                        string email = Email_txt.Text.ToLower();
                        string password = Password_txt.Text;
                        // TextBox'ların boş olup olmadığını kontrol et
                        if (string.IsNullOrEmpty(textBox1.Text) || string.IsNullOrEmpty(email) || string.IsNullOrEmpty(password))
                        {
                            MessageBox.Show("Tüm alanları doldurun.");
                            return;
                        }
                        // E-posta adresinin doğru formatı kontrol ediliyor
                       else if (!email.EndsWith("@gmail.com"))
                       {
                            MessageBox.Show("Geçersiz e-posta adresi. !!@gmail.com olmalıdır ve büyük harf olmamalıdır");
                            return;
                       }

                        // Girilen bilgileri doktorgir_bil tablosuna ekle
                        string insertQuery = "INSERT INTO doktorgir_bil (doktorlar_id, email, password) VALUES (@doktorlar_id, @email, @password)";

                        

                        MySqlCommand insertCommand = new MySqlCommand(insertQuery, connection);
                        insertCommand.Parameters.AddWithValue("@doktorlar_id", textBox1.Text);
                        insertCommand.Parameters.AddWithValue("@email", email);
                        insertCommand.Parameters.AddWithValue("@password", password);

                        insertCommand.ExecuteNonQuery();

                        MessageBox.Show("Bilgiler başarıyla eklendi.");
                    }
                    else
                    {
                        MessageBox.Show("Geçersiz doktor ID'si.");
                    }
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Hata: " + ex.Message);
                }
            }


        }

        private bool showPassword = false;
        private void GunaCircleButton1_Click(object sender, EventArgs e)
        {
            showPassword = !showPassword; // Her tıklamada showPassword değişkeninin değerini tersine çevirir

            if (showPassword)
            {
                Password_txt.PasswordChar = '\0'; // Parolayı görünür hale getirir
            }
            else
            {
                Password_txt.PasswordChar = '*'; // Parolayı gizler
            }
        }
    }
    
}
