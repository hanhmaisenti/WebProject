# WebProject

This requires setting up of fake sendmail on your system

  sendmail.exe is a simple windows console application that emulates sendmail's
  "-t" option to deliver emails piped via stdin.

  it is intended to ease running unix code that has /usr/lib/sendmail hardcoded
  as an email delivery means.

  it doesn't support deferred delivery, and requires an smtp server to perform
  the actual delivery of the messages.

install

  (1) download sendmail.zip (http://www.glob.com.au/sendmail/sendmail.zip)

  (2) copy sendmail.exe and sendmail.ini to C:\Bitnami\wampstack-7.1.15-0 on the drive where the
      unix application is installed.

  (3) configure smtp server and default domain in sendmail.ini
        smtp_server=smtp.gmail.com
        smtp_port=465
        smtp_ssl=ssl
        default_domain=localhost
        error_logfile=error.log
        debug_logfile=debug.log
        auth_username=youremailaddress@gmail.com
        auth_password=the passsord google gave you. To generate a password please look here:
            https://security.google.com/settings/security/apppasswords