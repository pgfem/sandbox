<!DOCTYPE html>
<html>
  <head>
    <title>Login with Google</title>
    <meta name="google-signin-client_id" content="16638818624-n9culggai0aqi39pph2r7e94qcm6g4ao.apps.googleusercontent.com">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
      function handleCredentialResponse(response) {
        // Store credential temporarily
        localStorage.setItem("google_token", response.credential);
        // Redirect to landing.php
        window.location.href = "landing.php";
      }

      window.onload = function () {
        google.accounts.id.initialize({
          client_id: "16638818624-n9culggai0aqi39pph2r7e94qcm6g4ao.apps.googleusercontent.com",
          callback: handleCredentialResponse
        });
        google.accounts.id.renderButton(
          document.getElementById("buttonDiv"),
          { theme: "outline", size: "large" }
        );
        google.accounts.id.prompt(); // Display prompt
      };
    </script>
  </head>
  <body>
    <h2>Login using Google</h2>
    <div id="buttonDiv"></div>
  </body>
</html>
