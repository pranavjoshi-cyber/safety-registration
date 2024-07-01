<?php include("reg.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <script type="text/javascript" src="https://unpkg.com/webcam-easy@1.1.1/dist/webcam-easy.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
            margin: 5px;
        }

        label {
            color: darkgrey;
        }

        #camera {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
        }

        #webcam,
        #canvas {
            margin-bottom: 10px;
        }

        .hidden {
            display: none;
        }

        .image-section {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
            border-radius: 10px;
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }

        .btn-info {
            font-family: 'Arial', sans-serif;
            font-size: 0.8rem;
        }

        .light-border {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            width: 220px;
            display: flex;
            justify-content: center;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .divider {
            border-left: 2px solid #ccc;
            height: calc(100% - 40px);
            position: absolute;
            left: 50%;
            top: 20px;
        }

        .row-position {
            position: relative;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row row-position">
            <!-- Registration Form Section -->

            <div class="col-md-6">
                <h2>Register</h2>
                <form action="registration.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="picture">Take Picture</label>
                            <div class="light-border">
                                <div id="camera" class="hidden">
                                    <video id="webcam" autoplay playsinline width="200" height="200"></video>
                                    <canvas id="canvas" width="200" height="200" class="hidden"></canvas>
                                </div>
                            </div>
                            <input type="hidden" id="pictureData" name="pictureData">
                            <div class="button-group">
                                <button type="button" class="btn btn-info" onclick="startCamera()">Capture Image</button>
                                <button type="button" class="btn btn-info hidden" id="snap" onclick="takePicture()">Snap</button>
                                <button type="button" class="btn btn-secondary hidden" id="retake" onclick="retakePicture()">Retake</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="thumb">Add Thumb</label>
                        <input type="file" class="form-control-file" id="thumb" name="thumb" accept="image/*">
                    </div>
                    <input type="submit" value="Register" class="btn btn-primary" name="register">
                </form>
            </div>
            <div class="divider"></div>
            <!-- Image Section -->
            <div class="col-md-6 image-section">
                <img src="https://abettech.com/safety_training/images/select_lang.png" class="img-fluid" alt="Attractive Image">
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const webCamElement = document.getElementById("webcam");
        const canvasElement = document.getElementById("canvas");
        const retakeButton = document.getElementById("retake");
        const snapButton = document.getElementById("snap");
        const webcam = new Webcam(webCamElement, "user", canvasElement);

        function startCamera() {
            webcam.start()
                .then(result => {
                    document.getElementById("camera").classList.remove("hidden");
                    snapButton.classList.remove("hidden");
                })
                .catch(err => {
                    console.log(err);
                });
        }

        function takePicture() {
            const context = canvasElement.getContext('2d');
            context.drawImage(webCamElement, 0, 0, canvasElement.width, canvasElement.height);
            webCamElement.classList.add("hidden");
            canvasElement.classList.remove("hidden");
            retakeButton.classList.remove("hidden");
            snapButton.classList.add("hidden");
            webcam.stop();

            canvasElement.toBlob(function(blob) {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    document.getElementById('pictureData').value = reader.result;
                };
            }, 'image/png');
        }

        function retakePicture() {
            canvasElement.classList.add("hidden");
            webCamElement.classList.remove("hidden");
            retakeButton.classList.add("hidden");
            snapButton.classList.remove("hidden");
            webcam.start();
        }
    </script>
</body>

</html>