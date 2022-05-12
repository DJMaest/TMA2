  <!-- Modal Structure -->
  <div id="signUpModal" class="modal">

      <div class="modal-content center">
          <h3 class="modal-close">&#10005;</h3>
          <h3>Create Account</h3>
          <br>

          <form id="signUpForm" method="POST" action="api/user/signup.php">

              <div class="input-field">
                  <i class="material-icons prefix">person</i>
                  <label for="name">Username</label>
                  <input name="username" type="text" id="username">

              </div>

              <div class="input-field">
                  <i class="material-icons prefix">lock</i>
                  <label for="pass">Password</label>
                  <input name="password" type="password" id="pass">
              </div>
              <div class="input-field">
                  <label for="pass">Confirm Password</label>
                  <input name="passwordConfirm" type="password" id="passConfirm">
              </div>
                <br>
              <input type="submit" value="Create Account" class="btn">

          </form>
      </div>

  </div>