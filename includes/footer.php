    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function validasi() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;   
            if (username != "" && password!="") {
            return true;
            }else{
            alert('Username dan Password harus di isi !');
            return false;
            }
        }

    </script>
    </body>
</html>

