using Guna.UI.WinForms;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Data.SqlClient;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using static System.Windows.Forms.VisualStyles.VisualStyleElement;
using MySql.Data.MySqlClient;

namespace dentist_appointment_system
{
    public partial class Form1 : Form
    {
        private MySqlConnection connection;
        private string server;
        private string database;
        private string uid;
        private string password;
        private int doktorlarId;



        public Form1()
        {
            InitializeComponent();
            
        }

        private void Form1_Load(object sender, EventArgs e)
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

        private void Login_btn_Click(object sender, EventArgs e)
        {
            server = "localhost"; // MySQL sunucusunun adresini buraya girin
            database = "dental"; // Veritabanı adını buraya girin
            uid = "root"; // MySQL kullanıcı adını buraya girin
            password = " "; // MySQL şifresini buraya girin
            string connectionString = $"SERVER={server};DATABASE={database};UID={uid};PASSWORD={password};";

            connection = new MySqlConnection(connectionString);
            try
            {
                connection.Open();

                string email = Email_txt.Text;
                string password = Password_txt.Text;

                if (string.IsNullOrEmpty(email) && string.IsNullOrEmpty(password))
                {
                    System.Windows.Forms.MessageBox.Show("Lütfen e-posta adresinizi ve şifrenizi giriniz!");
                }
                else if (string.IsNullOrEmpty(email))
                {
                    System.Windows.Forms.MessageBox.Show("Lütfen e-posta adresinizi giriniz!");
                }
                else if (string.IsNullOrEmpty(password))
                {
                    System.Windows.Forms.MessageBox.Show("Lütfen şifrenizi giriniz!");
                }
                else
                {
                    // Veritabanındaki doktorgir_bil tablosundan e-posta ve şifre kontrolü yapalım
                    string query = $"SELECT doktorlar_id FROM doktorgir_bil WHERE LOWER(email) = LOWER('{email}') AND password = '{password}'";
                    MySqlCommand command = new MySqlCommand(query, connection);
                    MySqlDataReader reader = command.ExecuteReader();
                    if (reader.Read())
                    {
                        int doktorlarId = reader.GetInt32("doktorlar_id");
                        System.Windows.Forms.MessageBox.Show("Giriş yapıldı!");

                        // Form1'i gizle
                        this.Hide();

                        // Form2'yi aç
                        Form2 form2 = new Form2(doktorlarId);//
                        form2.ShowDialog();

                        // Form2 kapandıktan sonra Form1'i göster
                        this.Show();
                        this.Close();
                    }


                    else
                    {
                        System.Windows.Forms.MessageBox.Show("E-posta veya şifre hatalı!");
                    }


                }


            }
            catch (Exception ex)
            {
                System.Windows.Forms.MessageBox.Show("Veritabanına bağlanırken bir hata oluştu: " + ex.Message);
            }
        }

        private void Register_btn_Click(object sender, EventArgs e)
        {
            // Form1'i gizle
            this.Hide();

            // Form2'yi aç
            Form3 form3 = new Form3(doktorlarId);//
            form3.ShowDialog();

            // Form2 kapandıktan sonra Form1'i göster
            this.Show();
            this.Close();
        }

        private void panel1_Paint(object sender, PaintEventArgs e)
        {

        }
    }
}
