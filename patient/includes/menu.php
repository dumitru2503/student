<div class="menu">
  <table class="menu-container" border="0">
    <tr>
      <td style="padding:10px" colspan="2">
        <table border="0" class="profile-container">
          <tr>
            <td width="30%" style="padding-left:20px">
              <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
            </td>
            <td style="padding:0px;margin:0px;">
              <p class="profile-title"><?php echo substr($user_name, 0, 13) ?></p>
              <p class="profile-subtitle"><?php echo substr($user_email, 0, 22) ?></p>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <a href="../logout.php"><input type="button" value="Deconectare"
                  class="logout-btn btn-primary-soft btn"></a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="menu-row">
      <td class="menu-btn menu-icon-home menu-active menu-icon-home-active">
        <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
          <div>
            <p class="menu-text">Acasă</p>
          </div>
        </a>
      </td>
    </tr>
    <tr class="menu-row">
      <td class="menu-btn menu-icon-doctor">
        <a href="doctors.php" class="non-style-link-menu">
          <div>
            <p class="menu-text">Toți medicii</p>
          </div>
        </a>
      </td>
    </tr>

    <tr class="menu-row">
      <td class="menu-btn menu-icon-session">
        <a href="schedule.php" class="non-style-link-menu">
          <div>
            <p class="menu-text">Servicii</p>
          </div>
        </a>
      </td>
    </tr>
    <tr class="menu-row">
      <td class="menu-btn menu-icon-appoinment">
        <a href="appointment.php" class="non-style-link-menu">
          <div>
            <p class="menu-text">Programările mele</p>
          </div>
        </a>
      </td>
    </tr>
    <tr class="menu-row">
      <td class="menu-btn menu-icon-settings">
        <a href="settings.php" class="non-style-link-menu">
          <div>
            <p class="menu-text">Setări</p>
          </div>
        </a>
      </td>
    </tr>

  </table>
</div>