<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Disable JavaScript Demo</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /**
             * Stop the form from being submitted if the name input is empty
             */
            var form = document.getElementById('formDemo');

            form.addEventListener('submit', function(e){

                if (document.getElementById('inputName').value == '') {

                    e.preventDefault();

                    alert('Name is required');
                }
            });
        });
    </script>
</head>
<body>

    <h1>Demo</h1>

    <form method="post" action="process-form.php" id="formDemo">

        <label for="inputName">Name</label>
        <input id="inputName" name="name">

        <button type="submit">Send</button>

    </form>

</body>
</html>
 -->
 <?php
    setcookie('example', 'hello', time() + 60*60*24*30);
    echo 'Cookie Set';

 ?>