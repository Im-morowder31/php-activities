<!DOCTYPE html>
<html lang="en">
<head>
  <title>Static Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
  @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900');
  
  body {
    font-family: 'Poppins', sans-serif;
    font-weight: 300;
    line-height: 1.7;
    color: #ffeba7;
    background-color: #1f2029;
  }

  .section {
    position: relative;
    width: 100%;
    display: block;
  }

  .full-height {
    min-height: 100vh;
  }

  .card-3d-wrap {
    position: relative;
    width: 440px;
    max-width: 100%;
    height: 400px;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    perspective: 800px;
    margin-top: 60px;
  }

  .card-3d-wrapper {
    width: 100%;
    height: 100%;
    position: absolute;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    transition: all 600ms ease-out;
  }

  .card-front {
    width: 100%;
    height: 100%;
    background-color: #2b2e38;
    background-image: url('/img/pattern_japanese-pattern-2_1_2_0-0_0_1__ffffff00_000000.png');
    position: absolute;
    border-radius: 6px;
    -webkit-transform-style: preserve-3d;
  }

  .center-wrap {
    position: absolute;
    width: 100%;
    padding: 0 35px;
    top: 50%;
    left: 0;
    transform: translate3d(0, -50%, 35px) perspective(100px);
    z-index: 20;
    display: block;
  }

  .form-group {
    position: relative;
    margin: 0;
    padding: 0;
  }

  .form-style {
    padding: 13px 20px;
    padding-left: 55px;
    height: 48px;
    width: 100%;
    font-weight: 500;
    border-radius: 4px;
    font-size: 14px;
    line-height: 22px;
    letter-spacing: 0.5px;
    outline: none;
    color: #c4c3ca;
    background-color: #1f2029;
    border: none;
    -webkit-transition: all 200ms linear;
    transition: all 200ms linear;
    box-shadow: 0 4px 8px 0 rgba(21,21,21,.2);
  }

  .form-style:focus,
  .form-style:active {
    border: none;
    outline: none;
    box-shadow: 0 4px 8px 0 rgba(21,21,21,.2);
  }

  .input-icon {
    position: absolute;
    top: 0;
    left: 18px;
    height: 48px;
    font-size: 24px;
    line-height: 48px;
    text-align: left;
    transition: all 200ms linear;
  }

  .btn {
    border-radius: 4px;
    height: 44px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    transition: all 200ms linear;
    padding: 0 30px;
    letter-spacing: 1px;
    background-color: #ffeba7;
    color: #000000;
  }

  .btn:hover {
    background-color: #000000;
    color: #ffeba7;
    box-shadow: 0 8px 24px 0 rgba(16,39,112,.2);
  }

  .notification {
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    max-width: 350px;
    margin: 0;
    z-index: 9999;
  }
</style>

</head>
<body>
  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="card-3d-wrap mx-auto">
            <div class="card-3d-wrapper">
              <div class="card-front">
                <div class="center-wrap">
                  <div class="section text-center">
                    <h4 class="mb-4 pb-3">Log In</h4>
                    
                    <?php
                      $userLists = [
                          'Admin' => [
                              'Admin' => 'Admin',
                              'Shane' => 'Kian'
                          ],
                          'Content Manager' => [
                              'Content' => 'Manager',
                              'Gab' => 'Cale'
                          ],
                          'System User' => [
                              'User' => 'System'
                          ]
                      ];

                      $notificationMessage = '';
                      $notificationClass = '';

                      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-signin'])) {
                          $selectedType = $_POST['slctUserType'];
                          $inputUsername = $_POST['inputUsername'];
                          $inputPassword = $_POST['inputPassword'];

                          $isValidUser = isset($userLists[$selectedType][$inputUsername]) && $userLists[$selectedType][$inputUsername] === $inputPassword;

                          if ($isValidUser) {
                              $notificationMessage = "Welcome to the system, " . htmlspecialchars($inputUsername) . "!";
                              $notificationClass = 'alert-success';
                          } else {
                              $notificationMessage = "Invalid Username or Password.";
                              $notificationClass = 'alert-danger';
                          }

                          header("Location: " . $_SERVER['PHP_SELF'] . "?notification=" . urlencode($notificationMessage) . "&class=" . urlencode($notificationClass));
                          exit;
                      }

                      if (isset($_GET['notification']) && isset($_GET['class'])):
                    ?>
                      <div class="alert <?php echo htmlspecialchars($_GET['class']); ?> alert-dismissible fade show notification" role="alert">
                        <?php echo htmlspecialchars($_GET['notification']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    <?php endif; ?>

                    <form method="post">
                      <div class="form-group">
                        <select name="slctUserType" class="form-style" required>
                          <option value="Admin">Admin</option>
                          <option value="Content Manager">Content Manager</option>
                          <option value="System User">System User</option>
                        </select>
                      </div>
                      <div class="form-group mt-2">
                        <input type="text" name="inputUsername" class="form-style" placeholder="Username" required>
                        <i class="input-icon uil uil-user"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="password" name="inputPassword" class="form-style" placeholder="Password" required>
                        <i class="input-icon uil uil-lock-alt"></i>
                      </div>
                      <button type="submit" name="btn-signin" class="btn mt-4">Sign in</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
