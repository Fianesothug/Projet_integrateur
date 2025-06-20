<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<h2>Inscription à la newsletter</h2>
<form id="newsletterForm" method="POST">
    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="email" id="email" name="email" placeholder="Votre email" required>
    <button type="submit">S'inscrire</button>
</form>

<div id="responseMessage"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('#newsletterForm').submit(function(e) {
    e.preventDefault();
    var email = $('#email').val();
    var csrf_token = $('#csrf_token').val();
    $('#responseMessage').removeClass('success error').html('');

    $.ajax({
      type: 'POST',
      url: 'newsletter-handler.php',
      data: {
        email: email,
        csrf_token: csrf_token
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          $('#responseMessage').addClass('success').html(response.message);
          $('#email').val('');
        } else {
          $('#responseMessage').addClass('error').html(response.message);
        }
      },
      error: function() {
        $('#responseMessage').addClass('error').html('Une erreur est survenue.');
      }
    });
  });
});
</script>