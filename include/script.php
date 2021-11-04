    <script src="../front-end/vendor/jquery/jquery.min.js"></script>
    <script src="../front-end/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../front-end/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../front-end/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../front-end/vendor/chart.js/Chart.min.js"></script>
    
    <script src="../front-end/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../front-end/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../front-end/js/demo/chart-area-demo.js"></script>
    <script src="../front-end/js/demo/chart-pie-demo.js"></script>

    <script src="../front-end/js/demo/datatables-demo.js"></script>
    <script>
        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("link_wrapper").innerHTML =
                this.responseText;
                }
            };
            xhttp.open("GET", "dashboard_realtime.php", true);
            xhttp.send();
        }

        setInterval(function() {
            loadXMLDoc();
        },1000);

        window.onload = loadXMLDoc;
    </script>