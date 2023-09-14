<?php

// https://github.com/CodeSeven/toastr

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    if (!$name) {
        exit(json_encode(['res' => 0, 'answer' => 'Hello, Guest! Send your name, please.']));
    } else {
        exit(json_encode(['res' => 1, 'answer' => "Hello, {$name}! Welcome."]));
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>

<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form id="form" method="post">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input class="form-control" type="text" name="name" id="name">
                </div>

                <button class="btn btn-primary" id="send">Send</button>
            </form>

        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

    toastr.options = {
        "progressBar": true,
        "closeButton": true,
        "hideDuration": 300,
        "positionClass": "toast-top-right"
    }

    let form = document.getElementById('form');
    let btn = document.getElementById('send');
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        btn.textContent = 'Sending...';
        btn.disabled = true;
        fetch('index.php', {
            method: 'POST',
            body: new FormData(form)
        })
            .then((responce) => responce.json())
            .then((data) => {
                if (!data.res) {
                    toastr.error(data.answer, 'Error');
                } else {
                    toastr.success(data.answer, 'Success', {
                        "positionClass": "toast-bottom-right"
                    });
                }
                form.reset();
                btn.textContent = 'Send';
                btn.disabled = false;
            });
    });

</script>
</body>

</html>
