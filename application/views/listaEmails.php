
<html lang="pt-br"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lista Email</title>

     
        <script src="<?php echo base_url(); ?>/assets/js/jquery.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/listaEmail.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap-theme.min.css">
        <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

    </head>
    <script>
        $(document).ready(function() {
            
            ajaxListaEmail();
            //INTERVALO DO AJAX
            setInterval(function() {
                ajaxListaEmail();
            }, 1000);

            //AJAX QUE LISTA OS EMAILS
            function ajaxListaEmail() {
                $.ajax({
                    url: "<?php echo site_url(); ?>/index/consultaEmails",
                    success: function(result) {
                        $("#divResult").html(result);
                    }});
            }
        })
    </script>
    <body>


        <div class="container">
            <div class="starter-template" id="divResult">

            </div>

        </div>
    </body>
</html>