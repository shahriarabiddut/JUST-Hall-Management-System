function domReady(fn) {
    if (
        document.readyState === "complete" ||
        document.readyState === "interactive"
    ) {
        setTimeout(fn, 5000);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

domReady(function () {

    // If found your QR code
    function onScanSuccess(decodeText, decodeResult) {
        // Assuming the variable is part of the current URL
        let myVariable = "/" + decodeText;
        // Get the current URL
        let currentURL = window.location.href;
        // Concatenate the variable to the current URL
        let newURL = currentURL + myVariable;
        // Redirect to the new URL
        window.location.href = newURL;

        // Stop the scanner after a successful scan
        htmlscanner.stop();
    }

    let htmlscanner = new Html5QrcodeScanner(
        "my-qr-reader",
        { fps: 10, qrbos: 250 }
    );

    // Start the scanner
    htmlscanner.render(onScanSuccess);
});
