function hash_password_client(form, password)
{
  var passCipher = document.getElementById("passCipher");
  passCipher.value = hex_sha512(password.value);
  // Make sure the plain password isn't sent...
  password.value = "";
  form.submit();
  return true;
}

function register_form(form, fName, lName, company, email, uName, password1, password2)
{
  // Check for blank values
  if (fName.value == "" || lName.value == "" || email.value == "" || uName.value == "" || password1.value == "" || password2.value == "" )
  {
    var help_msg = document.createElement("p");
    help_msg.value = "The fields marked in red with an asterisk are required. ";
    $( "div.errors" ).append(help_msg);
    
    return false;
  }
  // regex for first name
  var name_regex = /^[A-Za-z]+{1,20}/;
  if (!name_regex.test(form.fName.value))
  {
    help_msg.value = "First name must be the letters A-z only. ";
    form.fName.focus();
    return false;
  }
  name_regex = /^[A-Za-z \-]+{1,25}/;
  if (!name_regex.test(form.lName.value))
  {
    help_msg.value = "Last name must be letters, spaces and -'s only. ";
    form.lName.focus();
    return false;
  }
  // company name regex
  var company_regex = /^[A-Za-z0-9 \-]*{0,50}/;
  if (!company_regex.test(form.company.value))
  {
    help_msg.value = "Company name must be letters, numbers, spaces and -'s only please. ";
    form.company.focus();
    return false;
  }
  var email_regex = /^[A-Za-z0-9\-_]+@[A-Za-z0-9\-_]+\.[a-z.]+{1,100}/;
  if (!email_regex.test(form.email.value))
  {
    help_msg.value = "The email isn't in a valid format, e.g. name@example.com ";
    form.email.focus();
    return false;
  }
  var user_regex = /^[a-zA-Z0-9\-_]+{1,25}/;
  if (!user_regex.test(form.uName.value))
  {
    help_msg.value = "The user name contains too many special characters or spaces. ";
    form.uName.focus();
    return false;
  }
  if (password1.value != password2.value)
  {
    help_msg.value = "Those passwords don't match, please try typing again. ";
    form.password2.focus();
    return false;
  }
  // Must be 7-50 chars long, one or more digits 0-9, 1+ a-z, and A-Z and 1+ 
  // special characters. Can be in any order.
  pass_regex = /[a-zA-Z0-9$!"£%^*-_+?#~]+{7,50}/;
  if (!pass_regex.test(form.password1.value))
  {
    help_msg.value = "The password should contain <strong>7</strong> characters or more. <br />1 capital letter A-Z. <br />Some lowercase letters a-z. <br />A number 0-9. <br /> 1 or more special characters: <strong>$ £ % ^ - ! and no spaces. </strong>";
    form.password1.focus();
    return false;
  }
  else
  {
    // hashy password
    var passCipher = document.getElementById("passCipher");
    passCipher.value = hex_sha512(password1.value);
    // make sure plain text passwords don't get sent...
    password1.value = "";
    password2.value = "";
    // submit the form... sends it to server and PHP
    form.submit();
    return true;
  }
}

function reset_pass_form(form, pin, password1, password2)
{
  // Check for blank values
  if ( pin.value == "" || password1.value == "" || password2.value == "" )
  {
    var help_msg = document.createElement("p");
    help_msg.value = "The fields marked in red with an asterisk are required. ";
    $( "div.errors" ).append(help_msg);
    
    return false;
  }
  var pin_regex = /[^;=//]*{3,400}/;
  if (!pin_regex.test(form.pin.value))
  {
    help_msg.value = "The pin is wrong, please copy it straight in from the email. ";
    form.pin.focus();
    return false;
  }
  if (password1.value != password2.value)
  {
    help_msg.value = "Those passwords don't match, please try typing again. ";
    form.password2.focus();
    return false;
  }
  // Must be 7-50 chars long, one or more digits 0-9, 1+ a-z, and A-Z and 1+ 
  // special characters. Can be in any order.
  pass_regex = /[a-zA-Z0-9$!"£%^*-_+?#~]+{7,50}/;
  if (!pass_regex.test(form.password1.value))
  {
    help_msg.value = "The password should contain <strong>7</strong> characters or more. <br />1 capital letter A-Z. <br />Some lowercase letters a-z. <br />A number 0-9. <br /> 1 or more special characters: <strong>$ £ % ^ - ! and no spaces. </strong>";
    form.password1.focus();
    return false;
  }
  else
  {
    // hashy password
    var passCipher = document.getElementById("passCipher");
    passCipher.value = hex_sha512(password1.value);
    // make sure plain text passwords don't get sent...
    password1.value = "";
    password2.value = "";
    // submit the form... sends it to server and PHP
    form.submit();
    return true;
  }
}

