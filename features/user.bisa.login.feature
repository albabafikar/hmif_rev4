Feature:
  User bisa masuk ke dalam sistem

Background:
  Given User sudah teregistrasi di system dengan status "1"

Scenario:
  When user dengan status "1" melakukan login
  Then user dapat memasuki sistem