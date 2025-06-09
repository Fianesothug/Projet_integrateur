<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>contact_us</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/contact.css">
</head>

<body>
  <?php include_once ('includes/header.php'); ?>
  <div class="page-wrapper">
    <div class="contact-container">
      <div class="text">
        Contactez nous
      </div>
      <form action="#">
        <div class="form-row">
          <div class="input-data">
            <input type="text" required>
            <div class="underline"></div>
            <label for="">Nom</label>
          </div>
          <div class="input-data">
            <input type="text" required>
            <div class="underline"></div>
            <label for="">Prenom</label>
          </div>
        </div>
        <div class="form-row">
          <div class="input-data">
            <input type="text" required>
            <div class="underline"></div>
            <label for="">Address Email</label>
          </div>
          <div class="input-data">
            <input type="text" required>
            <div class="underline"></div>
            <label for="">Telephone</label>
          </div>
        </div>
        <div class="form-row">
          <div class="input-data textarea">
            <textarea rows="8" cols="80" required></textarea>
            <br />
            <div class="underline"></div>
            <label for="">Message</label>
            <br />
            <div class="form-row submit-btn">
              <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Soumettre">
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php include_once ('includes/footer.php'); ?>
  </div>
</body>

</html>