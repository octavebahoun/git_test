<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Scanner QR</title>
</head>
<body>
<h2>Scanner un QR Code</h2>
<video id="preview" width="400" height="300"></video>
<p id="result"></p>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
const html5QrCode = new Html5Qrcode("preview");

html5QrCode.start(
    { facingMode: "environment" },
    {
        fps: 10,
        qrbox: 250
    },
    qrCodeMessage => {
        document.getElementById('result').innerText = qrCodeMessage;

        // Envoi au serveur PHP
        fetch('process.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'token=' + encodeURIComponent(qrCodeMessage)
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(err => console.error(err));

        // Arrêter le scan après un code lu
        html5QrCode.stop();
    },
    errorMessage => {
        // erreurs de lecture ignorées
    }
).catch(err => console.error(err));
</script>
</body>
</html>
