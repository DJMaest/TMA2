  <!-- Modal Structure -->
  <div id="signInModal" class="modal">

      <div class="modal-content center">
          <h3 class="modal-close">&#10005;</h3>
          <h3>Sign In</h3>
          <br>

          <form id="signInForm" method="GET" action="api/user/signin.php">

              <div class="input-field">
                  <i class="material-icons prefix">person</i>
                  <label for="username">Username</label>
                  <input name="username" type="text">

              </div>
              <br>

              <div class="input-field">
                  <i class="material-icons prefix">lock</i>
                  <label for="pass">Password</label>
                  <input name="password" type="password">

              </div>
              <br>
              <p> Don't have an account? <a class="signup-trigger" href="#">Create Account</a></p>
              <br>

              <input type="submit" value="Login" class="btn">

          </form>
      </div>

  </div>