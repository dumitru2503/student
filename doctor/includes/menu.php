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
      <td class="menu-btn menu-icon-home">
        <a href="index.php">
          <div>
            <p class="menu-text"><i class="fa-solid fa-house"
                style="margin-right: 12px; padding: 10px; color: #ffffff;"></i>Acasă
            </p>
          </div>
        </a>
      </td>
    </tr>
    <tr class="menu-row">
      <td class="menu-btn menu-icon-appoinment">
        <a href="appointment.php">
          <div>
            <p class="menu-text"><i class="fa-solid fa-calendar-days"
                style="margin-right: 12px; padding: 10px; color: #ffffff;"></i>Programări
            </p>
          </div>
        </a>
      </td>
    </tr>
    <tr class="menu-row">
      <td class="menu-btn menu-icon-appoinment">
        <a href="patient.php">
          <div>
            <p class="menu-text"><i class="fa-solid fa-user"
                style="margin-right: 12px; padding: 10px; color: #ffffff;"></i>Pacienți
            </p>
          </div>
        </a>
      </td>
    </tr>

    <!-- <tr class="menu-row">
      <td class="menu-btn menu-icon-patient">
        <a href="patient.php">
          <div>
            <p class="menu-text">Pacienti</p>
          </div>
        </a>
      </td>
    </tr> -->
    <tr class="menu-row">
      <td class="menu-btn menu-icon-schedule">
        <a href="schedule.php">
          <div>
            <p class="menu-text"><i class="fa-solid fa-list"
                style="margin-right: 12px; padding: 10px; color: #ffffff; "></i>Orar
            </p>
          </div>
        </a>
      </td>
    </tr>
    <tr class="menu-row">
      <td class="menu-btn menu-icon-settings">
        <a href="settings.php">
          <div style="margin-top: 50px;">
            <p class="menu-text"><i class="fas fa-cog" style="margin-right: 12px; padding: 10px; color: #ffffff;"></i>
              Setări</p>
          </div>
        </a>
      </td>
    </tr>

  </table>
</div>