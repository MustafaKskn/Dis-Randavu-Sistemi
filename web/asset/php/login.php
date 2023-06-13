<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="Diş randevu sistemi">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../images/ikon.webp">
        <link rel="stylesheet" href="../css/login.css">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
            crossorigin="anonymous">
        <title>Giriş Yap &#129321;</title>
    </head>
    <body>
        <div class="header">
            <img src="../images/Başlıksız-1.jpg" alt></div>
            <div style="display: flex; justify-content: center;">
                <img src="../images/background-image.jpg" alt="" class="img">
            
                <form class="login" action="../php/giriskontrol.php" method="post">
                    <div class="arkaDiv">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email_txt">Email
                            address</label>
                        <input type="email" id="email" name="email"
                            class="form-control" />
                       
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password_txt">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control" />
                        
                    </div>

                    <!-- 2 column grid layout for inline styling -->
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="form2Example31" />
                                <label class="form-check-label" for="form2Example31">Beni Hatırla</label>
                              </div>
                              
                        </div>

                        <div class="col" style="width: 300px;" >
                            <!-- Simple link -->
                            <a href="#!">Parolanızı mı unuttunuz?</a>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4 float-end">Giriş Yap</button>
                    <br /><br />

                    <!-- Register buttons -->
                    <div class="text-center" style="margin-left: 30px;">
                        <p>Üye değil? veya ile kayıt ol: <a href="../php/kayıtol.html">kayıt ol</a></p>
                    </div>
                    
                </form>
            </div>
            
        
        <script src="../js/logincon.js"></script>
       
       
   

    </body>
</html>