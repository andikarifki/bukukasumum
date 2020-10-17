<?php include_once 'includes/head.php';?>
<div class="container text-center login-page">
    <h2>Selamat Datang Di Buku Kas Umum</h2>
    <div class="mt-5">
        <form action="proseslogin.php" method="post" onSubmit="return validasi()">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" id="username" />
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" id="password" />
            </div>      
                <button type="submit" class="tombol btn btn-success">Login</button>
        </form>
    </div>
</div>
<?php include_once 'includes/footer.php';?>